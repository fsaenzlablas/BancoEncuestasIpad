<?php
@session_start();
//	echo "salida ";

$valor = "---";
$variable = "var";
$respuesta = "";
if (isset($_POST['nombrevar'])) {

	$variable = $_POST['nombrevar'];
	$valor =  $_POST['valorvar'];
	$_SESSION[$variable] = $valor;
//	$respuesta .= "con sesion ".$_SESSION[$variable];
}

$respuesta  .= " {'". $variable."' : '".$valor ."'}";
echo $respuesta;







?>