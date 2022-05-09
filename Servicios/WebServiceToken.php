<?php

require '../vendor/autoload.php';
use Firebase\JWT\JWT;
Use Firebase\JWT\Key;

class WebServiceToken
{
    public static function get_token($Usuario, $Clave)
    {     
        $dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        $qry_verifica = $dbo->query("CREATE TABLE IF NOT EXISTS `usuariosws` (
            `IDUsuariosWs` int(11) NOT NULL AUTO_INCREMENT,
            `Nombre` varchar(50) NOT NULL,
            `Usuario` varchar(50) NOT NULL,
            `Clave` varchar(100) NOT NULL,
            `Activo` tinyint(4) NOT NULL,
            PRIMARY KEY (`IDUsuariosWs`)
          ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;"); 
          
          exit;

        if (!empty($Usuario) && !empty($Clave)) {
            $issuedAt = time();
            $notBefore = $issuedAt + 0;
            $segundos_expira = 60000;
            $expire = $notBefore + $segundos_expira;

            $sql_verifica = "SELECT * FROM UsuariosWS WHERE Usuario = '$Usuario' and  Clave = '" . sha1($Clave) . "' and Activo = 1";
            $qry_verifica = $dbo->query($sql_verifica);            

            if (mysqli_num_rows($qry_verifica) > 0) {

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
            $respuesta["message"] = "T1. Atencion faltan parametros";
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