<?php
@session_start();

if (!isset($_SESSION['usuario_encuesta'])) {
    include('../apl/loginDemograficos.php');
    die;
}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title></title>
		
        
        
        <script src="../js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.alerts.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery.alerts.css"  type="text/css" media="screen" />

        <script src="../js/formulariocompleto.js" type="text/javascript" ></script>

<!-- 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
			<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
			<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
-->			
			
           <script type="text/javascript">getBacteriologasMovil();</script>
           <script type="text/javascript">getBcoCategorias();</script>
          <script type="text/javascript">getBcoEps();</script>
         <script type="text/javascript">fLlenarGenero();</script>
         <script type="text/javascript">fGet100AAAA();</script>
         <script type="text/javascript">fLlenarMeses();</script>
         <script type="text/javascript">procesarLlenarEdades();</script>
         <script type="text/javascript">fLlenarInfoPopups();</script>
 
 
<!--          <script language="JavaScript">getInfoDonante();</script>
-->

<!--         <script language="JavaScript">getInfoDonante();</script>
-->
	 <script language="JavaScript">
		function cancelarDonante(){
		    if (confirm('Desea cancelar el registro del donante?')) {
//			getInfoDonante();
		        document.forms[0].action='../apl/login.php';
		        document.forms[0].submit();
		    }
			
		}
	

		function grabarDonante() {
			arregloCampos = ["txtCedula","txtNombre","txtApellido1","txtDireccion","txtTelefonos"];
			salir = 0;
			for (var i=0;i<arregloCampos.length;i++){
			

					valores = document.getElementsByName(arregloCampos[i]);
					indice = valores.length-1;
					console.log(valores[indice].value);
					valor=	valores[indice].value;
					if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
							alert (valor+" Falta Informacion en "+arregloCampos[i]);
							console.log(valores[0]);
							valores[0].focus();
							salir=1;
							break;
					}
					
			}
			// Botones de radio .
			arregloCamposBotones = ["radio_genero_2",
			"radio_grupo_2","radio_Rh_2","radio_categoria_2"];
			if (salir==0){
				salir =1 ;
				correctos = 0;
				
				
				for (var i=0;i<arregloCamposBotones.length;i++){
						salir =1 ;
						valores = document.getElementsByName(arregloCamposBotones[i]);
						for (var j=1 ; j< valores.length;j++){
							valor=	valores[j].checked;
							//alert(valor);
							//console.log(valores[j]);
							if (valor==true){
								salir=0;
								correctos++;
							}
					
						}
						//console.log(valores[0].value);

						if( salir==1 ) {
								alert (valor+" Falta Informacion en "+arregloCamposBotones[i]);
								//console.log(valores[i]);
								document.getElementsByName(arregloCamposBotones[i]).item(0).focus();
							//	salir=1;
								break;
						}
						
				}
				if (correctos!=arregloCamposBotones.length){
					salir =1 ;
				}
				
			}
			
			if (fValidarPeso(slider_peso.value)==0){
				alert("Peso NO permitido");
			}else if (fValidarPresionASistolica(slider_pasistolica.value)==0){
				alert("Presion Arterial Sistolica NO permitida");
			}else if (fValidarPresionADiastolica(slider_padiastolica.value)==0){
				alert("Presion Arterial Diastolica NO permitida");
			}else if (fValidarFCardiaca(slider_fcardiaca.value)==0){
				alert("Frecuencia Cardiaca NO permitida");
			}else if (fValidarHemoglobina(slider_hemoglobina.value,radio_genero_22.checked)==0){
				alert("Hemoglobina NO permitida");
			}else if (fValidarHematocrito(slider_hematocrito.value,radio_genero_22.checked)==0){
				alert("Hematocrito NO permitido");
			}else if (fValidarTemperatura(slider_temperatura.value)){
				alert("Temperatura NO permitida")
			}


			
			if (salir == 0){
			    if (confirm('Esta seguro de grabar el donante?')) {
			        document.forms[0].action='../apl/grabarBancoRegistro.php';
			        document.forms[0].submit();
			    }
			}
		}
		</script>
		
		
	</head>
	<body>
<form id ="formRegistro"  action="grabarBancoRegistro.php" method="POST"  target="_self"  >  


	
	
<!--		
	<div class="filaCampo">
	<div class="etiqueta">Nro_Consecutivo :</div>
	<div class="campo"><input type="text" name="txtNro_Consecutivo"  id="txtNro_Consecutivo" value = "0076138BD" 
	/></div>
<div class="filaCampo">
	<div class="etiqueta">Fecha :</div>
	<div class="campo"><input type="text" name="txtFecha" value = "2013-03-14"  /></div>
</div>
-->


<br>
<div id ="idMeses2"><select name="idMeses2" id="idMeses2" ></select></div>
     <div id="detalleRespBact"></div>

	<div id="txtInfoDonante"></div>

<div id="waiting"></div>
	<!--	<input type="button"  name="botonBuscarDonante"  value="Buscar" onClick="getInfoDonante();" />
	-->
<div id="llenadoDin">rereee</div>

<table width = "100%">
	<tr>
	<th width="15%">&nbsp;</th>
	<th width="35%"></th>
	<th width="15%">&nbsp;</th>
	<th width="35%"></th>
	</tr>
	
	<tr>
		<td>Cedula:</td>
		<td><input type="text" name="txtCedula" id="txtCedula" value = "" onchange="getInfoDonante();" /> </td>
		<td>Nombre :</td>
		<td><div id="txtNombre"><input type="text" name="txtNombre" value = ""  /></div></td>
	</tr>
	
	<tr>
		<td>Apellido1 :</td>
		<td><div id="txtApellido1"><input type="text" name="txtApellido1" class='normal-field' value = "" /></div></td>
		<td>Apellido2:</td>
		<td><div id="txtApellido2"><input type="text" name="txtApellido2" value = "" /></div></td>
	</tr>
	
	<tr>
		<td>Direccion :</td>
		<td><div id="txtDireccion"><input type="text" name="txtDireccion" value = "" /></div></td>
		<td>Telefonos :</td>
		<td><div id="txtTelefonos"><input type="text" name="txtTelefonos" value = "" /></div></td>
	</tr>
	
	<tr>
		<td>Edad:</td>
		<td><div id="slider_edad"><input type="range" name="slider_edad" id="slider_edad" value="18" min="0" max="100" onChange="fCambioEdad(slider_edad.value)" /></div></td>
		<td>Fecha de Nacimiento:</td>
		<td>
 	        <label for="select_choice_edad">Edad</label>
			<div id="select_choice_edad"></div>
			<div id="select_choice_edadunidad"></div>

			<select name="select_choice_edaddec" id="select_choice_edaddec" >
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>
			<select name="select_choice_edadunid" id="select_choice_edadunid" >
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>

 	        <label for="select_choice_peso">Peso</label>


 	        <label for="select_choice_temperatura">Temperatura</label>
			<div id="select_choice_peso"></div>
			<div id="select_choice_pesounidad"></div>
<div id="select_choice_temperatura"></div>.
<div id="select_choice_temperatura_dec"></div>

			
			<div data-role="fieldcontain">
    <fieldset data-role="controlgroup" data-type="horizontal">
	
	
    
    
        <label for="select_choice_day">Dia</label>
        <select name="select_choice_day" id="select_choice_day" >
            <option>Dia</option>
			
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
            <!-- etc. -->
			
        </select>

        <label for="select_choice_month">Mes</label>
        <select name="select_choice_month" id="select_choice_month" >
            <option>Mes</option>

			<option value="ene">Enero</option>
			<option value="feb">Febrero</option>
			<option value="mar">Marzo</option>
			<option value="abr">Abril</option>
			<option value="may">Mayo</option>
			<option value="jun">Junio</option>
			<option value="jul">Julio</option>
			<option value="ago">Agosto</option>
			<option value="sep">Septiembre</option>
			<option value="oct">Octubre</option>
			<option value="nov">Noviembre</option>
			<option value="dic">Diciembre</option>

            <!-- etc. -->
        </select>
		
       <label for="select_choice_year">A&ntilde;o</label>
<div id="select_choice_year"></div>	
 <!--  	-->
        <!-- etc. --> 
    </fieldset>
</div>

		</td>
	</tr>

	<tr>
		<td>Grupo Sanguineo:</td>
		<td>
			<div data-role="fieldcontain">
			    <fieldset data-role="controlgroup" data-type="horizontal">
				<div id="radio_grupo_2">
				     	<input type="radio" name="radio_grupo_2" id="radio_grupo_21" value="&nbsp;" checked='checked'  />
				     	<label for="radio_grupo_21">&nbsp;</label>


			        	<input type="radio" name="radio_grupo_2" id="radio_grupo_22" value="O"  />
			         	<label for="radio_grupo_22">O</label>

			         	<input type="radio" name="radio_grupo_2" id="radio_grupo_23" value="A"  />
			         	<label for="radio_grupo_23">A</label>

			        	<input type="radio" name="radio_grupo_2" id="radio_grupo_24" value="B"  />
			         	<label for="radio_grupo_24">B</label>

			         	<input type="radio" name="radio_grupo_2" id="radio_grupo_25" value="AB"  />
			         	<label for="radio_grupo_25">AB</label>
</div>
			     </fieldset>
			</div>
			
		</td>
		<td>Rh:</td>
		<td>
			<div data-role="fieldcontain">
			    <fieldset data-role="controlgroup" data-type="horizontal">
				     	<input type="radio" name="radio_Rh_2" id="radio_Rh_21" value="&nbsp;" checked='checked'  />
				     	<label for="radio_Rh_21">&nbsp;</label>


			        	<input type="radio" name="radio_Rh_2" id="radio_Rh_22" value="POSITIVO"  />
			         	<label for="radio_Rh_22">POSITIVO</label>

			         	<input type="radio" name="radio_Rh_2" id="radio_Rh_23" value="NEGATIVO"  />
			         	<label for="radio_Rh_23">NEGATIVO</label>


			     </fieldset>
			</div>
			
		</td>
	</tr>
	
	
	<tr>
		<td>Genero:</td>
		<td><div id='generoPac'>
			<div data-role='fieldcontain'>
			    <fieldset data-role='controlgroup' data-type='horizontal'>
				<div id="radio_genero_2">
			 	     	<input type='radio' name='radio_genero_2' id='radio_genero_21' value='&nbsp;' checked='checked'  />
				     	<label for='radio_genero_21'>&nbsp;</label>


			        	<input type='radio' name='radio_genero_2' id='radio_genero_22' value='Masculino'   />
			         	<label for='radio_genero_22'>Masculino</label>

			         	<input type='radio' name='radio_genero_2' id='radio_genero_23' value='Femenino'  />
			         	<label for='radio_genero_23'>Femenino</label>

</div>
			     </fieldset>
			</div>
		</div>
			
			
		</td>
		<td>Categoria:</td>
		<td>
			<div data-role="fieldcontain">
			    <fieldset data-role="controlgroup" data-type="horizontal">
				     	<input type="radio" name="radio_categoria_2" id="radio_categoria_21" value="-" checked="checked"  />
				     	<label for="radio_categoria_21">&nbsp;</label>

			        	<input type="radio" name="radio_categoria_2" id="radio_categoria_22" value="FLEBOTOMIA"  />
			         	<label for="radio_categoria_22">FLEBOTOMIA</label>

			         	<input type="radio" name="radio_categoria_2" id="radio_categoria_23" value="AFERESIS"  />
			         	<label for="radio_categoria_23">AFERESIS</label>


			     </fieldset>
			</div>

			
		</td>
	</tr>
	
	<tr>
		<td>Observaciones:</td>
		<td><div id="textarea_observaciones"><textarea name="textarea_observaciones" id="textarea_observaciones">
		</textarea></div></td>
		<td>Reaccion:</td>
		<td><div id="textarea_reaccion"><textarea name="textarea_reaccion" id="textarea_reaccion">
		</textarea></div></td>
	</tr>
	
	<tr>
		<td>Categorias</td>
		<td><div id="detalleRespCat"></div></td>
		<td>EPS</td>
		<td><div id="detalleRespEps"></div></td>
	</tr>
	
	<tr>
		<td>Email :</td>
		<td><div id="txtE_Mail"><input type="email" name="txtE_Mail" value = ""/></div></td>
		<td>Receptor :</td>
		<td><div id="txtReceptor"><input type="text" name="txtReceptor" value = ""/></div></td>
	</tr>
	



	<tr>
		<div id="select_choice_peso"></div>
		<div id="select_choice_pesounidad"></div>
		
		<td>Peso 50-150kg</td>
		<td><div id="slider_peso"><input type="range" name="slider_peso" id="slider_peso" value="50" min="0" max="200" onChange="fCambioPeso(slider_peso.value)"   /></div></td>
		<td>Temperatura *10 360-375</td>
		<td><div id="slider_temperatura"><input type="range" name="slider_temperatura" id="slider_temperatura" value="370" min="345" max="395" onChange="fCambioTemperatura(slider_temperatura.value)" /></div></td>
	</tr>
	
	<tr>
		<div id="select_choice_sistolica"></div>
		<div id="select_choice_sistolicaunidad"></div>
		<td>P.A Sistolica 100-150:</td>
		
	<td><div id="slider_pasistolica"><input type="range" name="slider_pasistolica" id="slider_pasistolica" value="100" min="80" max="200"onChange="fCambioPresionASistolica(slider_pasistolica.value)"  /></div></td>
	<div id="select_choice_diastolica"></div>
	<div id="select_choice_diastolicaunidad"></div>
	<td>P.A Diastolica 60-95</td>
	<td><div id="slider_padiastolica"><input type="range" name="slider_padiastolica" id="slider_padiastolica" value="70" min="50" max="200" onChange="fCambioPresionADiastolica(slider_padiastolica.value)" /></div></td>
	</tr>
	
	<tr>
		<div id="select_choice_hemoglobina"></div>
		<td>Hemoglobina (H 13-19 M 12-18)</td>
		<td><input type="range" name="slider_hemoglobina" id="slider_hemoglobina" value="14" min="10" max="20" onChange="slider_hematocrito.value=fHematocrito(slider_hemoglobina.value);"  /></td>
		<div id="select_choice_hematocrito"></div>
		<td>Hematocrito (H 41-57 M 38-54)</td>
		<td><input type="range" name="slider_hematocrito" id="slider_hematocrito" value="41" min="0" max="60"  /></td>
	</tr>


	
	<tr>
		<div id="select_choice_fcardiaca"></div>
		<div id="select_choice_fcardiacaunidad"></div>
		<td>Fecuencia Cardiaca 50-95:</td>
		<td><div ="slider_fcardiaca"><input type="range" name="slider_fcardiaca" id="slider_fcardiaca" value="70" min="0" max="200" onChange="fCambioFcardiaca(slider_fcardiaca.value)" /></div></td>
		<td>Comentario Examen Fisico:</td>
		<td><textarea name="textarea_comentaFisico" id="textarea_comentaFisico"></textarea></td>
	</tr>
	
	<tr>
		<td colspan="2"><input type="button"  name="botoningresarDonate"  value="Grabar Donante" onClick="grabarDonante();" /></td>
		<td colspan="1"><input type="button"  name="botonBuscar"  value="Buscar" onClick="getInfoDonante();" /></td>
		<td colspan="1"><input type="button"  name="botonCancelar"  value="Cancelar" onClick="cancelarDonante();" /></td>
	</tr>
</table>
<div id="message" style="margin-top: 5px; display: none;"></div>
<!--
   

<label for="slider_pasistolica">P.A Sistolica:</label>
   <input type="range" name="slider_pasistolica" id="slider_pasistolica" value="100" min="0" max="300"  />
-->

   
<label for="select-choice-0" class="select">Shipping method:</label>
<select name="select-choice-0" id="select-choice-0">
   <option value="standard">Standard: 7 day</option>
   <option value="rush">Rush: 3 days</option>
   <option value="express">Express: next day</option>
   <option value="overnight">Overnight</option>
</select>
   
<label for="slider_dechemoglobina">Decimal:</label>
   <input type="range" name="slider_dechemoglobina" id="slider_dechemoglobina" value="0" min="0" max="9"   />






<!--

<div data-role="fieldcontain">
    <fieldset data-role="controlgroup" data-type="horizontal">
    	<legend>Examen_Fisico:</legend>
	     	<input type="radio" name="txtExamen_F" id="radio_efisico_21" value="PE" checked="checked"  />
	     	<label for="radio_efisico_21">PE</label>


        	<input type="radio" name="txtExamen_F" id="radio_efisico_22" value="RE"  />
         	<label for="radio_efisico_22">RE</label>

         	<input type="radio" name="txtExamen_F" id="radio_efisico_23" value="OC"  />
         	<label for="radio_efisico_23">OC</label>
         	<input type="radio" name="txtExamen_F" id="radio_efisico_24" value="OK"  />
         	<label for="radio_efisico_24">OK</label>


     </fieldset>
</div>




<div data-role="fieldcontain">
    <fieldset data-role="controlgroup" data-type="horizontal">
    	<legend>Aceptada:</legend>
	     	<input type="radio" name="txtAceptada" id="radio_aceptada_21" value="PE" checked="checked"  />
	     	<label for="radio_aceptada_21">PE</label>


        	<input type="radio" name="txtAceptada" id="radio_aceptada_22" value="RE"  />
         	<label for="radio_aceptada_22">RE</label>

         	<input type="radio" name="txtAceptada" id="radio_aceptada_23" value="OK"  />
         	<label for="radio_aceptada_23">OK</label>


     </fieldset>
</div>





<input type="submit"  name="botoningresarDonate"  value="Grabar Donante" />
<div class="filaCampo">
	<div class="etiqueta">Observaciones :</div>
	<div class="campo"><input type="text" name="txtObservaciones"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Reaccion :</div>
</div>
<input type="text" name="txtReaccion" />



<div class="filaCampo">
	<div class="etiqueta">Empresa :</div>
	<div class="campo"><input type="text" name="txtEmpresa" value = "EPS009"/></div>
</div>


<div class="filaCampo">
	<div class="etiqueta">Categoria :</div>
	<div class="campo"><input type="text" name="txtCategoria" value = "001"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Encuesta :</div>
	<div class="campo"><input type="text" name="txtEncuesta" value = "PE"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Perfil :</div>
	<div class="campo"><input type="text" name="txtPerfil" value = "PE"/></div>
</div>
<div class="filaCampo">
	<div class="etiqueta">Fenotipo :</div>
	<div class="campo"><input type="text" name="txtFenotipo" value = "PE"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Bacteriologa :</div>
	<div class="campo"><input type="text" name="txtBacteriologa" value = "026"/></div>
</div>


<div class="filaCampo">
	<div class="etiqueta">Fecha_Nac :</div>
	<div class="campo"><input type="text" name="txtFecha_Nac" value = "1985-03-02"/></div>
</div>



<div class="filaCampo">
	<div class="etiqueta">Edad :</div>
	<div class="campo"><input type="text" name="txtEdad" value = "28"/></div>
</div>
<div class="filaCampo">
	<div class="etiqueta">Sexo :</div>
	<div class="campo"><input type="text" name="txtSexo" value = "F"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Grupo :</div>
	<div class="campo"><input type="text" name="txtGrupo" value = "O"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Rh :</div>
	<div class="campo"><input type="text" name="txtRh" value = "NEGATIVO"/></div>
</div>

<div class="filaCampo">
	<div class="etiqueta">Tipo :</div>
	<div class="campo"><input type="text" name="txtTipo" value = ""/></div>
</div>

<input type="button" id="getDonante" class="boton2" onclick="myFunction(document.getElementById('txtNro_Consecutivo').value)" value="Buscar Donante"/>
-->
<div id="message" style="margin-top: 5px; display: none;"></div>
<div id="waiting" style="margin-top: 5px; display: none;"></div>

</form>
	</body>
</html>

