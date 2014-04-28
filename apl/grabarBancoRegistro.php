<?php
@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------

$wMensaje = "";
$NameSpace = "";

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


// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------

//echo var_dump($_POST);

//die(var_dump($_POST));

//echo $_POST['txtCedula'];
//die(var_dump($_POST));

//if (isset($_POST['txtCedula']) and (isset($_POST['txtCedula'])) ) {
//}



$parametros = array();

/*
$parametros['wsNumHistoria'] = "253829";
$parametros['wsNumCedula'] = "";

$parametros['wsSeparador'] = "|";

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarBancoRegistro', $parameters);
$resultado = $database->call4DWebServer('wsNombrePdfsEnS3', $parametros);

$database->disconnect();

echo $resultado+"----------";
die ($resultado);
*/


$parametros['wsItxtNombre'] = $_POST['txtNombre'];
$parametros['wsItxtCedula'] = $_POST['txtCedula'];

$parametros['wsIpopOrdenes'] = $_POST['popOrdenes'];
$parametros['wsItxtCodBacteriologa'] = $_POST['txtCodBacteriologa'];

if ($parametros['wsItxtCodBacteriologa']==""){
    $parametros['wsItxtCodBacteriologa'] = $_SESSION['codigobacteriologa'];
}


$parametros['wsIBacteriologas'] = $_POST['Bacteriologas'];

$parametros['wsItxtOTbuscar'] = $_POST['txtOTbuscar'];
$parametros['wsItxtFechaDesde'] = $_POST['txtFechaDesde'];
$parametros['wsItxtFechaHasta'] = $_POST['txtFechaHasta'];
$parametros['wsItxtOrden'] = $_POST['txtOrden'];
$parametros['wsItxtFecha'] = $_POST['txtFecha'];

$parametros['wsItxtApellido1'] = $_POST['txtApellido1'];
$parametros['wsItxtApellido2'] = $_POST['txtApellido2'];
$parametros['wsItxtDireccion'] = $_POST['txtDireccion'];
$parametros['wsItxtTelefonos'] = $_POST['txtTelefonos'];


$parametros['wsIpoFechanat'] = $_POST['txtFechaNat'];
$parametros['wsIpoPedad'] = $_POST['txtEdad'];

$parametros['wsIpopGenero'] = $_POST['popGenero'];

$parametros['wsIpopGrupoSanguineo'] = $_POST['popGrupoSanguineo'];
$parametros['wsIpopRH'] = $_POST['popRH'];
$parametros['wsIpopTipoDonacion'] = $_POST['popTipoDonacion'];
$parametros['wsICategorias'] = $_POST['popCategorias'];
$parametros['wsIEPS'] = $_POST['EPS'];
$parametros['wsItxtE_Mail'] = $_POST['txtE_Mail'];

$parametros['wsItxtReceptor'] = $_POST['txtReceptor'];

$parametros['wsItextarea_observaciones'] = $_POST['textarea_observaciones'];


$parametros['wsItextarea_reaccion'] = $_POST['textarea_reaccion'];
$parametros['wsIpoPpeso'] = $_POST['poPpeso'];
$parametros['wsIpoPpesounidad'] = $_POST['poPpesounidad'];

$parametros['wsIpoPtemperatura'] = $_POST['poPtemperatura'];
$parametros['wsIpoPtemperatura_dec'] = $_POST['poPtemperatura_dec'];

$parametros['wsIpoPsistolica'] = $_POST['poPsistolica'];
$parametros['wsIpoPsistolicaunidad'] = $_POST['poPsistolicaunidad'];

$parametros['wsIpoPdiastolica'] = $_POST['poPdiastolica'];
$parametros['wsIpoPdiastolicaunidad'] = $_POST['poPdiastolicaunidad'];

$parametros['wsIpoPhemoglobina'] = $_POST['poPhemoglobina'];
$parametros['wsIpoPhemoglobina_dec'] = $_POST['poPhemoglobina_dec'];
$parametros['wsIpoPhematocrito'] = $_POST['poPhematocrito'];
$parametros['wsIpoPhematocrito_dec'] = $_POST['poPhematocrito_dec'];

$parametros['wsIpoPfcardiaca'] = $_POST['poPfcardiaca'];
$parametros['wsIpoPfcardiacaunidad'] = $_POST['poPfcardiacaunidad'];

$parametros['wsItextarea_comentaFisico'] = $_POST['textarea_comentaFisico'];

$parametros['wsIComponentes'] = $_POST['Componentes'];
$parametros['wsIidEncuestaTxt'] = $_POST['idEncuestaTxt'];
$parametros['wsIidPerfilTxt'] = $_POST['idPerfilTxt'];
$parametros['wsIidFenotipoTxt'] = $_POST['idFenotipoTxt'];
$parametros['wsIidEFisicoTxt'] = $_POST['idEFisicoTxt'];


$parametros['wsAuxiliarEFisico'] = $_POST['idwsAuxiliarEFisico'];//18/03/2014




//die(var_dump($_POST));
//echo $parameters;
//die(var_dump($parameters);
//$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$database = new FourDimensionAccess();
$database->connect();
//$resultado = $database->call4DWebServer('wsGrabarBancoRegistro', $parameters);
$resultado = $database->call4DWebServer('wsIpadBancoRegistro', $parametros);

$database->disconnect();

if (0){//comentado por ahora
  if ($resultado != ""){
    $donante  = $resultado;
    $num_ot =$resultado;
    $_SESSION[$num_ot]['encOtDon'] = $donante;
    $_SESSION[$num_ot]['encCCDon'] = $parametros['wsItxtCedula'] ;

    $_SESSION[$num_ot]['encNombreDon'] = $parametros['wsItxtNombre'] ;
    $_SESSION[$num_ot]['encApellido1Don'] = $parametros['wsItxtApellido1']; 
    $_SESSION[$num_ot]['encApellido2Don'] = $parametros['wsItxtApellido2'] ;
    $_SESSION[$num_ot]['encReceptor'] = $parametros['wsItxtReceptor'] ;
    $_SESSION[$num_ot]['encSexDonante'] = $parametros['wsIpopGenero'] ;
    $_SESSION[$num_ot]['cod_bact'] = $parametros['wsItxtCodBacteriologa'] ;
    include "../ajax/configEncuesta.php";
}
  
}
//unset($Client);
echo $resultado;


?>


    
