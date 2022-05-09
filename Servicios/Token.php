<?php

require_once('general.php');
require_once('/WebService/WebServiceToken.php');
/* 
$Usuario = $_POST['Usuario'];
$Clave = $_POST['Clave']; */

/* $Usuario = "BolsaApi";
$Clave = "B01sA4P1"; */

echo "HOLA";
exit;

$dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
echo "HOLA";
exit;


$Token = WebServiceToken::get_token($Usuario, $Clave);

die(json_encode(array('success' => $Token['success'], 'message' => $Token['message'], 'response' => $Token['response'], 'date' => $nowserver)));
exit;


