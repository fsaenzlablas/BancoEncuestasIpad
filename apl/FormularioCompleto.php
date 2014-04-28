
<?php
@session_start();

if (!isset($_SESSION['usuario_encuesta'])) {
    include('../apl/menuDonante.php');
 //   include('../apl/loginDemograficos.php');
    die;
}

 if (isset($_POST['eFisico'])) {//si viene de la ventana de demograficos .
   // vMostrarEFisico = $_POST['eFisico'];
}

$txtCedula="";
if (isset($_POST['txtCedula'])) {//si viene de la ventana de demograficos .
   $txtCedula = $_POST['txtCedula'];
}


if (isset($_POST['cc_paciente'])) {//si viene de la ventana de formulario completo .
   $_SESSION["num_cc"]=$_POST['cc_paciente'];//"";
   $txtCedula=$_POST['cc_paciente'];
}

if (isset($_POST['num_ot'])) {//si viene de la ventana de formulario completo .
   $txtCedula=$_SESSION['num_ot'];
}

$codBact="";
if (isset($_POST['codigobacteriologa'])) {//si viene de la ventana de formulario completo .
   $codBact=$_POST['codigobacteriologa'];
}

if ($codBact==""){
	$codBact = $_SESSION['codigobacteriologa'];
}


?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Language" content="es"/>

        	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="apple-mobile-web-app-capable" content="yes" />

           <script src="../js/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/jquery.alerts.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../css/jquery.alerts.css"  type="text/css" media="screen" />
      <link rel="stylesheet" href="../css/formulariocompleto.css"  type="text/css" media="screen" /> 


<!--         <script src="../js/formulariocompleto.js" type="text/javascript" ></script> -->	



		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.css" /> 
 		<script src="http://code.jquery.com/mobile/1.2.1/jquery.mobile-1.2.1.min.js"></script>

        <script src="../js/formulariocompleto.js" type="text/javascript" ></script>


<!---->	
         <script type="text/javascript">fLlenarGenero();</script>
		
			
	
		
	</head>
	<body >
<!-- una gran tabla es la ventana  <table  width = "98%"  background='../Movil4.jpg'>-->		
<input type='hidden'   id='usuarioencuesta' name='usuarioencuesta' class='normal-field' value='<?php echo $_SESSION["usuario_encuesta"] ?>' />




<div id="pagina1" data-role="page">



<h2>Ingreso de Demogr&aacute;ficos <?php if ($txtCedula=="") echo "y Examen F&iacute;sico"; else echo ""; ?> </h2>




<div  id="idInfoOTs" class="cSoloBacteriologa" >
	<div data-role="fieldcontain" >

	<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">

	</fieldset>


			<fieldset data-role="fieldcontain" data-type="horizontal" >
						<fieldset class="ui-grid-a">
							<div class="ui-block-a">
							
							<div id="labelOTdona"><label for="txtOrden" class="label-Demografico" >OT:</label></div>		
							<input type='text' name='txtOrden' id='txtOrden' value = '' readonly />
							
							
							</div>
							<div class="ui-block-b">

							
							<div id="labelFechaDona"><label for="txtNombre" class="label-Demografico">Fecha:</label></div>		
							<input type='text' name='txtFecha' id='txtFecha' value = ''  readonly/>
							

							
						</fieldset>

			</fieldset>

	<fieldset data-role="fieldcontain" data-type="horizontal" >
	<div id='popOrdenes'></div>
	</fieldset>

	</div>

</div>






<div data-role="content" data-theme='d'>


	






<form id ="formRegistro"  action="grabarBancoRegistro.php" method="POST"  target="_self"   > 


	

     

	<div id="txtInfoDonante"></div>

	<div id="waiting"></div>
	<!--	<input type="button"  name="botonBuscarDonante"  value="Buscar" onClick="getInfoDonante();" />
	DatosBusqueda
	-->

<div data-role="content" data-theme="c" class="Demograficos">	

		<div data-role="fieldcontain">




			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelCedula"><label for="txtCedula" class="label-Demografico" >Cedula:</label></div>		
				<div id="txtCedula"><input type="text" name="txtCedula"  id="txtCedula"  value = "<?php echo $txtCedula; ?>" <?php if ( $_SESSION["usuario_encuesta"]=="donante" ) echo "readonly" ?>
			     />
				</div>
				</fieldset>
				</div>
				<div class="ui-block-b">

				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelNombre"><label for="txtNombre" class="label-Demografico">Nombre:</label></div>		
				<div id="txtNombre"><input type="text" id="txtNombre" name="txtNombre"  value = ""  class="mayuscula" /></div>
				</fieldset>

				</div>
			</fieldset>

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelApellido1"><label for="txtApellido1" class="label-Demografico">Apellido1:</label></div>		
				<div id="txtApellido1"><input type="text" name="txtApellido1" id="txtApellido1" value = ""  /></div>
				</fieldset>

				</div>
				<div class="ui-block-b">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelApellido2"><label for="txtApellido2" class="label-Demografico">Apellido2:</label></div>		
				<div id="txtApellido2"><input type="text" name="txtApellido2" id="txtApellido2" value = ""  /></div>
				</fieldset>

				</div>
			</fieldset>

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelDireccion"><label for="txtDireccion" class="label-Demografico">Direccion:</label></div>		
				<div id="txtDireccion"><input type="text" name="txtDireccion" id="txtDireccion" value = ""  /></div>
				</fieldset>

				</div>
				<div class="ui-block-b">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelTelefonos"><label for="txtTelefonos" class="label-Demografico">Telefonos:</label></div>		
				<div id="txtTelefonos"><input type="tel" name="txtTelefonos" id="txtTelefonos" value = ""  /></div>
				</fieldset>

				</div>
			</fieldset>

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
<div class="ui-block-a">
<!--
						
					<div id="poPedad"></div> readonly="readonly"
					<div id="poPedadunidad"></div>

-->


					<label for="miEdadTeclado" class="label-Demografico">Edad:</label>


					<input style="background: white; color: black;" type="number" pattern="[0-9.]*" id="miEdadTeclado"/>


					<table class="ui-bar-a" id="n_keypad" style="display: none; -khtml-user-select: none;">
					<tr>
						<td><a data-role="button" data-theme="e" class="done">OK</a></td>
						<td><a data-role="button" data-theme="b" class="zero">0</a></td>
						<td><a data-role="button" data-theme="b" class="numero">1</a></td>
						<td><a data-role="button" data-theme="b" class="numero">2</a></td>
						<td><a data-role="button" data-theme="b" class="numero">3</a></td>
						<td><a data-role="button" data-theme="b" class="numero">4</a></td>
						<td><a data-role="button" data-theme="e" class="pos">+</a></td>
						<td><a data-role="button" data-theme="e" class="del">Borrar</a></td>

					</tr>
					<tr>
						<td><a data-role="button" data-theme="e" class="cancelar" >Cancelar</a></td>
						<td><a data-role="button" data-theme="b" class="numero">5</a></td>
						<td><a data-role="button" data-theme="b" class="numero">6</a></td>
						<td><a data-role="button" data-theme="b" class="numero">7</a></td>
						<td><a data-role="button" data-theme="b" class="numero">8</a></td>
						<td><a data-role="button" data-theme="b" class="numero">9</a></td>
						<td><a data-role="button" data-theme="e" class="neg">-</a></td>
						<td><a data-role="button" data-theme="e" class="clear">Limpiar</a></td>
					</tr>

					</table>


  

				
</div>






				</fieldset>

				</div>
				<div class="ui-block-b">
				<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					
						<div id="labelFNat"><label for="txtFechaNat" class="label-Demografico">Nacimiento:</label></div>
						<div id="txtFechaNat"><input type="date" name="txtFechaNat" id="txtFechaNat" value ="" format="yyyy-mm-dd"/></div>

				
				</fieldset>


				</div>
			</fieldset>

<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
	<div data-role="fieldcontain">
	<div id="popGenero"></div><!--Genero: -->
	</div>
</fieldset>






<div data-role="fieldcontain">
    <fieldset data-role="controlgroup" data-type="horizontal">
    	
         	<input type="radio" name="radio-Genero-1" id="radio-Genero-Sx" value="" /> <!-- checked="checked"  -->
         	<label for="radio-Genero-Sx">Soy</label>

         	<input type="radio" name="radio-Genero-1" id="radio-Genero-M" value="Masculino"  />
         	<label for="radio-Genero-M">Hombre</label>

         	<input type="radio" name="radio-Genero-1" id="radio-Genero-F" value="Femenino"  />
         	<label for="radio-Genero-F">Mujer</label>

     </fieldset>
</div>


<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
	<div data-role="fieldcontain">

		G.Sanguineo:<div id="popGrupoSanguineo"></div>
			<div id="popRH"></div>
	
				
				
	</div>					
</fieldset>

				

<div data-role="fieldcontain">

    <fieldset data-role="controlgroup" data-type="horizontal">


 	<input type="radio" name="radio-GS-1" id="radio-GS-O" value="O"  />
 	<label for="radio-GS-O">O</label>

 	<input type="radio" name="radio-GS-1" id="radio-GS-A" value="A"  />
 	<label for="radio-GS-A">A</label>

	<input type="radio" name="radio-GS-1" id="radio-GS-B" value="B"  />
 	<label for="radio-GS-B">B</label>

 	<input type="radio" name="radio-GS-1" id="radio-GS-AB" value="AB"  />
 	<label for="radio-GS-AB">AB</label>

 	<input type="radio" name="radio-GS-1" id="radio-GS-Sin" value="" /> <!-- checked="checked"  -->
 	<label for="radio-GS-Sin">&nbsp;</label>

	</fieldset>

</div>

<div data-role="fieldcontain">

    <fieldset data-role="controlgroup" data-type="horizontal">

 	<input type="radio" name="radio-RH-1" id="radio-RH-Sin" value="" /> <!-- checked="checked"  -->
 	<label for="radio-RH-Sin">RH</label>

 	<input type="radio" name="radio-RH-1" id="radio-RH-P" value="POSITIVO"  />
 	<label for="radio-RH-P">+</label>

 	<input type="radio" name="radio-RH-1" id="radio-RH-N" value="NEGATIVO"  />
 	<label for="radio-RH-N">-</label>

	</fieldset>

</div>






				<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					<div data-role="fieldcontain">
						EPS<div id="popEps"></div>
					</div>

				</fieldset>





			<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
				<div data-role="fieldcontain">

					Email:<div id="txtE_Mail"><input type="email" width="80%" name="txtE_Mail" value = ""/></div>
				</div>
			</fieldset>

					
			<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
				Receptor:<div id="txtReceptor"><input type="text" name="txtReceptor" id="txtReceptor" value = ""/></div>
			</fieldset>



			
		</div>



		
</div><!-- /content -->

<div data-role="content" data-theme="c" class="cSoloBacteriologa">	
		

		<div data-role="fieldcontain">
			
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">

					<div data-role="fieldcontain">
						
						<fieldset class="ui-grid-a">
						<div class="ui-block-a">
							<fieldset data-role="fieldcontain" data-type="horizontal">
							<div id="labelEncuesta"><label for="idEncuestaTxt">Encuesta</label></div>		
							<div id="idEncuestaTxt">
							<input type="text" name="idEncuestaTxt" id="idEncuestaTxt" value = "PE" readonly />
							</div>
							</fieldset>

						</div>

						<div class="ui-block-b">
							<fieldset data-role="fieldcontain" data-type="horizontal">
							<div id="labelFenotipo"><label for="idFenotipoTxt">Fenotipo</label></div>		
							<div id="idFenotipoTxt">
							<input type="text" name="idFenotipoTxt" id="idFenotipoTxt" value = "PE" readonly />
							</div>
							</fieldset>

						</div>

						</fieldset>
					</div>




				</div>

			<div class="ui-block-b">
					<div data-role="fieldcontain">
						
						<fieldset class="ui-grid-a">
						<div class="ui-block-a">
							<fieldset data-role="fieldcontain" data-type="horizontal">
							<div id="labelPerfil"><label for="idPerfilTxt">Perfil</label></div>		
							<div id="idPerfilTxt">
								<input type="text" name="idPerfilTxt" id="idPerfilTxt" value = "PE" readonly />
							</div>
							</fieldset>
						</div>

						<div class="ui-block-b">
							<fieldset data-role="fieldcontain" data-type="horizontal">
							<div id="labelEFisico"><label for="idEFisicoTxt">E. Fisico</label></div>		
							<div id="idEFisicoTxt">
								<input type="text" name="idEFisicoTxt" id="idEFisicoTxt" value = "PE" readonly />
							</div>
							</fieldset>

						</div>

						</fieldset>
					</div>


			</div>

			</fieldset>
		

			
		</div>



		
</div><!-- /content -->
<div id="idInfoBact" class"cSoloBacteriologa">

			<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
			Observaciones:<div id="textarea_observaciones"><textarea name="textarea_observaciones"></textarea></div>
			</fieldset>


	<fieldset data-role="fieldcontain" data-type="horizontal">
		<div data-role="fieldcontain">

			<input type="hidden" name="txtCodBacteriologa" id="txtCodBacteriologa" value = "<?php echo $_SESSION['codigobacteriologa'] ?>" readonly />
			<!-- label for='idNomBacteriologa' ></label> Bacteriologa: -->
			<input type="text" name="idNomBacteriologa" id="idNomBacteriologa" value = "<?php echo $_SESSION['nombrebacteriologa'] ?>"  readonly />
			<div id="detalleRespBact"></div>
		</div><!-- faltaba -->
	</fieldset>


	<fieldset class="ui-grid-b">
			<div class="ui-block-a">

				<fieldset class="ui-grid-a">
					<div class="ui-block-a">
						Buscar Desde :
					</div>
					<div class="ui-block-b">
						<input type='date' name='txtFechaDesde' id='txtFechaDesde' value = ''/>
					</div>
				</fieldset>
			</div>

			<div class="ui-block-b">

				<fieldset class="ui-grid-a">
					<div class="ui-block-a">
						Hasta :
					</div>
					<div class="ui-block-b">
						<input type='date' name='txtFechaHasta' id='txtFechaHasta' value = ''/>
					</div>
				</fieldset>
			</div>

			<div class="ui-block-c">

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					Orden:
				</div>
				<div class="ui-block-b">
					<input type='text' name='txtOTbuscar' id='txtOTbuscar' value = '' />
				</div>
			</fieldset>
		 	</div>


				
	</fieldset>

</div>

        <div id="message" style="margin-top: 5px; display: none;"></div>






<div id="message" style="margin-top: 5px; display: none;"></div>
<div id="waiting" style="margin-top: 5px; display: none;"></div>

<input type='hidden'   id='tipoencuesta' name='tipoencuesta' class='normal-field' value='0' />
<!-- <input type='hidden'   id='tipoencuesta' name='tipoencuesta' class='normal-field' value='<?php echo $_SESSION["tipo_encuesta"]?>' />
-->
<!-- <input type='hidden'   id='usuarioencuesta' name='usuarioencuesta' class='normal-field' value='<?php echo $_SESSION["usuario_encuesta"] ?>' />
-->
<input type='hidden'   id='cc_paciente' name='cc_paciente' class='normal-field' value='<?php echo $_SESSION["num_cc"] ?>' />
<input type='hidden'   id='num_ot' name='num_ot' class='normal-field' value='' />


                 <input type='hidden'   id='go' name='go' class='normal-field' value='0' />





</div>

</form>




<!--style='opacity:0.4;filter:alpha(opacity=40)'-->			






	 <div data-role="footer" data-theme='d' class="footer" data-position="fixed" >

		<!--		<td><a href="#pagina2" data-rel="dialog" data-role="button">Mostrar Encuesta</a></td>
	
	        	<td><input type="button"  name="botonCancelar"  value="Salir" onClick="cancelarDonante();" /></td>  -->
     
	        <!--
	            <td><input type="button" id="bExamenFisico" name="bExamenFisico"  value="Ocultar E.Fisico" onclick="ocultarExamenFisico();" /></td>
			-->




			<?php if ($_SESSION["usuario_encuesta"]!="donante"){
				echo <<< HTML


		<fieldset data-role="fieldcontain" data-type="horizontal">
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">

				<fieldset class="ui-grid-b">
					<div class="ui-block-a">
					<input type="button" id="botonEncuesta" name="botonEncuesta" data-theme="c" value="Mostrar Encuesta" onclick="showDialog();" />
					</div>
					<div class="ui-block-b">
					<input type="button" id="bIrExamenFisico" name="bIrExamenFisico"  data-theme="c" value="Ex.Fisico" onclick="irExamenFisico();" />
					</div>
					<div class="ui-block-c">
					<input type="button" id="bComponentes" name="bComponentes" data-theme="c" value="Componentes" onclick="showComponentes();" />
					</div>
				</fieldset>


				</div>
				<div class="ui-block-b">

				<fieldset class="ui-grid-b">
					<div class="ui-block-a">
					<input type="button" id="bCodigoBarras" name="bCodigoBarras" data-theme="c" value="Cod.Barras" onclick="imprimirCodBarras();" />
					</div>
					<div class="ui-block-b">
					<input type="button" id="bCorregirCedula" name="bCorregirCedula" data-theme="c" value="Corregir Cedula" onclick="corregirCedula();" />
					</div>
					<div class="ui-block-c">
					<input type='button'  id='botonBuscar'  name='botonBuscar'  data-theme="c" value='Buscar' onClick='getInfoDonante();' />
					</div>
				</fieldset>

				</div>
			</fieldset>

			</fieldset>


	

HTML;
			}

			?>


		<fieldset data-role="fieldcontain" data-type="horizontal">
			<fieldset class="ui-grid-b">
				<div class="ui-block-a">
				<input type="button"  name="botoningresarDonate" data-theme="b" value="Grabar Información" onClick="grabarDonante();" />
				</div>

				<div class="ui-block-b">
				<input type="button"  name="botonInicializar" data-theme="b" value="Inicializar" onClick="inicializarCampos();" />
				</div>

				<div class="ui-block-c">
				<input type="button"  name="bIrEncuesta" data-theme="b" value="Salir" onClick="irAMenuPpal();" />
				</div>


				
			</fieldset>
		</fieldset>



	

 	</div><!-- footer -->






</div> <!-- pagina 1 -->




<div id="pagina2" data-role="page">
<a href="#pagina1" data-role="button"  class="volverDeEncuesta">volver</a>

<div id="infoDlgEncuesta"></div>


            <select class='combo-box-resp' name='encAceptar' id='encAceptarDemo' onChange='clickAceptarEncDemo();'>
            <option selected value='NA'>Seleccione Acción</option>
            <option value='1'>Aceptar Encuesta</option>
            <option value='0'>Rechazar Encuesta</option>
            </select>

 	<a href="#pagina1" data-role="button" class="volverDeEncuesta"  data-rel="back">Cerrar</a>

<div data-role="footer" data-theme='d' class="footer" data-position="fixed" >
<!-- <input type="button"  name="bFooterEncuesta"  value="Grabar Encuesta" onClick="fGrabarEncuesta();" /> -->


			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					
				</div>
				<div class="ui-block-b">
					<input type="button"  name="bSalirEncuesta"  value="Salir" onClick="fSalirExamenFisico();" />

				</div>
			</fieldset>




</div><!-- Footer -->


 </div>   <!-- Pagina -->
    


<div id="pagina3" data-role="dialog" class="ui-dialog" data-title="Selección de Componentes">
	<a href="#" data-role="button" class="volverDeComponentes"  data-rel="back">Cerrar</a>
	
<!--	<div id="infoComponentes">
		<select name='infoComponentes' id='infoComponentes' multiple='multiple' >
			<option >Componentes</option>
		</select>
	</div>
	<ul><li> </li><li> </li></ul>
-->

 <div data-role="footer" data-theme='d' class="footer" data-position="fixed" >

		<fieldset data-role="fieldcontain" data-type="horizontal">
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<input type="button"  name="bFooterComponentes"  value="Grabar Componentes" onClick="fGrabarComponentes();" />
				</div>
				<div class="ui-block-b">
				<input type="button"  name="bSalirComponentes"  value="Salir" onClick="fSalirExamenFisico();" />
				</div>
			</fieldset>
		</fieldset>
</div>

</div>   <!-- Pagina -->  









<div data-role="dialog" id="miAlerta" data-title="Imprimir Barras">
  <div data-role="content">

 

	 <label  for="idOTxImprimir">Numero de Donacion:</label>
	<div id='idOTxImprimir'>
	<textarea  name="idOTxImprimir" id="idOTxImprimir" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset" ></textarea>
	</div>

	<label  for="printers">Impresoras de Codigos de Barras:</label><br>
	<select name="idprinters" id="idprinters" >
		<option value="imp1" selected>Movil</option>
		<option value="imp2">Examen Fisico</option>
		<option value="imp3">Despacho</option> 
	</select>


    <a href="#" class="sure-do" data-role="button" data-theme="b" data-rel="back">Imprimir</a>
    <a href="#" data-role="button" data-theme="c" data-rel="back">Cancelar</a>


  </div>
</div>





<div data-role="page" id="paginaEFisico" data-title="Examen Físico">












<div data-role="content" data-theme="c">	
		<label  for="idOTxImprimir">Examen Fisico:</label>
		<div id='idNomPacienteEFisico'></div>









			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				Tipo de Donacion:<div id="popTipoDonacion"></div>
				</fieldset>
				</div>

				<div class="ui-block-b">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="labelCategoria"><label for="popCategorias">Categoria</label></div>		
				<div id="popCategorias"></div>
				</fieldset>

				</div>
			</fieldset>







<table class="ui-bar-b" id="n_CamposEFisico" ><!--style="display: none; -khtml-user-select: none;"-->


<tr>
	<td><input name="radio-ExamenFisico" type="radio" id="radioPesoTeclado" value="Peso"/>
		<label for="radioPesoTeclado">Peso</label></td>
	<td><input name="radio-ExamenFisico"  type="radio" id="radioFCardiacaTeclado" value="F.Cardiaca"/>
		<label for="radioFCardiacaTeclado">F.Cardiaca</label></td>
	<td><input name="radio-ExamenFisico"  type="radio" id="radioPASistolicaTeclado" value="P.A.Sistolica"/>
		<label for="radioPASistolicaTeclado">P.A.Sistolica</label></td>
	<td><input name="radio-ExamenFisico"  type="radio" id="radioPADiastolicaTeclado" value="P.A.Diastolica"/>
		<label for="radioPADiastolicaTeclado">P.A.Diastolica</label></td>


</tr>

<tr>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miPesoTeclado" class="cVlrEFisico" value=""/></td>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miFCardiacaTeclado" class="cVlrEFisico" value=""/></td>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miPASistolicaTeclado" class="cVlrEFisico" value=""/></td>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miPADiastolicaTeclado" class="cVlrEFisico" value=""/></td>
</tr>


<tr>
	<td><div id="labelPeso"><label>Peso 50-150kg</label></div></td>
	<td><div id="labelFCardiaca"><label>Fecuencia Cardiaca 60-95:</label></div></td>
	<td><div id="labelPASistolica"><label>P.A Sistolica 100-150:</label></div></td>
	<td><div  id="labelPADiastolica"><label>P.A Diastolica 60-95</label></div></td>
</tr>

<tr>
	<td><input name="radio-ExamenFisico"  type="radio" id="radioHemoglobinaTeclado" value="Hemoglobina"/>
		<label for="radioHemoglobinaTeclado">Hemoglobina</label></td>
	<td><input name="radio-ExamenFisico"  type="radio" id="radioHematoritoTeclado" value="Hematocrito"/>
		<label for="radioHematoritoTeclado">Hematocrito</label></td>
	<td><input name="radio-ExamenFisico" type="radio" id="radioTemperaturaTeclado" value="Temperatura"/>
		<label for="radioTemperaturaTeclado">Temperatura</label></td>
	<td></td>
</tr>



<tr>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miHemoglobinaTeclado" class="cVlrEFisico" value=""/></td>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miHematocritoTeclado" class="cVlrEFisico" value=""/></td>
	<td><input style="background: white; color: blue;" type="text" readonly="readonly" id="miTemperaturaTeclado" class="cVlrEFisico" value=""/></td>
	<td></td>
</tr>

<tr>
	<td><div id="labelHemoglobina"><label>Hemoglobina (H 13-19 M 12-18)</label></div></td>
	<td><div id="labelHematocrito"><label>Hematocrito (H 41-57 M 38-54)</label></div></td>
	<td><div  id="labelTemperatura"><label>Temperatura 36.0-37.5</label></div></td>
	<td></td>
</tr>
 </table>





		    <table class="ui-bar-a" id="n_tecladoEFisico" style="display: none; -khtml-user-select: none;">
		    		
		    		
		    <tr>
		    	<td><input style="background: white; color: black;" type="text" readonly="readonly" id="miLabelEFisicoTeclado"/>
				</td>
				<td><a data-role="button" data-theme="e" class="doneFisico">OK</a></td>
				<td><a data-role="button" data-theme="b" class="zeroFisico">0</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">1</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">2</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">3</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">4</a></td>
				<td><a data-role="button" data-theme="e" class="decimalFisico">.</a></td>
				<td><a data-role="button" data-theme="e" class="posFisico">+</a></td>
			</tr>

		    <tr>
		    	<td><input style="background: white; color: black;" type="text" readonly="readonly" id="miEFisicoTeclado"/></td>
		    	 
				<td><a data-role="button" data-theme="e" class="cancelarFisico" >Cancelar</a></td>

				<td><a data-role="button" data-theme="b" class="numeroFisico">5</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">6</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">7</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">8</a></td>
				<td><a data-role="button" data-theme="b" class="numeroFisico">9</a></td>
				<td><a data-role="button" data-theme="e" class="delFisico">Borrar</a></td>
				<td><a data-role="button" data-theme="e" class="clearFisico">Limpiar</a></td>
		       
		    </tr>

		    </table>


<!--

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					<fieldset class="ui-grid-b">
						<div class="ui-block-a">Peso 50-150 kg:</div>
						
						<div class="ui-block-b"><div id="poPpeso"></div></div>
						<div class="ui-block-c"><div id="poPpesounidad"></div></div>
						
					</fieldset>
				</fieldset>

				</div>
				<div class="ui-block-b">

					<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
						<fieldset class="ui-grid-b">
							<div class="ui-block-a">Fecuencia Cardiaca 60-95:</div>
							<div class="ui-block-b"><div id="poPfcardiaca"></div></div>
							<div class="ui-block-c"><div id="poPfcardiacaunidad"></div></div>
						</fieldset>

					</fieldset>





				</div>
			</fieldset>


			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
					<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					<fieldset class="ui-grid-b">
						<div class="ui-block-a">P.A Sistolica 100-150:</div>
						<div class="ui-block-b"><div id="poPsistolica"></div></div>
						<div class="ui-block-c"><div id="poPsistolicaunidad"></div></div>

					</fieldset>

				</fieldset>
				</div>
				<div class="ui-block-b">

				<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					<fieldset class="ui-grid-b">
						<div class="ui-block-a">P.A Diastolica 60-95</div>
						<div class="ui-block-b"><div id="poPdiastolica"></div></div>
						<div class="ui-block-c"><div id="poPdiastolicaunidad"></div></div>
					</fieldset>

				</fieldset>
				</div>
			</fieldset>

			<fieldset class="ui-grid-a">

				<div class="ui-block-a">

				<fieldset data-role="fieldcontain" data-type="horizontal">
					<div data-role="fieldcontain">
						
						<fieldset class="ui-grid-c">
						<div class="ui-block-a">Hemoglobina (H 13-19 M 12-18)</div>
						<div class="ui-block-b"><div id="poPhemoglobina"></div></div>
						<div class="ui-block-c"><select><option>.</option></select></div>
						<div class="ui-block-d"><div id="poPhemoglobina_dec"></div></div>

						</fieldset>
					</div>
				
				</fieldset>

				</div>
				<div class="ui-block-b">

					<fieldset data-role="fieldcontain" data-type="horizontal">
					<div data-role="fieldcontain">
						
						<fieldset class="ui-grid-c">
						<div class="ui-block-a">Hematocrito (H 41-57 M 38-54)</div>
						<div class="ui-block-b"><div id="poPhematocrito"></div></div>
						<div class="ui-block-c"><select><option>.</option></select></div>
						<div class="ui-block-d"><div id="poPhematocrito_dec"></div></div>

						</fieldset>

					</div>
				
				</fieldset>
				</div>
			</fieldset>

			<fieldset class="ui-grid-a">
				<div class="ui-block-a">


				<fieldset data-role="fieldcontain" data-type="horizontal" data-role="controlgroup">
					<div data-role="fieldcontain">

						<fieldset class="ui-grid-c">
						<div class="ui-block-a">T. 36.0-37.5 ºC</div>
								
						<div class="ui-block-b"><div id="poPtemperatura"></div></div>
						<div class="ui-block-c"><select><option>.</option></select></div>
						<div class="ui-block-d"><div id="poPtemperatura_dec"></div> </div>

						</fieldset>
						
					</div>
				
				</fieldset>
				

				</div>
				<div class="ui-block-b">
					<fieldset data-role="fieldcontain" data-type="horizontal">
					
					
					Reacción<div id="popReacciones"></div>
					
					</fieldset>
				</div>
			</fieldset>

-->
					<fieldset data-role="fieldcontain" data-type="horizontal">
					
					
					Reacción<div id="popReacciones"></div>
					
					</fieldset>
					
		<fieldset data-role="fieldcontain" data-type="horizontal">
			
		Comentario Examen Fisico:<div id="textarea_comentaFisico"><textarea name="textarea_comentaFisico" id="textarea_comentaFisico"></textarea>
		</fieldset>

<fieldset data-role="fieldcontain" data-type="horizontal">


			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="infoComponentes"></div>
				</fieldset>
				</div>

				<div class="ui-block-b">
				<fieldset data-role="fieldcontain" data-type="horizontal">
				<div id="popEnfermeras"></div>
				</fieldset>

				</div>
			</fieldset>
	

</fieldset>










	

<fieldset data-role="fieldcontain" data-type="horizontal">

	<div id="popNomComponentes">
		<ul data-role="listview" data-inset="true" data-theme="b" data-dividertheme="a">
		</ul>	
	</div>
</fieldset>	



	</div><!-- /content -->
	<div id="idDeExaFisico">

    	<a href="#" data-role="button" data-theme="c" data-rel="back">Salir</a>


 <div data-role="footer" data-theme='d' class="footer" data-position="fixed" >


		<fieldset data-role="fieldcontain" data-type="horizontal">
			<fieldset class="ui-grid-a">
				<div class="ui-block-a">
				<input type="button"  name="bFooterFisico" data-theme="b" value="Grabar Examen Fisico" onClick="fGrabarExFisico();" />
				</div>
				<div class="ui-block-b">
				<input type="button"  name="bSalirExFisico" data-theme="b" value="Salir" onClick="fSalirExamenFisico();" />
				</div>
			</fieldset>
		</fieldset>




</div>

</div>




<div data-role="dialog" id="PaginaAlerta" data-title="ALERTA" data-theme="d">
	 <div data-role="content">

		<div id='idMsgAlerta'></div>
    	<a href="#" data-role="button" data-theme="c" data-rel="back">Salir</a>
	</div>
</div>





<div data-role="dialog" id="paginaClaveUsuario" data-title="CLAVE">
	<div id='idBactXClave'></div><br>
	<label  for="idClaveUsuario">Clave:</label>
	<input type="password" name="idClaveUsuario" id="idClaveUsuario" value = ""  />
	 <div data-role="content" data-theme="c">
		<a href="#pagina1" data-role="button" class="verificar-clave"  data-rel="back">Ingresar</a>	
    	<a href="#" data-role="button" data-theme="c" data-rel="back">Salir</a>
	</div>
</div>





	</body>
</html>
