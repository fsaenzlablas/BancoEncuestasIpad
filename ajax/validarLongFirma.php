<?php
@session_start();//29 oct 2013

$firma = $_POST['firma_donante'];
$num_ot=$_POST['num_ot'];

$_SESSION[$num_ot]['firma'] = $firma;

//removing the "data:image/png;base64," part
$uri = substr($firma, strpos($firma, ",") + 1);
// put the data to a file


if ($_SESSION["tipo_encuesta"] =="0")//firma pre donacion
	$file = "../firmas/" . $_SESSION[$num_ot]['encOtDon'] . ".png";
else//firma post donacion
	$file = "../firmas/" . $_SESSION[$num_ot]['encOtDon'] ."P". ".png";


if (file_exists($file)) {
unlink($file);
}

file_put_contents($file, base64_decode($uri));
$tam=filesize($file);

if (filesize($file)<10000){//estaba en 3000 que permite firmas en blanco.
    // Retornar FAIL (fallo) = que indica que la firma es demasiado corta.
    die("FAIL");
} else {
    // Retornar OK  = que indica que la firma es de longitud correcta
    die("OK");
}
?>