<?php

// ------------------------------------------------------------------------
// Programa: grabarRespuesta.php
//
// Rutina AJAX que graba la respuesta a una pregunta especifica recibida
// como parametro.
// ------------------------------------------------------------------------


include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// -----------------------------------------------------------------------------------------
// Capturar todas los parametros que vienen en el POST.
// -----------------------------------------------------------------------------------------

$htmlCode = "";
$num_ot =$_POST['num_ot'];

$cod_preg = $_POST['cod_preg'];
$tipo_preg = $_POST['tipo_preg'];
$resp_preg = $_POST['resp_preg'];
$text_resp = $_POST['text_resp'];
$resp_esp = $_POST['resp_esp'];

$cod_next = $_POST['cod_next'];
$resp_next = $_POST['resp_next'];
$tipo_next = $_POST['tipo_next'];

// Si es la primera pregunta se debe marcar la encuesta como 'EN PROCESO' para que no pueda ser
// respondida por otro navegador

if ($_SESSION[$num_ot]['primera_preg'] == $cod_preg) {

    $fecha = date('Y-m-d');
    $cedula = $_SESSION[$num_ot]['encCCDon'];
    $bact = $_SESSION[$num_ot]['cod_bact'];
    $estado = "EP"; // En Proceso de ser contestada desde un IPAD
    $nombre = $_SESSION[$num_ot]['encNombreDon'] . " " . $_SESSION[$num_ot]['encApellido1Don'] . " " . $_SESSION[$num_ot]['encApellido2Don'];
    $obs = "EN PROCESO"; // Si se cambia este mensaje actualizar tambien en el script getDonante.php en la Linea 37

    $sql = <<< INSERT1
             INSERT INTO banco_encuesta_enc_tmp
                 (nro_consecutivo, cedula, fecha, estado, cod_bacteriologa, nombre, Observaciones) VALUES
                 ('{$num_ot}', '{$cedula}', '{$fecha}', '{$estado}', '{$bact}', '{$nombre}', '{$obs}');
INSERT1;


    // Si graba exitosamente el registro, al invocar la funcion query se retorna  1
   $db->query($sql);

}
// -----------------------------------------------------------------------------------------
// Si la pregunta tiene respuesta proceder a grabarla
// -----------------------------------------------------------------------------------------


if ( $cod_preg != "" ) {

    $key = array_search($cod_preg, $_SESSION[$num_ot]['codigos_pre']);

    // -----------------------------------------------------------------------------------------
    // Guardar la respuesta dada por el usuario en la variable de session
    // -----------------------------------------------------------------------------------------

    if ($tipo_preg == "SI-NO") {
        $_SESSION[$num_ot]['rdonante'][$key] = $resp_preg;
    } else {
        $_SESSION[$num_ot]['rdonante'][$key] = $text_resp;
    }

    // -----------------------------------------------------------------------------------------
    // Si la respuesta de una pregunta del tipo si-no NO ES la esperada y si la siguiente
    // pregunta a responder es de tipo Seleccion, deberá mostrar esa pregunta
    // -----------------------------------------------------------------------------------------
    $a="";
    if (($tipo_preg == "SI-NO") and ($tipo_next == "SELECCION") and ($resp_preg != $resp_esp)) {
        $_SESSION[$num_ot]['cod_next'] = $cod_next;
        $a="PASE POR 1";
    }

    // -----------------------------------------------------------------------------------------
    // Si la respuesta de una pregunta del tipo si-no ES la esperada y la siguiente pregunta a
    // responder es de tipo Seleccion, deberá saltarse esa pregunta y continuar con la siguiente
    // a esta.
    // -----------------------------------------------------------------------------------------

    if (($tipo_preg == "SI-NO") and ($tipo_next == "SELECCION") and ($resp_preg == $resp_esp)) {

        $key = array_search($cod_next, $_SESSION[$num_ot]['codigos_pre']);
        $_SESSION[$num_ot]['rdonante'][$key] = "NO APLICA";

        $nextNext = $_SESSION[$num_ot]['cod_sig'][$key];
        $key1 = array_search($nextNext, $_SESSION[$num_ot]['codigos_pre']);
        $_SESSION[$num_ot]['cod_next'] = $_SESSION[$num_ot]['codigos_pre'][$key1];
        $a="PASE POR 2: key:$key: nn:$nextNext key1: $key1 codnext: {$_SESSION[$num_ot]['codigos_pre'][$key1]} tp:$tipo_preg tn:$tipo_next rp:re:$resp_preg:$resp_esp ";
    } else {
        $_SESSION[$num_ot]['cod_next'] = $cod_next;
    }

    $_SESSION[$num_ot]['cod_ant'] = $cod_preg;

    // -----------------------------------------------------------------------------------------
    // Asignar la respuesta de la proxima pregunta dependiente si aplica
    // -----------------------------------------------------------------------------------------
    $_SESSION[$num_ot]['debug'] = $a;
    $_SESSION[$num_ot]['jaime'] = "  SESSION['rdonante'][0]: {$_SESSION[$num_ot]['rdonante'][0]}, cod_preg: $cod_preg, resp_preg: $resp_preg, resp_esperada: $resp_esp, text_resp: $text_resp, cod_next: $cod_next, resp_next: $resp_next, ";
    
}

// -----------------------------------------------------------------------------------------
// Si es la ultima pregunta agradecer al donante y solicitarle que se comunique con la 
// auxiliar para proceder.
// -----------------------------------------------------------------------------------------

$htmlCode="";

if ($_SESSION[$num_ot]['cod_next'] == "LAST") {
    $_SESSION[$num_ot]['origen_grab']="R";

   
    $htmlCode = "LA ENCUESTA HA TERMINADO. GRACIAS POR SU HONESTIDAD. POR FAVOR FIRME LA ENCUESTA Y DEVUELVA EL IPAD A LA AUXILIAR.";
 
   

    // --------------------------------------------------------------------------------------------
    // Proceder a grabar la encuesta en 4th Dimension. esta encuesta sera validada luego de que la
    // Auxiliar verifique las respuestas del usuario.
    // --------------------------------------------------------------------------------------------
    include_once("../ajax/grabarEncuestaMySQL.php");

    // --------------------------------------------------------------------------------------------
    // Si falla el acceso a 4D Debe mostrar el Boton de Reintento
    // --------------------------------------------------------------------------------------------

    if ( (substr($resultado, 0,1)=="F" ) OR (substr($resultado, 0,1)=="0") )  {
         $htmlCode .= "|".substr($resultado, 0,1)."-NO SE PUDO GRABAR LA ENCUESTA EN MYSQL. INTENTE GRABAR LA ENCUESTA NUEVAMENTE." ;
      
    } else if (substr($resultado, 0,1)=="1") {
         $htmlCode .= "|".substr($resultado, 0,1)."-".substr($resultado, 2);
    }
    
} else {

    // --------------------------------------------------------------------------------------------
    // Como no es la ultima pregunta debe seguir mostrando el botón "Pregunta Siguiente", en los
    // combo-box no se muestra el botón si la respuesta es NO APLICA.
    // --------------------------------------------------------------------------------------------

    if (isset($_SESSION[$num_ot]['cod_next']) and ($_SESSION[$num_ot]['cod_next'] != "LAST") AND ($resp_preg != "NO APLICA")) {
        $htmlCode = 'SP';
        #$htmlCode = '<input type="button" class="boton2" style="float:right;"  id="siguientePreg" onclick="showPregunta()" value="Pregunta Siguiente"/>';
    }
}
//echo $htmlCode.$_SESSION[$num_ot]['rdonante'][$key]."  ".$resp_preg;
echo $htmlCode;
?>
