<?php

// ------------------------------------------------------------------------
// Programa: getBacteriologas.php
//
// Buscar todos las bacteriologas Grabadas en el sistema de Banco
//
// ------------------------------------------------------------------------


$codigos_bact=array();
$nombres_bact=array();

include_once("../class/class.PopUp.php");

//include_once("../class/class.PopUpSelect.php");

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$sql = "SELECT * FROM banco_eps ORDER BY descripcion;";
		$select = "<div id='popEps' >";
		$select .= "<select name='popEps' id='popEps' class='select1Linea' >";
		$select  .=  "<option id='id-popEPS' value=''>EPS</option>";

if ($users = $db->get_results($sql, ARRAY_A)) {
    foreach ($users as $user) {
  		$codigo = $user['codigo'];
    	$nombre = htmlentities($user['descripcion'], ENT_COMPAT);
    	$select  .=  "<option id='$codigo' value='$codigo'>$nombre</option>";

        array_push($codigos_bact, $user['codigo']);
        array_push($nombres_bact, htmlentities($user['descripcion'], ENT_COMPAT));
    }

    array_multisort($nombres_bact, $codigos_bact);
}

	$select .= "</select>";
	$select .= "  </div>";



$OpcionesSelect = " id='popEps' class='ui-select'  " ;
$OpcionesSelect = " id='popEps' class='combo-box-small'  " ;
$OpcionesSelect = " id='popEps' class='select'  " ;
$list = new PopUp($codigos_bact, $nombres_bact, "EPS", "", "EPS", 1, 50, $OpcionesSelect);
//echo $list->echoHtmlMovil();//faltaba el echo.
echo $select;

//$list = new PopUpSelect($codigos_bact, $nombres_bact, "EPS","EPS");

//echo $list->echoHtml();//faltaba el echo.



?>



