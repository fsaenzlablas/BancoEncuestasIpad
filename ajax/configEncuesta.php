<?php

//@session_start();//29 oct 2013
//no empieza la sesion aqui 
//8 de marzo de 2014

// ------------------------------------------------------------------------
// Programa: configEncuesta.php
//
// Buscar todos las preguntas a las encuesta de donación para iniciar
// los arreglos de SESSION que permitiran grabar la encuesta
// ------------------------------------------------------------------------



if (isset($_POST['num_ot'])) {
    $num_ot = trim($_POST['num_ot']);//15 nov

    if (isset($_POST['cod_bact'])) {
        $cod_bact = $_POST['cod_bact'];
        $nom_bact = $_POST['nom_bact'];

        unset ($_SESSION[$num_ot]['cod_bact']);
        unset ($_SESSION[$num_ot]['nom_bact']);

    } else {
        $cod_bact = $_SESSION[$num_ot]['cod_bact'];
        $nom_bact = $_SESSION[$num_ot]['nom_bact'];
    }

}

$_SESSION[$num_ot]['encOtDon'] = $num_ot;//12 de noviembre



//$_SESSION["tipo_encuesta"] 30 de diciembre 2013
if (isset($_POST['tipoEncuesta'])) {
 
 //   if   ( 0) {//$_SESSION['tipo_encuesta'] != $_POST['tipoEncuesta'])
    if   (0){



         unset ($_SESSION[$num_ot]['codigos_pre']);
         unset ($_SESSION[$num_ot]['secuencias'] );
         unset ($_SESSION[$num_ot]['descripciones'] );

         unset ($_SESSION[$num_ot]['tipos'] );
         unset ($_SESSION[$num_ot]['tipos_sig'] );
         unset ($_SESSION[$num_ot]['cod_sig']);

         unset ($_SESSION[$num_ot]['resperadas']);
         unset ($_SESSION[$num_ot]['criticidades'] );

         unset ($_SESSION[$num_ot]['selecciones']);
         unset ($_SESSION[$num_ot]['sexo'] );

         unset ($_SESSION[$num_ot]['rdonante'] );// Respuesta del donante, se inicializa en blancos
         unset ($_SESSION[$num_ot]['objresp'] ); // Objeto en HTML que contiene la respuesta
    } 
   $_SESSION['tipo_encuesta'] = $_POST['tipoEncuesta']; 



}


$_SESSION[$num_ot]['arrSql'] = array();

$codigos = array();
$secuencias = array();
$descripciones = array();
$tipopsig = array(); // Tipo de la pregunta siguiente
$cod_sig = array(); // Codigo de la pregunta siguiente

$tipos = array();
$resperada = array();
$criticidad = array();

$seleccion = array();
$sexos = array();

$rdonante = array();
$objresp = array();
$objhtml = "<select><option value'NA'>Seleccione...</option></select>";

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php"; include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);


// ------------------------------------------------------------------------
// Buscar todas las preguntas de la encuesta que esten activas en su orden
// respectivo
// ------------------------------------------------------------------------

mysql_set_charset('utf8');//11 de dic 2013

$sexo = "AM";
$sqlGenero = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$num_ot' ";
$recGenero = $db->get_row($sqlGenero);

if ( isset($recGenero->Sexo)) {
  $sexo= $recGenero->Sexo; 
}
$sexo = $sexo == 'F' ? 'FE' : 'MA';
//$sexo = $_SESSION[$num_ot]['encSexDonante'] == 'F' ? 'FE' : 'MA';
//$sexo = $_SESSION["GeneroDonante"]== 'Masculino' ? 'MA' : 'FE';



//$sql = "SELECT * FROM banco_encuesta WHERE activa=1 AND sexo IN ('AM', '$sexo') AND (codigo%2=1) ORDER BY secuencia ASC;";
$prefijoEncuesta = "";

$tipoenconfigencuesta = intval($_SESSION["tipo_encuesta"]) ;
$sql = "SELECT * FROM banco_encuesta WHERE activa=1 AND sexo IN ('AM', '$sexo') AND postdonacion = $tipoenconfigencuesta   ORDER BY secuencia ASC;";
//echo $sql;
//
unset($_SESSION[$num_ot]['primera_preg']);

if ($preguntas = $db->get_results($sql, ARRAY_A)) {
    foreach ($preguntas as $pregunta) {

        $p = $pregunta['codigo'];

        if (!isset($_SESSION[$num_ot]['current'])) {
            $_SESSION[$num_ot]['current'] = $p;
        }

        array_push($codigos, $pregunta['codigo']);
        array_push($secuencias, $pregunta['secuencia']);
         
      //  $vDesPregunta = htmlentities($pregunta['descripcion'], ENT_COMPAT,"UTF-8");

      //  array_push($descripciones, htmlentities($pregunta['descripcion'], ENT_COMPAT));
 //array_push($descripciones, $pregunta['descripcion']);

 //      array_push($descripciones, htmlentities($pregunta['descripcion'], ENT_SUBSTITUTE));

        //Algunos caracteres no aparecen .

        

       // $vDesPregunta = htmlentities($pregunta['descripcion'], ENT_SUBSTITUTE);//"UTF-8");
           $vDesPregunta = htmlentities($pregunta['descripcion'], ENT_COMPAT);
  //  $vDesPregunta = htmlentities($pregunta['descripcion'], ENT_QUOTES | ENT_SUBSTITUTE);//"UTF-8");
      //     var $preg = $pregunta['descripcion'];
      //     $preg= str_replace("Ñ","&Ntilde;");
 //$vDesPregunta = htmlentities($preg, ENT_QUOTES | ENT_SUBSTITUTE);//"UTF-8");

      array_push($descripciones, $vDesPregunta);

        array_push($tipos, $pregunta['tipo']);
        array_push($resperada, $pregunta['respuesta_esp']);
        array_push($criticidad, $pregunta['criticidad']);

        array_push($seleccion, $pregunta['seleccion']);
        array_push($sexos, $pregunta['sexo']);

        array_push($rdonante, ""); // Respuesta del donante, se inicializa en NULO: No contestada
    }

}


array_push($codigos, "FIRMA");
array_push($secuencias, $pregunta['secuencia'] + 1);
array_push($descripciones, "<div class='alert'> Por favor despues de haber firmado, presione el bot&oacute;n [Finalizar encuesta]</div>");

array_push($tipos, "FIRMA");
array_push($resperada, "NA");
array_push($criticidad, 0);

array_push($seleccion, "NA");
array_push($sexos, $pregunta['sexo']);

array_push($rdonante, ""); // Respuesta del donante, se inicializa en NULO: No contestada


// ------------------------------------------------------------------------
// Por cada pregunta se debe saber que tipo de pregunta sigue para saber
// si se debe preguntar la siguiente. Preguntas tipo SI-NO cuya respuesta
// no es la esperada deben tener una aclaratoria despues de ella.
// ------------------------------------------------------------------------

$_SESSION[$num_ot]['primera_preg'] = $codigos{0};

$cod_sig = $codigos;
$tipopsig = $tipos;

$item = array_shift($tipopsig);
array_push($tipopsig, "");

$item = array_shift($cod_sig);
array_push($cod_sig, "LAST");

for ($i = 0; $i < sizeof($codigos); $i++) {

    $p = $codigos[$i]; // Codigo de pregunta
    $tipo_preg = $tipos[$i]; // Tipo de la  pregunta
    $tipo_next = $tipopsig [$i]; // Tipo de la siguiente pregunta
    $cod_next = $cod_sig [$i]; // Codigo de la siguiente pregunta
    $re = $resperada[$i]; // Respuesta esperada a la pregunta
    //
    // ------------------------------------------------------------------------
    // Por cada pregunta se debe armar un objeto HTML que servira para capturar
    // la respuesta del donante.
    // ------------------------------------------------------------------------

    $objhtml = "";

    if ($tipos[$i] == "SI-NO") {
        $re = $resperada[$i];

        $objhtml .= "<input type='radio' class='big-radio' group='respuesta_$p' id='respuesta_$p' name='respuesta_$p' value='SI' onClick=\"onClickRadio(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next', '$num_ot', '$p')\"><span class='large-font'>&nbsp;&nbsp;SI</span></input>";
        $objhtml .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $objhtml .= "<input type='radio' class='big-radio' group='respuesta_$p' id='respuesta_$p' name='respuesta_$p' value='NO' onClick=\"onClickRadio(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next', '$num_ot', '$p')\"><span class='large-font'>&nbsp;&nbsp;NO</span></input>";
        //$objhtml.= "<input type='checkbox' id='iphoneCheckBox' />";
    } else if ($tipos[$i] == "SELECCION") {
        $re = "NA";
        $codigos_resp = array();
        $detalle_resp = array();


        // por cada respuesta de seleccion multiple debemos buscar sus opciones
        // y armar un combo-box

        $sql = "SELECT d.codigo, d.detalle FROM banco_enc_sel s, banco_enc_det_sel d WHERE s.detalle ='{$seleccion[$i]}' AND s.codigo=d.codigo_enc ORDER BY s.codigo ASC";
        array_push($_SESSION[$num_ot]['arrSql'], $sql);

        $opciones_resp = $db->get_results($sql);
        //array_push($_SESSION[$num_ot]['arrSql'], $opciones_resp);
        if ($opciones_resp) {
            foreach ($opciones_resp as $opcion) {
                array_push($codigos_resp, $opcion->codigo);
                array_push($detalle_resp, htmlentities($opcion->detalle, ENT_COMPAT));
            }
        }


        $OpcionesSelect = " class='combo-box-resp' id='respuesta_$p'  onChange=\"onChangeComboBox(this, '$tipo_preg', '$re', '$tipo_next', '$cod_next', '$num_ot' , '$p')\"";
        $list = new PopUp($codigos_resp, $detalle_resp, "respuesta_$p", "NO APLICA", "Seleccione su respuesta", "NO APLICA", 270, $OpcionesSelect);
        $objhtml = $list->getHtml();
    } else if ($tipos[$i] == "FIRMA") {
        $objhtml ='';
    } else {
        $objhtml = "<span>Tipo de pregunta no correcto</span>";
    }

    array_push($objresp, $objhtml); // Objeto en HTML que contiene la respuesta
}


//
// Guardar en variables de sesion la informacion de preguntas
//


$_SESSION[$num_ot]['codigos_pre'] = $codigos;
$_SESSION[$num_ot]['secuencias'] = $secuencias;
$_SESSION[$num_ot]['descripciones'] = $descripciones;

$_SESSION[$num_ot]['tipos'] = $tipos;
$_SESSION[$num_ot]['tipos_sig'] = $tipopsig;
$_SESSION[$num_ot]['cod_sig'] = $cod_sig;

$_SESSION[$num_ot]['resperadas'] = $resperada;
$_SESSION[$num_ot]['criticidades'] = $criticidad;

$_SESSION[$num_ot]['selecciones'] = $seleccion;
$_SESSION[$num_ot]['sexo'] = $sexo;

$_SESSION[$num_ot]['rdonante'] = $rdonante; // Respuesta del donante, se inicializa en blancos
$_SESSION[$num_ot]['objresp'] = $objresp; // Objeto en HTML que contiene la respuesta

$_SESSION[$num_ot]['cod_bact'] = $cod_bact;
$_SESSION[$num_ot]['nom_bact'] = $nom_bact;


//12 de noviembre
   $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$num_ot' ";
    $rec = $db->get_row($sql);

    $vEstadoEncuesta ="PE";
    
  if ( isset($rec->Nombre)) {//if (isset($rec->Nombre)) {
        $donante =$num_ot ;
        $_SESSION[$donante]['encOtDon'] = $donante;
        $_SESSION[$donante]['encCCDon'] = $rec->Cedula;

        $_SESSION[$donante]['encNombreDon'] = $rec->Nombre;
        $_SESSION[$donante]['encApellido1Don'] = $rec->Apellido1;
        $_SESSION[$donante]['encApellido2Don'] = $rec->Apellido2;
        $_SESSION[$donante]['encReceptor'] = $rec->Receptor;
        $_SESSION[$donante]['encSexDonante'] = $rec->Sexo;
        $_SESSION[$donante]['cod_bact'] = $rec->Bacteriologa;
        $vEstadoEncuesta=$rec->Encuesta ;
        if ($vEstadoEncuesta != ""){
            $prefijoEncuesta = "-";
        }
}

//echo $prefijoEncuesta+$num_ot;//13 nov
?>



