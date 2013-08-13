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

    if (!isset($_SESSION[$num_ot]['reinicios'])) {

        $grupo="ENFERMERIA";
        $msg="Usuario o password incorrecto (Requiere ser password de Enfermeria)";
        $sql = "SELECT * FROM UsuariosLab WHERE CodigoUsuario4D = '$usuario' AND Clave LIKE BINARY '$password' AND (Grupo = 'ENFERMERIA' OR Grupo = 'AUX BANCO')";

    } else {
        $grupo="BACTERIOLOGIA";
        $msg="Usuario o password incorrecto (Requiere ser password de Bacteriologa)";
        $sql = "SELECT * FROM UsuariosLab WHERE CodigoUsuario4D = '$usuario' AND Clave LIKE BINARY '$password' AND Grupo = 'BACTERIOLOGIA'";
    }
    $rs = $db->get_row($sql);

    if (isset($rs->Nombres)) {
        $_SESSION[$num_ot]['reinicios'] = "REQUIERE LOGIN POR BACT";
        echo "1";
    } else {
        echo "2|$msg";
    }


}
?>