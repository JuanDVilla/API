<?php

require_once('general.php');

$Servicio = $_POST['Servicio'];
$Token = Req::Request('Token');

if($Servicio == 'Token'):
    
    $Usuario = $_POST['Usuario'];
    $Clave = $_POST['Clave'];

    $respuesta = WebServiceToken::get_token($Usuario, $Clave);

    die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
    exit;
    
endif;


if(!empty($Token)):
    $respuesta = WebServiceToken::valida_token($Token);

    if(!$respuesta['success']):
        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    endif;
else:
    die(json_encode(array('success' => false, 'message' => 'Falta Token', 'response' => '', 'date' => $nowserver)));
    exit;
endif;

switch($Servicio):    
    
    case 'CrearUsuario':

        $Correo = Req::Request('Correo');
        $Nombre = Req::Request('Nombre');
        $TipoDocumento = Req::Request('TipoDocumento');
        $NumeroDocumento = Req::Request('NumeroDocumento');

        $respuesta = WebServiceUsuario::UsuarioNuevo($Nombre, $NumeroDocumento, $TipoDocumento, $Correo);

        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    break;
    
    case 'NuevaOferta':
        $Nombre = Req::Request('Nombre');
        $Estado = Req::Request('Estado');
        $Candidatos = Req::Request('Candidatos');

        $respuesta = WebServiceOfertas::NuevaOferta($Nombre, $Estado, $Candidatos);

        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    break;

    case 'ConsultaOferta':      

        $respuesta = WebServiceOfertas::ConsultaOfertas();

        die(json_encode(array('success' => $respuesta['success'], 'message' => $respuesta['message'], 'response' => $respuesta['response'], 'date' => $nowserver)));
        exit;
    break;

    default:

        die(json_encode(array('success' => false, 'message' => 'no existe el servicio ('.$Servicio.')', 'response' => "", 'date' => $nowserver)));
        exit;
        
    break;

endswitch;



