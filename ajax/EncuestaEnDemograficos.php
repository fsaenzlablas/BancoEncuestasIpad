<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Incluir bibliotecas y clases necesarias
// ------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// ------------------------------------------------------------------------
// Capturar el numero de la OT del donante digitado 
// ------------------------------------------------------------------------
$num_ot="0076257BD";//$_POST['txtOrden'];
$donante=$num_ot

$secuencias = array();
$codigos = array();
$descripciones = array();
$valor = array();


if ($donante != "") {



    // ------------------------------------------------------------------------
    // Buscar las respuestas grabadas anteriormente
    // ------------------------------------------------------------------------
    
    $sql = "SELECT * FROM banco_mvto_encuesta_tmp m  WHERE m.nro_consecutivo = '$donante' ORDER BY orden ASC";
    //echo $sql;

    if ($respuestas = $db->get_results($sql, ARRAY_A)) {

        $i = 0;

        $htmlCode = "<br><h3 class='info'>Respuestas de la encuesta</h3>";
        $htmlCode .= "<table border='1' width='100%'>";

        foreach ($respuestas as $resp) {

            $i++;

            $p = $resp['codigo'];

            // ------------------------------------------------------------------------
            // Crear nuevamente las variables de session que serviran al momento de
            // grabar la encuesta en 4D
            // ------------------------------------------------------------------------

            

            // ------------------------------------------------------------------------
            // Mostrar las preguntas tal con un icono de cara feliz o triste segun
            // la respuesta
            // ------------------------------------------------------------------------
            
            if ((($resp['tipo'] == "SELECCION") and ($resp['valor'] != "NO APLICA")) OR (($resp['tipo'] == "SI-NO") )) {
                $htmlCode .= "<tr id='pregunta_$p'>";
                $htmlCode .= "<td id='pregunta_{$p}_col1'  width='10%' align='center'><h3>{$i}</h3></td>";
                
                if ($resp['criticidad'] == 2) {
                    $htmlCode .= "<td id='pregunta_{$p}_col2'  width='60%' align='left' bgcolor='ffff99'><h3>{$resp['descripcion']}</h3></td>";
                } else {
                     $htmlCode .= "<td id='pregunta_{$p}_col2'  width='60%' align='left'><h3>{$resp['descripcion']}</h3></td>";
                }
                

                $carita = $resp['carita'];
                $htmlCode .= "<td id='respuesta_{$p}_col2' width='20%' align='center'><strong>{$resp['valor']}<strong></td>";
                if ($carita == "feliz.png") {
                    $htmlCode .= "<td id='respuesta_{$p}_col1' width='20%' class='respuesta-correcta' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/$carita' ></img></td>";
                } else {
                    $htmlCode .= "<td id='respuesta_{$p}_col1' width='20%' class='respuesta-incorrecta' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/$carita' ></img></td>";
                }
                $htmlCode .= "</tr>";
            }
        }

        $htmlCode .= "</table>";
        echo $htmlCode;
    }	
 
    // ------------------------------------------------------------------------
    // Buscar el encabezado de la encuesta para saber si fue rechazada o no
    // automaticamente, o se debe aceptar condicionalmente
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.nro_Consecutivo = '$donante'";
    $rec = $db->get_row($sql);

    if (isset($rec->estado)) {
        $estado = $rec->estado;
    } else {
        $estado = "NA";
    }
}
?>
