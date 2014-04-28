<?php
/* 
 * Rutina para generar las respuestas esperadoas en todas las preguntas,
 * Sirve para hacer debugger
 */

@session_start();//29 oct 2013

if (isset($_GET['num_ot'])) {
    $num_ot = $_GET['num_ot'];

    for ($i = 0; $i < sizeof($_SESSION[$num_ot]['descripciones']); $i++) {

        if ($_SESSION[$num_ot]['tipos'][$i] == "SI-NO") {
            $_SESSION[$num_ot]['rdonante'][$i] = $_SESSION[$num_ot]['resperadas'][$i];
        } else {
            $_SESSION[$num_ot]['rdonante'][$i] = "NO APLICA";
        }

    }


    $_SESSION['parameters'] = "";
    $_SESSION['resGrabEnc'] = "";


    echo "Encuesta contestada";
    include "control.php";
} else {
    echo "Suministre una OT de donante";
}

?>
