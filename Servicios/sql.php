<?php

require_once('general.php');

$dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);


$sql = "INSERT INTO `usuariosws` (`IDUsuariosWs`, `Nombre`, `Usuario`, `Clave`, `Activo`) VALUES
(1, 'Bolsa', 'BolsaApi', '5f639f0522f18b1c0217373473fd7011a38743c4', 1);
COMMIT;";
$qry_verifica = $dbo->query($sql); 
  
  exit;