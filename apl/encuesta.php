<?php

@session_start();//29 oct 2013
  if (!isset($_SESSION['usuario_encuesta'])) {

    include('../../dona.html');//'../apl/login.php');
    die;
}


$num_ot="";

if (isset($_POST['txtOrden'])) {//si viene de la ventana de demograficos .
    $num_ot = $_POST['txtOrden'];
    //$('#num_ot').val($num_ot);

}
if (isset($_POST['tipoencuesta'])) {//si viene de la ventana de demograficos .
    if ($_SESSION['tipo_encuesta'] != $_POST['tipoencuesta']){
         $_SESSION['tipo_encuesta'] = $_POST['tipoencuesta'];  
    }
   

  //  $_SESSION["tipo_encuesta"] = $_POST['tipoencuesta'];
    //$('#num_ot').val($num_ot);
  //  unset($_POST['tipoencuesta']);
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

        <title>Encuestas Donantes</title>

        <link rel="stylesheet" href="../css/encuestas.css"      type="text/css" media="all" />
        
        <script src="../js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.alerts.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery.alerts.css"  type="text/css" media="screen" />
        <script src="../js/encuesta.js" type="text/javascript" ></script>
        
    </head>
    <body onload="$('#num_ot').focus();">


        <div class="shell">

            <div class="header">
                <h1 class="logo"><a href="#">las americas laboratorio medico</a></h1>
            </div>


            <div class="main">
                <h2>Encuestas donantes </h2>

                <div class="center">

                    <div class="heading">
                        <h3>Datos del Donante y Bacteriologa responsable:</h3>
                        <div class="cl">&nbsp;</div>
                        <div class="users">&nbsp;</div>
                        <div class="cl">&nbsp;</div>
                    </div>



                    <form action="det_encuesta.php" method="POST" class="info-form" name="encuesta" id="encuesta">


                        <div id="message" style="margin-top: 5px; display: none;"></div>


                        <div id="Donante" class="item">
                            <label for="num_ot">Numero OT Donante:</label>

                            <input type='text'   id='num_ot' name='num_ot' class='normal-field' value='<?php echo $num_ot ?>' />



                            <input type="button" id="getDonante" class="boton2"  value="Buscar Donante"/>
                        </div>


                        <div id="detalleDonante"></div>


                        <div id="bacteriologas" style="margin-top: 5px; display: none;">

                            <div id="Responsable">
                                <label>Bacteriologa responsable:</label>
                                <script language="JavaScript">getBacteriologas();</script>
                                <br/><br/>
                            </div>

                            <div id="detalleResp"></div>
                            <br/>


                        </div>

                        <div id="divEmpezarEnc" style="display: none;">
                            <input type="button" class="boton2"  id="empezarEncuesta" value="Empezar encuesta"/>
                        </div>

                        <div id="divValidarEnc" style="display: none;">
                            <input type="button" class="boton2"  id="valEncuesta2" value="Validar encuesta"/>
                        </div>


                        <div id="det_encuesta">

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
				<input type='hidden'   id='tipoEncuesta' name='tipoEncuesta' class='normal-field' value='<?php echo $_SESSION["tipo_encuesta"]?>' />
                <input type='hidden'   id='txtOrden' name='txtOrden' class='normal-field' value='<?php echo $num_ot?>' />
                           
            </div>




        </div>
    </body>
</html>