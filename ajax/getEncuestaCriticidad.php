<?php
@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------


include_once("../class/Database.php");
include_once("../class/FourDimensionAccess.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");

//echo var_dump($_POST['popRespComponentes']);
//echo "<br/> VALOR DE POST:<br/>";
//echo var_dump($_POST);
//var_dump($_POST);
//die($_POST['popRespComponentes']);
//die("ACABE");

date_default_timezone_set("America/Bogota");




@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarRespuesta.php
//
// Rutina AJAX que graba la respuesta a una pregunta especifica recibida
// como parametro.
// ------------------------------------------------------------------------


include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$orden = $_POST['wsTxtOrden'];

$vEsperada = "";

$maxcriticidad = 0;




$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$cmdSelect = "SELECT resperada,valor,criticidad FROM banco_mvto_encuesta_tmp WHERE nro_consecutivo = '$orden' ";
if ($resEsperadas = $db->get_results($cmdSelect,ARRAY_A)) {//
    foreach ($resEsperadas as $resEsperada) {
        $vEsperada = $resEsperada['resperada'];
        $valor = $resEsperada['valor'];
        $criticidad = $resEsperada['criticidad'];


        if ($vEsperada==$valor){

           
        }else if ($valor=="NO-APLICA"){
            
        }else if ($valor=="NO APLICA"){
            
        }else if ($maxcriticidad < $criticidad){
            $maxcriticidad = $criticidad;  
        }else { }



    }

}



//unset($Client);
echo "{ 'orden' : '$orden' , 'criticidad':'$maxcriticidad' } ";



?>


    
