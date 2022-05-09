<?php

date_default_timezone_set('America/Bogota');

/* define("DBHOST", "localhost:3308");
define("DBNAME", "BolsaEmpleo");
define("DBUSER", "Bolsa");
define("DBPASS", "uDx5PlvZAheJHVzt"); */

/* define("DBHOST", "sql10.freesqldatabase.com:3306");
define("DBNAME", "sql10491032");
define("DBUSER", "sql10491032");
define("DBPASS", "M9jzgskYcX"); */

define("DBHOST", "us-cdbr-east-05.cleardb.net");
define("DBNAME", "heroku_ebee224f7f955f7");
define("DBUSER", "ba9ee4b5da754f");
define("DBPASS", "c9a1c352");


define("KEY_TOKEN", "XI#f*i2yJ9BnFQRV1uuh");

$nowserver = date('Y-m-d H:i:s');

require_once('../WebService/WebServiceToken.php');
require_once('../WebService/WebServiceUsuario.php');