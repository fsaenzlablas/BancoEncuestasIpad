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
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

date_default_timezone_set("America/Bogota");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------




$num_ot = $_POST['num_ot'];

$parameters = array();

$parameters['encOtDon'] = $_POST['num_ot'];
$parameters['encCCDonante'] = $_SESSION[$num_ot]['encCCDon'];

$parameters['encNombreDon'] = $_SESSION[$num_ot]['encNombreDon'];
$parameters['encApellido1Don'] = $_SESSION[$num_ot]['encApellido1Don'];
$parameters['encApellido2Don'] = $_SESSION[$num_ot]['encApellido2Don'];

$parameters['encEstado'] = $_POST['encEstado'];
$parameters['encAceptar'] = $_POST['encAceptar'];
$parameters['encComentarios'] = $_POST['encComentarios'];

$parameters['cod_bact'] = $_SESSION[$num_ot]['cod_bact'];
$parameters['nom_bact'] = $_SESSION[$num_ot]['nom_bact'];

$parameters['codigos_pre'] = implode('|', $_SESSION[$num_ot]['codigos_pre']);
$parameters['descripciones'] = implode('|', $_SESSION[$num_ot]['descripciones']);

$parameters['tipos'] = implode('|', $_SESSION[$num_ot]['tipos']);
$parameters['rdonante'] = implode('|', $_SESSION[$num_ot]['rdonante']);


$database = new FourDimensionAccess();
$database->connect();
$resultado = $database->call4DWebServer('wsGrabarEncuesta', $parameters);

$database->disconnect();

$_SESSION[$num_ot]['parameters'] = $parameters;

unset($Client);

if ($resultado === false) {

    $resultado = "F|NO HAY SISTEMA DE LABORATORIO EN ESTE MOMENTO O SE ESTA REALIZANDO COPIA DE SEGURIDAD. INTENTE NUEVAMENTE. <br/><br/>Fecha y Hora: " .
        date('d/m/Y H:m:s'); // Significa que 4D Fallo
    $_SESSION[$num_ot]['resGrabEnc'] = $resultado;
} else {
    /*
     * 4th Dimension responde con las siguientes mensajes:
     *
     * resGrabEnc:="1|LA ENCUESTA SE GRABO EXITOSAMENTE."
     * resGrabEnc:="0|LA ENCUESTA NO SE GRABO CORRECTAMENTE. INTENTE DE NUEVO."
     */
    $_SESSION[$num_ot]['resGrabEnc'] = $resultado;


    // Marcar la encuesta como validada para que no intenten validarla 2 veces
    // Esto solo si el resultado de la Grabacion en 4D fue Exitoso.

    if (substr($resultado, 0, 1) == "1") {

        $donante = $_SESSION[$num_ot]['encOtDon'];
        $sql = "UPDATE  banco_encuesta_enc_tmp SET Observaciones='CONFIRMADA'  WHERE  nro_consecutivo = '$donante'";
        $db->query($sql);
        // Borrar el array que contiene todos los datos de la encuesta que se acaba de responder y grabar


        unset($_SESSION[$num_ot]);
    }
}
echo $resultado;
?>
