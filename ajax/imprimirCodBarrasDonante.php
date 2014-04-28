<?php

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------

$wMensaje = "";
$NameSpace = "";

include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

//echo "<script> alert(".$_POST['txtCedula'].")</SCRIPT>"
//die(var_dump($_POST));

date_default_timezone_set("America/Bogota");

//$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// --wbanef_cons----------------------------------------------------------------------



//if (isset($_POST['txtCedula']) and (isset($_POST['txtCedula'])) ) {
//}
$parameters = array();


$parameters['wbanef_cons'] = $_POST['txtOrden'];
$parameters['wbanef_imp'] = $_POST['txtcualimpresora'];
//Marzo 12 2014
$parameters['wbanef_obliga'] = "1";//obligar que tenga componentes 

$ot =  $_POST['txtOrden'];
$impresora = $_POST['txtcualimpresora'];

$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsCodBarrasDonante', $parameters);

$database->disconnect();

//echo "<script> alert (".$resultado.") </script>";

 $respJson = "{ 'orden' : '$ot' , 'resultado':'$resultado'} ";  

echo $respJson;

?>


