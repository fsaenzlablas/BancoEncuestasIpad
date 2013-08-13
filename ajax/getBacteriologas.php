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
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$sql = "SELECT * FROM banco_bacteriologas WHERE tipo='Bacteriologa' ORDER BY nombre;";

/*dump($sql);
die("ACABE2");*/

if ($users = $db->get_results($sql, ARRAY_A)) {
    foreach ($users as $user) {
        array_push($codigos_bact, $user['codigo']);
        array_push($nombres_bact, htmlentities($user['nombre'], ENT_COMPAT));
    }
    array_multisort($nombres_bact, $codigos_bact);
}




$OpcionesSelect = " class='combo-box' id='bacteriologa' " ;
$list = new PopUp($codigos_bact, $nombres_bact, "bacteriologa", "", "", 1, 270, $OpcionesSelect);
$list->echoHtml();


?>



