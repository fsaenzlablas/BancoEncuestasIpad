<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Programa: revisarEncuesta.php
//
// El programa consiste en validar que todas las preguntas tengan su
// respuesta sino informar la situación, existen respuestas dependientes
// 
// ------------------------------------------------------------------------

$malas = array();
$sw = 0;
$aceptarCond = 0; // No permitir Aceptarla condicionalmente
$rechazarAut = 0; // No Rechazarla Automaticamente


for ($i = 0; $i < sizeof($_SESSION['codigos_pre']); $i++) {
    $sw = 1;
    // ------------------------------------------------------------------------
    // Si la pregunta es del tipo SI-NO debemos averiguar si tiene respuesta
    // en caso de que no la tenga almacenar el numero de la pregunta.
    // ------------------------------------------------------------------------

    if (($_SESSION['tipos'][$i] == "SI-NO") and ($_SESSION['rdonante'][$i] == "")) {
        # Una pregunta sin respuesta es un error del usuario
        array_push($malas, $_SESSION['secuencias'][$i]);
    } else {
        if (($_SESSION['tipos'][$i] == "SELECCION") and ($_SESSION['rdonante'][$i] == "NO APLICA") and ($_SESSION['rdonante'][$i - 1] != $_SESSION['resperadas'][$i - 1])) {
            # Una pregunta de seleccion sin respuesta, cuando la anterior (tipo SI-NO) no es la esperada es un error del usuario
            array_push($malas, $_SESSION['secuencias'][$i]);
        }
    }

    // --------------------------------------------------------------------------
    // Si la pregunta es de mucha importancia (criticidad 2) se debe rechazar
    // la encuesta inmediatamente.
    // --------------------------------------------------------------------------

    $tiene_resp = $_SESSION['rdonante'][$i] != "" ? true : false;

    // ---------------------------------------------------------------------------
    // Validar la criticidad de las preguntas solo si es necesario, o sea mientras
    // no este rechazada
    // ---------------------------------------------------------------------------

    if ($rechazarAut == 0) {

        if (($_SESSION['criticidades'][$i] == '0') or ($_SESSION['criticidades'][$i] == '1')) {

            //
            // Pregunta no critica se puede aceptar condicionalmente si la respuesta no es la esperada
            //

            if ($tiene_resp) {

                if ($_SESSION['tipos'][$i] == "SI-NO") {

                    if ($_SESSION['rdonante'][$i] != $_SESSION['resperadas'][$i]) {
                        $aceptarCond = 1;
                    }
                } else {

                    if ($_SESSION['rdonante'][$i] != "NO APLICA") {
                        $aceptarCond = 1;
                    }
                }
            } else {
                // No tiene respuesta Aceptar condicionalmente por ahora
                $aceptarCond = 1;
            }
        } else if ($_SESSION['criticidades'][$i] == '2') {

            // Pregunta critica se debe rechazar inmediatamente la encuesta  si la respuesta no es la esperada
            if ($tiene_resp) {

                if ($_SESSION['tipos'][$i] == "SI-NO") {

                    # La respuesta esperada para el grado critico 2 de tipo SI-NO debe ser la configurada (esperada)

                    if ($_SESSION['rdonante'][$i] != $_SESSION['resperadas'][$i]) {
                        $rechazarAut = 1;
                    }
                } else {

                    # La respuesta esperada con grado critico 2 del tipo seleccion debe ser NO APLICA

                    if ($_SESSION['rdonante'][$i] != "NO APLICA") {
                        $rechazarAut = 1;
                    }
                }
            } else {
                // No tiene respuesta Rechazar la encuesta  por ahora
                $rechazarAut = 1;
            }
        }
    }



 } // For


$msg = "S|EXISTEN PREGUNTAS SIN RESPONDER, POR FAVOR REVISE<BR><BR>"; // El cero significa que hay error.

for ($i = 0; $i < sizeof($malas); $i++) {
    $msg.="Pregunta N&uacute;mero {$malas[$i]} sin respuesta.<BR>";
    $_SESSION['statusEnc'] = "S";
}

if (sizeof($malas) == 0) {

    if ($rechazarAut == 1) {
        // No borrar el status 2, significa que no faltan respuestas y que fue rechazado automaticamente
        $msg = "R|ENCUESTA TERMINADA, COMUNIQUESE CON LA PERSONA RESPONSABLE [RA]";
        $_SESSION['statusEnc'] = "R";
    } else {
        if ($aceptarCond == 1) {
            // No borrar el 3, significa que no faltan respuestas y que se puede aceptar condicionalmente
            $msg = "C|ENCUESTA TERMINADA EXITOSAMENTE, COMUNIQUESE CON LA PERSONA RESPONSABLE [OC]";
            $_SESSION['statusEnc'] = "C";
        } else {
            // No borrar el 1, significa que no faltan respuestas y que se puede aceptar totalmente automaticamente
            $msg = "O|ENCUESTA TERMINADA EXITOSAMENTE, COMUNIQUESE CON LA PERSONA RESPONSABLE [OK]";
            $_SESSION['statusEnc'] = "O";
        }
    }
}

$_SESSION['revisarEnc'] = $msg;

echo $msg;
?>
