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

//echo var_dump($_POST['popRespComponentes']);
//echo "<br/> VALOR DE POST:<br/>";
//echo var_dump($_POST);
//var_dump($_POST);
//die($_POST['popRespComponentes']);
//die("ACABE");

date_default_timezone_set("America/Bogota");




$parametros = array();


@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarRespuesta.php
//
// Rutina AJAX que graba la respuesta a una pregunta especifica recibida
// como parametro.
// ------------------------------------------------------------------------


include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$parametros['wsNroConsecutivo'] = $_POST['wsTxtOrden'];
$parametros['wsObservaciones'] = $_POST['wsTxtObservaciones'];
$parametros['wsEstadoEncuesta'] = $_POST['wsTxtEstado'];
$parametros['wscodbact'] = $_SESSION['codigobacteriologa'];

$orden = $_POST['wsTxtOrden'];
$observacion = $_POST['wsTxtObservaciones'];
$estado = $_POST['wsTxtEstado'];


//die(var_dump($_POST));
//echo $parameters;
//die(var_dump($parameters);
//$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarBancoRegistro', $parameters);
$resultado = $database->call4DWebServer('wsActualizarEstadoEncuesta', $parametros);

$database->disconnect();

$res4D = "";
//unset($Client);
echo "{ 'orden' : '$orden'  , 'estado' : '$resultado' } ";


//ya no se necesita revisar el comando ." = ".$cmdSql;


?>


    
