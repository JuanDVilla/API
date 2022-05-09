<?php

require_once('general.php');

$Servicio = $_POST['Servicio'];
$Token = $_POST['Token'];


if(!empty($Token)):
    $respuesta = WebServiceToken::valida_token($Token);

    if(!$respuesta[success]):
        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    endif;
endif;

switch($Servicio):

    case 'token':
        $Usuario = $_POST['Usuario'];
        $Clave = $_POST['Clave'];
    
        $respuesta = WebServiceToken::get_token($Usuario, $Clave);
    
        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    break;
    
    case 'CrearUsuario':

        $Correo = $_POST['Correo'];
        $Nombre = $_POST['Nombre'];
        $TipoDocumento = $_POST['TipoDocumento'];
        $NumeroDocumento = $_POST['NumeroDocumento'];

        $respuesta = WebServiceUsuario::UsuarioNuevo($Nombre, $NumeroDocumento, $TipoDocumento, $Correo);

        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    break;
endswitch;



