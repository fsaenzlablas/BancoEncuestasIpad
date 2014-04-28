<?php
@session_start();//29 oct 2013

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
date_default_timezone_set('America/Bogota');

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

$hoy = date("Y-m-d");  
$mes2_anterior  = date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
$ayer = date("Y-m-d",mktime(0, 0, 0, date("m")-1, date("d")-1,   date("Y")));

//$mes2_anterior  = date("Y-m-d",mktime(0, 0, 0, date("m")-2, date("d"),   date("Y")));

$donante = trim($_POST['num_ot']);

$num_ot = trim($_POST['num_ot']);

$pagFormulario="FormularioCompleto.php";//#paginaClaveUsuario";

if ($donante != "") {
    $donanteUP = strtoupper ($donante);
    if ( ($donanteUP=="ENF")||($donanteUP=="BACT") ){

        $respJson = "{ 'pagina' : '".$pagFormulario."' ,metodo : '' , 'info': '$donante' , 'tipoencuesta' : '0', 'error' : '','usuario' : 'bacteriologa' ,  'cc' : '' ";
        $respJson.=" } ";
        $_SESSION['usuario_encuesta'] = "bacteriologa";
        die($respJson);
    }

    //8 de enero 2014
    $_SESSION['usuario_encuesta'] = "donante";//faltaba


    $_SESSION['num_cc'] = $donante;

    $_SESSION[$donante]=array();


    // ------------------------------------------------------------------------
    // Verificar que la encuesta no esta siendo contestada en este momento.
    // ------------------------------------------------------------------------

    // el donante ya ingreso los demograficos hoy ?

    $vEstadoEncuesta = "PE";


    $ccReal = $donante;

    $sqlDonanteHoy = "SELECT * FROM banco_registro r  WHERE r.Cedula = '$donante' OR r. Nro_Consecutivo = '$donante'  ORDER BY Nro_Consecutivo DESC   ";

    $recDonanteHoy = $db->get_row($sqlDonanteHoy);

    if (!isset($recDonanteHoy->Nro_Consecutivo)) {//no ha donado nunca
        $respJson = "{ 'pagina' : 'FormularioCompleto.php' ,metodo :'' , 'info': '".$donante."' , 'tipoencuesta' : '0', 'error' :'','usuario' : 'donante', 'cc' : '$donante' } ";
        $_SESSION['usuario_encuesta'] = "donante";
        die($respJson);
    } 
    if ($recDonanteHoy->Nro_Consecutivo == $donante){//si se ingreso numero de orden
        $ccReal = $recDonanteHoy->Cedula;
    }

    if (($recDonanteHoy->Fecha == $hoy ) ||($recDonanteHoy->Fecha >= $ayer)) {//ya ingreso demograficos hoy

        $donante = $recDonanteHoy->Nro_Consecutivo;
        $vEstadoEncuesta= $recDonanteHoy->Encuesta;//Si es PE no puede contestar la encuesta post donacion
        $vEstadoExamenF = $recDonanteHoy->Examen_F;
        $sqlNumPregEnc = "SELECT COUNT(*) as cuenta FROM  banco_encuesta b WHERE  b.activa =1 ";
        $sqlNumMvtoEnc = "SELECT COUNT(*) as cuenta FROM  banco_mvto_encuesta b WHERE  b.nro_consecutivo = '$donante' ";

$sqlNumMvtoTmp = "SELECT COUNT(*) as cuenta FROM  banco_mvto_encuesta_tmp b WHERE  b.nro_consecutivo = '$donante' ";//4 de marzo 2014

    //Todas las preguntas activas deben estar validadas
        $regPregEnc = $db->get_row($sqlNumPregEnc);
        $regMvtoEnc = $db->get_row($sqlNumMvtoEnc);
$regMvtoTmp = $db->get_row($sqlNumMvtoTmp);//4 de marzo 2014

        $vNumPregEnc = $regPregEnc->cuenta;
        $vNumMvtoEnc = $regMvtoEnc->cuenta; 
 $vNumMvtoTmp =  $regMvtoTmp->cuenta;        
        
        $sqlGraficas = "SELECT count(*) as cuenta FROM  Blobs WHERE  NomDocumento LIKE  '".$num_ot."%' ";
        $regGrafEnc = $db->get_row($sqlGraficas);
        $numGraficas = $regGrafEnc->cuenta;
//&& ($numGraficas==2)
        if (($vEstadoExamenF!="PE") && ($regPregEnc->cuenta == $regMvtoEnc->cuenta ) ) {//todas las preguntas estan contestadas .
            $respJson = "{ 'pagina' : 'menuDonante.php' ,metodo : '' , 'info': '".$num_ot."' , 'tipoencuesta' : '0' , 'error' : 'El Donante ya completo la Autoexclusion Post Donacion' ,'usuario' : 'donante',  'cc' : '$ccReal'} ";
            die($respJson);

        }//if ($regPregEnc->cuenta == $regMvtoEnc->cuenta ){//todas las preguntas estan contestadas .

  //      $_SESSION[$donante]['encOtDon'] = $donante;

        $_SESSION[$donante]['encOtDon'] = $donante;
        $_SESSION[$donante]['encCCDon'] = $recDonanteHoy->Cedula;

        $_SESSION[$donante]['encNombreDon'] = $recDonanteHoy->Nombre;
        $_SESSION[$donante]['encApellido1Don'] = $recDonanteHoy->Apellido1;
        $_SESSION[$donante]['encApellido2Don'] = $recDonanteHoy->Apellido2;
        $_SESSION[$donante]['encReceptor'] = $recDonanteHoy->Receptor;
        $_SESSION[$donante]['encSexDonante'] = $recDonanteHoy->Sexo;
        $_SESSION[$donante]['cod_bact'] = $recDonanteHoy->Bacteriologa;

      //    include "configEncuesta.php";
 //header("Location:../ajax/configEncuesta.php"); 

     //     include "getDonante.php";
      // include "showPregunta.php";

        $cta1=0;
        $cta2 = 0;
 
        $sqlXDonacion = "SELECT b.PostDonacion, COUNT( * ) AS cuenta FROM banco_encuesta b WHERE  b.activa =1   GROUP BY b.PostDonacion ";//" ORDER BY PostDonacion ";
        //$recXDonacion = $db->get_row($sqlXDonacion);
        $arrPosDonaicon = array();
       $arrPosDonaTipo = array();


        if ($users = $db->get_results($sqlXDonacion, ARRAY_A)) {
            foreach ($users as $user) {
                array_push($arrPosDonaicon, $user['cuenta']);
                array_push($arrPosDonaTipo, $user['PostDonacion']);
                if ($user['PostDonacion'] ==0){
                    $cta1 = $user['cuenta'];
                }
                if ($user['PostDonacion'] ==1){
                    $cta2 = $user['cuenta'];
                }
            }
        }//if ($users = $db->get_results($sqlXDonacion, ARRAY_A)) {


       
         // $cta1 = $arrPosDonaicon[0];
        //$cta2 = $arrPosDonaicon[1];

        $respJson= "{ 'pagina' : 'det_encuesta.php',metodo : ''  , 'info': '$cta2', 'tipoencuesta' : '0',  'error' :' $vNumMvtoEnc faltan preguntas pre donacion' ,'usuario' : 'donante',  'cc' : '$ccReal'";
        $respJson .=" }" ;

       //die($respJson);


        if (($cta1> $vNumMvtoEnc ) && ($vNumMvtoTmp==0)){//faltan preguntas por contestar
            $_SESSION["tipo_encuesta"]  = "0";
             $_SESSION['usuario_encuesta'] = "donante";
             include "../ajax/configEncuesta.php";
            $respJson = "{ 'pagina' : 'det_encuesta.php',metodo : ''  , 'info': '".$donante."', 'tipoencuesta' : '0',  'error' :'' ,'usuario' : 'donante' ,  'cc' : '$ccReal'";
            $respJson.="  , 'nombre' : '$recDonanteHoy->Nombre','apellido1' : '$recDonanteHoy->Apellido1' ,'apellido2' : '$recDonanteHoy->Apellido2'   ";
            $respJson.=" , 'sexo' : '$recDonanteHoy->Sexo' , 'codbact' : '$recDonanteHoy->Bacteriologa'  "; 
            $respJson.=" } ";  

            die($respJson);
        }//if ($cta1> $vNumMvtoEnc ){//faltan preguntas por contestar
        if ($vEstadoExamenF=="PE"){//($vEstadoEncuesta=="PE"){//Falta la validacion de la encuesta antes de realizar la autoexclusion post donacion
             $_SESSION["tipo_encuesta"]  = "0";
            $respJson = "{ 'pagina' : 'FormularioCompleto.php' ,metodo : '' , 'info': '".$donante."' , 'tipoencuesta' : '0', 'error' : '','usuario' : 'bacteriologa' ,  'cc' : '$ccReal'";
            $respJson.=" } ";
            $_SESSION['usuario_encuesta'] = "bacteriologa";
            die($respJson);
        }//if ($vEstadoExamenF=="PE")
        
 

        //if ( (($cta1+$cta2) > $vNumMvtoEnc) || ($numGraficas<2) ) {//falta la autoexclusion post donacion .
        if ( ($cta1+$cta2) > $vNumMvtoEnc )  {//falta la autoexclusion post donacion .
            $_SESSION["tipo_encuesta"]  = "1";
            $_SESSION['usuario_encuesta'] = "donante";
include "../ajax/configEncuesta.php";
            $respJson = "{ 'pagina' : 'det_encuesta.php',metodo : ''  , 'info': '".$donante."', 'tipoencuesta' : '1',  'error' :'','usuario' : 'donante' ,  'cc' : '$ccReal' ";
            $respJson.="  , 'nombre' : '$recDonanteHoy->Nombre','apellido1' : '$recDonanteHoy->Apellido1' ,'apellido2' : '$recDonanteHoy->Apellido2'   ";
            $respJson.=" , 'sexo' : '$recDonanteHoy->Sexo' , 'codbact' : '$recDonanteHoy->Bacteriologa' "; 
            $respJson.=" } ";  

            die($respJson);
        }//if (($cta1+$cta2) > $vNumMvtoEnc){/


$vMsgCuentas = "paso con  $cta1+$cta2 total respuestas = $vNumMvtoEnc " ;

        $_SESSION["tipo_encuesta"]  = "0";
        $respJson = "{ 'pagina' : 'det_encuesta.php' ,metodo : '' , 'info': '".$donante."' , 'tipoencuesta' : '0', 'error' :'".$vMsgCuentas."','usuario' : 'donante' ,  'cc' : '$ccReal'  ";
        $respJson.="  , 'nombre' : '$recDonanteHoy->Nombre','apellido1' : '$recDonanteHoy->Apellido1' ,'apellido2' : '$recDonanteHoy->Apellido2'   ";
        $respJson.=" , 'sexo' : '$recDonanteHoy->Sexo' , 'codbact' : '$recDonanteHoy->Bacteriologa' "; 
        $respJson.=" } ";  
       include "../ajax/configEncuesta.php";

//echo $respJson;

        die($respJson);
       
    }//encuesta de hoy
    if ($mes2_anterior < $recDonanteHoy->Fecha){//el donante dono hace menos de 2 meses 
        $donante = $recDonanteHoy->Nro_Consecutivo;//$mes2_anterior
        $respJson = "{ 'pagina' : 'det_encuesta.php' ,metodo : '' , 'info': '".$num_ot."' , 'tipoencuesta' : '0', 'error' : 'Ultima donacion $recDonanteHoy->Fecha  ','usuario' : 'donante'  ,  'cc' : '$ccReal' }";
        die($respJson);
      
    }



    if ($donante != $recDonanteHoy->Nro_Consecutivo){
        //$donante = $recDonanteHoy->Nro_Consecutivo;
        
    }//if ($donante != $recDonanteHoy->Nro_Consecutivo){

    // El paciente ya constesto la encuesta ?
 
    //el paciente puede donar nuevamente .
    $respJson = "{ 'pagina' : 'FormularioCompleto.php' ,metodo : '3' , 'info': '".$donante."' , 'tipoencuesta' : '0', 'error' : '','usuario' : 'donante' ,  'cc' : '$num_ot' } ";

         
    die($respJson);


 
}//if ($donante != "") {

$respJson = "{ 'pagina' : 'MenuDonante.php' ,metodo : '' , 'info': '".$donante."' , 'tipoencuesta' : '0', 'error' : 'falta categorizar','usuario' : 'donante' ,  'cc' : '$num_ot' } ";

die($respJson);

?>
