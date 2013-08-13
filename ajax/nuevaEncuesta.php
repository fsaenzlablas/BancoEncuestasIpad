<?php
$user=$_SESSION['usuario_encuesta'];
$_SESSION=array();
$_SESSION['usuario_encuesta']=$user;
echo "";
?>
