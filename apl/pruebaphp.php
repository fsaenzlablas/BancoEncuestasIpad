<?php

// ------------------------------------------------------------------------
// Programa: subirFirma.php
//
// El programa realiza la grabacion de la firma en 4D, la firma debe estar
// grabada en el directorio /Applications/XAMPP/htdocs/dolphin4/firmas/XXXXXX.png
// donde XXXXXX es el numero de la ot del donante.
// 
// Este programa se escribe en caso de que sea necesario subir la firma 
// a 4D por que no subio al momento de grabar la firma desde el iPad.
// ------------------------------------------------------------------------


$wMensaje = "";
$NameSpace = "";

include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------
 
$parameters = array();

$parameters['conse_encuesta'] = "1234";//$_GET['ot'];

$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsPrueba4D', $parameters);

$database->disconnect();

date_default_timezone_set("America/Bogota");

if ($resultado === false) {

    $resultado = "F|NO HAY SISTEMA DE LABORATORIO EN ESTE MOMENTO O SE ESTA REALIZANDO COPIA DE SEGURIDAD. INTENTE NUEVAMENTE. <br/><br/>Fecha y Hora: " . date('d/m/Y H:m:s'); // Significa que 4D Fallo
   
} 

echo $resultado;
?>

