<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
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
       <link rel="stylesheet" href="../css/formulariocompleto.css"  type="text/css" media="screen" />

        <script src="../js/formulariocompleto.js" type="text/javascript" ></script>



		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" />
			<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>
			<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



<!---->	
         <script type="text/javascript">fLlenarGenero();</script>
		
			
 
 
<!--          <script language="JavaScript">getInfoDonante();</script>
-->

<!--         <script language="JavaScript">getInfoDonante();</script>
-->
		
		
	</head>
	<body>
<form id ="formRegistro"  action="grabarBancoRegistro.php" method="POST"  target="_self"   >  


	
	


<br>

     

	<div id="txtInfoDonante"></div>

<div id="waiting"></div>
	<!--	<input type="button"  name="botonBuscarDonante"  value="Buscar" onClick="getInfoDonante();" />
	-->
	<table width = "98%" background='../Movil4.jpg' >
		<tr>
		<th width="24%">&nbsp;</th>
		<th width="25%">&nbsp;</th>
		<th width="24%">&nbsp;</th>
		<th width="25%">&nbsp;</th>
		</tr>


		<tr>
			<td></td>
			<td><label for="txtOTbuscar">Orden</label><input type="text" name="txtOTbuscar" id="txtOTbuscar" value = "" /> </td>
			<td><label for="txtFechaDesde">Desde :</label><input type="date" name="txtFechaDesde" id="txtFechaDesde" value = ""/></td>
			<td><label for="txtFechaHasta">Hasta :</label><input type="date" name="txtFechaHasta" id="txtFechaHasta" value = ""/></td>	
		</tr>

		<tr>
			
			<td><label for="txtOrden" align="right">OT :</label></td>
			<td><input type="text" name="txtOrden" id="txtOrden" value = "" readonly /></td>
			<td><input type="text" name="txtFecha" id="txtFecha" value = ""  readonly/></td>
			<td><div id="popOrdenes"></div></td>
		</tr>	
		
		
		
		
	</table>
<!--style='opacity:0.4;filter:alpha(opacity=40)'-->			
<table width = "98%" background='../Movil4.jpg'  >
	<tr>
	<th width="15%">&nbsp;</th>
	<th width="34%"></th>
	<th width="15%">&nbsp;</th>
	<th width="34%"></th>
	</tr>


	<tr>
	<td><label for="txtCodBacteriologa">Cod. Bateriologa:</label></td>
	<td><div id="txtCodBacteriologa"><input type="password" name="txtCodBacteriologa" id="txtCodBacteriologa" value = ""  /></div></td>
	<td colspan="2"><div id="detalleRespBact"></td>
</tr>
		
	<tr>
		<td><label>Cedula:</label></td>
		<td><div id="txtCedula"><input type="text" name="txtCedula"  id="txtCedula"  value = ""  /></div></td>
		<td><label>Nombre :</label></td>
		<td><div id="txtNombre"><input type="text" id="txtNombre" name="txtNombre"  value = ""  /></div></td>
	</tr>
	
	<tr>
		<td><label>Apellido1 :</label></td>
		<td><div id="txtApellido1"><input type="text" name="txtApellido1" id="txtApellido2" value = ""  /></div></td>
		<td><label>Apellido2:</label></td>
		<td><div id="txtApellido2"><input type="text" name="txtApellido2" id="txtApellido2" value = ""  /></div></td>
	</tr>

	
	<tr>
		<td><label>Direccion :</label></td>
		<td><div id="txtDireccion"><input type="text" name="txtDireccion" id="txtDireccion" value = ""  /></div></td>
		<td><label>Telefonos :</label></td>
		<td><div id="txtTelefonos"><input type="text" name="txtTelefonos" id="txtTelefonos" value = ""  /></div></td>
	</tr>
		
	
	<tr>
		<td><div  id="labelEdad"><label>Edad:</label></div></td>
		<td>
			<div data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal">
				<div id="poPedad"></div>
				<label for="poPedadunidad">+</label>
				<div id="poPedadunidad"></div>	
    			</fieldset>
			</div>
		</td>
		<td><label>Fecha de Nacimiento:</label></td>
		<td>
 <!-- 	        <label for="poPedad">Edad</label> -->
 <!--			
	<div data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal">
		<div id="poPday"></div>
		<div id="poPmonth"></div>
		<div id="poPyear"></div>	
		</fieldset>
	</div>
	 -->
			<div id="txtFechaNat"><input type="date" name="txtFechaNat" id="txtFechaNat" value ="" format="yyyy-mm-dd"/></div>
			
		</td>
	</tr>

	<tr>
		<td><label>Genero:</label></td>
		<td><div id="popGenero"></div>
		</td>
			
	
		<td colspan="2">
			<div data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal">
				
				<label for="popGrupoSanguineo">G.Sanguineo:</label>
				<div id="popGrupoSanguineo"></div>
				<div id="popRH"></div>	
				</fieldset>
			</div>
			
		</td>
	</tr>
	
	<tr>
		<td><label>Tipo de Donacion:</label></td>
		<td><div id='popTipoDonacion'></div></td>
		<td colspan="2"><label for="popCategorias">Categoria</label><div id="popCategorias"></div></td>
	</tr>
	
	<tr>
	<td colspan="2"><label for="popEps">EPS</label><div id="popEps"></div></td>
	<td colspan="2"><label for="txtE_Mail">Email :</label><div id="txtE_Mail"><input type="email" name="txtE_Mail" value = ""/></div></td>
	</tr>
	
	<tr>
		<td><label>Receptor :</label></td>
		<td><div id="txtReceptor"><input type="text" name="txtReceptor" value = ""/></div></td>
		<td><label>Observaciones:</label></td>
		<td><div id="textarea_observaciones"><textarea name="textarea_observaciones" id="textarea_observaciones">
		</textarea></div></td>
	</tr>
<!--	
-->
	<tr>
		
		<td><div id="labelPeso"><label>Peso 50-150kg</label></div></td>
		<td>
			<div data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal">
				<div id="poPpeso"></div>
				<label for="poPpesounidad">+</label>
				<div id="poPpesounidad"></div>	
				</fieldset>
			</div>

		</td>
		
		<td><div  id="labelTemperatura"><label>Temperatura 36.0-37.5</label></div></td>
		<td> 
			<div data-role="fieldcontain"><fieldset data-role="controlgroup" data-type="horizontal">
				<div id="poPtemperatura" class="dospopups"></div>
				<label for="poPtemperatura_dec">.</label>
				<div id="poPtemperatura_dec" class="dospopups"></div>	
				</fieldset>
			</div>
		</td>	
			
	</tr>



	
	<tr>
		<td><div id="labelPASistolica"><label>P.A Sistolica 100-150:</label></div></td>
		<td><div id="poPsistolica"></div><label for="poPsistolicaunidad">+</label><div id="poPsistolicaunidad"></div></td>
		<td><div  id="labelPADiastolica"><label>P.A Diastolica 60-95</label></div></td>
		<td><div id="poPdiastolica"></div><label for="poPdiastolicaunidad">+</label><div id="poPdiastolicaunidad"></div></td>
	</tr>
	
	<tr>
		<td><div id="labelHemoglobina"><label>Hemoglobina (H 13-19 M 12-18)</label></div></td>
		<td> <fieldset data-role="fieldcontain" data-type="horizontal">
			<div id="poPhemoglobina"></div><label for="poPhemoglobina_dec">.</label>
			<div id="poPhemoglobina_dec"></div></fieldset></td>
		<td><div id="labelHematocrito"><label>Hematocrito (H 41-57 M 38-54)</label></div></td>
		<td><fieldset data-role="fieldcontain" data-type="horizontal">
			<div id="poPhematocrito"></div><label for="poPhematocrito_dec">.</label>
			<div id="poPhematocrito_dec"></div>
			</fieldset>
		</td>
	</tr>
	
	<tr>
		<td><div id="labelFCardiaca"><label>Fecuencia Cardiaca 60-95:</label></div></td>
		<td><div id="poPfcardiaca"></div><label for="poPfcardiacaunidad">+</label>
			<div id="poPfcardiacaunidad"></div></td>
		<td><label>Reaccion:</label></td>
		<td><div id="popReacciones"></div></td>
	</tr>
	
	<tr>
		<td><label>Comentario Examen Fisico:</label></td>
		<td colspan="3"><div id="textarea_comentaFisico"><textarea name="textarea_comentaFisico" id="textarea_comentaFisico"></textarea></div></td>
	</tr>
	<tr>
		<!--textarea_reaccion -->

		<td colspan="3"><div id="popRespComponentes"></div></td>
        <td><div id="popNomComponentes"><input type="text" name="popNomComponentes" id="popNomComponentes" value = "" readonly /></div></td>
	</tr>
	
	<tr>
		<td><label for="idEncuestaTxt">Encuesta</label><div id="idEncuestaTxt">
			<input type="text" name="idEncuestaTxt" id="idEncuestaTxt" value = "PE" readonly /></div></td>
		<td><label for="idPerfilTxt">Perfil</label>
			<div id="idPerfilTxt">
			<input type="text" name="idPerfilTxt" id="idPerfilTxt" value = "PE" readonly />
		</div></td>
		<td><label for="idFenotipoTxt">Fenotipo</label><div id="idFenotipoTxt">
			<input type="text" name="idFenotipoTxt" id="idFenotipoTxt" value = "PE" readonly /></div></td>
		<td><label for="idEFisicoTxt">E. Fisico</label><div id="idEFisicoTxt">
			<input type="text" name="idEFisicoTxt" id="idEFisicoTxt" value = "PE" readonly /></div></td>
	</tr>
	<tr>
		<td colspan="3"><input type="button" id="botonEncuesta" name="botonEncuesta"  value="Encuesta" onclick="showDialog();" /></td>
		<td>
			<a href="pruebaDlg.html" data-rel="dialog" data-transition="pop">Open dialog</a> 

			<div data-role="popup" id="popupBasic">
				<p>This is a completely basic popup, no options set.<p>
			</div>
			
			</td>
	</tr>
	
	<tr>
	<td><input type="button"  name="botonBuscar"  value="Buscar" onClick="getInfoDonante();" /></td>
		<td><input type="button"  name="botonInicializar"  value="Inicializar" onClick="inicializarCampos();" /></td>
		<td><input type="button"  name="botoningresarDonate"  value="Grabar Donante" onClick="grabarDonante();" /></td>
		<td><input type="button"  name="botonCancelar"  value="Cancelar" onClick="cancelarDonante();" /></td>
	</tr>
</table>


<div id="dialog-modal" title="Basic modal dialog" style="display: none;"></div>

<div id="message" style="margin-top: 5px; display: none;"></div>
<!--
   


<label for="slider_pasistolica">P.A Sistolica:</label>
   <input type="range" name="slider_pasistolica" id="slider_pasistolica" value="100" min="0" max="300"  />
-->

 

<div id="dialogo" title="Encuesta"  data-rel="dialog">
   <p>Esta es la caja de diálogo más básica, que se puede redimensionar y arrastrar a otra posición. Además, se puede cerrar con el icono del aspa "X" que aparece en el titular de la caja.</p>
</div>


<!--





<input type="button" id="getDonante" class="boton2" onclick="myFunction(document.getElementById('txtNro_Consecutivo').value)" value="Buscar Donante"/>
-->
<div id="message" style="margin-top: 5px; display: none;"></div>
<div id="waiting" style="margin-top: 5px; display: none;"></div>


<table>
	<tr>
	<th width="15%">&nbsp;</th>
	<th width="35%"></th>
	<th width="15%">&nbsp;</th>
	<th width="35%"></th>
	</tr>
	
</table>

</form>
	</body>
</html>

