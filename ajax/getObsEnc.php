<?php

include_once("../class/FourDimensionAccess.php");
$parameters = array();

$parameters['wNombreTabla'] = "banco_encuesta_enc";
$parameters['wNombreCampoIndex'] = "nro_consecutivo";

$parameters['wCriterioQuery'] = $_SESSION['encOtDon'];
$parameters['wNombreCampoResult'] = "Observaciones";

$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsQuery', $parameters);

$database->disconnect();

//var_dump($resultado);
?>