<?php
/* 
 * Rutina para generar las respuestas esperadoas en todas las preguntas,
 * Sirve para hacer debugger
 */

@session_start();//29 oct 2013
 for ($i = 0; $i < sizeof($_SESSION['rdonante']); $i++) {

     if ($_SESSION['tipos'][$i]=="SI-NO") {
        $_SESSION['rdonante'][$i]=$_SESSION['resperadas'][$i];
     } else {
         $_SESSION['rdonante'][$i]="NO APLICA";
     }

     

 }

 /*
 $key = array_search("34",$_SESSION['codigos_pre']);
 $_SESSION['rdonante'][$key]="SI";

 $key = array_search("44",$_SESSION['codigos_pre']);
 $_SESSION['rdonante'][$key]="SI";


 $key = array_search("1",$_SESSION['codigos_pre']);
 $_SESSION['rdonante'][$key]="SI";
 */

$_SESSION['parameters']="";
$_SESSION['resGrabEnc']="";

 echo "Encuesta contestada";
 
?>
