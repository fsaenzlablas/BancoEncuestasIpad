<?php

// ------------------------------------------------------------------------
// Programa: grabarFirma4D.php
//
// Rutina AJAX que graba la Firma de una encuesta en 4D
// ------------------------------------------------------------------------

if (!isset($_SESSION['cod_bact'])) {
    include_once('../../dona.html');//'../apl/login.php');
    die();
}


// -----------------------------------------------------------------------------------------
// Capturar todas los parametros que vienen en el POST.
// -----------------------------------------------------------------------------------------

$htmlCode = "";
//var_dump($_POST);
$firma = $_POST['firma_donante'];
include_once("../class/FourDimensionAccess.php");
$_SESSION['firma'] = $firma;


//removing the "data:image/png;base64," part
$uri = substr($firma, strpos($firma, ",") + 1);
// put the data to a file
$file = "../firmas/" . $_SESSION['encOtDon'] . ".png";

if (file_exists($file)) {
    unlink($file);
}

file_put_contents($file, base64_decode($uri));

if (filesize($file)<15000){
    die("F|LA FIRMA ES DEMASIADO PEQUE&Ntilde;A PARA SER CONSIDERADA CORRECTA. POR FAVOR COMPLETE SU FIRMA.");
}
    if ((isset($resultado['faultstring']) ) && ($resultado['faultstring'] != 0)) {
        $resultado = $resultado['faultstring'] . "  " . $resultado['faultstring'];
        $_SESSION['resGrabEnc'] = $resultado;
        $resultado = "F";
    } else {
        $_SESSION['resGrabEnc'] = $resultado;
        $resultado = "K";
    }

    /*
     * 4th Dimension responde con las siguientes mensajes:
     *
     * resGrabEnc:="1|LA ENCUESTA SE GRABO EXITOSAMENTE."
     * resGrabEnc:="0|LA ENCUESTA NO SE GRABO CORRECTAMENTE. INTENTE DE NUEVO. Hist: "+String($hist)+" det: "+String($det)+" Enc: "+String($enc)
     */

echo $resultado;
?>
