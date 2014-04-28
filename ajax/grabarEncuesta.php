<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D, la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------



$wMensaje = "";
$NameSpace = "";

include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");
include_once("../lib/ez_sql.php");

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------

$parameters = array();

$parameters['encOtDon'] = $_SESSION['encOtDon'];
$parameters['encCCDonante'] = $_SESSION['encCCDon'];

$parameters['encNombreDon'] = $_SESSION['encNombreDon'];
$parameters['encApellido1Don'] = $_SESSION['encApellido1Don'];
$parameters['encApellido2Don'] = $_SESSION['encApellido2Don'];

$parameters['encEstado'] = $_POST['encEstado'];
$parameters['encAceptar'] = $_POST['encAceptar'];
$parameters['encComentarios'] = $_POST['encComentarios'];

$parameters['cod_bact'] = $_SESSION['cod_bact'];
$parameters['nom_bact'] = $_SESSION['nom_bact'];

$parameters['codigos_pre'] = implode('|', $_SESSION['codigos_pre']);
$parameters['descripciones'] = implode('|', $_SESSION['descripciones']);

$parameters['tipos'] = implode('|', $_SESSION['tipos']);
$parameters['rdonante'] = implode('|', $_SESSION['rdonante']);

$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsGrabarEncuesta', $parameters);

$database->disconnect();


$_SESSION['parameters'] = $parameters;

unset($Client);

date_default_timezone_set("America/Bogota");

if ($resultado === false) {

    $resultado = "F|--NO HAY SISTEMA DE LABORATORIO EN ESTE MOMENTO O SE ESTA REALIZANDO COPIA DE SEGURIDAD. INTENTE NUEVAMENTE. <br/><br/>Fecha y Hora: " . date('d/m/Y H:m:s'); // Significa que 4D Fallo
    $_SESSION['resGrabEnc'] = $resultado;
} else {
    /*
     * 4th Dimension responde con las siguientes mensajes:
     *
     * resGrabEnc:="1|LA ENCUESTA SE GRABO EXITOSAMENTE."
     * resGrabEnc:="0|LA ENCUESTA NO SE GRABO CORRECTAMENTE. INTENTE DE NUEVO. Hist: "+String($hist)+" det: "+String($det)+" Enc: "+String($enc)
     */
    $_SESSION['resGrabEnc'] = $resultado;

    
    // Marcar la encuesta como validada para que no intenten validarla 2 veces
    // Esto solo si el resultado de la Grabacion en 4D fue Exitoso.
    
    if (substr($resultado, 0, 1) == "1") {
        
        $donante=$_SESSION['encOtDon'];
        $sql = "UPDATE  banco_encuesta_enc_tmp SET Observaciones='CONFIRMADA'  WHERE  nro_consecutivo = '$donante'";
        $db->query($sql);
        unset($_SESSION['encOtDon']);
    }
}

echo $resultado;
?>
