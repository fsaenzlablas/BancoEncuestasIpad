<?php
// -------------------------------------------------------------------------------------
// Validar que el usuario haya pasado por login y haya digitado una ot valida
// -------------------------------------------------------------------------------------

if (!isset($_POST['num_ot'])) {
include '../apl/login.php';
die;
}

$num_ot = $_POST['num_ot'];

// -------------------------------------------------------------------------------------
// Si la encuesta esta validada lo sabremos si su estado es diferente a PE en la tabla
// banco_registro
// -------------------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$donante = $num_ot;

$sqlNumPregEnc = "SELECT COUNT(*) as cuenta FROM  banco_encuesta b WHERE  b.activa =1 ";
$sqlNumMvtoEnc = "SELECT COUNT(*) as cuenta FROM  banco_mvto_encuesta b WHERE  b.nro_consecutivo = '$donante' ";

//Todas las preguntas activas deben estar validadas
$regPregEnc = $db->get_row($sqlNumPregEnc);
$regMvtoEnc = $db->get_row($sqlNumMvtoEnc);

$sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta = 'PE'";
$sql = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$donante' AND r.Encuesta <> 'RE' AND r.Encuesta <> 'OK' ";
$rec = $db->get_row($sql);

//if (!isset($rec->Nombre)) {
if ( ($regPregEnc->cuenta == $regMvtoEnc->cuenta) && (!isset($rec->Nombre)) ) {//si todas las preguntas estan validadas .
include '../apl/login.php';
die;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>Validar Encuesta</title>


        <link rel="stylesheet" href="../css/encuestas.css"      type="text/css" media="all" />

        <script src="../js/jquery-1.4.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.alerts.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery.alerts.css"  type="text/css" media="screen" />
        <script src="../js/encuesta.js" type="text/javascript" ></script>

    </head>
    <body>


        <div class="shell">

            <div class="header">
                <h1 class="logo"><a href="#">Las Americas laboratorio medico</a></h1>
            </div>


            <div class="main">
                <div class="center">

                    <div class="heading">
                        <h3>Detalle de la encuesta</h3>

                        <div class="cl">&nbsp;</div>
                    </div>



                    <form action="" method="POST" class="info-form" name="validarEncuesta" id="validarEncuesta">

                        <script type="text/javascript">
                            $('#validarEncuesta').append($('<input type="hidden" id="num_ot" value="<?php echo $_POST['num_ot']?>" />'));
                        </script>

                        <div id="message" style="margin-top: 5px; display: none;"></div>

                        <div id="detalleDonante"><script language="JavaScript">showDatosDonante();</script></div>

                        <hr/>

                        <div id="detalleEncuesta">
                            <?php include_once("../ajax/showRespuestas.php"); ?>
                        </div>

                        <div id="detalleFirma" align="center">
	
                            <?php
								$sufijo = "";
								if ($_SESSION["tipo_encuesta"] !="0"){//firma post donacion
									$sufijo="P";
								}
								if ($sufijo=="P"){//deben existir 2 firmas
	 								$html_object = "<img src='../firmas/".$_POST['num_ot'].".png' width='50%' height='320'/><img src='../firmas/".$_POST['num_ot'].$sufijo.".png' width='50%' height='320'/>" ;
									
								} else {
	 								$html_object = "<img src='../firmas/".$_POST['num_ot'].$sufijo.".png' width='100%' height='320'/>" ;
									
								}
							?>	
                            <?php echo $html_object ?>
                        </div>



                        <hr/>


                        <?php
                        $style = "style='margin-top: 10px'";
                        $text = "";
                        ?>

                        <div id="comentarios" <?= $style ?> >

                            <?php
                            if ($estado == "OC") {

                                $str = "<div class='info'>LA ENCUESTA DEBE SER ACEPTADA O RECHAZADA CONDICIONALMENTE</div><br/>".
                                '<select class="combo-box-resp" name="encAceptar" id="encAceptar" >'.
                                    '<option SELECTED value="NA" >Seleccione Acci&oacute;n</option>'.
                                    '<option value="1" >Aceptar Encuesta</option>'.
                                    '<option value="0" >Rechazar Encuesta</option>'.
                                '</select>';

                            } elseif ($estado == "OK") {
                                
                                $str = "<div class='success'>LA ENCUESTA HA SIDO ACEPTADA AUTOMATICAMENTE</div><br/>".
                                '<select class="combo-box-resp" name="encAceptar" id="encAceptar" >'.
                                    '<option value="1" SELECTED >Aceptar Encuesta</option>'.
                                '</select>';
                                
                            } elseif ($estado == "RA") {
                                
                                $str = "<div class='error'>LA ENCUESTA HA SIDO RECHAZADA AUTOMATICAMENTE</div><br/>".
                                '<select class="combo-box-resp" name="encAceptar" id="encAceptar" >'.
                                    '<option value="0" SELECTED >Rechazar Encuesta</option>'.
                                '</select>';

                            } else {
                                
                                $str = "<div class='info'>LA ENCUESTA DEBE SER ACEPTADA O RECHAZADA </div><br/>".
                                '<select class="combo-box-resp" name="encAceptar" id="encAceptar" >'.
                                    '<option SELECTED value="NA" >Seleccione Acci&oacute;n</option>'.
                                    '<option value="1" >Aceptar Encuesta</option>'.
                                    '<option value="0" >Rechazar Encuesta</option>'.
                                '</select>';
                            }    
                            echo $str;
                            ?>

                            <br/><br/>
                            <span class="header-comment">Comentarios a la encuesta:</span><BR/>

                            <textarea class="text-comment" name="encComentarios" id="encComentarios" cols="70" rows="5"><?= $text ?></textarea>
                            <br/><br/>

                        </div>


                        <div id="waiting2" class="item" style="display: none;">
                            <img src="../css/images/ajax-loader.gif" title="Loader" alt="Loader"/>
                        </div>
                        <input type="hidden" id="encEstado" name="encEstado" value="<?= $estado ?>"/>

                        <div id="divGrabarEnc" style="margin-top: 10px">
                            <input type="button" class="boton2"  id="grabarEnc" value="Grabar Encuesta"/>

                        </div>
                        <div id="erroresEnc" class="error" style="display: none;" ></div>

                        <div id="divNuevaEnc" style="display: none; margin-top: 10px">
                            <input type="button" class="boton2"  id="nuevaEnc"  onClick="nuevaEncuesta()" value="Nueva Encuesta"/>
                        </div>

                        <div class="cl">&nbsp;</div>


                    </form>
                </div>
                <div class="cl">&nbsp;</div>

            </div>

            <div class="bottom-section">

            </div>


            <div class="footer">
                <p class="left">
                    <a rel="nofollow" href="#">W3C Valid XHTML</a> | <a rel="nofollow" href="#">W3C Valid CSS</a></p>
                <p>&copy;<?= date("Y") ?>, Laboratorio Médico las Américas Ltda. All rights reserved. </p>
            </div>




        </div>
    </body>
</html>