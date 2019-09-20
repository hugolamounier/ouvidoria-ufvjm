<?php
session_start();
header('P3P: CP="CAO PSA OUR"');
header ('Content-type: text/html; charset=utf-8');
ini_set('session.use_only_cookies', 1); 
date_default_timezone_set("Brazil/East");
error_reporting(0);
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

// Requerendo Classes
require_once("../class/User.class.php");
require_once("../class/Helper.class.php");
require_once("../class/Manifestacoes.class.php");
require_once("../class/Pendencias.class.php");

$config["website_title"] = "Sistema de Gestão - Ouvidoria";

$config["db_server"] = "localhost";
$config["db_username"] = "root";
$config["db_password"] = "01954501";
$config["db_name"] = "ouvidoria";

$config["pagination_num"] = 10;

$db_conn = Helper::mysqlConnect($config["db_server"], $config["db_username"], $config["db_password"], $config["db_name"]);
?>