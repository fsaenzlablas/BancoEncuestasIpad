<?php
@session_start();//29 oct 2013
// ------------------------------------------------------------------------
// Programa: grabarEncuestaMySQL.php
//
// El programa realiza la grabacion de la encuesta en MySQL, la encuesta 
// NO ESTA validada y debe hacerse en MySQL en tablas temporales de la
// encuesta.
// ------------------------------------------------------------------------
// ------------------------------------------------------------------------
// Incluir bibliotecas y clases necesarias
// ------------------------------------------------------------------------

include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
date_default_timezone_set("America/Bogota");

$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);
$num_ot =$_POST['num_ot'];
$wMensaje = "";

// ------------------------------------------------------------------------
// Obtener los datos del registro de las variables de sesion.
// ------------------------------------------------------------------------

$conse = $_SESSION[$num_ot]['encOtDon'];
$fecha = date('Y-m-d');

$cedula = $_SESSION[$num_ot]['encCCDon'];

$bact = $_SESSION[$num_ot]['cod_bact'];
$obs = "SIN CONFIRMAR"; // Si se cambia este mensaje actualizar tambien en el script getDonante.php en la Linea 32

$nombre = $_SESSION[$num_ot]['encNombreDon'] . " " . $_SESSION[$num_ot]['encApellido1Don'] . " " . $_SESSION[$num_ot]['encApellido2Don'];


// --------------------------------------------------------------------------
// Insertar las respuestas de la encuesta en la tabla banco_mvto_encuesta_tmp
// ---------------------------------------------------------------------------


$j = 1;
$estado = "OK";


for ($i = 0; $i < sizeof($_SESSION[$num_ot]['codigos_pre']); $i++) {

    // ------------------------------------------------------------------------
    // Tomar los valores de las variables de session
    // ------------------------------------------------------------------------

    $codigo = $_SESSION[$num_ot]['codigos_pre'][$i];
    $descripcion = $_SESSION[$num_ot]['descripciones'][$i];
    $valor = $_SESSION[$num_ot]['rdonante'][$i];

    $tipo = $_SESSION[$num_ot]['tipos'][$i];
    $orden = $i + 1;
    $crit = $_SESSION[$num_ot]['criticidades'][$i];

    $resperada = $_SESSION[$num_ot]['resperadas'][$i];
    $secuencia = $_SESSION[$num_ot]['secuencias'][$i];

    $tiposig = $_SESSION[$num_ot]['tipos_sig'][$i];
    $codsig = $_SESSION[$num_ot]['cod_sig'][$i];

    // ------------------------------------------------------------------------
    // Configurar que carita debe mostrar en el listado, depende del grado de
    // importancia de la pregunta. (servira para rechazar o aceptar el donante)
    // ------------------------------------------------------------------------


    if ($_SESSION[$num_ot]['criticidades'][$i] == "1") {

        if ($_SESSION[$num_ot]['resperadas'][$i] != $_SESSION[$num_ot]['rdonante'][$i]) {
            $carita = "triste.png";

            if ((($_SESSION[$num_ot]['tipos'][$i] == "SELECCION") and ($_SESSION[$num_ot]['rdonante'][$i] != "NO APLICA")) OR (($_SESSION[$num_ot]['tipos'][$i] == "SI-NO") )) {

                # Sino esta rechazado automaticamente puede colocarse condicional
                if ($estado != "RA") {
                    $estado = "OC";
                }
            }
        } else {
            $carita = "feliz.png";
        }
    } elseif ($_SESSION[$num_ot]['criticidades'][$i] == "2") {

        if ($_SESSION[$num_ot]['resperadas'][$i] != $_SESSION[$num_ot]['rdonante'][$i]) {
            $carita = "triste.png";
            # Pregunta no esperada de criticidad 2 significa que el donante
            # debe ser rechazado automaticamente
            if ((($_SESSION[$num_ot]['tipos'][$i] == "SELECCION") and ($_SESSION[$num_ot]['rdonante'][$i] != "NO APLICA")) OR (($_SESSION[$num_ot]['tipos'][$i] == "SI-NO") )) {
                $estado = "RA";
            }
        } else {
            $carita = "feliz.png";
        }
    } else {

        // Si la respuesta no tiene importancia para aceptar o rechazar solo preocuparse por que
        // Carita mostrar. Que las preguntas de mas importancia cambien el estado de la encuesta.
        $carita = "feliz.png";
    }

    // ------------------------------------------------------------------------
    // Insertar el detalle de la respuesta, si no es la FIRMA
    // ------------------------------------------------------------------------

    if ($codigo == "FIRMA") {
       // No hacer nada. Ignore esta pregunta. La firma se graba en otra parte
    } else {

        $sql = " DELETE FROM banco_mvto_encuesta_tmp WHERE nro_consecutivo='$conse' AND codigo=$codigo ;";
        $n = $db->query($sql);

        if (n >= 0 ) {
            $resultado = "1";
        } else {
            $resultado = "F|{$db->last_error} <br/> {$db->last_query}";
            break;
        }

        $sql = <<< SQLSTM
     INSERT INTO banco_mvto_encuesta_tmp
            (nro_consecutivo, codigo,  descripcion,    valor,     tipo,   orden,  criticidad, resperada,   secuencia,   carita) VALUES
            ('{$conse}',     {$codigo}, '{$descripcion}', '{$valor}', '{$tipo}', {$orden}, {$crit},     '{$resperada}', {$secuencia}, '{$carita}' );
SQLSTM;

        // Si graba exitosamente el registro, al invocar la funcion query se retorna  1
        if ($db->query($sql) == 1) {
            $resultado = "1";
        } else {
            $resultado = "F|{$db->last_error} <br/> {$db->last_query}";
            break;
        }

    }

}


// ------------------------------------------------------------------------
// Insertar el encabezado de la encuesta en las tablas temporales
// ------------------------------------------------------------------------


if (  $resultado = "1" ) {

    $sql = " DELETE FROM banco_encuesta_enc_tmp WHERE nro_consecutivo='$conse';";
    $n = $db->query($sql);

    if (n >= 0 ) {

        $sql = <<< INSERT1
             INSERT INTO banco_encuesta_enc_tmp
                 (nro_consecutivo, cedula, fecha, estado, cod_bacteriologa, nombre, Observaciones) VALUES
                 ('{$conse}', '{$cedula}', '{$fecha}', '{$estado}', '{$bact}', '{$nombre}', '{$obs}');
INSERT1;


        // Si graba exitosamente el registro, al invocar la funcion query se retorna  1
        if ($db->query($sql) == 1) {
            $resultado = "1|LA ENCUESTA SE GRABO EXITOSAMENTE. INFORME A LA AUXLIAR.";
            $_SESSION[$num_ot]['enc_terminada'] = "SI";
        } else {
            $resultado = "F|{$db->last_error} <br/> {$db->last_query}";
        }


    } else {
        $resultado = "F|{$db->last_error} <br/> {$db->last_query}";

    }

}

echo $resultado;

?>
