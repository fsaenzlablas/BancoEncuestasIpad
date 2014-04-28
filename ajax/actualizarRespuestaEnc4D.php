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




$parametros = array();


@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarRespuesta.php
//
// Rutina AJAX que graba la respuesta a una pregunta especifica recibida
// como parametro.
// ------------------------------------------------------------------------

$carita="";

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$parametros['wsTxtOrden'] = $_POST['wsTxtOrden'];
$parametros['wsTxtPregunta'] = $_POST['wsTxtPregunta'];

$parametros['wsTxtRespuestaEnc'] = trim($_POST['wsTxtRespuestaEnc']);

$ot = $_POST['wsTxtOrden'];
$orden = $_POST['wsTxtOrden'];
$pregunta = $_POST['wsTxtPregunta'];
$valor = trim($_POST['wsTxtRespuestaEnc']);

$vEsperada = "";

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$cmdSelect = "SELECT resperada FROM banco_mvto_encuesta_tmp WHERE nro_consecutivo = '$orden' AND codigo = '$pregunta' ";
if ($resEsperadas = $db->get_results($cmdSelect,ARRAY_A)) {//
    foreach ($resEsperadas as $resEsperada) {
        //$vEsperada = trim($resEsperada['resperada']);
        $vEsperada = trim($resEsperada['resperada']);
       
    }

}

$cmdSql = "UPDATE banco_mvto_encuesta_tmp SET valor = '$valor' ";
if ($vEsperada!=""){
    if ($vEsperada === $valor){
        $carita ="feliz.png";
    }else if ($valor=="NO-APLICA"){
        $carita ="feliz.png";
    }else if ($valor=="NO APLICA"){
        $carita ="feliz.png";
    }else {  $carita ="triste.png";
       // $carita = " $vEsperada === $valor "; 
    }//"feliz.png"
    $cmdSql .= " , carita = '$carita' " ;
}

$cmdSql .= " WHERE nro_consecutivo = '$orden' AND codigo = '$pregunta' ";



if ($db->query($cmdSql) == 1) {
}




//die(var_dump($_POST));
//echo $parameters;
//die(var_dump($parameters);
//$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarBancoRegistro', $parameters);
$resultado = $database->call4DWebServer('wsActualizarResptaEncDonante', $parametros);

$database->disconnect();

$res4D = "";
$partes = array();

$ctaMalas=0;
$estado ="";

if ($resultado!=""){

    $partes = explode('|', $resultado);
    if (count($partes)>1){
        $ctaMalas =  $partes[1] ;  
        $orden = $partes[0] ; 
        $res4D = $partes[0] ; 
        $estado = $partes[2];

    }else{
        $res4D = $resultado;

    }

}
//unset($Client);
echo "{ 'orden' : '$ot' , 'pregunta':'$pregunta' , 'respuesta' : '$res4D' , 'malas' : '$ctaMalas' , 'estado' : '$estado' ,'carita': '$carita','esperada' : '$vEsperada' , 'valor':'$valor'} ";


//ya no se necesita revisar el comando ." = ".$cmdSql;


?>


    
