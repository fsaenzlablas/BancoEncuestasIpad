<?php

error_reporting(E_ALL);
//error_reporting(E_ERROR);

Class PopUpSelect {

	// Contiene el codigo HTML que se generara para el PopUp
	var $HtmlCode="";

	
	function PopUpSelect($Codigos, $Descripciones, $id, $label) {

		$limite=sizeof($Codigos);
		$select = "";
		if ($id != ""){
			$select = "<div id='".$id."' >";
			$select .= "<select name='".$id."' id='".$id."' >";
		}
		if ($label != ""){
			$select .= "<option >".$label."</option>";
		}
		$i=0;
		while ( $i<$limite){
			$yyy =$Descripciones[$i];
			$cod = $Codigos[$i];
			$select  .=  "<option id=\'".$cod."\' value='".$yyy."'>".$yyy."</option>";
			$i += 1;
		}
		$select .= "</select>";
		$select .= "  </div>";
		$this->HtmlCode=$select;

	}

	function  echoHtml() {
		print $this->HtmlCode;
	}

    function  getHtml() {
		return $this->HtmlCode;
	}
	//
	function  echoHtmlMovil() {
		
//		print $ccJqmovil.$this->HtmlCode;
		return $this->HtmlCode;
		
//		print "<label for='detalleRespBact' class='select'>".$this->Name.":</label>".$this->HtmlCode;
	}

}

?>
