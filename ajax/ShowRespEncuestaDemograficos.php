<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Incluir bibliotecas y clases necesarias
// ------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// ------------------------------------------------------------------------
// Capturar el numero de la OT del donante digitado 
// ------------------------------------------------------------------------
$num_ot = $_POST['num_ot'];
date_default_timezone_set('America/Bogota');
//$num_ot="0071734BD";//$_POST['num_ot'];


$secuencias = array();
$codigos = array();
$valor = array();

$codigos_pre=array();
$descripciones = array();
$tipos=array();
$rdonante=array();

$comentarioEnc = "";

$esHoy = 0;

if ($num_ot != "") {


    // ------------------------------------------------------------------------
    // Buscar las respuestas grabadas anteriormente
    // ------------------------------------------------------------------------
    $vfuenteSQL = 0;

    $sql = "SELECT * FROM banco_mvto_encuesta_tmp m  WHERE m.nro_consecutivo = '$num_ot' ORDER BY orden ASC";
    //echo $sql;
    $sql2 = "SELECT * FROM banco_mvto_encuesta m  WHERE m.nro_consecutivo = '$num_ot' ";//ORDER BY codigo ASC";
    if ($respuestas = $db->get_results($sql, ARRAY_A)) {
        $i = 0;

        $fechaHoy = Date('Y-m-d');

        $fechaEnc = "";

        $nomDonante = "";
        $ccDonante = "";
        $codBact = "";

        $sqlCom = "SELECT * FROM banco_encuesta_enc_tmp en  WHERE en.nro_consecutivo = '$num_ot' ";//ORDER BY codigo ASC";
        if ($encabezados = $db->get_results($sqlCom, ARRAY_A)) {
            foreach ($encabezados as $encabeza) {
                $comentarioEnc = $encabeza['Observaciones'];
                $fechaEnc = $encabeza['fecha'];
                $nomDonante = $encabeza['nombre'];
                $ccDonante = $encabeza['cedula'];
                $codBact = $encabeza['cod_bacteriologa'];
            }
        }

//la encuesta ya fue grabada , los datos se deben traer de la tabla definitiva y no la temporal de 4D.
        $sqlCom2 = "SELECT * FROM banco_encuesta_enc en  WHERE en.nro_consecutivo = '$num_ot' ";//ORDER BY codigo ASC";
        if ($encabezados = $db->get_results($sqlCom2, ARRAY_A)) {
            foreach ($encabezados as $encabeza) {
                $comentarioEnc = $encabeza['Observaciones'];
                $fechaEnc = $encabeza['fecha'];
                $nomDonante = $encabeza['nombre'];
                $ccDonante = $encabeza['cedula'];
                $codBact = $encabeza['cod_bacteriologa'];
            }
        }






        if($fechaHoy == $fechaEnc){
            $esHoy = 1;
        }


 
        //$htmlCode = "<div id = 'infoDlgEncuesta' class='dialogo' ><br><h3 class='info'>Respuestas de la encuesta:"+$num_ot+"</h3>";

        $htmlCode = "<div class='datosDonante'>";
        $htmlCode .= "    CEDULA:  <strong> $ccDonante</strong>";
        $htmlCode .= "    NOMBRES: <strong> $nomDonante </strong> ";
        $htmlCode .= "    Consecutivo donaci&oacute;n: <strong> $num_ot</strong>";
        $htmlCode .= "    Fecha de donaci&oacute;n: <strong> $fechaEnc</strong>";
        //$htmlCode .= "    <br>Bacteriologa responsable:  $codBact";
        $htmlCode .= "</div>";


        $htmlCode .= "<table border='1' width='100%' >";

        foreach ($respuestas as $resp) {


            $i++;

            $p = $resp['codigo'];

            // ------------------------------------------------------------------------
            // Crear nuevamente las variables de session que serviran al momento de
            // grabar la encuesta en 4D
            // ------------------------------------------------------------------------


            // ------------------------------------------------------------------------
            // Mostrar las preguntas tal con un icono de cara feliz o triste segun
            // la respuesta
            // ------------------------------------------------------------------------

            if ((($resp['tipo'] == "SELECCION") and ($resp['valor'] != "NO APLICA")) OR (($resp['tipo'] == "SI-NO") )) {
                $htmlCode .= "<tr id='pregunta_$p'>";
                $htmlCode .= "<td id='pregunta_{$p}_col1'  width='10%' align='center'><h3>{$i}</h3></td>";
   //$htmlCode .= "<td id='pregunta_{$p}_col1'  width='10%' align='center'><h3>{$p}</h3></td>";

                if ($resp['criticidad'] == 2) {
                    $htmlCode .= "<td id='pregunta_{$p}_col2'  width='60%' align='left' bgcolor='ffff99'><h3>{$resp['descripcion']}</h3></td>";
                } else {
                    $htmlCode .= "<td id='pregunta_{$p}_col2'  width='60%' align='left'><h3>{$resp['descripcion']}</h3></td>";
                }
                $htmlCode .= "<div id='poprespuesta_{$p}_col6' >";

                if ($fechaHoy == $fechaEnc){



                    switch($resp['tipo']){
                        case "SI-NO" :
                           $htmlCode .= "<td id='poprespuesta_fila{$p}' width='20%'> ";
                           if ($resp['valor']=="SI") $valorInic=1;
                           else $valorInic=0;
                           $val3 = $resp['valor'];
                            $val2 = "$val3";

                            $htmlCode .= "<div id='popRes_{$p}'><select name = 'popRes_{$p}' id ='popRes_{$p}' onChange = 'clickSi($p , $valorInic );' >";
                           $selectSI = "";
                           $selectNO = "";
                            if ($resp['valor'] =="SI"){
                                $selectSI = "selected";

                            }else{
                                $selectNO = "selected";
                            }
                            $htmlCode .= "<option  value='SI' $selectSI >SI</option>";
                            $htmlCode .= "<option  value='NO' $selectNO>NO</option></select></div></td>";

                            break;
                        case "SELECCION" :
                            $htmlCode .= "<td id='poprespuesta_fila{$p}' width='20%'>";
                            $htmlCode .= " <select name = 'popRes_{$p}' id ='popRes_{$p}' onChange= 'clickOpcionesEnc($p);'>";
                            $codPregunta = $resp['seleccion'];
                        
                            $sqlOpcionessql = "SELECT d.codigo, d.detalle FROM banco_encuesta b, banco_enc_sel s, banco_enc_det_sel d WHERE b.codigo = '$p' AND s.detalle = b.seleccion  AND s.codigo=d.codigo_enc  ORDER BY d.detalle";
                            $htmlCode .= "<option  value='NO-APLICA' >NO APLICA</option>";
                            if ($opcionesArr = $db->get_results($sqlOpcionessql, ARRAY_A)) {
                                 foreach ($opcionesArr as $opcion1) {
                                    $seleccionado ="";
                                    if ($resp['valor']== $opcion1['detalle']){
                                        $seleccionado ="selected";
                                    }else{

                                    }
                                    $valorOpc = $opcion1['detalle'];
                                    $htmlCode .= "<option  value='$valorOpc' $seleccionado>$valorOpc</option><strong>";
                                    //$htmlCode .= "</select></td>";


                                 }

                            }
                            $htmlCode .= "</select></td>";

     //                       $htmlCode .= "<td id='respuesta_{$p}_col2' width='20%' align='center'><strong>{$resp['valor']}<strong></td>";

                            break;    
                        //case "NO APLICA" :
                            //$htmlCode .= "<td id='respuesta_{$p}_col2' width='20%' align='center'><strong>{$resp['valor']}<strong></td>";

                            //break;    
                        default :
                            $htmlCode .= "<td id='respuesta_fila{$p}_col3' width='20%' align='center'><strong>{$resp['valor']}<strong></td>";
                            break;    
                               
                    }// del switch
                }else{//no se puede modificar la encuesta si es de otro dia .
                    $htmlCode .= "<td id='respuesta_fila{$p}_col3' width='20%' align='center'><strong>{$resp['valor']}<strong></td>";

                }


                $htmlCode .= "</div>";
 
                if ($vfuenteSQL==0){

                    $carita = $resp['carita'];
                    if ($carita == "feliz.png") {
                        $htmlCode .= "<td id='respuesta_{$p}_col1' width='20%' class='respuesta-correcta' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/$carita' ></img></td>";
                    } else {
                        $htmlCode .= "<td id='respuesta_{$p}_col1' width='20%' class='respuesta-incorrecta' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/$carita' ></img></td>";
                    }
                }


                $htmlCode .= "</tr>";

            }
        }


        $htmlCode .= "</table>";

        $nomArchivoEncuesta = "../firmas/".$num_ot.".png" ;
        $nomArchivoPostDonacion = "../firmas/".$num_ot."P.png" ;


        $nombre_archivo = $nomArchivoEncuesta;
        if (file_exists($nomArchivoEncuesta)) {
            $htmlCode .= "Encuesta Fecha y Hora: " . date("F d Y H:i:s.", filectime($nomArchivoEncuesta));
                           $htmlCode .= "<img src='".$nomArchivoEncuesta."' width='100%' height='320' alt='Pre-donacion'/>";
        }else {
           $htmlCode .= "Falta la firma en la encuesta ";  
        }
        $nombre_archivo = $nomArchivoPostDonacion;
        if (file_exists($nomArchivoPostDonacion)) {
            $htmlCode .= "Post Donacion Fecha y Hora: " . date("F d Y H:i:s.", filectime($nomArchivoPostDonacion));
                           $htmlCode .= "<img src='".$nomArchivoPostDonacion."' width='100%' height='320' alt='Pre-donacion'/>";
        }else {
           $htmlCode .= "Falta la firma post donacion";  
        }



  

        $txtComentarioReadOnly =" readonly='yes' ";//si no es de hoy no se puede modificar el comentario 
        if ($esHoy==1){
            $txtComentarioReadOnly="";

            //$htmlCode .= "       <br/><br/>";  
            // $htmlCode .= "       <span class='header-comment'>Comentarios a la encuesta:</span><BR/>";  


        }
        //$comentarioEnc = " $fechaHoy == $fechaEnc ";
   
        $htmlCode .= "<textarea txtComentarioReadOnly class='text-comment ui-input-text ui-body-c ui-corner-all ui-shadow-inset' name='encComentarios' id='encComentarios'  cols='70' rows='5'>$comentarioEnc</textarea>";  

      //  $htmlCode .= "</div> ";
 
        echo $htmlCode;
    }else {

        $parameters = array();
        $parametros['wsOrden'] = $num_ot;

        $database = new FourDimensionAccess();
        $database->connect();
        $resultado = $database->call4DWebServer('wsInfoEncuesta', $parametros);

        $database->disconnect();

  //      $jsonEncuesta = json_decode( $resultado );
      //  echo $jsonEncuesta->encuesta[0]["codigo"]//;.$resultado;
        $resultado = "<br><h3 class='info'>Respuestas de la encuesta 4D:"+$num_ot+"</h3>".$resultado;


          $resultado .= "<p><span class='ui-icon ui-icon-alert' style='float: left; margin: 0 7px 20px 0;'></span>";  
            $resultado .= "<div id='infoDlgEncuesta'></div>";  
            $resultado .= "     <div id='comentarios' style='display: none; margin-top: 10px'>";  
            $resultado .= "        <br/>";  

             $resultado .= "       <select class='combo-box-resp' name='encAceptar' id='encAceptar'>";  
             $resultado .= "           <option selected value='NA'>Seleccione Acci&oacute;n</option>";  
             $resultado .= "           <option value='1'>Aceptar Encuesta</option>";  
             $resultado .= "           <option value='0'>Rechazar Encuesta</option>";  
             $resultado .= "       </select>";  

             $resultado .= "       <br/><br/>";  
             $resultado .= "       <span class='header-comment'>Comentarios a la encuesta:</span><BR/>";  

             $resultado .= "       <textarea class='text-comment' name='encComentarios' id='encComentarios' cols='70'";  
             $resultado .= "                 rows='5'>$comentarioEnc</textarea>";  
             $resultado .= "       <br/><br/>";  

             $resultado .= "   </div>";  




         echo $resultado;




    }


    // ------------------------------------------------------------------------
    // Buscar el encabezado de la encuesta para saber si fue rechazada o no
    // automaticamente, o se debe aceptar condicionalmente
    // ------------------------------------------------------------------------

}
?>
