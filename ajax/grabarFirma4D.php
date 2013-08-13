<?php

// ------------------------------------------------------------------------
// Programa: grabarFirma4D.php
//
// Rutina AJAX que graba la Firma de una encuesta en 4D
// ------------------------------------------------------------------------

include_once("../class/FourDimensionAccess.php");

// -----------------------------------------------------------------------------------------
// Capturar todas los parametros que vienen en el POST.
// -----------------------------------------------------------------------------------------

$htmlCode = "";
$num_ot = $_POST['num_ot'];
$firma = $_SESSION[$num_ot]['firma'] ;

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------

$parameters = array();

$parameters['conse_encuesta'] = $_SESSION[$num_ot]['encOtDon'];
$parameters['sufijo_firma'] = "";

$parametersPost = array();
$parametersPost['conse_encuesta'] = $_SESSION[$num_ot]['encOtDon'];
$parametersPost['sufijo_firma'] = "P";

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarFirma4D', $parameters);
$resultado = $database->call4DWebServer('wsGrabarFirmaPost4D', $parameters);
if ($_SESSION["tipo_encuesta"] != "0"){
	
	$resultado = $database->call4DWebServer('wsGrabarFirmaPost4D', $parametersPost);
}
$database->disconnect();

$_SESSION[$num_ot]['parameters'] = $parameters;

unset($Client);

date_default_timezone_set("America/Bogota");

if ($resultado === false) {

    $resultado = "F|NO HAY SISTEMA O SE ESTA REALIZANDO BACKUP. INTENTE DE NUEVO. Fecha: " . date('d/m/Y H:m:s'); // Significa que 4D Fallo
    $_SESSION[$num_ot]['resGrabEnc'] = $resultado;
} else {

    if ((isset($resultado['faultstring']) ) && ($resultado['faultstring'] != 0)) {
        $resultado = $resultado['faultstring'] . "  " . $resultado['faultstring'];
        $_SESSION[$num_ot]['resGrabEnc'] = $resultado;
        $resultado = "F|NO HAY SISTEMA O SE ESTA REALIZANDO BACKUP. INTENTE DE NUEVO. Fecha: " . date('d/m/Y H:m:s');
    } else {
        $_SESSION[$num_ot]['resGrabEnc'] = $resultado;
        $resultado = "K|LA FIRMA SE GRABO EXITOSAMENTE";

    }

}

echo $resultado;
?>
