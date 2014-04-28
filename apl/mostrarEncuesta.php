<?php
// -------------------------------------------------------------------------------------
// Validar que el usuario haya pasado por login y haya digitado una ot valida
// -------------------------------------------------------------------------------------
@session_start();//29 oct 2013

if (!isset($_SESSION['encOtDon'])) {
    include '../../dona.html';//'../apl/login.php';
    die;
}


// -------------------------------------------------------------------------------------
// Si la encuesta esta validada lo sabremos si su estado es diferente a PE en la tabla
// banco_registro
// -------------------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$donante = $_SESSION['encOtDon'];

$sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.nro_Consecutivo = '$donante'";
$rec = $db->get_row($sql);

$obs = $rec->Observaciones;


//echo "<br>OBSERVACIONES: $obs<br>$sql<br>Base de datos: " . EZSQL_DB_HOST . ":" . EZSQL_DB_NAME;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <title>Consultar Encuesta</title>

        <link rel="stylesheet" href="../css/encuestas.css"      type="text/css" media="all" />

        <script src="../js/jquery-1.4.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.alerts.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery.alerts.css"  type="text/css" media="screen" />
        <script src="../js/consultar.js" type="text/javascript" ></script>

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



                    <form action="" method="POST" class="info-form" name="mostrarEnc" id="mostrarEnc">

                        <div id="message" style="margin-top: 5px; display: none;"></div>

                        <div id="detalleDonante"><script language="JavaScript">showDatosDonante();</script></div>

                        <hr/>

                        <div id="detalleEncuesta">
                            <?php include_once("../ajax/showRespuestas.php"); ?>
                        </div>

                        
                        <div id="detalleFirma" align="center">
                            <?php echo "<img src='../firmas/{$_SESSION['encOtDon']}.png' width='300' height='200'></img>" ?>
                        </div>
                        
                        
                        <hr/>


                        <?php
                        
                        
                        if ($estado == "OC") {
                            $style = "style='margin-top: 10px'";
                            $text = "";
                        } else {
                            $style = "style='display: none; margin-top: 10px'";
                            $text = "NO APLICA";
                        }

                        if ($obs == "CONFIRMADA") {
                            
                            $sql = "SELECT * FROM banco_registro WHERE Nro_Consecutivo = '$donante'";
                            $rec = $db->get_row($sql);
                            $encuesta = $rec->Encuesta;
                        
                            //echo "ESTADO ENCUESTA: $encuesta SQL: $sql";
                            
                            
                            if ($encuesta == "OK") {
                                echo "LA ENCUESTA FUE ACEPTADA";
                            } else if ($encuesta == "RE") {
                                echo "LA ENCUESTA FUE RECHAZADA";
                            } else if ($encuesta == "OC") {
                                
                                $sql = "SELECT * FROM banco_encuesta_enc WHERE nro_Consecutivo = '$donante'";
                                $rec = $db->get_row($sql);
                                $estado = $rec->estado;
                                
                                if (isset($estado) and $estado==1) {
                                    echo "LA ENCUESTA FUE ACEPTADA CONDICIONALMENTE";
                                } else {
                                    echo "LA ENCUESTA FUE RECHAZADA CONDICIONALMENTE";
                                }
                            } else if ($encuesta == "PE") {
                                echo "LA ENCUESTA ESTA PENDIENTE";
                                
                            }
                        } else {
                            
                            if ($estado == "OK") {
                                echo "<div class='success'>LA ENCUESTA VA A SER ACEPTADA AUTOMATICAMENTE</div>";
                            } else if ($estado == "RA") {
                                echo "<div class='error'>LA ENCUESTA VA A SER RECHAZADA AUTOMATICAMENTE</div>";
                            } else if ($estado == "OC" ) {
                                echo "<div class='info'>LA ENCUESTA ESTA PARA SER ACEPTADA O RECHAZADA CONDICIONALMENTE</div>";
                            } 
                        }
                        
                        ?>
                        
                        <div id="comentarios" <?= $style ?>>

                            <br/>
                        <?php
                        include_once '../ajax/getObsEnc.php';
                        $text = $resultado['txtResult'];
                        if ($text != "") {
                            echo '<span class="header-comment">Comentarios a la encuesta:</span><BR/>';
                            echo "<textarea class='text-comment' name='encComentarios'  id='encComentarios' cols='70' rows='5'>" . $text . "</textarea>";
                            echo '<br/><br/>';
                        }
                        ?>
                        </div>



                        <input type="hidden" id="encEstado" name="encEstado" value="<?= $estado ?>"></input>

                        <div id="erroresEnc" class="error" style="display: none;" ></div>

                        <div id="divNuevaEnc" style="margin-top: 10px">
                            <input type="submit" class="boton2"  id="nuevaEnc"  value="Consultar Otra Encuesta"/>
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