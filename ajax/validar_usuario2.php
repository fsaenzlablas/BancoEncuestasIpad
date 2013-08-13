<?php
$num_ot = $_POST['num_ot'];

if (!isset($_SESSION[$num_ot]['encOtDon'])) {
    include '../apl/login.php';
    die;
}

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);


if (isset($_POST['usuario']) and (isset($_POST['password']))) {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];


    $msg="Usuario o password incorrecto (Requiere ser password de Bacteriologa,  Enfermeria o Auxiliar de Banco)";
    $sql = "SELECT * FROM UsuariosLab WHERE CodigoUsuario4D = '$usuario' AND Clave LIKE BINARY '$password' AND (Grupo = 'ENFERMERIA' OR Grupo = 'AUX BANCO' OR Grupo = 'BACTERIOLOGIA')";

    $rs = $db->get_row($sql);

    if (isset($rs->Nombres)) {
        echo "1";
    } else {
        echo "2|$msg";
    }


}
?>