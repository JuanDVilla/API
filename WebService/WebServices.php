<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
Use Firebase\JWT\Key;

class WebServiceToken
{
    public static function get_token($Usuario, $Clave)
    {     
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
           
        if (!empty($Usuario) && !empty($Clave)) {
            $issuedAt = time();
            $notBefore = $issuedAt + 0;
            $segundos_expira = 3600;
            $expire = $notBefore + $segundos_expira;

            $sql_verifica = "SELECT * FROM usuariosws WHERE Usuario = '$Usuario' and  Clave = '" . sha1($Clave) . "' and Activo = 1";
            $qry_verifica = $dbo->query($sql_verifica);            

            if(mysqli_num_rows($qry_verifica) > 0) {

                $response = array();
                $datos_usuario = $qry_verifica->fetch_array(MYSQLI_ASSOC);
                //Genero el token
                $token = array(                   
                    "iat" => $issuedAt,
                    "nbf" => $notBefore,
                    'exp' => $expire,
                    "data" => array(
                        "IDUsuarioWS" => $datos_usuario["IDUsuariosWs"],
                        "Nombre" => $datos_usuario["Nombre"],                        
                        "Usuario" => $datos_usuario["Usuario"],                        
                    ),
                );

                $jwt = JWT::encode($token, KEY_TOKEN, 'HS256');

                $datos_token["Token"] = $jwt;
                $datos_token["TiempoExpira"] = $segundos_expira;

                array_push($response, $datos_token);

                $respuesta["message"] = "Token Generado con exito!";
                $respuesta["success"] = true;
                $respuesta["response"] = $response;
                
            } else {
                $respuesta["message"] = "Datos incorrectos";
                $respuesta["success"] = false;
                $respuesta["response"] = null;
            }

        } else {
            $respuesta["message"] = "Faltan parametros";
            $respuesta["success"] = false;
            $respuesta["response"] = null;
        }
        return $respuesta;

       
    }

    public static function valida_token($Token)
    {
        if (!empty($Token)) {            
            try {
                $decoded = JWT::decode($Token, new key (KEY_TOKEN,'HS256'));
                $respuesta["message"] = "Token valido";
                $respuesta["success"] = true;
                $respuesta["response"] = null;

            } catch (Exception $e) {
                $respuesta["message"] = "Token invalido";
                $respuesta["success"] = false;
                $respuesta["response"] = "";
            }

        } else {
            $respuesta["message"] = "Token vacio";
            $respuesta["success"] = false;
            $respuesta["response"] = null;
        }
        return $respuesta;
    }
}

class Req
{
    // FUNCION PARA VALIDAR EL ENVIO DE LAS VARIABLES
    public static function Request($Variable)
    {
        if(isset($_GET[$Variable])):
            return $_GET[$Variable];
        elseif(isset($_POST[$Variable])):
            return $_POST[$Variable];
        else:
            return "";
        endif;
    }

    public static $TiposDocumento = array('CC','CE','PP','TI');
}

class WebServiceUsuario
{
    public static function UsuarioNuevo($Nombre, $NumeroDocumento, $TipoDocumento, $Correo)
    {
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        
        if(!empty($Nombre) && !empty($NumeroDocumento) && !empty($TipoDocumento) && !empty($Correo)):
            // INSERTAMOS EL CANDIDATO EN LA BASE DE DATOS
            if(filter_var($Correo, FILTER_VALIDATE_EMAIL)):

                $TipoDocumento = strtoupper($TipoDocumento);
                if(in_array($TipoDocumento,Req::$TiposDocumento)):

                    $SQLBusca = "SELECT * FROM Candidatos WHERE NumeroDocumento = '$NumeroDocumento'";
                    $QRYBusca = $dbo->query($SQLBusca);
                    $datos = $QRYBusca->fetch_array(MYSQLI_ASSOC);
                                    
                    if(!empty($datos)):                    
                        // SI YA EXISTE SE ACTUALIZA
                        $SQLUpdate = "UPDATE Candidatos SET Nombre = '$Nombre', TipoDocumento = '$TipoDocumento', Correo = '$Correo' WHERE IDCandidatos = $datos[IDCandidatos]";
                        $dbo->query($SQLUpdate);

                        $mensaje = "DATOS ACTULIZADOS CON EXITO!";
                    else:

                        $SQLInsert = "INSERT INTO Candidatos (Nombre, NumeroDocumento, TipoDocumento, Correo) VALUES ('$Nombre','$NumeroDocumento','$TipoDocumento','$Correo')";
                        $dbo->query($SQLInsert);

                        $mensaje = "CANDIDATO CREADO CON EXITO!";
                    endif;  

                    $respuesta["message"] = $mensaje;
                    $respuesta["success"] = true;
                    $respuesta["response"] = "";
                else:
                    $respuesta["message"] = "Ingrese un tipo de documento valido como: " . json_encode(Req::$TiposDocumento);
                    $respuesta["success"] = false;
                    $respuesta["response"] = null;
                endif;
            else:
                $respuesta["message"] = "Por favor ingrese un correo electronico valido";
                $respuesta["success"] = false;
                $respuesta["response"] = null;
            endif;      
        else:
            $respuesta["message"] = "Faltan parametros";
            $respuesta["success"] = false;
            $respuesta["response"] = null;
        endif;

        return $respuesta;
    }
    
}

class WebServiceOfertas
{
    public static function NuevaOferta($Nombre, $Estado, $Candidatos)
    {
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $Documentos = array();

        if(!empty($Nombre) && !empty($Estado) && !empty($Candidatos)):

            $Candidatos = json_decode($Candidatos, true);
            if(count($Candidatos) > 0):
                if($Estado == 'Activo' ||  $Estado == 'Inactivo'):

                    // VALIDAMOS LOS CANDIDATOS EXISTAN
                    foreach($Candidatos as $id => $Documento):
                        //BUSCAMMOS EL CANDIDATOS
                        $SQLBuscar = "SELECT * FROM candidatos WHERE NumeroDocumento = '$Documento[NumeroDocumento]'";
                        $QRYBuscar = $dbo->query($SQLBuscar);
                        $datos = $QRYBuscar->fetch_array(MYSQLI_ASSOC);

                        if(empty($datos)):
                            $respuesta["message"] = "El candidato con numero docuemto $Documento[NumeroDocumento] no existe, ingrese uno valido";
                            $respuesta["success"] = false;
                            $respuesta["response"] = "";
                            
                            return $respuesta;
                        endif;

                        if(in_array($Documento['NumeroDocumento'],$Documentos)):
                            $respuesta["message"] = "Hay un numero repetido, por favor validar";
                            $respuesta["success"] = false;
                            $respuesta["response"] = "";
                            
                            return $respuesta;
                        endif;

                        $Documentos[]= $Documento['NumeroDocumento'];
                    endforeach;

                    $SQLInsert = "INSERT INTO ofertas (Nombre, Estado) VALUES ('$Nombre','$Estado')";
                    $QRYInsert = $dbo->query($SQLInsert);
                    $IDOfertas = $dbo -> insert_id;

                    $Mesanje = "Oferta ingresada con exito";            

                    foreach($Candidatos as $id => $Documento):
                        //BUSCAMMOS EL CANDIDATOS
                        $SQLBuscar = "SELECT * FROM candidatos WHERE NumeroDocumento = '$Documento[NumeroDocumento]'";
                        $QRYBuscar = $dbo->query($SQLBuscar);
                        $datos = $QRYBuscar->fetch_array(MYSQLI_ASSOC);
                     
                        $SQLInsertCandidato = "INSERT INTO candidatosofertas (IDOfertas, IDCandidatos) VALUES ($IDOfertas, $datos[IDCandidatos])";
                        $QRYIsertaCandidato = $dbo->query($SQLInsertCandidato);
                       
                    endforeach;    

                    $respuesta["message"] = $Mesanje;
                    $respuesta["success"] = true;
                    $respuesta["response"] = "";

                else:
                    $respuesta["message"] = 'Los estados validos son Activo o Inactivo';
                    $respuesta["success"] = false;
                    $respuesta["response"] = "";
                endif;              

            else:
                $respuesta["message"] = "Debe ingresar al menos un candidato";
                $respuesta["success"] = false;
                $respuesta["response"] = "";
            endif;
        else:
            $respuesta["message"] = "Faltan parametros";
            $respuesta["success"] = false;
            $respuesta["response"] = null;
        endif;

        return $respuesta;
    }

    public static function ConsultaOfertas()
    {
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $response = array();
        // CONSULTO LAS OFERTAS

        $SQLOfertas = "SELECT * FROM ofertas WHERE 1";
        $QRYOfertas = $dbo->query($SQLOfertas);  
        if(mysqli_num_rows($QRYOfertas) > 0):

            $Mensaje ="Ofertas encontradas";
            while($datos = $QRYOfertas->fetch_array(MYSQLI_ASSOC)):

                $InfoResponse['NombreOferta'] = $datos['Nombre'];
                $InfoResponse['EstadoOferta'] = $datos['Estado'];
    
                $Candidatos = array();
    
                $SQLCandidatos = "SELECT * FROM candidatosofertas WHERE IDOfertas = $datos[IDOfertas]";
                $QRYCandidatos = $dbo->query($SQLCandidatos);
    
                while($datos_candidatos = $QRYCandidatos->fetch_array(MYSQLI_ASSOC)):
                    $SQLCandidato = "SELECT * FROM candidatos WHERE IDCandidatos = $datos_candidatos[IDCandidatos]";
                    $QRYCandidato = $dbo->query($SQLCandidato);
                    $Candidato = $QRYCandidato->fetch_array(MYSQLI_ASSOC);

                    $InfoCandidatos['NombreCandidato'] = $Candidato['Nombre'];
                    $InfoCandidatos['TipoDocumento'] = $Candidato['TipoDocumento'];
                    $InfoCandidatos['NumeroDocumento'] = $Candidato['NumeroDocumento'];
                    $InfoCandidatos['CorreoCandidato'] = $Candidato['Correo'];

                    array_push($Candidatos,$InfoCandidatos);
                endwhile;
    
                $InfoResponse['Candidatos'] = $Candidatos;
    
                array_push($response,$InfoResponse);
                
            endwhile;

            $respuesta["message"] = $Mensaje;
            $respuesta["success"] = true;
            $respuesta["response"] = $response;

        else:
            $respuesta["message"] = "No hay ofertas actualmente";
            $respuesta["success"] = false;
            $respuesta["response"] = "";
        endif;
        

        return $respuesta;
    }
}


