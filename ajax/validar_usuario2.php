<?php

@session_start();//29 oct 2013

$num_ot = $_POST['num_ot'];

if (!isset($_SESSION[$num_ot]['encOtDon'])) {
    include '../../dona.html';//'../apl/login.php';
    die;
}

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);


if (isset($_POST['usuario']) and (isset($_POST['password']))) {

    $ccPac =  $_SESSION[$num_ot]['encCCDon'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (($usuario == "donante") && ($password==$ccPac)){//el mismo usuario termina la encuesta .
//    if ($usuario == "donante") {//el mismo usuario termina la encuesta .
        echo "1";
        //echo "2|$password = $ccPac";
    }else{
        $msg="Usuario o password incorrecto (Requiere ser password de Bacteriologa,  Enfermeria o Auxiliar de Banco)";
        $sql = "SELECT * FROM UsuariosLab WHERE CodigoUsuario4D = '$usuario' AND Clave LIKE BINARY '$password' AND (Grupo = 'ENFERMERIA' OR Grupo = 'AUX BANCO' OR Grupo = 'BACTERIOLOGIA')";

        $rs = $db->get_row($sql);

        if (isset($rs->Nombres)) {
            echo "1";
        } else {
            echo "2|$msg";
        }

    }
 



}
?>