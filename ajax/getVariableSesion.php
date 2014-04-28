<?php
@session_start();
//	echo "salida ";

$valor = "---";
$variable = "var";
$respuesta = "";
if (isset($_POST['nombrevar'])) {

	$variable = $_POST['nombrevar'];
	$valor =  $_POST['valorvar'];
	$respuesta  = $_SESSION[$variable] ;
//	$respuesta .= "con sesion ".$_SESSION[$variable];
}

//$respuesta  .= " {'". $variable."' : '".$valor ."'}";
echo $respuesta;







?>