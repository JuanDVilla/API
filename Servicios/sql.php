<?php

require_once('general.php');

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