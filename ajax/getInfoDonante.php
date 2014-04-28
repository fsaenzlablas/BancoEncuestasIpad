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
// ------------------------------------------------------------------------



//if (isset($_POST['txtCedula']) and (isset($_POST['txtCedula'])) ) {
//}
$parameters = array();

$parameters['wsCedula'] = $_POST['txtCedula'];
$parameters['wsOrden'] = $_POST['txtOrden'];

$parameters['wstxtOTbuscar'] = $_POST['txtOTbuscar'];
$parameters['wstxtFechaDesde'] = $_POST['txtFechaDesde'];
$parameters['wstxtFechaHasta'] = $_POST['txtFechaHasta'];

$parameters['wstxtNombre'] = $_POST['txtNombre'];
$parameters['wstxtApellido1'] = $_POST['txtApellido1'];
$parameters['wstxtApellido2'] = $_POST['txtApellido2'];

$parameters['wstxtDireccion'] = $_POST['txtDireccion'];
$parameters['wstxtTelefonos'] = $_POST['txtTelefonos'];
$parameters['wstxtFechaNat'] = $_POST['txtFechaNat'];
	
$parameters['wstxtDireccion'] = $_POST['txtDireccion'];
//$parameters['wstxtTelefonos'] = $_POST['txtTelefonos'];

$parameters['wspopGenero'] = $_POST['popGenero'];
$parameters['wspopGrupoSanguineo'] = $_POST['popGrupoSanguineo'];
$parameters['wspopRH'] = $_POST['popRH'];
$parameters['wspopTipoDonacion'] = $_POST['popTipoDonacion'];
$parameters['wspopCategorias'] = $_POST['popCategorias'];
$parameters['wstxtE_Mail'] = $_POST['txtE_Mail'];
$parameters['wstxtReceptor'] = $_POST['txtReceptor'];
$parameters['wsidEncuestaTxt'] = $_POST['idEncuestaTxt'];
$parameters['wsidPerfilTxt'] = $_POST['idPerfilTxt'];
$parameters['wsidFenotipoTxt'] = $_POST['idFenotipoTxt'];
$parameters['wsidEFisicoTxt'] = $_POST['idEFisicoTxt'];
	
				
//die(var_dump($_POST));

$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsDatosDonante', $parameters);

$database->disconnect();


unset($Client);
//echo "<script> alert (".$resultado.") </script>";
echo $resultado;

?>


