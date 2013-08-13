<?php

// ------------------------------------------------------------------------
// Programa: getUsuarios.php
//
// Buscar todos los usuarios que acceden a terminales moviles.
//
// ------------------------------------------------------------------------


$codigos=array();
$nombres=array();

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

$sql = "SELECT * FROM UsuariosLab where PerfilWeb='008';";

if ($users = $db->get_results($sql, ARRAY_A)) {
    foreach ($users as $user) {
        array_push($codigos, $user['CodigoUsuario4D']);
        //array_push($nombres, $user['Nombres']." ".$user['Apellido']);
        array_push($nombres, htmlentities($user['Nombres']." ".$user['Apellido'], ENT_COMPAT));
    }
} 
array_multisort($nombres, $codigos);


$OpcionesSelect = " ";
$lstEmpleados = new PopUp($codigos, $nombres, "usuario", "", "", 1, 270, $OpcionesSelect);
$lstEmpleados->echoHtml();


?>



