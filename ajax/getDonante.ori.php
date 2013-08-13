<?php

// ------------------------------------------------------------------------
// Programa: getDonante.php
//
// El programa consiste en capturar un nuemero de OT de donante
// y buscar el estado de la encuesta. para pemitir capturar sus respuestas
// o validar la misma
// ------------------------------------------------------------------------
// 
// ------------------------------------------------------------------------
// Incluir bibliotecas y clases necesarias
// ------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// ------------------------------------------------------------------------
// Capturar el numero de la OT del donante digitado
// ------------------------------------------------------------------------

$donante = $_POST['donante'];

if ($donante != "") {


    // ------------------------------------------------------------------------
    // Buscar si ese numero de OT Donante realmente si existe con estado PE
    // (Pendiente) en la tabla banco_registro. Si es asi implica que la encuesta
    // no ha sido conestada y hay que capturar sus respuestas.
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='SIN CONFIRMAR'";

    $rec = $db->get_row($sql);

    // Atencion nombre con MINUSCULAS

    if (isset($rec->nombre)) {  // Encuesta tiene registros implica que debo ir a validar (estado 2)
        $bresp = $rec->cod_bacteriologa;

        $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
        $rec = $db->get_row($sql);

        if (isset($rec->Nombre)) {
            // ------------------------------------------------------------------------
            // Almacenar en variables de session los datos del coponente que se intenta
            // aplicar a un paciente.
            // ------------------------------------------------------------------------


            $_SESSION['encOtDon'] = $donante;
            $_SESSION['encCCDon'] = $rec->Cedula;

            $_SESSION['encNombreDon'] = $rec->Nombre;
            $_SESSION['encApellido1Don'] = $rec->Apellido1;
            $_SESSION['encApellido2Don'] = $rec->Apellido2;
            $_SESSION['encReceptor'] = $rec->Receptor;
            $_SESSION['encSexDonante'] = $rec->Sexo;
            $_SESSION['cod_bact'] = $rec->Bacteriologa;

            // ------------------------------------------------------------------------
            // Si la encuesta tiene respuestas debe validar y mostrar los detalles de esta
            // ------------------------------------------------------------------------

            $sql = "SELECT * FROM banco_bacteriologas b  WHERE b.codigo = '$bresp'";
            $bact = $db->get_row($sql);
            $_SESSION['nom_bact'] = htmlentities($bact->nombre, ENT_COMPAT);

            $htmlCode = "<br>";

            $nomb = htmlentities($rec->Nombre, ENT_COMPAT);
            $ape1 = htmlentities($rec->Apellido1, ENT_COMPAT);
            $ape2 = htmlentities($rec->Apellido2, ENT_COMPAT);
            $rece = htmlentities($rec->Receptor, ENT_COMPAT);


            $htmlCode .= "<h2>C&eacute;dula: {$rec->Cedula}      Consecutivo donaci&oacute;n: {$_SESSION['encOtDon']}</h2>";
            $htmlCode .= "<h2>Nombres: {$nomb} {$ape1} {$ape2}</h2>";
            $htmlCode .= "<h2>Fecha de Nacimiento: (A/M/D) {$rec->Fecha_Nac} Sexo: {$rec->Sexo}</h2>";
            $htmlCode .= "<h3>Receptor: {$rece}</h3><br>";
            $htmlCode .= "<h3>Bacteriologa Responsable: " . htmlentities($bact->nombre, ENT_COMPAT) . "</h3><br>";
            $htmlCode .= "<h3>Estado de la encuesta:  CONTESTADA Y PENDIENTE POR VALIDAR</h3><br>";


            echo "2|" . $htmlCode;
        } else {
            echo "0|<div class='error'> ENCUESTA CON RESPUESTAS SIN ENTRADA EN BANCO REGISTRO. IMPOSIBLE!! </div>";
        }
    } else {

        $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='CONFIRMADA'";

        $rec = $db->get_row($sql);

        // Atencion nombre con MINUSCULAS

        if (!isset($rec->nombre)) {



            // ------------------------------------------------------------------------
            // Buscar si ese numero de OT Donante realmente si existe con estado PE
            // (Pendiente) en la tabla banco_registro y con un numero de OT mas un
            // caracter underline. Si es asi implica que la encuesta ya fue respondida
            // por el donante y hay que validarla y completar su información en 4D.
            // ------------------------------------------------------------------------


            $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta='PE'";

            $rec = $db->get_row($sql);


            if (isset($rec->Nombre) and ($rec->Encuesta == "PE")) {

                // ------------------------------------------------------------------------
                // Almacenar en variables de session los datos del coponente que se intenta
                // aplicar a un paciente.
                // ------------------------------------------------------------------------


                $_SESSION['encOtDon'] = $donante;
                $_SESSION['encCCDon'] = $rec->Cedula;

                $_SESSION['encNombreDon'] = $rec->Nombre;
                $_SESSION['encApellido1Don'] = $rec->Apellido1;
                $_SESSION['encApellido2Don'] = $rec->Apellido2;
                $_SESSION['encReceptor'] = $rec->Receptor;
                $_SESSION['encSexDonante'] = $rec->Sexo;

                // ------------------------------------------------------------------------
                // Si el componente existe se deben mostrar detalles del mismo.
                // ------------------------------------------------------------------------

                $htmlCode = "<br>";

                $nomb = htmlentities($rec->Nombre, ENT_COMPAT);
                $ape1 = htmlentities($rec->Apellido1, ENT_COMPAT);
                $ape2 = htmlentities($rec->Apellido2, ENT_COMPAT);
                $rece = htmlentities($rec->Receptor, ENT_COMPAT);


                $htmlCode .= "<h2>C&eacute;dula: {$rec->Cedula}      Consecutivo donaci&oacute;n: {$_SESSION['encOtDon']}</h2>";
                $htmlCode .= "<h2>Nombres: {$nomb} {$ape1} {$ape2}</h2>";
                $htmlCode .= "<h2>Fecha de Nacimiento: (A/M/D) {$rec->Fecha_Nac} Sexo: {$rec->Sexo}</h2>";
                $htmlCode .= "<h3>Receptor: {$rece}</h3><br>";
                $htmlCode .= "<h3>Estado de la encuesta: NO CONTESTADA</h3><br>";

                echo "1|" . $htmlCode;
            } else {
                echo "0|<div class='error'> DONANTE NO EXISTE O LA ENCUESTA FUE CONTESTADA </div>";
            }
        } else {
            echo "0|<div class='error'>LA ENCUESTA YA FUE CONTESTADA Y VALIDADA </div>";
        }
    }
}
?>
