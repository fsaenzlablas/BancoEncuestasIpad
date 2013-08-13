<?php

// ------------------------------------------------------------------------
// Programa: configEncuesta.php
//
// Buscar todos las preguntas a las encuesta de donación para iniciar
// los arreglos de SESSION que permitiran grabar la encuesta
// ------------------------------------------------------------------------
$num_ot ="0072293BD";
$_SESSION[$num_ot]['enc_terminada'] = "SI";
echo "ASIGNE SI";
die();

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php"); $db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);



date_default_timezone_set("America/Bogota");
$conse ="0072293BD";

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$sql = <<< INSERT
UPDATE banco_enfermeras SET nombre = 'JAKELINE ALVAREZ' WHERE RecordNumber = 999;
INSERT;


$sql = <<< INSERT
INSERT INTO banco_enfermeras (registro, codigo_nomina, nombre, estado, RecordNumber)
    VALUES ('998', '998', 'JAKELINE MATEUS', 0, 998),
           ('999', '999', 'JAKELINE MATEUS', 0, 999);
INSERT;


$sql = <<< INSERT
DELETE FROM banco_enfermeras WHERE RecordNumber = 999 or RecordNumber = 998;
INSERT;


$n =  $db->query($sql);


var_dump($n);
var_dump($db->last_error);
var_dump($db->last_query);



if ($db->query($sql) ) {

    echo $db->query($sql);

} else {
    echo "<br>F|Fallo al ejecutar: $sql";
}

die();

unset($_SESSION['0072293BD']['reinicios']);
die();

session_start();
$_SESSION["usuario_encuesta"] = "JAIME";

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

die();


$_SESSION['arrSql'] = array();
$codigos = array();
$secuencias = array();
$descripciones = array();
$tipopsig = array();  // Tipo de la pregunta siguiente
$cod_sig=array(); // Codigo de la pregunta siguiente

$tipos = array();
$resperada = array();
$criticidad = array();

$seleccion = array();
$sexos = array();

$rdonante = array();
$objresp = array();
$objhtml = "<select><option value'NA'>Seleccione...</option></select>";

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

if (isset($_POST['cod_bact'])) {
    $cod_bact = $_POST['cod_bact'];
    $nom_bact = $_POST['nom_bact'];
} else {
    $cod_bact = $_SESSION['cod_bact'];
    $nom_bact = $_SESSION['nom_bact'];
}

// ------------------------------------------------------------------------
// Buscar todas las preguntas de la encuesta que esten activas en su orden
// respectivo
// ------------------------------------------------------------------------

$sexo = $_SESSION['encSexDonante'] == 'F' ? 'FE' : 'MA';
$sql = "SELECT * FROM banco_encuesta WHERE activa=1 AND sexo IN ('AM', '$sexo') ORDER BY secuencia ASC;";
//echo $sql;

unset($_SESSION['primera_preg']);

if ($preguntas = $db->get_results($sql, ARRAY_A)) {
    foreach ($preguntas as $pregunta) {

        $p = $pregunta['codigo'];

        if (!isset($_SESSION['current']) ) {
            $_SESSION['current']=$p;
        }

        array_push($codigos, $pregunta['codigo']);
        array_push($secuencias, $pregunta['secuencia']);
        array_push($descripciones,  htmlentities($pregunta['descripcion'], ENT_COMPAT));

        array_push($tipos, $pregunta['tipo']);
        array_push($resperada, $pregunta['respuesta_esp']);
        array_push($criticidad, $pregunta['criticidad']);

        array_push($seleccion, $pregunta['seleccion']);
        array_push($sexos, $pregunta['sexo']);

        array_push($rdonante, "");      // Respuesta del donante, se inicializa en NULO: No contestada
    }

    // ------------------------------------------------------------------------
    // Por cada pregunta se debe saber que tipo de pregunta sigue para saber
    // si se debe preguntar la siguiente. Preguntas tipo SI-NO cuya respuesta
    // no es la esperada deben tener una aclaratoria despues de ella.
    // ------------------------------------------------------------------------

    $cod_sig=$codigos;
    $tipopsig=$tipos;

    $item=array_shift($tipopsig);
    array_push($tipopsig, "");

    $item=array_shift($cod_sig);
    array_push($cod_sig, "LAST");

    for ($i = 0; $i < sizeof($codigos); $i++) {

        $p = $codigos[$i];            // Codigo de pregunta
        $tipo_preg = $tipos[$i];      // Tipo de la  pregunta
        $tipo_next = $tipopsig [$i];  // Tipo de la siguiente pregunta
        $cod_next = $cod_sig [$i];    // Codigo de la siguiente pregunta
        $re = $resperada[$i];         // Respuesta esperada a la pregunta
        //
        // ------------------------------------------------------------------------
        // Por cada pregunta se debe armar un objeto HTML que servira para capturar
        // la respuesta del donante.
        // ------------------------------------------------------------------------

        $objhtml = "";

        if ($tipos[$i] == "SI-NO") {
            $re = $resperada[$i];

            $objhtml.="<input type='radio' class='big-radio' group='respuesta_$p' id='respuesta_$p' name='respuesta_$p' value='SI' onClick=\"onClickRadio(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next')\"><span class='large-font'>&nbsp;&nbsp;SI</span></input>";
            $objhtml.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $objhtml.="<input type='radio' class='big-radio' group='respuesta_$p' id='respuesta_$p' name='respuesta_$p' value='NO' onClick=\"onClickRadio(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next')\"><span class='large-font'>&nbsp;&nbsp;NO</span></input>";
            //$objhtml.= "<input type='checkbox' id='iphoneCheckBox' />";
        } else if ($tipos[$i] == "SELECCION") {
            $re = "NA";
            $codigos_resp = array();
            $detalle_resp = array();
            $DEBUGGER=array();

            // por cada respuesta de seleccion multiple debemos buscar sus opciones
            // y armar un combo-box

            $sql = "SELECT d.codigo, d.detalle FROM banco_enc_sel s, banco_enc_det_sel d WHERE s.detalle ='{$seleccion[$i]}' AND s.codigo=d.codigo_enc ORDER BY s.codigo ASC";
            array_push($_SESSION['arrSql'], $sql );

            $opciones_resp = $db->get_results($sql);
            //array_push($_SESSION['arrSql'], $opciones_resp);
            if ($opciones_resp) {
                foreach ($opciones_resp as $opcion) {
                    array_push($codigos_resp, $opcion->codigo);
                    array_push($detalle_resp, htmlentities($opcion->detalle, ENT_COMPAT));
                }
            }

            $db->debug();


            $OpcionesSelect = " class='combo-box-resp' id='respuesta_$p'  onChange=\"onChangeComboBox(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next')\"";
            $list = new PopUp($codigos_resp, $detalle_resp, "respuesta_$p", "NO APLICA", "Seleccione su respuesta", "NO APLICA", 270, $OpcionesSelect);
            $objhtml = $list->getHtml();
        } else {
            $objhtml = "<span>Tipo de pregunta no correcto</span>";
        }

        array_push($objresp, $objhtml); // Objeto en HTML que contiene la respuesta
    }
}

//
// Guardar en variables de sesion la informacion de preguntas
//

$_SESSION['codigos_pre'] = $codigos;
$_SESSION['secuencias'] = $secuencias;
$_SESSION['descripciones'] = $descripciones;

$_SESSION['tipos'] = $tipos;
$_SESSION['tipos_sig'] = $tipopsig;
$_SESSION['cod_sig'] = $cod_sig;

$_SESSION['resperadas'] = $resperada;
$_SESSION['criticidades'] = $criticidad;

$_SESSION['selecciones'] = $seleccion;
$_SESSION['sexo'] = $sexo;

$_SESSION['rdonante'] = $rdonante; // Respuesta del donante, se inicializa en blancos
$_SESSION['objresp'] = $objresp;  // Objeto en HTML que contiene la respuesta

$_SESSION['cod_bact'] = $cod_bact;
$_SESSION['nom_bact'] = $nom_bact;
?>



