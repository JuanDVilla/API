<?php

class WebServiceUsuario
{
    public static function UsuarioNuevo($Nombre, $NumeroDocumento, $TipoDocumento, $Correo)
    {
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        
        if(!empty($Nombre) && !empty($NumeroDocumento) && !empty($TipoDocumento) && !empty($Correo)):
            // INSERTAMOS EL CANDIDATO EN LA BASE DE DATOS
            if(filter_var($Correo, FILTER_VALIDATE_EMAIL)):

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