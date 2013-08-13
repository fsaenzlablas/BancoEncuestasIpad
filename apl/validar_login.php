<?php


date_default_timezone_set("America/Bogota");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);


if (isset($_POST['usuario']) and (isset($_POST['password'])) ) {

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
	$tipoencuesta = $_POST['tipoencuesta'];


    $sql="SELECT * FROM UsuariosLab WHERE CodigoUsuario4D = '$usuario' AND Clave LIKE BINARY '$password'";
    $rs = $db->get_row($sql);
    //$db->debug();
 
    if (isset($rs->Nombres)) {
        @session_start();
        $_SESSION["usuario_encuesta"] = $usuario;
        $_SESSION["tipo_encuesta"] = $tipoencuesta;

        header("Location:../apl/encuesta.php");
    } else {
        header("Location:../apl/login.php?login=NO");
    }
}
?>