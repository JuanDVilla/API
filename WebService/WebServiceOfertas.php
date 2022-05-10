<?php 

class WebServiceOfertas
{
    public static function NuevaOferta($Nombre, $Estado, $Candidatos)
    {
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

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
        
    }
}
