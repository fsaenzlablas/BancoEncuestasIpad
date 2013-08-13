<?php
// ------------------------------------------------------------------------
// Programa: firmar.php
//
// ------------------------------------------------------------------------


if (!isset($_POST['num_ot'])) {
    include_once('../apl/login.php');
    die();
}


?>

<!DOCTYPE html>
<html lang="en" manifest="cache.manifest">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">

    <title>Firma de la encuesta</title>

    <!-- CSS Styles -->
    <link rel="stylesheet" href="../css/encuestas.css"/>
    <link rel="stylesheet" href="../css/jquery.signaturepad.css">
    <link rel="stylesheet" href="../css/firma.css"/>

    <!--[if lt IE 9]>
    <script src="../js/flashcanvas.js"></script><![endif]-->

    <script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>

    <link rel="stylesheet" href="../js/ui/jquery-ui.css"/>
    <script src="../js/ui/jquery-ui.js"></script>


    <script type="text/javascript" src="../js/firma.js"></script>

</head>
<body>

<div class="shell">


    <div class="header">
        <h1 class="logo"><a href="#">Laboratorio Medico las Americas</a></h1>
    </div>
    <div class="main">

        <div class="heading" id="formTitle">
            <h3>Datos del donante</h3>
        </div>


        <div id="detalleDonante">
            <?php include_once("../ajax/showDatosDonante.php"); ?>
        </div>


        <form method="post" action="../apl/revisarRespuestas.php" id="signatureForm">


            <input type='hidden' id='num_ot' name='num_ot' value='<?php echo $_POST['num_ot']?>'>
            <input type='hidden' id='firma_donante' name='firma_donante' value=''>

            <div id="divMensaje" class="alert">
                Por favor firme con el dedo sobre el fondo amarillo y luego presione el bot&oacute;n <strong>Revisar
                Respuestas</strong>
            </div>

            <canvas class="canvas" name="canvas"  id="canvas" width="955px" height="315px"></canvas>

            <input type="hidden" id="output" name="output" class="output">

            <hr/>
            <div class="buttons">

                <div id="divBorrarFirma">
                    <input type="button" class="clearButton" id="clear" style="float:left;" id="borrarFirma" value="Borrar Firma"/>
                </div>

                <div id="divRevisarResp">
                    <input type="button" class="boton2" style="float:right;" value="Revisar Respuestas" id="revisarResp"/>
                </div>

            </div>
        </form>


        <script src="../js/jquery.signaturepad.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#signatureForm').signaturePad(
                    {
                        canvas:'canvas',
                        defaultAction:'drawIt',
                        drawOnly:true,
                        bgColour:'#ffffe0',
                        penWidth:4,

                        lineTop:250, /* Distance to draw the signature line from the top of the canvas */
                        lineColour:"#ccc", /* Colour of the signature line */
                        lineWidth:1, /* Thickness, in pixels, of the signature line */
                        lineMargin:2 , /* The margin on the left and the right of signature line */

                        errorMessageDraw:'A&uacute;n no ha firmado o la firma es demasiado corta.',
                        errorMessage:'A&uacute;n no ha firmado o la firma es demasiado corta.'

                    }
                );
            });
        </script>
        <script src="../js/json2.min.js"></script>

    </div>

    <div class="footer">
        <p class="left">
            <a rel="nofollow" href="#">W3C Valid XHTML</a> | <a rel="nofollow" href="#">W3C Valid CSS</a>
        </p>

        <p>&copy;<?=date("Y")?>, Laboratorio M&eacute;dico las Am&eacute;ricas Ltda. All rights reserved. </p>

    </div>

</div>

</body>
</html>