<?php

function  fSelect($inicial , $final ,$id , $label,$incremento=1) {
	$select = "";
	if ($id != ""){
		$select = "<div id='$id' >";
		$select .= "<select name='$id' id='$id'  >";
	}
	if ($label != ""){
		$select .= "<option >$label</option>";
	}
	$i=$inicial;
	while ( $i<=$final){
		$yyy = $i;
		$select  .=  "<option id=\'$id.$i\' value='$yyy'>$yyy</option>";
		$i += $incremento;
	}
	$select .= "</select>";
	$select .= "  </div>";

	$vTxt = "<div id='$id' >";
	$vTxt .="	<div class='ui-select'><div data-corners='true' data-shadow='true' data-iconshadow='true' data-wrapperels='span' data-icon='arrow-d' data-iconpos='right' data-theme='c' class='ui-btn ui-btn-icon-right ui-corner-right ui-controlgroup-last ui-btn-up-c'><span class='ui-btn-inner ui-corner-right ui-controlgroup-last'><span class='ui-btn-text'></span><span class='ui-icon ui-icon-arrow-d ui-icon-shadow'>&nbsp;</span></span>";
	$vTxt .= "<select name='$id' id='$id'>";
	
	$ccJqmovil=	"<div class='ui-select'><div data-corners='true' data-shadow='true' data-iconshadow='true' data-wrapperels='span' data-icon='arrow-d' data-iconpos='right' data-theme='c' class='ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c'><span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'><span>".$label."</span></span><span class='ui-icon ui-icon-arrow-d ui-icon-shadow'>&nbsp;</span></span>";
	return $select;
}

function  fSelect10($inicial , $final ,$id , $label,$incremento=1) {

	$select = "";
	if ($id != ""){
		$select = "<div id='$id' >";
		$select .= "<select name='$id' id='$id'  >";
	}
	if ($label != ""){
		$select .= "<option >$label</option>";
	}
	$i=$inicial;
	$yyy = $inicial/10;
	while ( $i<=$final){
		
		$select  .=  "<option id=\'$id.$i\' value='$i'>$yyy</option>";
		$i += $incremento;
		$yyy = $i / $incremento;
	}
	$select .= "</select>";
	$select .= "  </div>";
	return $select;

}



function fLlenarPopArreglo($id,$label ,$arreglo){
	$select="<select name='$id' id='$id'  >";
	$i = 0;
	$final= count($arreglo);
	
	while ( $i<$final){
		$yyy = $arreglo[$i];
		$select  .=  "<option id=\'$id.$i\' value='$yyy'>$yyy</option>";
		$i ++;
	}
	return $select;
}
function fLlenarPopArregloConValor($id,$label ,$arreglo){
	$select="<select name='$id' id='$id' >";
	$i = 0;
//	$final= count($arreglo);
	

	foreach ($arreglo as $key => $valor) {
		$yyy = $key;
		$valor = $valor;
		$select  .=  "<option id=\'$id.$i\' value='$valor'>$yyy</option>";
		$i ++;
		
	}
	

	return $select;
}


function fLlenarGenero(){
$select="	<select name='popGenero' id='radio_genero_2' >";
$select.="        <option id='radio_genero_21' value='&nbsp;' selected >&nbsp;</option>";
$select.="		<option id='radio_genero_22' value='Masculino'>Masculino</option>";
$select.="		<option id='radio_genero_23' value='Femenino'>Femenino</option>";
$select.="    </select>";
return $select;	
}

	$tempSelect = fSelect(35,39,'poPtemperatura','&deg;C',1);
	$tempDecimal = fSelect(0,9,'poPtemperatura_dec','.',1);
	$tempPeso = fSelect10(40,170,'poPpeso','Peso',10);
	$tempPesoUnidad = fSelect(0,9,'poPpesounidad','+',1);
	

	$tempEdad = fSelect10(0,110,'poPedad','A&ntilde;os',10);
	$tempEdadUnidad = fSelect(0,9,'poPedadunidad','+',1);

	$tempSistolica = fSelect10(90,170,'poPsistolica','mmHg',10);
	$tempSistolicaUnidad = fSelect(0,9,'poPsistolicaunidad','+',1);

	$tempDiastolica = fSelect10(50,100,'poPdiastolica','mmHg',10);
	$tempDiastolicaaUnidad = fSelect(0,9,'poPdiastolicaunidad','+',1);
	
	$tempHemoglobina = fSelect(10,20,'poPhemoglobina','gr/dL',1);
	$tempHematocrito = fSelect(30,62,'poPhematocrito','gr/dL',1);

	$tempFCardiaca = fSelect10(50,100,'poPfcardiaca','P/min',10);
	$tempFCardiacaUnidad = fSelect(0,9,'poPfcardiacaunidad','+',1);
	
	$tempDias =  fSelect(1,31,'poPday','Dia',1);
//$tempGenero=	fLlenarGenero();
$arreglo = array('','Masculino','Femenino');
	$tempGenero=fLlenarPopArreglo('popGenero','',$arreglo);
		$arregloT = array('','FLEBOTOMIA','AFERESIS');
		$aregloValorT = array('','1','2');
		$arraegloTipoDonacion = array('' =>'' ,'FLEBOTOMIA'=>'1' ,'AFERESIS' =>'2'  );
		$tempTipoDonacion= fLlenarPopArregloConValor('popTipoDonacion','',$arraegloTipoDonacion);
		
		$arregloGrupoSang = array('','O','A','B','AB');
		$tempGrupoSang= fLlenarPopArreglo('popGrupoSanguineo','',$arregloGrupoSang);
		
		$arraegloTipoRH = array('RH' =>'' ,'+'=>'POSITIVO' ,'-' =>'NEGATIVO'  );
		$tempRH= fLlenarPopArregloConValor('popRH','',$arraegloTipoRH);
		
//		$arregloRH = array('RH','POSITIVO','NEGATIVO');
//		$tempRH= fLlenarPopArreglo('popRH','',$arregloRH);
		$tempDigitos = fSelect(0,9,'','',1);//sin id para ser usado en varios selects
//se crea un JSON con la información de cada popup que se va a llenar .
echo "{'temperatura':\"$tempSelect\",'temperaturaDecimal':\"$tempDecimal\",'peso':\"$tempPeso\",'pesounidad':\"$tempPesoUnidad\",'edad':\"$tempEdad\",'edadunidad':\"$tempEdadUnidad\",'sistolica':\"$tempSistolica\",'sistolicaunidad':\"$tempSistolicaUnidad\",'diastolica':\"$tempDiastolica\",'diastolicaunidad':\"$tempDiastolicaaUnidad\",'hemogoblobina':\"$tempHemoglobina\",'hematocrito':\"$tempHematocrito\",'fcardiaca':\"$tempFCardiaca\",'fcardiacaunidad':\"$tempFCardiacaUnidad\",'dias':\"$tempDias\",'genero':\"$tempGenero\",'tipodonacion':\"$tempTipoDonacion\",'gsanguineo':\"$tempGrupoSang\",'rh':\"$tempRH\",'digitos':\"$tempDigitos\"}";

?>