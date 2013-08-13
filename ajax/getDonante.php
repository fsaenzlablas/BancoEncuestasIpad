<?php

// ------------------------------------------------------------------------
// Programa: getDonante.php
//
// El programa consiste en capturar un nuemero de OT de donante
// y buscar el estado de la encuesta. para pemitir capturar sus respuestas
// o validar la misma, en caso de que no exista o tenga respuestas informar
// al usuario.
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

//
//$tipoenconfigencuesta = intval(tipoEncuesta.value);//$_SESSION["tipo_encuesta"]) ;
$tipoenconfigencuesta =intval( $_SESSION["tipo_encuesta"]) ;
//

$donante = $_POST['num_ot'];
if ((sizeof ($_SESSION[$donante]) > 0) && ($tipoenconfigencuesta==0)) {
    die("4|<div class='error'>ESE N&Uacute;MERO DE OT ESTA SIENDO CONTESTADO EN OTRA PESTA&Ntilde;A DEL MISMO NAVEGADOR $tipoenconfigencuesta</div>");
}

if ($donante != "") {
    $_SESSION[$donante]=array();


    // ------------------------------------------------------------------------
    // Verificar que la encuesta no esta siendo contestada en este momento.
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='EN PROCESO'";
    $rec = $db->get_row($sql);

    // Atencion nombre con MINUSCULAS
    if (isset($rec->nombre)) {
        die("3|<div class='error'>LA ENCUESTA ESTA SIENDO CONTESTADA EN OTRO IPAD</div>");
    }

    // ------------------------------------------------------------------------
    // Verificar si la encuesta esta confirmada y validada, en ese caso 
    // debe informar al usuario.
    // ------------------------------------------------------------------------
	$sqlNumPregEnc = "SELECT COUNT(*) as cuenta FROM  banco_encuesta b WHERE  b.activa =1 ";
	$sqlNumMvtoEnc = "SELECT COUNT(*) as cuenta FROM  banco_mvto_encuesta b WHERE  b.nro_consecutivo = '$donante' ";

//Todas las preguntas activas deben estar validadas
$regPregEnc = $db->get_row($sqlNumPregEnc);
$regMvtoEnc = $db->get_row($sqlNumMvtoEnc);

$vNumPregEnc = $regPregEnc->cuenta;
$vNumMvtoEnc = $regMvtoEnc->cuenta;

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='CONFIRMADA'";
//    $rec = $db->get_row($sql);ya no se necesita

    // Atencion nombre con MINUSCULAS

	if ($regPregEnc->cuenta == $regMvtoEnc->cuenta ){//todas las preguntas estan contestadas .
//    if (isset($rec->nombre)) {
        die("0|<div class='error'>LA ENCUESTA YA FUE CONTESTADA Y VALIDADA</div>");
    }

    // ------------------------------------------------------------------------
    // Intentar determinar si la encuesta esta contestada y sin validar
    // ------------------------------------------------------------------------

    $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='SIN CONFIRMAR'";
    $rec = $db->get_row($sql);

    // Atencion nombre con MINUSCULAS
    if ((isset($rec->nombre)) && ($tipoenconfigencuesta==0)){
        $bresp = $rec->cod_bacteriologa;

       $sql = "SELECT * FROM banco_registro r  WHERE  r.Nro_Consecutivo = '$donante'  AND r.Encuesta = 'PE' ";
        $rec = $db->get_row($sql);

        if (isset($rec->Nombre)) {

            // ------------------------------------------------------------------------
            // La encuesta ya tiene respuestas pero no esta confirmada se debe validar
            // la encuesta para aceptarla condicionalmente, o si ya esta rechazada
            // o aceptada automaticamente permitir al operador grabar la encuesta.
            // ------------------------------------------------------------------------


            $_SESSION[$donante]['encOtDon'] = $donante;
            $_SESSION[$donante]['encCCDon'] = $rec->Cedula;

            $_SESSION[$donante]['encNombreDon'] = $rec->Nombre;
            $_SESSION[$donante]['encApellido1Don'] = $rec->Apellido1;
            $_SESSION[$donante]['encApellido2Don'] = $rec->Apellido2;
            $_SESSION[$donante]['encReceptor'] = $rec->Receptor;
            $_SESSION[$donante]['encSexDonante'] = $rec->Sexo;
            $_SESSION[$donante]['cod_bact'] = $rec->Bacteriologa;

            // ------------------------------------------------------------------------
            // Si la encuesta tiene respuestas debe validar y mostrar los detalles de esta
            // ------------------------------------------------------------------------

            $sql = "SELECT * FROM banco_bacteriologas b  WHERE b.codigo = '$bresp'";
            $bact = $db->get_row($sql);
            $_SESSION[$donante]['nom_bact'] = htmlentities($bact->nombre, ENT_COMPAT);

            $htmlCode = "<br>";

            $nomb = htmlentities($rec->Nombre, ENT_COMPAT);
            $ape1 = htmlentities($rec->Apellido1, ENT_COMPAT);
            $ape2 = htmlentities($rec->Apellido2, ENT_COMPAT);
            $rece = htmlentities($rec->Receptor, ENT_COMPAT);


            $htmlCode .= "<h2>C&eacute;dula: {$rec->Cedula}      Consecutivo donaci&oacute;n: {$_SESSION[$donante]['encOtDon']}</h2>";
            $htmlCode .= "<h2>Nombres: {$nomb} {$ape1} {$ape2}</h2>";
            $htmlCode .= "<h2>Fecha de Nacimiento: (A/M/D) {$rec->Fecha_Nac} Sexo: {$rec->Sexo}</h2>";
            $htmlCode .= "<h3>Receptor: {$rece}</h3><br>";
            $htmlCode .= "<h3>Bacteriologa Responsable: " . htmlentities($bact->nombre, ENT_COMPAT) . "</h3><br>";
            $htmlCode .= "<h3>Estado de la encuesta:  CONTESTADA Y PENDIENTE POR VALIDAR $tipoenconfigencuesta</h3><br>";


            die("2|$htmlCode");
        } else {
            $htmlCode="<div class='error'>INCONSISTENCIA EN LA BASE DE DATOS. NO SE ENCONTRARON RESPUESTAS A ENCUESTA NO VALIDADA.</div>";
            die("0|$htmlCode");
        }
    }


    // ------------------------------------------------------------------------
    // Si la encuesta nunca ha tenido respuestas debe permitir contestarla
    // ------------------------------------------------------------------------


 //   $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
    $sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' ";
    $rec = $db->get_row($sql);


  if ( (isset($rec->Nombre)) && ($vNumPregEnc > $vNumMvtoEnc) ) {//if (isset($rec->Nombre)) {
//    if  (isset($rec->Nombre)) {//if (isset($rec->Nombre)) {
	//faltan preguntas por contestar .
        $bresp = $rec->Bacteriologa;

        // ------------------------------------------------------------------------
        // La encuesta NO tiene respuestas permitir al usuario contestar la
        // encuesta
        // ------------------------------------------------------------------------


        $_SESSION[$donante]['encOtDon'] = $donante;
        $_SESSION[$donante]['encCCDon'] = $rec->Cedula;

        $_SESSION[$donante]['encNombreDon'] = $rec->Nombre;
        $_SESSION[$donante]['encApellido1Don'] = $rec->Apellido1;
        $_SESSION[$donante]['encApellido2Don'] = $rec->Apellido2;
        $_SESSION[$donante]['encReceptor'] = $rec->Receptor;
        $_SESSION[$donante]['encSexDonante'] = $rec->Sexo;
        $_SESSION[$donante]['cod_bact'] = $rec->Bacteriologa;

        // ------------------------------------------------------------------------
        // Buscar los nombres de la bacteriologa
        // ------------------------------------------------------------------------

        $sql = "SELECT * FROM banco_bacteriologas b  WHERE b.codigo = '$bresp'";
        $bact = $db->get_row($sql);

        $_SESSION[$donante]['nom_bact'] = htmlentities($bact->nombre, ENT_COMPAT);

        $htmlCode = "<br>";

        $nomb = htmlentities($rec->Nombre, ENT_COMPAT);
        $ape1 = htmlentities($rec->Apellido1, ENT_COMPAT);
        $ape2 = htmlentities($rec->Apellido2, ENT_COMPAT);
        $rece = htmlentities($rec->Receptor, ENT_COMPAT);


        $htmlCode .= "<h2>C&eacute;dula: {$rec->Cedula}      Consecutivo donaci&oacute;n: {$_SESSION[$donante]['encOtDon']}</h2>";
        $htmlCode .= "<h2>Nombres: {$nomb} {$ape1} {$ape2}</h2>";
        $htmlCode .= "<h2>Fecha de Nacimiento: (A/M/D) {$rec->Fecha_Nac} Sexo: {$rec->Sexo}</h2>";
        $htmlCode .= "<h3>Receptor: {$rece}</h3><br>";
        
        $htmlCode .= "<h3>Estado de la encuesta:  NO CONTESTADA</h3><br>";

        die("1|" . $htmlCode);
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

    
    $htmlCode="<div class='error'>NUMERO DE DONANTE NO EXISTE.</div>";
    die("0|$htmlCode");
    
}
?>
