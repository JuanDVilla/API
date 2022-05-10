<?php

date_default_timezone_set('America/Bogota');
header("Content-type: application/json; charset=utf-8");

define("DBHOST", "us-cdbr-east-05.cleardb.net");
define("DBNAME", "heroku_ebee224f7f955f7");
define("DBUSER", "ba9ee4b5da754f");
define("DBPASS", "c9a1c352");

define("KEY_TOKEN", "XI#f*i2yJ9BnFQRV1uuh");

$nowserver = date('Y-m-d H:i:s');

require_once('../WebService/WebServices.php');

