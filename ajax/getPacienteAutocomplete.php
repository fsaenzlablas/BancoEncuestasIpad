<?php

// ------------------------------------------------------------------------
// Programa: getBacteriologas.php
//
// Buscar todos las bacteriologas Grabadas en el sistema de Banco
//
// ------------------------------------------------------------------------



$valor = $_POST['txtNombre'];
//Nombres
$codigos_bact=array();
$nombres_bact=array();

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$sql = "SELECT Nombres FROM Pacientes WHERE Nombres LIKE '$valor%' ORDER BY Nombres  LIMIT 20;";
$results = array();
$results =  {'pepito'};

if ($users = $db->get_results($sql, ARRAY_A)) {
    foreach ($users as $user) {
 array_push($results, $user['Nombres']);
 

    }

}


echo $results;

//echo json_encode($results);



?>



