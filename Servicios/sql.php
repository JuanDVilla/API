<?php

require_once('general.php');

$dbo = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);


echo $sql = "

DROP TABLE IF EXISTS `usuariosws`;
CREATE TABLE IF NOT EXISTS `usuariosws` (
  `IDUsuariosWs` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  `Usuario` varchar(50) NOT NULL,
  `Clave` varchar(100) NOT NULL,
  `Activo` tinyint(4) NOT NULL,
  PRIMARY KEY (`IDUsuariosWs`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuariosws`
--

INSERT INTO `usuariosws` (`IDUsuariosWs`, `Nombre`, `Usuario`, `Clave`, `Activo`) VALUES
(1, 'Bolsa', 'BolsaApi', '5f639f0522f18b1c0217373473fd7011a38743c4', 1);
COMMIT;

";
// $qry_verifica = $dbo->query($sql);
  
  exit;