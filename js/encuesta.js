var enFirma= false;
var enRevisar= false;

$(document).ready(

    function(){

        // ----------------------------------------------------------------------
        // Inicializacion de variables y frontend
        // ----------------------------------------------------------------------

        donante=$('#num_ot').val();
        $('#num_ot').focus();

        $('#divSiguientePreg').show();
        $('#divAnteriorPreg').show();
        $('#divLogin').hide();
        $('#reiniciarEnc').show();
        $('#detallePregunta').show();
        
        $('#PageRefresh').click(function() {

            location.reload();

        });


        $('#empezarEncuesta').click(function() {

            empezarEncuesta();

        });


        $('#Deshabilitar').click(function() {

            // Deshabilitar todas las respuestas para que no las cambien
            $("[id*=respuesta_]").attr("disabled",true);

        });

        $('#Habilitar').click(function() {

            // Deshabilitar todas las respuestas para que no las cambien
            $("[id*=respuesta_]").attr("disabled",false);

        });


        // Mostrar la siguiente pregunta

        $('#siguientePreg').click(function() {

            showPregunta();

        });

        // Mostrar la pregunta Anterior

        $('#anteriorPreg').click(function() {


            showPreguntaAnterior();

        });


        $('#reiniciarEnc').click(function() {
            reiniciarEncuesta()
        });


        $('#cancelarLogin').click(function() {

            $('#divSiguientePreg').show();
            $('#divAnteriorPreg').show();

            $('#divLogin').hide();
            $('#reiniciarEnc').show();

            $('#erroresEnc').hide();

            if ( enFirma ) {
                $('#divSiguientePreg').hide();
                $('#borrarEncuesta').show();
                $('#revisarResp').show();
                enRevisar=false;
            }

            if ( enRevisar ) {
                enFirma=false;
                $("#revisarResp").hide();
                $('#divBorrarFirma').show();
                $('#divSiguientePreg').hide();
                $('#grabarEnc2').show();

            }
        });


        $("#usuario").focus(function() { $(this).select() });


        $('#login').click(function() {

            $('#erroresEnc').hide();
            $('#erroresEnc').html("Validando acceso ...");
            $('#erroresEnc').show(500);

            $('#divBorrarFirma').hide();
            $('#divReiniciarEnc').hide();

            $.ajax({
                type : 'POST',
                url : "../ajax/validar_usuario.php",
                dataType : 'html',
                data: {
                    num_ot: $('#num_ot').val(),
                    usuario: $('#usuario').val(),
                    password: $('#password').val()
                },
                success : function(data){
                    switch (data.substring(0,1)) {
                        case '1' : // Login exitoso

                            $('#erroresEnc').hide();
                            $('#password').val("")

                            $('#divSiguientePreg').show();
                            $('#divAnteriorPreg').show();
                            $('#detalleFirma').hide();
                            $('#detalleRespuestas').hide();
                            $('#detallePregunta').show();
                            $('#divMensaje').hide();


                            $('#divLogin').hide();
                            $('#reiniciarEnc').show();

                            $.ajax({
                                type : 'POST',
                                url : "../ajax/configEncuesta.php",
                                dataType : 'html',
                                data: {
                                    num_ot :  $('#num_ot').val()
                                },
                                success : function(data){

                                    $('#waiting').hide();
                                    $('#encuesta').submit(); // hacia: det_encuesta.php

                                },
                                error : function(XMLHttpRequest, textStatus, errorThrown) {
                                    $('#waiting').hide();
                                    $('#message').fadeIn(1000);
                                    $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [#login.clic]').show(500);
                                    $('#detalleDonante').hide();


                                }
                            });
                            showPregunta(0)


                            break;
                        case '2': // Login no exitoso

                            $('#erroresEnc').hide();
                            $('#password').val("")

                            $('#divSiguientePreg').hide();
                            $('#divAnteriorPreg').hide();
                            $('#detalleFirma').hide();
                            $('#detalleRespuestas').hide();
                            $('#detallePregunta').show();
                            $('#divMensaje').hide();

                            $('#erroresEnc').html(data.substring(2));
                            $('#erroresEnc').show();
                            $('#divReiniciarEnc').show();
                            break;
                    }

                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeIn(1000);
                    $('#message').removeClass().addClass('error').text('Error al validar usuario. Informe a sistemas').show(500);
                    $('#detalleDonante').hide();


                }
            });

        });


        $('#contestarEnc').click(function() {

            
            
            $.ajax({
                type : 'POST',
                url : "../apl/contestar2.php",
                dataType : 'html',
                data: {
                    donante: $('#num_ot').val()
                },
                success : function(data){
                    $('#erroresEnc').html(data);
                    $('#erroresEnc').show();

                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeIn(1000);
                    $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                    $('#detalleDonante').hide();


                }
            });
          
             
        });

        $("#getDonante").click(

            
            function(){

                $('#num_ot').val($('#num_ot').val().toUpperCase())
                
                
                $('#waiting').show();
                $('#detalleDonante').hide();
                $('#detalleDonante').html('');
                
                $.ajax({
                    type : 'POST',
                    url : "../ajax/getDonante.php",
                    dataType : 'html',
                    data: {
                        num_ot: $('#num_ot').val()
                    },
                    success : function(data){

                        $('#waiting').hide();
                        
                        switch (data.substring(0,1)) {

                            case "0": // Indica que el numero de OT Donante no existe o ya se respondio y valido
                                jAlert(data.substring(2), 'Error');

                                $('#detalleDonante').hide();
                                $('#bacteriologas').hide();
                                $('#divValidarEnc').hide();
                                $('#divEmpezarEnc').hide();

                                $('#num_ot').focus();
                                $('#num_ot').select();
                                break;

                            case "1": // Indica que la encuesta NO esta contestada
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#bacteriologas').show();
                                $('#divEmpezarEnc').show();
                                $('#divValidarEnc').hide();

                                break;

                            case "2": // Indica que la encuesta ESTA contestada pero NO esta validada
                                
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#Responsable').hide();
                                $('#divEmpezarEnc').hide();
                                $('#divValidarEnc').show();

                                break;

                            case "3": // Indica que la encuesta ESTA siendo contestada en otro IPAD

                                if (confirm('La encuesta esta siendo contestada en otro IPAD, desea reiniciarla?')) {

                                    $.ajax({
                                        type : 'POST',
                                        url : "../ajax/permitirIpad.php",
                                        dataType : 'html',
                                        data: {
                                            num_ot :  $('#num_ot').val()
                                        },
                                        success : function(data){
                                            jAlert(data.substring(2), 'Informaci&oacute;n');
                                            $('#waiting').hide();

                                        },
                                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                                            $('#waiting').hide();
                                            $('#message').fadeIn(1000);
                                            $('#message').removeClass().addClass('error').text('Error al Acutalizar estado de la encuesta. Informe a sistemas [#getDonante.clic]').show(500);
                                            $('#detalleDonante').hide();


                                        }
                                    });
                                }
                                $('#detalleDonante').hide();
                                $('#bacteriologas').hide();
                                $('#divValidarEnc').hide();
                                $('#divEmpezarEnc').hide();

                                $('#num_ot').focus();
                                $('#num_ot').select();
                                break;

                            case "4": // Indica que la encuesta ESTA siendo contestada en otro IPAD

                                if (confirm('La encuesta esta siendo contestada en otra PESTAÑA del Navagador, desea reiniciarla?')) {

                                    $.ajax({
                                        type : 'POST',
                                        url : "../ajax/permitirPestana.php",
                                        dataType : 'html',
                                        data: {
                                            num_ot :  $('#num_ot').val()
                                        },
                                        success : function(data){
                                            jAlert(data.substring(2), 'Información');
                                            $('#waiting').hide();

                                        },
                                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                                            $('#waiting').hide();
                                            $('#message').fadeIn(1000);
                                            $('#message').removeClass().addClass('error').text('Error al permitir encuesta en otra pestaña. Informe a sistemas [#getDonante.clic]').show(500);
                                            $('#detalleDonante').hide();


                                        }
                                    });
                                }
                                $('#detalleDonante').hide();
                                $('#bacteriologas').hide();
                                $('#divValidarEnc').hide();
                                $('#divEmpezarEnc').hide();

                                $('#num_ot').focus();
                                $('#num_ot').select();
                                break;


                            }


                        },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        $('#waiting').hide();
                        $('#message').fadeIn(1000);
                        $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                        $('#detalleDonante').hide();
                    }
                });

                $('#num_ot').focus();
                $('#num_ot').select();
                return false;

              
            }

            );


        // ----------------------------------------------------------------------------------------------
        // Codigo a realizar cuando se hace clic en el boton VALIDAR Encuesta
        // ----------------------------------------------------------------------------------------------

        $("#valEncuesta").click(


            function(){
	
				if (   $("#tipoEncuesta").val() != "0" ) {
					
	                if (confirm('Esta seguro validar esa encuesta?-1')) {

	                    $('#det_encuesta').attr('action', '../apl/validarEncuesta.php')
	                    $('#det_encuesta').submit();

	                }

		
				}else{
					alert("Falta la firma Post-donación")
				}




                return false;


            }

        );

        $("#valEncuesta2").click(


            function(){
//$_SESSION["tipo_encuesta"]
				if (   $("#tipoEncuesta").val() != "0" ) {
	                if (confirm('Esta seguro validar esa encuesta? - 2')) {

	                    $('#encuesta').attr('action', '../apl/validarEncuesta.php')
	                    $('#encuesta').submit();

	                }
	
				}else{ alert("Falta la Firma Post-donación")}




                return false;


            }

        );



        // ----------------------------------------------------------------------------------------------
        // Codigo a realizar cuando se hace clic en el boton Grabar Encuesta al momento de validarla
        // ----------------------------------------------------------------------------------------------


        $("#grabarEnc").click(

            //
            //  Validar si la encuesta esta completa sino informar el error
            //


            function(){

                if (   $("#encEstado").val()=="OC" ) {

                    // -------------------------------------------------------------------------------------------
                    // Si la encuesta es de aceptacion condicional se debe validar que acepten la encuesta y que
                    // escriban la Justificacion
                    // -------------------------------------------------------------------------------------------

                    if (   $("#encAceptar").val()=="NA"  ) {

                        alert('Debe ACEPTAR o RECHAZAR la encuesta!');

                    } else {
                        if ($('#encComentarios').val()=="") {
                            alert('Debe escribir una JUSTIFICACION para aceptar o rechazar la encuesta!');
                        } else {
                            if (confirm('Esta seguro(a) de que desea grabar la encuesta?')) {
                                $('#waiting2').show(1000);
                                grabar4D();
                            }

                        } // Else
                    }

                } else {
                    if (confirm('Esta seguro(a) de que desea grabar la encuesta?')) {
                        $('#waiting2').show(1000);
                        grabar4D();
                    }

                }

                return false;
            } // grabarEnc funcion
            ); // grabarEnc clic




        // ----------------------------------------------------------------------------------------------
        // Codigo a realizar cuando se hace clic en el boton Grabar Encuesta
        // ----------------------------------------------------------------------------------------------

        $("#grabarEnc2").click(

            function(){
                saveCanvas();

                return false;

            }
        ); // grabarEnc2 clic





    } // Ready funcion
    ); // Ready




/**
     *Marcar la fila con un color de background cuando ha sido contestada
    */


function onClickRadio(obj, tipoPreg, re, tipoNext, codNext, num_ot, pa){

    var resp_next="_NULL";

    $('#waiting2').show();
    id_respuesta="#"+obj.name
    $(id_respuesta).removeClass().addClass('con-respuesta');

    
    cod_preg=obj.name.substring(obj.name.lastIndexOf('_')+1);
    resp_preg=obj.value;

 
    var id_carita=id_respuesta.replace("respuesta", "imagen");
    var id_pregunta_next="#pregunta_"+codNext;
    var id_respuesta_next="#respuesta_"+codNext;
    
    if (obj.value==re) {
        
        $(id_carita).attr('src', '../css/images/ok.png')

        if (tipoNext=="SELECCION") {
            $(id_respuesta_next).val('NO APLICA');
            resp_next="NO APLICA";
        }

    } else {
        $(id_carita).attr('src', '../css/images/ok.png')

        if (tipoNext=="SELECCION") {
            $(id_respuesta_next).val("NO APLICA");
            resp_next="NO APLICA";
        }

    }

    //
    // Grabar la respuesta dada por el usuario en variables de sesion
    //
    
    $.ajax({
        type : 'POST',
        url : "../ajax/grabarRespuesta.php",
        dataType : 'html',
        data: {
            num_ot: num_ot,
            cod_preg:  cod_preg,
            tipo_preg: tipoPreg,
            resp_preg: resp_preg,
            text_resp: resp_preg,
            resp_esp: re,
            cod_next: codNext,
            resp_next: resp_next,
            tipo_next: tipoNext
        },
        success : function(data){
            contestada(true);

            if (data == "FIRMA") {
                mostrarFirma();
            } else {
                showPregunta();
            }

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al guardar la respuesta. Intente de nuevo []').show(500);



        }
    });
    
    $('#waiting2').hide();


}

/**
 *Marcar la fila con un color de background cuando ha sido contestada
*/

function onChangeComboBox(obj, tipoPreg, re, tipoNext, codNext, num_ot, pa){

    id_respuesta="#"+obj.name
    
    $('#waiting2').show();
    
    cod_preg=obj.name.substring(obj.name.lastIndexOf('_')+1);
    var resp = obj.options[obj.selectedIndex].value;

    var id_carita=id_respuesta.replace("respuesta", "imagen");
    //$(id_carita).attr('src', '../css/images/triste.png')
    $(id_carita).attr('src', '../css/images/ok.png')
    
    if (resp!="NO APLICA") {
        $(id_respuesta).removeClass().addClass('con-respuesta');
    } else {
        $(id_respuesta).removeClass().addClass('sin-respuesta');
        $('#divSiguientePreg').hide();
        $('#waiting2').hide();
        $(id_carita).attr('src', './css/images/sinrespuesta.jpg')
        return
    }

    //
    // Grabar la respuesta dada por el usuario en variables de sesion
    //

    $.ajax({
        type : 'POST',
        url : "../ajax/grabarRespuesta.php",
        dataType : 'html',
        data: {
            num_ot: num_ot,
            cod_preg:  cod_preg,
            tipo_preg: tipoPreg,
            resp_preg: resp,
            text_resp: obj.options[obj.selectedIndex].text,
            resp_esp: re,
            cod_next: codNext,
            resp_next: "_NULL",
            tipo_next: tipoNext
        },
        success : function(data){

            if (codNext!="LAST") {
                // Mostrar el boton de pregunta siguiente
                $('#divSiguientePreg').show();
               // $('#divAnteriorPreg').show();

            } else {
                
               $('#divSiguientePreg').hide();
                var mensajeUser = data.split("|");

                if (mensajeUser[1].substr(0, 1)=='F') {
                    $('#erroresEnc').html(mensajeUser[1].substring(2) );
                    $('#erroresEnc').show();
                    $('#divGrabarEnc').show();
                } else {
                   // alert ($('#num_ot').val());
                }


                $('#message').html(mensajeUser[0]);
                $('#message').show();
                $('#message').removeClass().addClass('success');


            }

            contestada(true);

            if (data == "FIRMA") {
                mostrarFirma();
            } else {
                showPregunta();
            }

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al guardar la respueesta. Intente de nuevo []').show(500);



        }
    });

    $('#waiting2').hide();

   


}

function getBacteriologas() {


    $('#waiting').show();

    $.ajax({
        type : 'POST',
        url : "../ajax/getBacteriologas.php",
        dataType : 'html',
        data: {
                            
        },
        success : function(data){

            $('#waiting').hide();
            $('#detalleResp').html(data);
            $('#detalleResp').show();
           
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
            $('#detalleResp').hide();

        }
    });

    return false;
}


/*
     *  Busca los datos del donante y bacteriologa responsable de la encuesta y
     *  los muestra en pantalla
     */

function showDatosDonante() {
 

    $.ajax({
        type : 'POST',
        url : "../ajax/showDatosDonante.php",
        dataType : 'html',
        data: {
            num_ot :  $('#num_ot').val()
        },
        success : function(data){

            $('#detalleDonante').html(data);
            $('#detalleDonante').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeIn(1000);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [getDatosEncuesta]').show(500);
            $('#detalleDonante').hide();

        }
    });


    return false;
}


/*
 * Mostrar las preguntas de la encuesta
 */

function showPreguntaEncuesta() {


    $.ajax({
        type : 'POST',
        url : "../ajax/configEncuesta.php",
        dataType : 'html',
        data: {
            num_ot:  $('#num_ot').val(),
            cod_bact: $('#bacteriologa').val(),
            nom_bact: $('#bacteriologa :selected').text()
        },
        success : function(data){

            // -------------------------------------------------------------------
            // Como armo la encuesta nuevamente, ahora si muestre las preguntas
            // con sus respuestas posibles
            // -------------------------------------------------------------------
            
            $.ajax({
                type : 'POST',
                url : "../ajax/showPregunta.php",
                dataType : 'html',
                data: {

                },
                success : function(data){

                    $('#detallePregunta').html(data);
                    contestada(false);

                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [showPreguntaEncuesta()]').show(500);
                    $('#detallePregunta').hide();

                }
            });


        //$('#iphoneCheckBox').iphoneStyle({ checkedLabel: 'Mi Respuesta es SI', uncheckedLabel: 'Mi Respuesta es NO' });

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [#showPreguntaEncuesta()]').show(500);
            $('#detalleDonante').hide();


        }
    });

    return false;
}


/*
 * Configurar las preguntas de la encuesta
 */

function configEncuesta() {


    $.ajax({
        type : 'POST',
        url : "../ajax/configEncuesta.php",
        dataType : 'html',
        data: {
            num_ot: $('#num_ot').val(),
            cod_bact: $('#bacteriologa').val(),
            nom_bact: $('#bacteriologa :selected').text()
        },
        success : function(data){

            // -------------------------------------------------------------------
            // Como armo la encuesta nuevamente, ahora si muestre las preguntas
            // con sus respuestas posibles
            // -------------------------------------------------------------------

            $.ajax({
                type : 'POST',
                url : "../ajax/showPregunta.php",
                dataType : 'html',
                data: {

                },
                success : function(data){


                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [configEncuesta]').show(500);
                    $('#detallePregunta').hide();

                }
            });


        //$('#iphoneCheckBox').iphoneStyle({ checkedLabel: 'Mi Respuesta es SI', uncheckedLabel: 'Mi Respuesta es NO' });

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#waiting').hide();
            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [#configEncuesta]').show(500);
            $('#detalleDonante').hide();


        }
    });

   
    return false;
}




/*
 * Configurar las preguntas de la encuesta
 */

function showPregunta(go) {

    // -------------------------------------------------------------------
    // Como armo la encuesta nuevamente, ahora si muestre las preguntas
    // con sus respuestas posibles
    // -------------------------------------------------------------------

        $.ajax({
            type : 'POST',
            url : "../ajax/showPregunta.php",
            dataType : 'html',
            data: {
                go: go,
                num_ot :  $('#num_ot').val()
            },
            success : function(data){

                if (data == "FIRMA" ) {
                    mostrarFirma()
                } else {
                    $('#detallePregunta').html(data);
                    contestada(false);
                }

            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                $('#waiting').hide();
                $('#message').fadeOut(400);
                $('#message').fadeIn(400);
                $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [getDatosEncuesta]').show(500);
                $('#detallePregunta').hide();

            }
        });

    return false;
}


function showPreguntaAnterior() {

    // -------------------------------------------------------------------
    // Como armo la encuesta nuevamente, ahora si muestre las preguntas
    // con sus respuestas posibles
    // -------------------------------------------------------------------


    $.ajax({
        type : 'POST',
        url : "../ajax/showPreguntaAnt.php",
        dataType : 'html',
        data: {
            num_ot :  $('#num_ot').val()
        },
        success : function(data){

            $('#detallePregunta').html(data);
            $("#divMensaje").html("Por favor despues de haber firmado, presione el bot&oacute;n <strong>Revisar Respuestas</strong>");
            contestada(false)
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al buscar la pregunta Anterior. Informe a sistemas').show(500);



        }
    });


    return false;
}


/*
 * Mostrar las preguntas de la encuesta
 */

function showRespuestas() {


    // -------------------------------------------------------------------
    // Como armo la encuesta nuevamente, ahora si muestre las preguntas
    // con sus respuestas posibles
    // -------------------------------------------------------------------

    $.ajax({
        type : 'POST',
        url : "../ajax/showRespuestas.php",
        dataType : 'html',
        data: {

        },
        success : function(data){

            $('#detallePregunta').html(data);
            $('#detallePregunta').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#message').fadeOut(400);
            $('#message').fadeIn(400);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [mostrarRespuestas]').show(500);
            $('#detallePregunta').hide();

        }
    });


    return false;
}



// ----------------------------------------------------------------------------------------------
// Codigo a realizar cuando se hace clic en el boton NUEVA Encuesta
// ----------------------------------------------------------------------------------------------


function nuevaEncuesta() {

     
    if (confirm('Esta seguro comenzar una nueva encuesta?')) {

        document.forms[0].action='../apl/login.php';
        document.forms[0].submit();
        

    }

}

function contestada(answered, pregAnt) {

    $('#divSiguientePreg').show();
    $('#divAnteriorPreg').show();
    $('#divReiniciarEnc').show();
    $("#divMensaje").hide();


    if (answered) {

        //$('#grabarEnc2').removeAttr("disabled");
        $('#siguientePreg').removeAttr("disabled");

    } else {

        $('#siguientePreg').attr("disabled", "disabled");
        //$('#grabarEnc2').attr("disabled", "disabled");

    }

    $("#divRevisarResp").hide();
    $("#divBorrarFirma").hide();

    $("#detallePregunta").show();
    $("#detalleRespuestas").hide();
    $("#detalleFirma").hide();


}


function mostrarFirma() {

    $("#det_encuesta").attr("action", "../apl/firmar.php")
    $('#det_encuesta').submit();

}


function reiniciarEncuesta()  {

    if (confirm('Realmente quiere reiniciar la encuesta? (requiere llamar a la auxiliar)')) {

        $('#divSiguientePreg').hide();
        $('#divAnteriorPreg').hide();

        $('#divLogin').show();
        $('#reiniciarEnc').hide();

        $('#usuario').focus();
        $('#usuario').select();

        if (  ($('#revisarResp').is(":visible")) ) {
            $('#borrarEncuesta').hide();
            $('#revisarResp').hide();
            enFirma=true;
        } else {
            enFirma=false;
        }

        if (enRevisar) {
            $("#revisarResp").hide();
            $('#divBorrarFirma').hide();
            $('#divSiguientePreg').hide();
            $('#grabarEnc2').hide();
        }

    } else {
        $('#divSiguientePreg').show();
        $('#divAnteriorPreg').show();

        $('#divLogin').hide();
        $('#reiniciarEnc').show();




    }
}



function empezarEncuesta() {
    // alert ($('#bacteriologa').val() + " " +$('#bacteriologa option:selected').text());
    $.ajax({
        type : 'POST',
        url : "../ajax/configEncuesta.php",
        dataType : 'html',
        data: {
            num_ot :  $('#num_ot').val(),
            cod_bact: $('#bacteriologa').val(),
            nom_bact: $('#bacteriologa option:selected').text()
        },
        success : function(data){

            $('#encuesta').submit(); // hacia: det_encuesta.php

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            $('#message').fadeIn(1000);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [#login.clic]').show(500);
            $('#detalleDonante').hide();


        }
    });
    showPregunta(0)
}



function grabarEncuesta4D() {

    // Si graba la firma exitosamente proceda a grabar la encuesta

        $('#erroresEnc').fadeOut(1000);

        $.ajax({
            type:'POST',
            url:"../ajax/grabarEncuesta4D.php",
            dataType:'html',
            data:{
                num_ot:$('#num_ot').val(),
                encAceptar:$('#encAceptar').val(),
                encComentarios:$('#encComentarios').val(),
                encEstado:$('#encEstado').val()
            },
            success:function (data) {

                switch (data.substring(0, 1)) {

                    case "F":
                        // F: Significa existio una falla en 4D que esta abajo el http server
                        // o haciendo backup

                        // Colocar fondo rojo (falla) al mensaje
                        $('#erroresEnc').html(data.substring(2));
                        $('#erroresEnc').removeClass().addClass('error');
                        break;

                    case "1": // 1: Significa que la encuesta se grabo en 4D
                        // Colocar fondo verde (exito) al mensaje
                        $('#erroresEnc').html(data.substring(2));
                        $('#erroresEnc').removeClass().addClass('success');

                        // Ocultar el boton Grabar encuesta
                        $('#divGrabarEnc').hide();

                        // Mostrar el boton de nueva encuesta
                        $('#divNuevaEnc').show();

                        // Ocultar un posible aceptar condicional
                        $('#comentarios').hide();


                        break;

                    case "0": // 0: Significa que existio algun error en 4D al grabar
                        // Colocar fondo rojo (falla) al mensaje
                        $('#erroresEnc').removeClass().addClass('error');
                        break;
                }

                // Mostrar el mensaje de estado
                $('#erroresEnc').fadeIn(1000);
                $('#waiting2').hide(1000);


            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {

                $('#erroresEnc').fadeIn(1000);
                $('#erroresEnc').removeClass().addClass('error').text('Error al grabar la encuesta. Intente de nuevo [#grabarEnc.clic]').show(500);
                $('#waiting2').hide(1000);

            }
        }); // Ajax grabarEncuesta


}
function llenarGenero(){
	
}
function grabar4D() {


    $.ajax({
        type : 'POST',
        url : "../ajax/grabarfirma4D.php",
        dataType : 'html',
        data: {
            num_ot:  $('#num_ot').val()
        },
        success : function(data){


            switch (data.substring(0, 1)) {

                case "K": // K: Significa que la firma se grabo en 4D. No hacer Nada
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('success');
                    grabarEncuesta4D()
                    break;


                case "F":
                    // F: Significa existio una falla en 4D que esta abajo el http server
                    // o haciendo backup
                    $('#erroresEnc').hide(400);
                    $('#erroresEnc').html(data.substring(2));

                    // Colocar fondo rojo (falla) al mensaje
                    $('#erroresEnc').removeClass().addClass('error');
                    break;



            }

            // Mostrar el mensaje de estado
            $('#erroresEnc').fadeIn(1000);
            $('#waiting2').hide(1000);


        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#erroresEnc').fadeIn(1000);
            $('#erroresEnc').removeClass().addClass('error').text('Error al grabar la Firma. Intente de nuevo [grabarFirma4D()]').show(500);
            $('#waiting2').hide(1000);
            return "F"
        }
    }); // Ajax grabarFirma4D


}