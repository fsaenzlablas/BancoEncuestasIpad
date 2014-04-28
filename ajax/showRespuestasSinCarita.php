<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Capturar el numero de la OT del donante digitado 
// ------------------------------------------------------------------------
$num_ot=$_POST['num_ot'];

if ($num_ot != "") {

    // ------------------------------------------------------------------------
    // Buscar las respuestas grabadas anteriormente
    // ------------------------------------------------------------------------

    if (isset($_SESSION[$num_ot]['codigos_pre'])) {

        $i = 0;


        $htmlCode = "<table border='1'  width='100%'>";

        for ($i = 0; $i < sizeof($_SESSION[$num_ot]['codigos_pre']); $i++) {
            $j = $i+1;
            // ------------------------------------------------------------------------
            // Mostrar las preguntas tal con un icono de cara feliz o triste segun
            // la respuesta
            // ------------------------------------------------------------------------

            $p = $_SESSION[$num_ot]['secuencias'];

            if ((($_SESSION[$num_ot]['tipos'][$i] == "SELECCION") and ($_SESSION[$num_ot]['rdonante'][$i] != "NO APLICA")) OR (($_SESSION[$num_ot]['tipos'][$i] == "SI-NO") )) {
                $htmlCode .= <<< HTML
                <tr id='pregunta_$p'>
                    <td id='pregunta_{$p}_col1'  width='10%' align='center'><h3>{$j}</h3></td>
                    <td id='pregunta_{$p}_col2'  width='60%' align='left'><h3>{$_SESSION[$num_ot]['descripciones'][$i]}</h3></td>
                    <td id='respuesta_{$p}_col2' width='20%' align='center'><strong>{$_SESSION[$num_ot]['rdonante'][$i]}<strong></td>
                </tr>

HTML;

            }
        }

        $htmlCode .= "</table>";
        echo $htmlCode;
    }

}
?>
