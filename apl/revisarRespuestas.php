<?php
// -------------------------------------------------------------------------------------
// Validar que el usuario haya pasado por login y haya digitado una ot valida
// -------------------------------------------------------------------------------------

/*
if (!isset($_POST['num_ot'])) {
include '../apl/login.php';
die;
}
*/

//var_dump($_POST);

$firma = $_POST['firma_donante'];
$num_ot=$_POST['num_ot'];

$_SESSION[$num_ot]['firma'] = $firma;

//removing the "data:image/png;base64," part
$uri = substr($firma, strpos($firma, ",") + 1);
// put the data to a file
$file = "../firmas/" . $_SESSION[$num_ot]['encOtDon'] . ".png";
if ($_SESSION["tipo_encuesta"] !="0"){//firma post donacion
	$file = "../firmas/" . $_SESSION[$num_ot]['encOtDon']."P" . ".png";
}
if (file_exists($file)) {
    unlink($file);
}

file_put_contents($file, base64_decode($uri));
//die("Tamano firma: ". filesize($file));
$tam=filesize($file);





// -------------------------------------------------------------------------------------
// Si la encuesta esta validada lo sabremos si su estado es diferente a PE en la tabla
// banco_registro
// -------------------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$donante = $num_ot;
if ($_SESSION["tipo_encuesta"] !="0"){//firma post donacion
	$sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Aceptada = 'PE'";
}
else{
	$sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
	
}


//$sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
$rec = $db->get_row($sql);

if (!isset($rec->Nombre)) {
    include '../apl/login.php';
   die;
}

?>

<html>
<head>

    <title>Revisar Encuesta</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <script src="../js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../js/revisarRespuestas.js" type="text/javascript"></script>

    <link rel="stylesheet" href="../css/encuestas.css" type="text/css" media="all"/>
    <link rel="stylesheet" href="../css/firma.css" type="text/css" media="all"/>


</head>
<body>

<div class="shell">

    <div class="header">
        <h1 class="logo"><a href="#">Laboratorio Medico las Americas</a></h1>
    </div>


    <div class="main">

        <form action="" method="POST" class="info-form" name="revisarRespuestas" id="revisarRespuestas">


            <input type='hidden' id='num_ot' name='num_ot' value='<?php echo $_POST['num_ot']?>' >
            <input type='hidden' id='primera_preg' name='primera_preg'  value='<?php echo $_SESSION[$num_ot]['primera_preg']; ?>' >
            <input type='hidden' id='go' name='go'  value='<?php echo $_SESSION[$num_ot]['cod_ant']; ?>' >



            <div class="heading" id="datosDonante">
                <h3>Datos del Donante</h3>
            </div>

            <div id="detalleDonante">
                <?php include_once "../ajax/showDatosDonante.php" ?>
            </div>

            <hr/>

            <div class="heading" id="datosRespuestas">
                <h3>Respuestas de la encuesta</h3>
            </div>

            <div id="detalleEncuesta">
                <?php include_once("../ajax/showRespuestasSinCarita.php"); ?>
            </div>

            <div class="heading" id="imagenFirma">
                <h3>Firma del Donante</h3>
            </div>

            <div id="detalleFirma" align="center">
                <?php
					$sufijo = "";
					if ($_SESSION["tipo_encuesta"] !="0"){//firma post donacion
						$sufijo="P";
					}

 					$html_object = "<img src='../firmas/".$_POST['num_ot'].$sufijo.".png' width='100%' height='320'/>" ?>
                <?php echo $html_object ?>
            </div>

            <?php if ( !isset($_SESSION[$num_ot]['enc_terminada']) ) { ?>

            <div id="erroresEnc" class="alert">
                Por favor verifique que sus respuestas sean correctas y luego presione el bot&oacute;n <strong>Terminar Encuesta</strong>
            </div>
            <hr/>

            <div id="divReiniciarEnc">
                <input type="button" style="float:left;" id="reiniciarEnc" class="boton2" value="Reiniciar Encuesta"/>

                <div id="divLogin" style="display: none;" style="float:right;">
                    <span class="text-login ">Usuario :</span>
                    <input name="usuario" id="usuario" class="input-field"
                           value="<?php echo $_SESSION['usuario_encuesta'] ?>"/>
                    <span class="text-login ">Contrase&ntilde;a:</span>
                    <input name="password" id="password" type="password" class="input-field"/>
                    <input type="button" id="login" class="boton2" value="Aceptar"/>

                    <input type="button" id="cancelarLogin" class="boton2" value="Cancelar"/>
                </div>
            </div>
            <?php } else { ?>
                <div id="erroresEnc" class="alert">
                    Por favor Solicite la presencia de la auxiliar.  <strong>Ella debe validar la encuesta</strong>
                </div>
            <?php } ?>

            <?php if ( (isset($_SESSION[$num_ot]['enc_terminada']) ) ) { ?>
             <?php $displayValidar = ""; ?>

            <?php } else  { ?>
	           <?php $displayValidar = "style='display: none;'"; ?>
            <?php } ?>

            <div id="divValidarEnc" <?php echo $displayValidar ?> >
	
                <input type="button" style="float:right;" id="validarEnc" class="boton2" value="Validar Encuesta"/>

                <div id="divLoginValidar" style="display: none;" style="float:right;">
                    <span class="text-login ">Usuario :</span>
                    <input name="usuario" id="usuarioValidar" class="input-field"
                           value="<?php echo $_SESSION['usuario_encuesta'] ?>"/>
                    <span class="text-login ">Contrase&ntilde;a:</span>
                    <input name="password" id="passwordValidar" type="password" class="input-field"/>
                    <input type="button" id="loginValidar" class="boton2" value="Aceptar"/>
                    <input type="button" id="cancelarValidar" class="boton2" value="Cancelar"/>
                </div>
            </div>


            <div id="divButtons" class="buttons" >

                <?php if ( !isset($_SESSION[$num_ot]['enc_terminada'])  ) { ?>
                    <div id="divTermninarEnc" >
                        <input type="button" class="buttonGreen" id="terminarEnc" style="float:right;" value="Terminar Encuesta"/>
                    </div>

                <div id="divAnteriorPreg">
                    <input type="button" class="boton2" style="float:right;" id="anteriorPreg"
                           value="Pregunta Anterior"/>
                </div>

                <?php } ?>

                <div id="divNuevaEnc" style="display: none;">
                    <input type="button" class="boton2" id="nuevaEnc"  style="float:left;" onClick="nuevaEncuesta()" value="Nueva Encuesta"/>
                </div>


            </div>

            </div>
        </form>


    </div>

    <div class="footer">
        <p class="left">
            <a rel="nofollow" href="#">W3C Valid XHTML</a> | <a rel="nofollow" href="#">W3C Valid CSS</a></p>

        <p>&copy;<?= date("Y") ?>, Laboratorio Médico las Américas Ltda. All rights reserved. </p>
    </div>


</div>
</body>
</html>