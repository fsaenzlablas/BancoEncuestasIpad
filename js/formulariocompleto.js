function Donante(){
	this.orden = "";
	this.cedula  = "";
	this.nombres ="";
	this.apellido1  = "";
	this.apellido2 ="";
	this.telefonos  = "";
	this.direccion ="";
	this.email ="";
	this.receptor  = "";
	this.observaciones ="";
	this.reaccion ="";
	this.encuestaOK  = "PE";
	this.perfilOK ="PE";
	this.fenotipoOK ="PE";
	this.examenfisicoOK  = "PE";
	this.bacteriologa = "";
	this.fechanat = "";
	this.genero = "";
	this.edad = "";
	this.comentarios = "";
	this.empresa = "";
	this.categoria = "";
	this.tipodonacion = "";
}


function Bacteriologa(){

    this.codigo ="";
    this.nombre ="";
    this.secreto ="";

}

function Componentes(){
    this.codigo = "";
    this.descripcion = "";
    this.relacion = "";
}


var vDonante = new Donante();
var vArrBacteriologas = [];//new Bacteriologa();
var vArrComponentes = [];

var actualizarEdad = 1;

$(document).ready(



    function(){
		
/*		jQuery.extend(jQuery.mobile.datebox.prototype.options, {
		    'overrideDateFormat': '%Y-%m-%d',
		    'overrideHeaderFormat': '%Y-%m-%d'
		});*/
	
	getBacteriologasMovil() ;
	getBcoEps();
	fGet100AAAA();
	getBcoCategorias();
	getBcoReacciones();
	fLlenarMeses();
	fLlenarInfoPopups();
	fGetInfoComponentes();


	vHoy = new Date();
	var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-18,0,-1);
	actualizarCampoFecha(fechaStr,'txtFechaNat');			
	
	
/*    $("input").keyup(function () {
      var value = $(this).val();
    }).keyup();*/




    $("txtCedula").keyup(function () {
      var value = $(this).val();
//alert(value);
//cedula=value;
    }).keyup();

	$('#txtCedula').change(function(e) {
		var valee = e.target.value;
		vDonante.cedula = e.target.value;
		var result =getInfoDonante();	
	});

	$('#txtNombre').change(function(e) {
		vDonante.nombres = e.target.value;
	});

	$('#txtApellido1').change(function(e) {
		vDonante.apellido1 = e.target.value;
	});
	$('#txtApellido2').change(function(e) {
		vDonante.apellido2 = e.target.value;
	});
	$('#txtTelefonos').change(function(e) {
		vDonante.telefonos = e.target.value;
	});
	$('#txtDireccion').change(function(e) {
		vDonante.direccion = e.target.value;
	});
	$('#txtE_Mail').change(function(e) {
		vDonante.email = e.target.value;
	});
	$('#txtReceptor').change(function(e) {
		vDonante.receptor = e.target.value;
	});
	$('#textarea_observaciones').change(function(e) {
		vDonante.observaciones = e.target.value;
	});
/*	$('#textarea_reaccion').change(function(e) {
		vDonante.reaccion = e.target.value;
	});*/
	
	$('#txtFechaNat').change(function(e) {
		var vHoy = new Date();
		vDonante.fechanat = e.target.value;
		var fecha = new Date(e.target.value);
//		alert(e.target.value);
		vDonante.edad = vHoy.getFullYear()-fecha.getFullYear();
		$vEdad = vDonante.edad;
		alert("la edad del paciente "+$vEdad );
		$vEdadUnidad = $vEdad % 10;
		$vEdad = $vEdad -$vEdadUnidad;
		
		actualizarPopUp($vEdad,'poPedad');
		actualizarPopUp($vEdadUnidad,'poPedadunidad');
		
	});



	$('#txtCodBacteriologa').change(function(e) {

        var i=0;
        var posBact =-1;
        encontrado=0;
        var codigoBact="";

        while ((i<vArrBacteriologas.length)&&(encontrado==0)){
           console.log(e.target.value+" "+vArrBacteriologas[i].secreto);
            if (e.target.value==vArrBacteriologas[i].secreto){
                encontrado = 1;
                posBact=i;
            }
            i++;
        }
        if (posBact>=0){
//            alert(vArrBacteriologas[posBact].codigo+" "+vArrBacteriologas[posBact].secreto+" "+vArrBacteriologas[posBact].nombre);
            txtCodBacteriologa.value = vArrBacteriologas[posBact].codigo;
            codigoBact=vArrBacteriologas[posBact].codigo;
        }else{
            txtCodBacteriologa.value="";

        }
        var result =seleccBacteriologa(codigoBact);

		alert("la bacteriologa "+vDonante.bacteriologa);
	});



	$('#textarea_comentaFisico').change(function(e) {
		vDonante.comentarios = e.target.value;
	});


	$('#poPpeso').change(function(e) {
		var result =fEventoCambiarPeso();	
/*
		var sel =	e.target.options[e.target.selectedIndex].value;

		var str = "";

		var texto = $('#poPpesounidad :selected').text();
		var valorUnidad = $('#poPpesounidad :selected').val();
		var valor = $('#poPpeso :selected').val();

		$("select option:selected").each(function () {
			elemento =$(this);
			var cad = elemento.attr("id");
			if (cad===undefined){}
			else if (cad.indexOf("poPpesounidad"+".")>=0){
			          str += $(this).val() + " ";
			}
			fCambioPeso(parseInt(valor)+parseInt(valorUnidad));

*/

	});

	$('#poPpesounidad').change(function(e) {
		var result =fEventoCambiarPeso();	
	});

	$('#poPtemperatura').change(function(e) {
		var result = fEventoCambiarTemperatura();
	});

	$('#poPtemperatura_dec').change(function(e) {
		var result = fEventoCambiarTemperatura();
	});

	$('#poPedad').change(function(e) {
		var result =fEventoCambiarEdad();
		if (result>=0){
			var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
			actualizarCampoFecha(fechaStr,'txtFechaNat');			
		}
		
	});

	$('#poPedadunidad').change(function(e) {
		var result =fEventoCambiarEdad();
		if (result>=0){
			var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
			actualizarCampoFecha(fechaStr,'txtFechaNat');			
		}
	});

	$('#poPsistolica').change(function(e) {
		var result = fEventoCambiarPSistolica();
	});

	$('#poPsistolicaunidad').change(function(e) {
		var result = fEventoCambiarPSistolica();
	});


	$('#poPdiastolica').change(function(e) {
		var result = fEventoCambiarPDiastolica();
	});

	$('#poPdiastolicaunidad').change(function(e) {
		var result = fEventoCambiarPDiastolica();
	
	});

	$('#poPhemoglobina').change(function(e) {
		var result = fEventoCambiarHemoglobina();
	
	});

	$('#poPhemoglobina_dec').change(function(e) {
		var result = fEventoCambiarHemoglobina();
	
	});

	$('#poPhematocrito').change(function(e) {
		var result = fEventoCambiarHematocrito();
	});


	$('#poPhematocrito_dec').change(function(e) {
		var result = fEventoCambiarHematocrito();
	
	});

	$('#poPfcardiaca').change(function(e) {
		var result =fEventoCambiarFCardiaca();
	});

	$('#poPfcardiacaunidad').change(function(e) {
		var result =fEventoCambiarFCardiaca();
	});

	$('#popEps').change(function(e) {
		vDonante.empresa =e.target.options[e.target.selectedIndex].value;
	});
	$('#popCategorias').change(function(e) {
		vDonante.categoria =e.target.options[e.target.selectedIndex].value;
	});
	$('#popTipoDonacion').change(function(e) {
		vDonante.tipodonacion =e.target.options[e.target.selectedIndex].value;
	});

	$('#popReacciones').change(function(e) {
		vDonante.reaccion =e.target.options[e.target.selectedIndex].value;
	});

	$('#popGenero').change(function(e) {
		vDonante.genero =e.target.options[e.target.selectedIndex].value;
	});


	$('#detalleRespBact').change(function(e) {
        var i=0;
        var posBact =-1;
        encontrado=0;
        while ((i<vArrBacteriologas.length)&&(encontrado==0)){
            console.log(e.target.options[e.target.selectedIndex].value+" "+vArrBacteriologas[i].codigo);
            if ( e.target.options[e.target.selectedIndex].value==vArrBacteriologas[i].codigo){
                encontrado = 1;
                posBact=i;
            }
            i++;
        }
        if (posBact>=0){
            alert(vArrBacteriologas[posBact].codigo+" "+vArrBacteriologas[posBact].secreto+" "+vArrBacteriologas[posBact].nombre);

        }
		seleccBacteriologa(txtCodBacteriologa.value);//Impedir que se cambie la bacteriologa ,solo puede ser seleccionada ingresando el codigo
		$('#detalleRespBact').prop('disabled', 'disabled');
	});


        $('#popRespComponentes').change(function(e) {
            var i=0;
            var posBact =-1;
            encontrado=0;
            while ((i<vArrComponentes.length)&&(encontrado==0)){
                console.log(e.target.options[e.target.selectedIndex].value+" "+vArrComponentes[i].codigo);
                if ( e.target.options[e.target.selectedIndex].value==vArrComponentes[i].codigo){
                    encontrado = 1;
                    posBact=i;
                }
                i++;
            }
            if (posBact>=0){

//                alert(vArrComponentes[posBact].codigo+" "+vArrComponentes[posBact].descripcion+" "+vArrComponentes[posBact].relacion);
                $string = vArrComponentes[posBact].relacion;
                var arrCoComponentes = [];//componentes que se pueden seleccionar con el seleccionado actualmente .
                for (var $i=1;$i<$string.length;$i++){
                   var  $cadOpera = $string.substr($i+2,1);
                    if ( $cadOpera=="&")$wl=1;
                    else if ($cadOpera=="+")$wl=1;
                    else if ($cadOpera=="-")$wl=1;
                    else $wl=2;


                    if ($string.substr($i,1)=="+"){
                        var $componenteStr = $string.substr($i+1,$wl);
                        arrCoComponentes.push($componenteStr)
                    }else if ($string.substr($i,1)=="&"){


                    }
                }
    //            vArrComponentes[i].codigo
            //    for($i;$i<count(arrCoComponentes);i++){

             //   }

                $cadTipo= $('#popRespComponentes').html();
                $cadOriginal = $cadTipo;
                var $cadNomComponentes = "";

                $('#popRespComponentes option').each(function(i, selected){
                    var $posComponente= arrCoComponentes.indexOf($(selected).val());
//                    alert($(selected).val());
$valor=$(selected).val();
                    if (e.target.options[e.target.selectedIndex].value==$valor){//valor actualmente señalado .
                        $cadTipo=$cadTipo.replace("value=\""+$valor+"\"","value=\""+$valor+"\" selected");
//alert($valor);
                        $cadNomComponentes += "<tr><td>"+$(selected).text()+"</td></tr>";

                    }else if ($posComponente>=0){
//                        alert("tambien en "+$valor);
                        $cadTipo=$cadTipo.replace("value=\""+$valor+"\" selected","value=\""+$valor+"\"");
                        $cadTipo=$cadTipo.replace("value=\""+$valor+"\"","value=\""+$valor+"\" selected");
                        $cadNomComponentes += "<tr><td>"+$(selected).text()+"</td></tr>";
 //                        $(selected).checked =true;
                    }else{
                        $cadTipo=$cadTipo.replace("value=\""+$valor+"\" selected","value=\""+$valor+"\"");
//                        $(selected).checked =false;
                    }


                });


                if ( $cadOriginal != $cadTipo){
                    $('#popRespComponentes').html($cadTipo);
                    $cadNomComponentes = "<table>"+$cadNomComponentes+"</table>";
                    $('#popNomComponentes').html($cadNomComponentes);

                }



            }


        });





//Seleccionar del listado de consecutivos de donacion
	$('#popOrdenes').change(function(e) {
		txtOrden.value = 	e.target.options[e.target.selectedIndex].value;
		vDonante.orden = e.target.options[e.target.selectedIndex].value;
		vTextFecha = e.target.options[e.target.selectedIndex].text;
		arr1=vTextFecha.split(" ");
		if (arr1.length>1){
			txtFecha.value =arr1[1];
			getInfoDonante();
	
		}else{txtFecha.value="";}
	});




	$('#botonEncuesta2').click(function(e) {
		alert("Dialogo");
//	    });
	
	 //close click		
//		 $("#dialogo").dialog();
		/*
	     alert('encuesta');

		    $('#waiting').show();
		console.log("data info donante ");
		console.log($('#txtCedula').val());


		    $.ajax({
		        type : 'POST',
		        url : "../ajax/EncuestaEnDemograficos.php",
		        dataType : 'html',
		        data: {
					txtOrden : $('#txtOrden').val() 
					},
		        success : function(data){
			    },
		        error : function(XMLHttpRequest, textStatus, errorThrown) {
		            $('#waiting').hide();
		            $('#message').fadeOut(400);
		            $('#message').fadeIn(400);
		            $('#message').removeClass().addClass('error').text('Error al ejecutar la busquede en encuesta. Informe a sistemas').show(500);
		            $('#txtInfoDonante').hide();

		        }
				    
		    });//ajax
*/
//		    return false;
		        

	});


    } // Ready funcion
); // Ready


	

function fEventoCambiarPeso(){
	var respuesta = -1;
	var valorUnidad = $('#poPpesounidad :selected').val();
	var valor = $('#poPpeso :selected').val();
	if ( !isNaN(valor) ){
		var suma = parseInt(valor)+parseInt(valorUnidad);
		var varresul = fCambioPeso(suma);
		console.log(suma)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
		
	}
	return respuesta;//información pendiente por ingresar 	
}
function fEventoCambiarTemperatura(){
	
	var respuesta = -1;
	var valorUnidad = $('#poPtemperatura_dec :selected').val();
	var valor = $('#poPtemperatura :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+(parseInt(valorUnidad)/10);
		var varresul = fCambioTemperatura(suma);
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
	
	}
	return respuesta;//información pendiente por ingresar 	
}

function fEventoCambiarEdad(){
	var respuesta = -1;
	var valorUnidad = $('#poPedadunidad :selected').val();
	var valor = $('#poPedad :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+parseInt(valorUnidad);
		var varresul = fCambioEdad(suma);
		console.log(suma)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
vDonante.edad=suma;		
	}
	return respuesta;//información pendiente por ingresar 	
	
}

function fEventoCambiarPSistolica(){
	var respuesta = -1;
	var valorUnidad = $('#poPsistolicaunidad :selected').val();
	var valor = $('#poPsistolica :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+parseInt(valorUnidad);
		var varresul = fCambioPresionASistolica(suma);
		console.log(suma)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
		
	}
	return respuesta;//información pendiente por ingresar 	
	
}	
function fEventoCambiarPDiastolica(){
	var respuesta = -1;
	var valorUnidad = $('#poPdiastolicaunidad :selected').val();
	var valor = $('#poPdiastolica :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+parseInt(valorUnidad);
		var varresul = fCambioPresionADiastolica(suma);
		console.log(suma)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
	}
	return respuesta;//información pendiente por ingresar 	
	
}

function fEventoCambiarHematocrito(){
	var respuesta = -1;
	var valorUnidad = $('#poPhematocrito_dec :selected').val();
	var valor = $('#poPhematocrito :selected').val();
	var genero = $('#popGenero :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+(parseInt(valorUnidad)/10);
		var varresul = fCambioHematocrito(suma,genero);
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
	}
	return respuesta;//información pendiente por ingresar 	
}

function fEventoCambiarHemoglobina(){
	var respuesta = -1;
	var valorUnidad = $('#poPhemoglobina_dec :selected').val();
	var valor = $('#poPhemoglobina :selected').val();
	var genero = $('#popGenero :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+(parseInt(valorUnidad)/10);
		
		var varresul = fCambioHemoglobina(suma,genero);	
		var vHematocrito = 3*suma;
		actualizarPopUp(parseInt(vHematocrito),'poPhematocrito');
		actualizarPopUp(parseInt((vHematocrito*10)%10) ,'poPhematocrito_dec');	

		console.log(genero+" "+suma+" hematocrito "+vHematocrito)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		

	}
	return respuesta;//información pendiente por ingresar 	
	
}

function fEventoCambiarFCardiaca(){
	var respuesta = -1;
	var valorUnidad = $('#poPfcardiacaunidad :selected').val();
	var valor = $('#poPfcardiaca :selected').val();
	if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
		var suma = parseInt(valor)+parseInt(valorUnidad);
		var varresul = fCambioFcardiaca(suma);
		console.log(suma)	;	
		(varresul == true) ? respuesta = 1 : respuesta = 0;		
		
	}
	return respuesta;//información pendiente por ingresar 	
	
}


function fSumarAFecha(fecha,annos,meses,dias){
	vHoy = new Date(fecha);
	var vHacexxx = new Date(vHoy.getFullYear()+annos, vHoy.getMonth()+meses, vHoy.getDate()+dias);
	var fechaStr = 	vHacexxx.getFullYear()+'-';
	mes = vHacexxx.getMonth();
	if (mes<10) {
		fechaStr+='0'+mes+'-';
	}else fechaStr+=mes+'-';
	dia = vHacexxx.getDate();
	if (dia<10) {
		fechaStr+='0'+dia;
	}else fechaStr+=dia;
	return fechaStr;
}


function fValidarEdad (valor){
	resultado = 1;
	if ((valor<16)|| (valor>70)){
		resultado = 0;
		
	}
	return resultado ;
}

function fHematocrito( hemoglobina){
	return 3*hemoglobina;
}


function fValidarPeso (valor){
	resultado = 1;
	if ((valor<50)|| (valor>150)){
		resultado = 0;
		
	}
//	alert(valor);
	return resultado ;
}

function fValidarTemperatura(valor){//temperatura por 10
	resultado = 1;
	if ((valor<36.0)|| (valor>37.5)){
		resultado = 0;		
	}
	return resultado ;	
}

function fValidarPresionASistolica (valor){
	resultado = 1;
	if ((valor<100)|| (valor>150)){
		resultado = 0;
		
	}
	return resultado ;
}

function fValidarPresionADiastolica (valor){
	resultado = 1;
	if ((valor<60)|| (valor>95)){
		resultado = 0;
		
	}
	return resultado ;
}

function fValidarFCardiaca (valor){
	resultado = 1;
	if ((valor<60)|| (valor>95)){
		resultado = 0;
		
	}
	return resultado ;
}

function fValidarHemoglobina(valor, genero){
	resultado = 1;
	if ((genero=="Masculino") && ((valor<13)|| (valor>19))){
		resultado = 0;		
	}
	if ((genero=="Femenino") && ((valor<12)|| (valor>18))){
		resultado = 0;		
	}
	if ( (valor<12)|| (valor>19) ){
		resultado = 0;		
	}
	return resultado ;
}

function fValidarHematocrito(valor, genero){
	resultado = 1;
	if ((genero=="Masculino") && ((valor<41)|| (valor>57))){
		resultado = 0;		
	}
	if ((genero=="Femenino") && ((valor<38)|| (valor>54))){
		resultado = 0;		
	}
	if ( (valor<38)|| (valor>57) ){
		resultado = 0;		
	}
	return resultado ;
}

function fCambioPeso(valor){
	return fAlertaVisualLabel('#labelPeso',fValidarPeso(valor));
}

function fCambioTemperatura(valor){
	return fAlertaVisualLabel('#labelTemperatura',fValidarTemperatura(valor));
}

function fCambioPresionASistolica(valor){
	return fAlertaVisualLabel('#labelPASistolica',fValidarPresionASistolica(valor));
}
function fCambioPresionADiastolica(valor){
	return fAlertaVisualLabel('#labelPADiastolica',fValidarPresionADiastolica(valor));
}

function fCambioEdad(valor){
	return fAlertaVisualLabel('#labelEdad',fValidarEdad(valor));
}

function fCambioFcardiaca(valor){
	return fAlertaVisualLabel('#labelFCardiaca',fValidarFCardiaca(valor));
}

function fCambioHemoglobina(valor,genero){
	return fAlertaVisualLabel('#labelHemoglobina',fValidarHemoglobina(valor,genero));
}

function fCambioHematocrito(valor,genero){
	return fAlertaVisualLabel('#labelHematocrito',fValidarHematocrito(valor,genero));
}



function fAlertaVisualLabel(idLabel,normalidad){
	if (normalidad == 0){//valor anormal
		 $(idLabel).css({ color: "#FF0000", background: "#FFFFFF" });//#
		return false;
		
	}else{
		//"#FFFFFF" ,background-color: transparent
		 $(idLabel).css({ color: "#000000", background: "transparent"});
		return true;
		
	}
}

	


function fLlenarMeses(){
	selectValues = { "01": "Enero", "02": "Febrero" , "03": "Marzo", "04": "Abril" 
	,"05": "Mayo", "06": "Junio" , "07": "Julio", "08": "Agosto"
	,"09": "Septiembre", "10": "Octubre" , "11": "Noviembre", "12": "Diciembre"};
	
	var output = [];
	var cadena = "";
	var meses = [ "Enero", "Febrero" ,  "Marzo",  "Abril" , "Mayo",  "Junio" , "Julio",  "Agosto"
	, "Septiembre", "Octubre" , "Noviembre", "Diciembre"];
	for (i=0;i<meses.length;i++){
		vCadKey = i+1;
		if (i<9) vCadKey = "0"+vCadKey;
	    cadena +="<option value='"+ vCadKey+"'>"+ meses[i] +"</option>";
		
	}
	$.each(selectValues, function(key, value)
	{
		//no salen los meses en el orden requerido .
//	    cadena +="<option value='"+ key +"'>"+ value +"</option>";
	});
//alert(cadena);
	return cadena;
}

/*
function fLlenarMeses(){
	selectValues = { "Enero": "Enero", "Febrero": "Febrero" , "Marzo": "Marzo", "Abril": "Abril" ,
	"Mayo": "Mayo", "Junio": "Junio" , "Julio": "Julio", "Agosto": "Agosto",
	"Septiembre": "Septiembre", "Octubre": "Octubre" , "Noviembre": "Noviembre", "Diciembre": "Diciembre"};
	
	var output = [];

	$.each(selectValues, function(key, value)
	{
	  output.push('<option value="'+ key +'">'+ value +'</option>');
	});

	$('#idMeses').html(output.join(''));
	
}*/	
	


function getInfoDonante2Mysql(){
	
	peticion.open("POST", "../ajax/getInfoDonanteMysql.php", true);
	peticion.onreadystatechange = procesarPeticion;
	peticion.send(null);
}

function procesarPeticion(){
	if (peticion.readyState == 4){
		if (peticion.status == 200){
		//	alert(peticion.responseText);
		alert("hola");
		}
	}
}

function procesarLlenarEdades(){
	
	var cadena = "";
	for(i=0;i<10;i++){
	    cadena +="<option value='"+ i +"'>"+i +"</option>";
		
	}
//	alert(cadena);
	cadena1 = "<select name='poPedaddec' id='poPedaddec' >"+cadena+"</select>";
	cadena2 = "<select name='poPedadunid' id='poPedadunid' >"+cadena+"</select>";
	document.write(cadena1);
//	$('#poPedaddec').html(cadena2);
}







function fLlenarInfoPopups(){
	
    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/LlenarInfopopups.php",
        dataType : 'html',
        data: {

        },
        success : function(data){
            $('#waiting').hide();
			var vObjPop = eval('('+data+')');//convierte el texto a JSON
//			 vObjPop = eval('('+data+')');//convierte el texto a JSON
            $('#poPtemperatura').html(vObjPop.temperatura);
            $('#poPtemperatura').show();
            $('#poPtemperatura_dec').html(vObjPop.temperaturaDecimal);
            $('#poPtemperatura_dec').show();

//            $('#puntoID').html("<label for='poPtemperatura_dec'>.</label>");//punto separador de valores .
//            $('#puntoID').show();//en el php hacia salto de linea
//            $('#idMas').html("+");//Mas (+) separador de valores .
//            $('#idMas').show();//en el php hacia salto de linea

            $('#poPpeso').html(vObjPop.peso);
//			console.log(vObjPop.peso);
$('#popGenero').html(vObjPop.genero);
$('#popTipoDonacion').html(vObjPop.tipodonacion);
//console.log(vObjPop.tipodonacion);

$('#popGrupoSanguineo').html(vObjPop.gsanguineo);
$('#popGrupoSanguineo').show();
$('#popRH').html(vObjPop.rh);
$('#popRH').show();

/*$cadr = $('#radio-choice-2').html();
$cadr = $cadr.replace("checked='checked'","");
$cadr = $cadr.replace("value='choice-2'","value='choice-2' checked='checked'");
$('#radio-choice-2').html($cadr);
$('#radio-choice-2').show();*/	
//$("input[type='radio']:value='choice-2'").attr('checked',true).checkboxradio("refresh");

            $('#poPpeso').show();
            $('#poPpesounidad').html(vObjPop.pesounidad);
            $('#poPpesounidad').show();

			$cadEdad= vObjPop.edad
			$cadEdad=$cadEdad.replace("selected","");
			$cadEdad=$cadEdad.replace("value='10'","value='10' selected");
            $('#poPedad').html($cadEdad);
            $('#poPedad').show();

			$cadEdadUnidad= vObjPop.edadunidad
			$cadEdadUnidad=$cadEdadUnidad.replace("selected","");
			$cadEdadUnidad=$cadEdadUnidad.replace("value='8'","value='8' selected");
           	$('#poPedadunidad').html($cadEdadUnidad);
            $('#poPedadunidad').show();

            $('#poPsistolica').html(vObjPop.sistolica);
            $('#poPsistolica').show();
           $('#poPsistolicaunidad').html(vObjPop.sistolicaunidad);
            $('#poPsistolicaunidad').show();

            $('#poPdiastolica').html(vObjPop.diastolica);
            $('#poPdiastolica').show();
           $('#poPdiastolicaunidad').html(vObjPop.diastolicaunidad);
            $('#poPdiastolicaunidad').show();

            $('#poPhemoglobina').html(vObjPop.hemogoblobina);
            $('#poPhemoglobina').show();
			$selectDecimales = "<div id='poPhemoglobina_dec' >";
			$selectDecimales += "<select name='poPhemoglobina_dec' id='poPhemoglobina_dec' >";
			$selectDecimales += "<option >.</option>";
			$selectDecimales += vObjPop.digitos;			
            $('#poPhemoglobina_dec').html($selectDecimales);
            $('#poPhemoglobina_dec').show();

			$('#poPhematocrito').html(vObjPop.hematocrito);
            $('#poPhematocrito').show();
			$selectDecimales = "<div id='poPhematocrito_dec' >";
			$selectDecimales += "<select name='poPhematocrito_dec' id='poPhematocrito_dec' >";
			$selectDecimales += "<option >.</option>";
			$selectDecimales += vObjPop.digitos;			
            $('#poPhematocrito_dec').html($selectDecimales);
            $('#poPhematocrito_dec').show();

            $('#poPfcardiaca').html(vObjPop.fcardiaca);
            $('#poPfcardiaca').show();
           $('#poPfcardiacaunidad').html(vObjPop.fcardiacaunidad);
            $('#poPfcardiacaunidad').show();

           $('#poPday').html(vObjPop.dias);
            $('#poPday').show();

           $('#poPmonth').html("<select name='poPmonth' id='poPmonth' ><option>Mes</option>"+fLlenarMeses()+"</select>");
            $('#poPmonth').show();






			

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#poPtemperatura').hide();

        }
    });

    return false;
	
}



function getBacteriologasMovil() {


    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/getBacteriologasMovil.php",
        dataType : 'html',
        data: {

        },
        success : function(data){

            $('#waiting').hide();

            var obj = eval('('+data+')');//convierte el texto a JSON

            var cadBact;
            cadBact = "<div id=\"detalleRespBact\" >";
            cadBact += "<select name=\"detalleRespBact\" id=\"detalleRespBact\" >";
            cadBact += "<option >Bacteriologas</option>";
            for (var i=0;i<obj.bacteriologas.length;i++){
                var vBacteriologas = new Bacteriologa();
                vBacteriologas.codigo = obj.bacteriologas[i]["codigo"];
                vBacteriologas.nombre = obj.bacteriologas[i]["nombre"];
                vBacteriologas.secreto = obj.bacteriologas[i]["secreto"];
                cadBact +=  "<option value=\""+vBacteriologas.codigo+"\">"+vBacteriologas.nombre +"</option>";
                vArrBacteriologas.push(vBacteriologas);
            }

            cadBact += "</select>";
            cadBact += "  </div>";

            $('#detalleRespBact').html(cadBact);
            $('#detalleRespBact').show();

for (i=0;i<vArrBacteriologas.length;i++){
 //               alert(vArrBacteriologas[i].codigo);
            }



        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#detalleRespBact').hide();

        }
    });

    return false;
}

function fLlenarGenero() {


    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/mostrarGeneroDonante.php",
        dataType : 'html',
        data: {
           genero : "Masculino"                 
        },
        success : function(data){

            $('#waiting').hide();
            $('#llenadoDin').html(data);
            $('#llenadoDin').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#llenadoDin').hide();

        }
    });

    return false;
}



		function getInfoDonanteMysql() {

		    $('#waiting').show();

		    $.ajax({
		        type : 'POST',
		        url : "../ajax/getInfoDonanteMysql.php",
		        dataType : 'html',
		        data: {
		             txtCedula: $('#txtCedula').val()  ,
					txtOrden : $('#txtOrden').val() 
		          	
		        },
		        success : function(data){

		            $('#waiting').hide();
		            $('#txtInfoDonante').html(data);
		            $('#txtInfoDonante').show();

		        },
		        error : function(XMLHttpRequest, textStatus, errorThrown) {
		            $('#waiting').hide();
		            $('#message').fadeOut(400);
		            $('#message').fadeIn(400);
		            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda [getInfoDonanteMysql]. Informe a sistemas ').show(500);
		            $('#txtInfoDonante').hide();

		        }
		    });

		    return false;
		}

function getBcoCategorias() {
    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/getBcoCategorias.php",
        dataType : 'html',
        data: {

        },
        success : function(data){

            $('#waiting').hide();
            $('#popCategorias').html(data);
            $('#popCategorias').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#popCategorias').hide();

        }
    });

    return false;
}

function getBcoReacciones() {
    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/getBcoReacciones.php",
        dataType : 'html',
        data: {

        },
        success : function(data){

            $('#waiting').hide();
            $('#popReacciones').html(data);
            $('#popReacciones').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#popReacciones').hide();

        }
    });

    return false;
}

	function getBcoEps() {


	    $('#waiting').show();

	    $.ajax({
	        type : 'POST',
	        url : "../ajax/getBcoEps.php",
	        dataType : 'html',
	        data: {

	        },
	        success : function(data){

	            $('#waiting').hide();
	            $('#popEps').html(data);
	            $('#popEps').show();

	        },
	        error : function(XMLHttpRequest, textStatus, errorThrown) {
	            $('#waiting').hide();
	            $('#message').fadeOut(400);
	            $('#message').fadeIn(400);
	            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
	            $('#popEps').hide();

	        }
	    });

	    return false;
	}

	function fGet100AAAA() {


	    $('#waiting').show();

	    $.ajax({
	        type : 'POST',
	        url : "../ajax/get100AAAA.php",
	        dataType : 'html',
	        data: {

	        },
	        success : function(data){

	            $('#waiting').hide();
	            $('#poPyear').html(data);
	            $('#poPyear').show();

	        },
	        error : function(XMLHttpRequest, textStatus, errorThrown) {
	            $('#waiting').hide();
	            $('#message').fadeOut(400);
	            $('#message').fadeIn(400);
	            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
	            $('#poPyear').hide();

	        }
	    });

	    return false;
	}

function getInfoDonante() {






    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/getInfoDonante.php",
        dataType : 'html',
        data: {
            txtCedula: vDonante.cedula,//$('#txtCedula').val() ,          
			txtOrden :vDonante.orden,// $('#txtOrden').val() ,
			txtOTbuscar : $('#txtOTbuscar').val() ,
			txtFechaDesde : $('#txtFechaDesde').val() ,
			txtFechaHasta : $('#txtFechaHasta').val() ,
			
			txtNombre :vDonante.nombres,// $('#txtNombre').val() ,
			txtApellido1 :vDonante.apellido1,//$('#txtApellido1').val() ,
			txtApellido2 : vDonante.apellido2,//$('#txtApellido2').val() ,
			txtDireccion :vDonante.direccion,// $('#txtDireccion').val() ,
			txtTelefonos :vDonante.telefonos,// $('#txtTelefonos').val() ,
			
			txtFechaNat : vDonante.fechanat,//$('#txtFechaNat').val() ,

			popGenero :vDonante.genero,// $('#popGenero :selected').val(),
			popGrupoSanguineo : $('#popGrupoSanguineo :selected').val(),
			popRH : $('#popRH :selected').val(),
			popTipoDonacion : vDonante.tipodonacion,// $('#popTipoDonacion :selected').val(),
			popCategorias : vDonante.categoria , //('#popCategorias :selected').val(),
			
			txtE_Mail : vDonante.email,//$('#txtE_Mail').val() ,
			txtReceptor : vDonante.receptor,//$('#txtReceptor').val() ,
			idEncuestaTxt : vDonante.encuestaOK,//$('#idEncuestaTxt').val() ,
			idPerfilTxt : vDonante.perfilOK,//$('#idPerfilTxt').val() ,
			idFenotipoTxt :vDonante.fenotipoOK,// $('#idFenotipoTxt').val() ,
			
			idEFisicoTxt : vDonante.examenfisicoOK//$('#idEFisicoTxt').val() 

        },
		        success : function(data){
//alert(data);
//console.log(data);
		var obj = eval('('+data+')');//convierte el texto a JSON
//		 obj = eval('('+data+')');//convierte el texto a JSON

		//alert(obj.apellido1);
//		arr1=data.split(":");
		$nombreHtml = "<div id='txtApellido1'><input type='text' name='txtApellido1' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+obj.apellido1+"' /></div>";
//		$('#txtNombre').html("<div id='txtNombre'><input type='text' name='txtNombre' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+obj.nombres+"' data-theme='a' /></div>")  ;

//LA Cedula se actualiza solo si no tiene informacion.
vDonante.nombres = obj.nombres;
vDonante.apellido1  = obj.apellido1;
vDonante.apellido2 =obj.apellido2;
vDonante.telefonos  = obj.telefonos;
vDonante.direccion =obj.direccion;
vDonante.email =obj.email;
vDonante.receptor  = obj.receptor;
vDonante.observaciones =obj.observaciones;
vDonante.reaccion =obj.reaccion;
vDonante.encuestaOK  = obj.encuestaOK;
vDonante.perfilOK =obj.perfilOK;
vDonante.fenotipoOK =obj.fenotipoOK;
vDonante.examenfisicoOK  = obj.examenfisicoOK;
vDonante.fechanat= obj.fechanat;
vDonante.genero = obj.genero;
vDonante.edad = obj.edad;
vDonante.comentarios = obj.comentarios;
vDonante.empresa = obj.empresa;
vDonante.categoria = obj.categoria;
vDonante.tipodonacion = obj.tipodonacion;


if (((vDonante.bacteriologa=="")||(vDonante.bacteriologa!=obj.bacteriologa)) &&(obj.bacteriologa!="")){
	vDonante.bacteriologa= obj.bacteriologa;
	actualizarCampoTexto(vDonante.bacteriologa,'txtCodBacteriologa',"password");
	actualizarPopUp(vDonante.bacteriologa,'detalleRespBact');
	
}

		actualizarCampoTexto(vDonante.nombres,'txtNombre','text');
		actualizarCampoTexto(vDonante.apellido1,'txtApellido1','text');
		actualizarCampoTexto(vDonante.apellido2,'txtApellido2','text');
		actualizarCampoTexto(vDonante.telefonos,'txtTelefonos','text');
		actualizarCampoTexto(vDonante.direccion,'txtDireccion','text');


//		$txtEdad = "<div id='slider_edad' style='color: rgb(255, 255, 255); background-color: rgb(255, 0, 0); background-position: initial initial; background-repeat: initial initial; '><input type='number' data-type='range' name='slider_edad' id='slider_edad' value='"+obj.edad+"' min='0' max='100' onchange='fCambioEdad(slider_edad.value)' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset ui-slider-input'><div role='application' class='ui-slider  ui-btn-down-c ui-btn-corner-all'><a href='#' class='ui-slider-handle ui-btn ui-shadow ui-btn-corner-all ui-btn-up-c' data-corners='true' data-shadow='true' data-iconshadow='true' data-wrapperels='span' data-theme='c' role='slider' aria-valuemin='0' aria-valuemax='100' aria-valuenow='6' aria-valuetext='6' title='6' aria-labelledby='slider_edad-label' style='left: 6%; '><span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'></span></span></a></div></div>"
//		$('#slider_edad').html($txtEdad);


		actualizarPopUp(vDonante.genero,'popGenero');

		$cadyyyy=$('#poPyear').html();
		$cadmes=$('#poPmonth').html();
		$caddia=$('#poPday').html();
//		console.log("aqui");
		
		$vFechaNat = vDonante.fechanat;
		arr1=$vFechaNat.split("-");
/*		if (arr1.length>2){
			value='"+ key +"'
			actualizarPopUp(arr1[0],'poPyear');
			actualizarPopUp(arr1[1],'poPmonth');
			$vDia= parseInt(arr1[2]);//si es menor de 10 trae un cero antes.

			actualizarPopUp($vDia,'poPday');
			
		}else{
			$cadyyyy=$cadyyyy.replace("selected","");
			$cadmes=$cadmes.replace("selected","");
			$caddia=$caddia.replace("selected","");
			actualizarPopUp($cadyyyy,'poPyear');
			actualizarPopUp($cadmes,'poPmonth');
			actualizarPopUp($caddia,'poPday');
			
		}*/
//		console.log("alla");

		$vEdad = vDonante.edad;
		$vEdadUnidad = $vEdad % 10;
		$vEdad = $vEdad -$vEdadUnidad;
		
		actualizarEdad=0;//no actualizar automaticamente
		actualizarPopUp($vEdad,'poPedad');
		actualizarPopUp($vEdadUnidad,'poPedadunidad');
		actualizarCampoFecha(vDonante.fechanat,'txtFechaNat');
		actualizarEdad=1;

		$('#txtNombre').show();
//		             $('#txtInfoDonante').html(data);
		            $('#txtInfoDonante').show();


                    cadOrdenes = "<div id=\"popOrdenes\" >";
                    cadOrdenes += "<select name=\"popOrdenes\" id=\"popOrdenes\" >";
                    cadOrdenes += "<option >Ordenes</option>";
                    var arrOrdenes = $.map(obj.ordenes, function (item, index) { return [[item.orden, item.fecha, item.estado]]; });
                    for (var i=0;i<obj.ordenes.length;i++){
                        vClave="";
                        vValor="";
                        for(key in obj.ordenes[i]){

                            if (obj.ordenes[i].hasOwnProperty(key)){
                                if (key == "orden"){
                                    vClave=obj.ordenes[i][key];
                                    vValor=vClave+ " ";
                                }else{
                                    vValor+=obj.ordenes[i][key]+" ";
                                }

                            }
                        }
                        cadOrdenes +=  "<option value=\""+vClave+"\">"+vValor+"</option>";

                    }

                    cadOrdenes += "</select>";
                    cadOrdenes += "  </div>";



         $('#popOrdenes').html(cadOrdenes);
         $('#popOrdenes').show();


		actualizarPopUp(obj.gsanguineo,'popGrupoSanguineo');
		actualizarPopUp(obj.rh,'popRH');
		actualizarPopUp(vDonante.categoria,'popCategorias');

		actualizarPopUp(vDonante.tipodonacion,'popTipoDonacion');

		actualizarPopUp(vDonante.empresa,'popEps');


		actualizarCampoTexto(vDonante.email,'txtE_Mail','text');
		actualizarCampoTexto(vDonante.receptor,'txtReceptor','text');
		actualizarCampoTexto(vDonante.observaciones,'textarea_observaciones','text');
		actualizarCampoTextoSoloLectura(vDonante.encuestaOK,'idEncuestaTxt');//
		actualizarCampoTextoSoloLectura(vDonante.perfilOK,'idPerfilTxt');
		actualizarCampoTextoSoloLectura(vDonante.fenotipoOK,'idFenotipoTxt');
		actualizarCampoTextoSoloLectura(vDonante.examenfisicoOK,'idEFisicoTxt');

actualizarPopUp(vDonante.reaccion,'popReacciones');

		actualizarPopUp(obj.peso-(obj.peso % 10),'poPpeso');
		actualizarPopUp(obj.peso % 10,'poPpesounidad');

		actualizarPopUp(obj.pdiastolica-(obj.pdiastolica % 10),'poPdiastolica');
		actualizarPopUp(obj.pdiastolica % 10,'poPdiastolicaunidad');

		actualizarPopUp(obj.psistolica-(obj.psistolica % 10),'poPsistolica');
		actualizarPopUp(obj.psistolica % 10,'poPsistolicaunidad');

		actualizarPopUp(parseInt(obj.temperatura),'poPtemperatura');
		actualizarPopUp(parseInt((obj.temperatura*10)%10) ,'poPtemperatura_dec');	

		actualizarPopUp(parseInt(obj.hemoglobina),'poPhemoglobina');
		actualizarPopUp(parseInt((obj.hemoglobina *10 )%10) ,'poPhemoglobina_dec');	

console.log("decimal hemoglobina "+obj.hemoglobina+" es "+parseInt((obj.hemoglobina-parseInt(obj.hemoglobina))*10));
console.log("diferencia "+(obj.hemoglobina-parseInt(obj.hemoglobina)));
console.log("parse int "+parseInt(obj.hemoglobina));

		actualizarPopUp(parseInt(obj.hematocrito),'poPhematocrito');
		actualizarPopUp(parseInt((obj.hematocrito*10)%10) ,'poPhematocrito_dec');	

		actualizarPopUp(obj.fcardiaca-(obj.fcardiaca % 10),'poPfcardiaca');
		actualizarPopUp(obj.fcardiaca % 10,'poPfcardiacaunidad');
		actualizarCampoTexto(vDonante.comentarios,'textarea_comentaFisico','text');


		$('#idEncuestaTxt').css('background-color','blue');
		$('#idPerfilTxt').css('background-color','red');
		$('#idFenotipoTxt').css('background-color','blue');
		$('#idEFisicoTxt').css('background-color','red');

		if (( (vDonante.cedula == "") || (vDonante.cedula!=obj.cedula) ) && (obj.cedula!="")) {
			vDonante.cedula	= obj.cedula;
			console.log("sin cedula "+vDonante.cedula);
			actualizarCampoTexto(obj.cedula,'txtCedula','text');
		}
		

		        },
		        error : function(XMLHttpRequest, textStatus, errorThrown) {
		            $('#waiting').hide();
		            $('#message').fadeOut(400);
		            $('#message').fadeIn(400);
		            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda getInfoDonante. Informe a sistemas').show(500);
		            $('#txtInfoDonante').hide();

		        }
		    });

		    return false;
		}
		
		
	function actualizarPopUp(campovalor, campohtml){
		$valor = campovalor;
		$cadTipo= $('#'+campohtml).html();
		$cadTipo=$cadTipo.replace("selected","");
		$cadTipo=$cadTipo.replace("value=\""+$valor+"\"","value=\""+$valor+"\" selected");
//		console.log("popuup "+$cadTipo);
		$('#'+campohtml).html($cadTipo);
	}
	
	function actualizarCampoTexto(campovalor, campohtml, tipocampo){
//		$('#'+campohtml).html("<div id='"+campohtml+"' data-role='content'><input type='text' name='"+campohtml+"' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+campovalor+"' /></div>")  ;
		$('#'+campohtml).html("<div id='"+campohtml+"' data-role='content'><input type='"+tipocampo+"' name='"+campohtml+"' id='"+campohtml+"'  class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+campovalor+"' /></div>")  ;
		
	}
	
	function actualizarCampoTextoSoloLectura(campovalor, campohtml){
		$('#'+campohtml).html("<div id='"+campohtml+"' data-role='content'><input type='text' name='"+campohtml+"' id='"+campohtml+"' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+campovalor+"' readonly /></div>")  ;
		
	}
	
	function actualizarCampoFecha(campovalor, campohtml){
		var cad = $('#'+campohtml).html();
//		alert(cad);
//		$('#'+campohtml).val(campovalor);
			$('#'+campohtml).html("<div id='"+campohtml+"'><input type='date' name='"+campohtml+"' id='"+campohtml+"'  value = '"+campovalor+"' format='yyyy-mm-dd' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset'/></div>")  ;
	}
		
	function cancelarDonante(){
	    if (confirm('Desea cancelar el registro del donante?')) {
//		getInfoDonante();
	        document.forms[0].action='../apl/login.php';
	        document.forms[0].submit();
	    }

	}

		function inicializarCampos(){
		    if (confirm('Desea cancelar Inicializar los Campos?')) {
	//		getInfoDonante();
		        document.forms[0].action='../apl/FormularioCompleto.php';
		        document.forms[0].submit();
		    }

		}


function grabarDonante() {

	arregloCampos = ["txtCedula","txtNombre","txtApellido1","txtDireccion","txtTelefonos"];
	salir = 1;
	
	

	if (vDonante.cedula==""){
		salir=1;
		alert("sin Cedula");
	}else if(vDonante.nombres==""){
		alert("sin Nombres");
	}else if(vDonante.apellido1==""){
		alert("sin Apellido 1");
	}else if(vDonante.direccion==""){
		alert("sin Direccion");
	}else if (vDonante.telefonos==""){
		alert("sin Telefonos");	
		vDonante.empresa
	}else if (vDonante.empresa==""){
		alert("sin Eps");
	}else if (vDonante.categoria==""){
		alert("sin Categoria");
	}else if (vDonante.tipodonacion==""){
		alert("sin Tipod e Donacion");
	}else{
		var informacion ="";
		informacion="Nombre :"+vDonante.nombres+" "+vDonante.apellido1+" eps "+vDonante.empresa+" Donante:"+vDonante.orden;
		alert(informacion);
		salir = 0;
	}


/*			for (var i=0;i<arregloCampos.length;i++){


			valores = document.getElementsByName(arregloCampos[i]);
			indice = valores.length-1;
			valor=	valores[indice].value;
			if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
					alert (valor+" Falta Informacion en "+arregloCampos[i]);
					console.log(valores[0]);
					valores[0].focus();
					salir=1;
					break;
			}

	}*/
	// Botones de radio .
	/*
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
*/


	if (fEventoCambiarEdad()!=1){
		salir = 1;
		alert("Edad NO permitida");
	}
	var codBacteriologa = $('#detalleRespBact :selected').val();
	if (vDonante.bacteriologa==""){
		salir = 1;
		alert("Falta seleccionar la Bacteriologa");
	}else {alert(vDonante.bacteriologa);}

	if (salir != 0){//falta informacion no hacer validaciones todavia
		
	}else if (fEventoCambiarPeso()==0){
		salir = 1;
		alert("Peso NO permitido");
	}else if (fEventoCambiarPSistolica()==0){
		salir = 1;
		alert("Presion Arterial Sistolica NO permitida");
	}else if (fEventoCambiarPDiastolica()==0){
		salir = 1;
		alert("Presion Arterial Diastolica NO permitida");
	}else if (fEventoCambiarFCardiaca()==0){
		salir = 1;
		alert("Frecuencia Cardiaca NO permitida");
	}else if (fEventoCambiarHemoglobina()==0){
		salir = 1;
		alert("Hemoglobina NO permitida");
	}else if (fEventoCambiarHematocrito()==0){
		salir = 1;
		alert("Hematocrito NO permitido");
	}else if (fEventoCambiarTemperatura()==0){
		salir = 1;
		alert("Temperatura NO permitida")
		
	}else{salir = 0;}



	if (salir == 0){
	    if (confirm('Esta seguro de grabar el donante?')) {
//	        document.forms[0].action='../apl/grabarBancoRegistro.php';
//	        document.forms[0].submit();
            var arrComponentesSel = [];
            $('#popRespComponentes :selected').each(function(i, selected){
                arrComponentesSel[i] = $(selected).val();//text
            });


            var multipleValues =arrComponentesSel.join(",");
alert("componentes sel "+multipleValues);
$.ajax({
    type : 'POST',
    url : "../apl/grabarBancoRegistro.php",
    dataType : 'html',
    data: {

        popRespComponentes :multipleValues,

        txtOTbuscar : $('#txtOTbuscar').val() ,
		txtFechaDesde : $('#txtFechaDesde').val() ,
		txtFechaHasta : $('#txtFechaHasta').val() ,
		txtOrden : vDonante.orden,//$('#txtOrden').val() ,
		txtFecha : $('#txtFecha').val() ,
		popOrdenes : $('#popOrdenes :selected').val() ,
		txtCodBacteriologa :vDonante.bacteriologa,// $('#txtCodBacteriologa').val() ,
		Bacteriologas : vDonante.bacteriologa,//$('#Bacteriologas :selected').val() ,
		txtCedula : vDonante.cedula,//$('#txtCedula').val() ,
		txtNombre : vDonante.nombres,//$
		txtApellido1 :vDonante.apellido1,//$ $('#txtApellido1').val() ,
		txtApellido2 :vDonante.apellido2,//$ $('#txtApellido2').val() ,
		txtDireccion : vDonante.direccion,//$$('#txtDireccion').val() ,
		txtTelefonos :vDonante.telefonos,//$ $('#txtTelefonos').val() ,
		poPedad : $('#poPedad :selected').val() ,
		poPedadunidad : $('#poPedadunidad :selected').val() ,
		poPday : $('#poPday :selected').val() ,
		poPmonth : $('#poPmonth :selected').val() ,
		poPyear : $('#poPyear :selected').val() ,
		popGenero : $('#popGenero :selected').val() ,
		popGrupoSanguineo : $('#popGrupoSanguineo :selected').val() ,
		popRH : $('#popRH :selected').val() ,
		popTipoDonacion : $('#popTipoDonacion :selected').val() ,
		popCategorias : vDonante.categoria,//$('#Categorias :selected').val() ,
		EPS : vDonante.empresa,//$('#EPS :selected').val() ,
		txtE_Mail : vDonante.email,//$$('#txtE_Mail').val() ,
		txtReceptor :vDonante.receptor,//$ $('#txtReceptor').val() ,
		textarea_observaciones :vDonante.observaciones,//$ $('#textarea_observaciones').val() ,
		textarea_reaccion :vDonante.reaccion,//$ $('#textarea_reaccion').val() ,
		poPpeso : $('#poPpeso :selected').val() ,
		poPpesounidad : $('#poPpesounidad :selected').val() ,
		poPtemperatura : $('#poPtemperatura :selected').val() ,
		poPtemperatura_dec : $('#poPtemperatura_dec :selected').val() ,
		poPsistolica : $('#poPsistolica :selected').val() ,
		poPsistolicaunidad : $('#poPsistolicaunidad :selected').val() ,
		poPdiastolica : $('#poPdiastolica :selected').val() ,
		poPdiastolica : $('#poPdiastolica :selected').val() ,
		poPhemoglobina : $('#poPhemoglobina :selected').val() ,
		poPhemoglobina_dec : $('#poPhemoglobina_dec :selected').val() ,
		poPhematocrito : $('#poPhematocrito :selected').val() ,
		poPhematocrito_dec : $('#poPhematocrito_dec :selected').val() ,
		poPfcardiaca : $('#poPfcardiaca :selected').val() ,
		poPfcardiacaunidad : $('#poPfcardiacaunidad :selected').val() ,
		textarea_comentaFisico : vDonante.comentarios,//$$('#textarea_comentaFisico').val() ,

		Componentes : $('#Componentes :selected').val() ,
		idEncuestaTxt : vDonante.encuestaOK,//$('#idEncuestaTxt').val() ,
		idPerfilTxt : vDonante.perfilOK,//$('#idPerfilTxt').val() ,
		idFenotipoTxt :vDonante.fenotipoOK,// $('#idFenotipoTxt').val() ,
		idEFisicoTxt :vDonante.examenfisicoOK// $('#idEFisicoTxt').val(),
	},
    success : function(data){

		if (vDonante.orden==""){//Nueva orden
			alert("Orden creada: "+data);
	        document.forms[0].action='../apl/formulariocompleto.php';
	        document.forms[0].submit();
			
		}else{alert("Orden actualizada :"+data);}

    },
    error : function(XMLHttpRequest, textStatus, errorThrown) {
        $('#waiting').hide();
        $('#message').fadeOut(400);
        $('#message').fadeIn(400);
        $('#message').removeClass().addClass('error').text('Error al ejecutar grabarBancoRegistro. Informe a sistemas').show(500);
        $('#txtInfoDonante').hide();

    }

});//ajax
	
	
	
	
	
	    }// if (confirm('Esta seguro de grabar el donante?')) {
	}//if (salir == 0){
}//function grabarDonante() {


function fGetInfoComponentes() {


    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/GetInfoComponentes.php",
        dataType : 'html',
        data: {

        },
        success : function(data){

            $('#waiting').hide();

            var obj = eval('('+data+')');//convierte el texto a JSON

            var cadBact;
            cadBact = "<div id=\"popRespComponentes\" >";
            cadBact += "<select name=\"popRespComponentes\" id=\"popRespComponentes\" multiple=\"multiple\" >";
            cadBact += "<option >Componentes</option>";
            for (var i=0;i<obj.componentes.length;i++){
                var vComponentes = new Componentes();
                vComponentes.codigo = obj.componentes[i]["codigo"];
                vComponentes.descripcion = obj.componentes[i]["descripcion"];
                vComponentes.relacion = obj.componentes[i]["relacion"];
                cadBact +=  "<option value=\""+vComponentes.codigo+"\">"+vComponentes.descripcion +"</option>";
                vArrComponentes.push(vComponentes);
            }
            cadBact += "</select>";
            cadBact += "  </div>";

            $('#popRespComponentes').html(cadBact);
  //          $('#popRespComponentes').html(data);
            $('#popRespComponentes').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#popRespComponentes').hide();

        }
    });

    return false;
}
	
	
function seleccBacteriologa(codBact){//Seleccionar la bacteriologa del popup menu.

    alert("para cambiar la bact "+codBact);

	$cadSelect = $('#detalleRespBact').html();
	$cadSelect=$cadSelect.replace("selected","");
	$cadSelect=$cadSelect.replace("value=\""+codBact+"\"","value=\""+codBact+"\" selected");
	$('#detalleRespBact').html($cadSelect);
	vDonante.bacteriologa =$('#detalleRespBact :selected').val() ;// e.target.value;
	

//	alert("Para seleccionar digite el codigo de la bacteriologa");
	console.log("acutalizado "+txtCodBacteriologa.value);
	
	return false;
}


function showDialog()
{
//   alert("en dialogo");

    $("#dialogo").dialog({
        height: 280,
        widht: 500,
        modal: true,
     });



}


