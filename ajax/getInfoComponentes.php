<?php

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------

$codigos_bact=array();
$nombres_bact=array();

include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);



//$sql = "SELECT * FROM banco_componentes ORDER BY posicion;";
$sql = "SELECT * FROM banco_componentes ORDER BY codigo;";

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------

$cadbact = "";
$c=",";
$comilla2=chr(34);// comilla doble "

if ($users = $db->get_results($sql, ARRAY_A)) {
    $numItems = count($users);
    $i=0;
    foreach ($users as $user) {
        $i++;
        $cadbact.=" { ";
        $cadbact.=$comilla2."codigo".$comilla2." : ".$comilla2.$user['codigo'].$comilla2;
        $cadbact.=$c.$comilla2."descripcion".$comilla2.": ".$comilla2.$user['descripcion'].$comilla2;
        $cadbact.=$c.$comilla2."relacion".$comilla2.": ".$comilla2.$user['relacion'].$comilla2;
        $cadbact.=" } ";
        if ($i<$numItems){
            $cadbact.=",";
        }
    }



}


echo "{ \"componentes\":[".$cadbact."] }";


?>


