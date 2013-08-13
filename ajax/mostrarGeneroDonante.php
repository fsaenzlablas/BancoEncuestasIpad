<?php
$genero = $_POST['genero'];
$esMaculino = "";
$esFemenino = "";
$otro = "";

if ($genero=="Masculino"){
	$esMaculino = "checked='checked'";
	
}else if ($genero=="Femenino"){
	$esFemenino = "checked='checked'";
	
}else{
	$otro = "checked='checked'";
}


$cadena ="<div id='llenadoDin' class='ui-field-contain ui-body ui-br'><div data-role='fieldcontain'><fieldset data-role='controlgroup' data-type='horizontal' class='ui-corner-all ui-controlgroup ui-controlgroup-horizontal'>";


$cadena .= "<div class='ui-radio'><input type='radio' name='radio_genero_2' id='radio_genero_21' value='&nbsp;' ".$otro."  /></div>";
 $cadena .= "<label for='radio_genero_21' data-corners='true' data-shadow='false' data-iconshadow='true' data-wrapperels='span' data-theme='c' data-mini='false' class='ui-btn ui-fullsize ui-radio-off ui-btn-up-c'><span class='ui-btn-inner'><span class='ui-btn-text'>&nbsp;</span></span></label>";

$cadena .= "<div class='ui-radio'><input type='radio' name='radio_genero_2' id='radio_genero_22' value='Masculino' ".$esMaculino."  /></div>";
$cadena .= "<label for='radio_genero_22' data-corners='true' data-shadow='false' data-iconshadow='true' data-wrapperels='span' data-theme='c' data-mini='false' class='ui-btn ui-fullsize ui-radio-off ui-btn-up-c'><span class='ui-btn-inner'><span class='ui-btn-text'>Masculino</span></span></label>";
$cadena .= "<div class='ui-radio'><input type='radio' name='radio_genero_2' id='radio_genero_23' value='Femenino' ".$esFemenino." /></div>";
$cadena .= "<label for='radio_genero_23' data-corners='true' data-shadow='false' data-iconshadow='true' data-wrapperels='span' data-theme='c' data-mini='false' class='ui-btn ui-fullsize ui-radio-off ui-btn-up-c'><span class='ui-btn-inner'><span class='ui-btn-text'>Femenino</span></span></label>";
$cadena .= " </fieldset>";
$cadena .= "</div>";
$cadena .= "</div>";

echo $cadena;

?>



