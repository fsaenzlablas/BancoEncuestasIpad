<?php

if (isset ($_GET['num_ot'])) {
    $_POST['num_ot'] = $_GET['num_ot'];
}

$num_ot = $_POST['num_ot'];

if (!isset($_SESSION[$num_ot]['encOtDon'])) {
    include '../apl/encuesta.php';
    die;
}
?>
<html>
<head>

    <title>Detalle encuesta</title>

    <script src="../js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="../css/encuestas.css" type="text/css" media="all"/>

    <script src="../js/encuesta.js" type="text/javascript"></script>
    <script src="../js/jquery.form.js"></script>


    <!--- firmar.php includes -->

    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="../js/ui/jquery-ui.css"/>
    <script src="../js/ui/jquery-ui.js"></script>


</head>
<body>

<div class="shell">

    <div class="header">
        <h1 class="logo"><a href="#">Laboratorio Medico las Americas</a></h1>
    </div>


    <div class="main">


            <form action="" method="POST" class="info-form" name="det_encuesta" id="det_encuesta">

                <div class="heading" id="formTitle">
                    <h3>Detalle de la encuesta</h3>
                </div>
                <div id="message" style="margin-top: 5px; display: none;"></div>

                <div id="waiting" class="item" style="display: none;">
                    <img src="../css/images/ajax-loader.gif" title="Loader" alt="Loader"/>
                </div>

                <input type='hidden' id='num_ot' name='num_ot' class='normal-field'  value='<?php echo $_POST['num_ot']?>' >

                <div id="detalleDonante">
                    <script language="JavaScript">showDatosDonante();</script>
                </div>

                <hr/>


                <?php if (isset($_GET['go'])) { ?>
                <div id='detallePregunta' class="detallePregunta">
                    <script language='JavaScript'>showPregunta(<?php echo $_GET['go'] ?>);</script>
                </div>
                <?php } ?>

                <?php if (isset($_POST['go'])) { ?>
                <div id='detallePregunta' class="detallePregunta">
                    <script language='JavaScript'>showPregunta(<?php echo $_POST['go'] ?>);</script>
                </div>
                <?php } else { ?>
                    <?php if (isset($_SESSION[$num_ot]['current'])) { ?>
                        <div id='detallePregunta' class="detallePregunta">
                            <script language='JavaScript'>showPregunta(<?php echo $_SESSION[$num_ot]['current'] ?>);</script>
                    </div>
                    <?php } else { ?>
                        <div id='detallePregunta' class="detallePregunta">
                        <script language='JavaScript'>showPregunta(0);</script>
                        </div>
                    <?php } ?>
                <?php } ?>


                <hr/>

                <div id="erroresEnc" class="error" style="display: none;"></div>

                <div id="waiting2" class="item" style="display: none;">
                    <img src="../css/images/ajax-loader.gif" title="Loader" alt="Loader"/>
                </div>



                <div id="divSiguientePreg" style="display: none;">
                    <input type="button" class="boton2" style="float:right;" id="siguientePreg"
                           value="Pregunta Siguiente"/>
                </div>

                <div id="divRevisarResp" style="display: none;">
                    <input type="button" class="boton2" style="float:right;" id="revisarResp" value="Revisar Respuestas"/>
                    <input type="button" class="buttonGreen" style="float:right"  id="grabarEnc2"  value="Grabar Encuesta"/>
                </div>

                <div id="divAnteriorPreg" style="display: none;">
                    <input type="button" class="boton2" style="float:right;" id="anteriorPreg"
                           value="Pregunta Anterior"/>
                </div>

                <div id="divBorrarFirma" style="display: none;">
                    <input type="button" class="boton2" style="float:right;" id="borrarEncuesta"
                           value="Borrar Firma"/>
                </div>

                <div id="divReiniciarEnc" >
                    <input type="button" style="float:left;" id="reiniciarEnc" class="boton2"
                           value="Reiniciar Encuesta"/>

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


                <div id="divGrabarEnc" style="display: none;">

                </div>


                <div id="comentarios" style="display: none; margin-top: 10px">
                    <br/>

                    <select class="combo-box-resp" name="encAceptar" id="encAceptar">
                        <option selected value="NA">Seleccione Acci&oacute;n</option>
                        <option value="1">Aceptar Encuesta</option>
                        <option value="0">Rechazar Encuesta</option>
                    </select>

                    <br/><br/>
                    <span class="header-comment">Comentarios a la encuesta:</span><BR/>

                    <textarea class="text-comment" name="encComentarios" id="encComentarios" cols="70"
                              rows="5"></textarea>
                    <br/><br/>

                </div>


                <div id="divValidarEnc" style="display: none;">
                    <input type="button" class="boton2"  style="float:left;" id="valEncuesta" value="Validar encuesta"/>
                </div>

                <div id="divNuevaEnc" style="display: none;">
                    <input type="button" class="boton2" style="float:right;" id="nuevaEnc" onClick="nuevaEncuesta()"
                           value="Nueva Encuesta"/>
                </div>



                <div class="cl">&nbsp;</div>


                <!-- Formulario de Firma de la encuesta -->



            </form>
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