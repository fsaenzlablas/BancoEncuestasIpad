<?php
// ------------------------------------------------------------------------
// Programa: getEncuesta.php
//
// Consulta la encuesta grabada y contestada y/o validada
// ------------------------------------------------------------------------
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
    // Verificar si la encuesta esta confirmada y validada, en ese caso 
    // debe informar al usuario.
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='SIN CONFIRMAR'";
    $rec = $db->get_row($sql);

    if (isset($rec->nombre)) {

        $bresp = $rec->cod_bacteriologa;

        $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante'";
        $rec = $db->get_row($sql);

        // ------------------------------------------------------------------------
        // La encuesta ya tiene respuestas pero no esta confirmada se debe validar
        // la encuesta para aceptarla condicionalmente, o si ya esta rechazada
        // o aceptada automaticamente permitir al operador grabar la encuesta.
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


        die("2|$htmlCode");
    }

    
    // ------------------------------------------------------------------------
    // Intentar determinar si la encuesta esta contestada y validada
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='CONFIRMADA'";
    $rec = $db->get_row($sql);

    // Atencion nombre con MINUSCULAS
    if (isset($rec->nombre)) {
        $bresp = $rec->cod_bacteriologa;

        $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante'";
        $rec = $db->get_row($sql);

        if (isset($rec->Nombre)) {

            // ------------------------------------------------------------------------
            // La encuesta ya tiene respuestas pero no esta confirmada se debe validar
            // la encuesta para aceptarla condicionalmente, o si ya esta rechazada
            // o aceptada automaticamente permitir al operador grabar la encuesta.
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
            $htmlCode .= "<h3>Estado de la encuesta:  CONTESTADA Y VALIDADA</h3><br>";


            die("2|$htmlCode");
        }
    }

    
    
    // ------------------------------------------------------------------------
    // La encuesta No tiene respuestas
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
    $rec = $db->get_row($sql);

    if (isset($rec->Nombre)) {
        die("0|<div class='error'>LA ENCUESTA NO TIENE RESPUESTAS</div>");
    }
    
    
    
    // ------------------------------------------------------------------------
    // Si la encuesta ya fue contestada desde 4D, informar al usuario.
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta <> 'PE'";
    $rec = $db->get_row($sql);

    if (isset($rec->Nombre)) {
        die("0|<div class='error'>LA ENCUESTA YA FUE CONTESTADA DESDE 4D</div>");
    }

        

    
    // ------------------------------------------------------------------------
    // Ninguno de casos anteriores indica que el numero de donacion no existe.
    // ------------------------------------------------------------------------


    $htmlCode = "<div class='error'>DONANTE NO EXISTE O LA ENCUESTA FUE CONTESTADA DESDE 4D.</div>";
    die("0|$htmlCode");
}
?>


}
?>
