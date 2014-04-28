<?php


//	$vTxt ="<label for='poPyear'>A&ntilde;o</label>2";
	
$vTxt = "<div id='poPyear' >";

//$vTxt .="<label for='poPyear'>A&ntilde;o</label>";
	/*
$vTxt .="	<div class='ui-select'><div data-corners='true' data-shadow='true' data-iconshadow='true' data-wrapperels='span' data-icon='arrow-d' data-iconpos='right' data-theme='c' class='ui-btn ui-btn-icon-right ui-corner-right ui-controlgroup-last ui-btn-up-c'><span class='ui-btn-inner ui-corner-right ui-controlgroup-last'><span class='ui-btn-text'></span><span class='ui-icon ui-icon-arrow-d ui-icon-shadow'>&nbsp;</span></span>";
*/

$vTxt .= "<select name='poPyear' id='poPyear' class='combo-box-demo'>";

	$vTxt .= "<option>A&ntilde;o</option>";
	$inicial = date("Y");
//	$vTxt .= "<option value='$inicial'>$inicial</option>";
	
	for ( $i=0;$i<100;$i++){
		$yyy = $inicial - $i;
		if ($i==18)
			$vTxt  .=  "<option value='$yyy' selected>$yyy</option>";
		else
		$vTxt  .=  "<option value='$yyy'>$yyy</option>";
		
	}
$vTxt .= "</select>";//"</div></div>";
  $vTxt .= "  </div>";
echo $vTxt;
?>

