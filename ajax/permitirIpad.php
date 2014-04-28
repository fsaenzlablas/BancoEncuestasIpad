<?php
@session_start();//29 oct 2013

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);

// -----------------------------------------------------------------------------------------
// Capturar todas los parametros que vienen en el POST.
// -----------------------------------------------------------------------------------------

$num_ot = $_POST['num_ot'];

$sql = "DELETE FROM banco_encuesta_enc_tmp WHERE nro_consecutivo = '{$num_ot}' AND Observaciones='EN PROCESO';";

// Si borrar exitosamente el registro, al invocar la funcion query se retorna  1
$n = $db->query($sql);

// Si graba exitosamente el registro, al invocar la funcion query se retorna  1
if ($n >= 0) {
    $resultado = "1|La encuesta se reinicio exitosamente, Haga clic en el bot&oacute;n <strong>Buscar Donante</strong>";
} else {
    $resultado = "F|{$db->last_error} <br/> {$db->last_query}";
}
echo $resultado;

?>