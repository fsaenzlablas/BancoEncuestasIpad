<?php
//var_dump($_POST);
@session_start();//29 oct 2013

date_default_timezone_set('America/Bogota');

include_once "../lib/shared/ez_sql_core.php";

include_once("../lib/ez_sql_mysql.php");



$num_ot = trim($_POST['num_ot']);

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$respJson="";

if ($_SESSION[$num_ot]['encNombreDon']=="") {


	$sqlDonanteHoy = "SELECT * FROM banco_registro r  WHERE r.Nro_Consecutivo = '$num_ot'  ORDER BY Nro_Consecutivo DESC   ";

	$recDonanteHoy = $db->get_row($sqlDonanteHoy);
	if (isset($recDonanteHoy->Nro_Consecutivo)) {
		$_SESSION[$num_ot]['encOtDon'] = $num_ot;
		$_SESSION[$num_ot]['encCCDon'] = $recDonanteHoy->Cedula;

		$_SESSION[$num_ot]['encNombreDon'] = $recDonanteHoy->Nombre;
		$_SESSION[$num_ot]['encApellido1Don'] = $recDonanteHoy->Apellido1;
		$_SESSION[$num_ot]['encApellido2Don'] = $recDonanteHoy->Apellido2;
		$_SESSION[$num_ot]['encReceptor'] = $recDonanteHoy->Receptor;
		$_SESSION[$num_ot]['encSexDonante'] = $recDonanteHoy->Sexo;
		$_SESSION[$num_ot]['cod_bact'] = $recDonanteHoy->Bacteriologa;
		$nombact = $_SESSION[$num_ot]['nom_bact'];

		$respJson = "{  'ot': '$num_ot' , 'cc' : '$recDonanteHoy->Cedula'  ";
        $respJson.="  , 'nombre' : '$recDonanteHoy->Nombre','apellido1' : '$recDonanteHoy->Apellido1' ,'apellido2' : '$recDonanteHoy->Apellido2'   ";
        $respJson.=" , 'sexo' : '$recDonanteHoy->Sexo' , 'codbact' : '$recDonanteHoy->Bacteriologa' , 'nombact' : '$nombact' "; 
        $respJson.=" } ";  

	}


}

if (isset($_SESSION[$num_ot]['encOtDon'])) {
	$cc = $_SESSION[$num_ot]['encCCDon'];
	$nombre = $_SESSION[$num_ot]['encNombreDon'];
	$apellido1 = $_SESSION[$num_ot]['encApellido1Don'];
	$apellido2 = $_SESSION[$num_ot]['encApellido2Don'];
	$sexo = $_SESSION[$num_ot]['encSexDonante'];
	$codbact = $_SESSION[$num_ot]['cod_bact'];
	$nombact = $_SESSION[$num_ot]['nom_bact'];



			$respJson = "{  'ot': '$num_ot' , 'cc' : '$cc'  ";
	        $respJson.="  , 'nombre' : '$nombre','apellido1' : '$apellido1' ,'apellido2' : '$apellido2'   ";
	        $respJson.=" , 'sexo' : '$sexo' , 'codbact' : '$codbact' , 'nombact' : '$nombact' "; 
	        $respJson.=" } ";  
	



	    $htmlCode = <<< HTML
	    <div class='datosDonante'>
	        CEDULA:  <strong>{$_SESSION[$num_ot]['encCCDon']} </strong>
	        NOMBRES: <strong>{$_SESSION[$num_ot]['encNombreDon']} {$_SESSION[$num_ot]['encApellido1Don']} {$_SESSION[$num_ot]['encApellido2Don']}  </strong> Sexo:  <strong>{$_SESSION[$num_ot]['encSexDonante']} </strong>
	        Consecutivo donaci&oacute;n: <strong> {$num_ot} </strong>
	        <br>Bacteriologa responsable:  {$_SESSION[$num_ot]['nom_bact']}
	    </div>
HTML;

	    echo $htmlCode;

	 


	//}

}
//echo $respJson;


?>