<?php
@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------


include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");


date_default_timezone_set("America/Bogota");




$parametros = array();


date_default_timezone_set("America/Bogota");

$parametros['wsTxtOrden'] = $_POST['wsTxtOrden'];
$parametros['wsTxtCedula'] = $_POST['wsTxtCedula'];
$parametros['wsTxtNuevaCedula'] = $_POST['wsTxtNuevaCedula'];

$ot = $parametros['wsTxtOrden'];
$cedula = $parametros['wsTxtCedula'];
$nueva = $parametros['wsTxtNuevaCedula'];

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarBancoRegistro', $parameters);
$resultado = $database->call4DWebServer('wsActualizarCedulaDonante', $parametros);
$database->disconnect();

$error="";
if ($nueva!=$resultado){
	$error=$resultado;
}
//unset($Client);
echo "{ 'orden' : '$ot' ,  'respuesta' : '$resultado' , 'cedula' : '$nueva' , 'anterior' : '$cedula' , 'error':'$error'} ";


//ya no se necesita revisar el comando ." = ".$cmdSql;


?>


    
