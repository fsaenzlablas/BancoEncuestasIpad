<?php
@session_start();
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

$cadbact = "";
$c=",";
$comilla2=chr(34);// comilla doble "

if ($users = $db->get_results($sql, ARRAY_A)) {
    $numItems = count($users);
    $i=0;
    foreach ($users as $user) {
        $i++;
        $vNomBact = htmlentities($user['nombre'], ENT_COMPAT);
        $cadbact.=" { ";
        $cadbact.=$comilla2."codigo".$comilla2." : ".$comilla2.$user['codigo'].$comilla2;
        $cadbact.=$c.$comilla2."nombre".$comilla2.": ".$comilla2.$vNomBact.$comilla2;
        $cadbact.=$c.$comilla2."secreto".$comilla2.": ".$comilla2.$user['secreto'].$comilla2;
        $cadbact.=" } ";
        if ($i<$numItems){
            $cadbact.=",";
        }
    }



}


echo "{ \"bacteriologas\":[".$cadbact."] }";

?>



