<?php

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------

$codigos_bact=array();
$nombres_bact=array();

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$ccPac = $_POST['txtCedula'];


$sql = "SELECT * FROM Pacientes WHERE CedulaActual= '".$ccPac."' ORDER BY Apellido1;";

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------



//if (isset($_POST['txtCedula']) and (isset($_POST['txtCedula'])) ) {
//}

$resultado = "";
$users = $db->get_results($sql, ARRAY_A);


if ($users = $db->get_results($sql, ARRAY_A)) {
    foreach ($users as $user) {
		$resultado = $user['CedulaActual']." ".$user['NombreCompleto'];//, ENT_COMPAT);
     }

 }

/*
 $htmlCode = <<< HTML
<div class='txtCedula'>$resultado
</div>
HTML;*/
	
echo $resultado;

?>


