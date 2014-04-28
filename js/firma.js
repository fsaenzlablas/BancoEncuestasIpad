
$(document).ready(

    function () {


        $('#revisarResp').click(function() {

//alert("al revisar");

            $resp = submitToRevisarEncuestas();
            if ($resp==false){
               // document.forms[0].action='../apl/firmar.php';
                //document.forms[0].submit();
            }
        });



    } // Ready funcion
); // Ready



function submitToRevisarEncuestas() {


$('#divMensaje').fadeOut(800);
$('#divMensaje').removeClass().addClass('error').text('Grabando la Firma del donante').show(500);
$('#divMensaje').fadeIn(800);


//alert("revisando respuestas");
    $.ajax({
        type : 'POST',
        url : "../ajax/validarLongFirma.php",
        dataType : 'html',
        data: {
            num_ot: $('#num_ot').val(),
            firma_donante: canvas.toDataURL("image/png")
        },
        success : function(data){

            if (data == "OK") {
                //6 de marzo 2014 , ir a ingresar otro donante

               // alert($('#tipoEncuesta').val());

                if ($('#tipoEncuesta').val()=="1") {//autoexclusion post donacion.
                    //Hay que grabar las respuestas 
                    grabarFirmayEncuestaMysql();
                }else{
                   grabarFirmayEncuestaMysql();//mostrarRespuestas() 
                }
                
                //mostrarRespuestas()

            } else {
                $('#divMensaje').hide();
                $('#divMensaje').removeClass().addClass('error').text('La firma es demasiado corta para ser considerada correcta. por favor firme de nuevo').show(1000)
                $('#divMensaje').fadeIn(800);
                return false;
            }

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#divMensaje').fadeOut(800);
            $('#divMensaje').removeClass().addClass('error').text('Error al validar la firma la encuesta. Intente de nuevo [submitToRevisarEncuestas()]').show(500);
            $('#divMensaje').fadeIn(800);

            return false;
        }
    });  // Ajax grabarEncuesta


}

function mostrarRespuestas() {


    $.ajax({
        type : 'POST',
        url : "../apl/revisarRespuestas.php",
        dataType : 'html',
        data: {
            num_ot: $('#num_ot').val(),
            firma_donante: canvas.toDataURL("image/png")
        },
        success : function(data){
            //$('#divMensaje').removeClass().addClass('success').text('Se envio correctamente la firma la encuesta.').show(1000)
            $('#firma_donante').val(canvas.toDataURL("image/png"));
            $('#signatureForm').submit();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#divMensaje').fadeOut(800);
            $('#divMensaje').removeClass().addClass('error').text('Error al enviar la firma de la encuesta. Intente de nuevo [#revisarResp.clic]').show(500);
            $('#divMensaje').fadeIn(800);


        }
    });  // Ajax grabarEncuesta



}








function grabarFirmayEncuestaMysql() {


$('#erroresEnc').hide();
$('#erroresEnc').html("Grabando Firma ...");
$('#erroresEnc').show(100);

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
                //alert("grabada la firma");
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('success');
                    grabarEncuestaEnFirmaMySQL();
                    //grabarEncuesta4DEnFirma();
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





 


function grabarEncuestaEnFirmaMySQL() {


    $.ajax({
        type:'POST',
        url:"../ajax/grabarEncuestaMySQL.php",
        dataType:'html',
        data:{
            num_ot:$('#num_ot').val()
        },
        success:function (data) {
            $('#erroresEnc').html("");
            $('#erroresEnc').hide();

            switch (data.substring(0, 1)) {

                case "F":

                    // F: Significa existio una falla en MySQL que esta abajo o no disponible

                    // Colocar fondo rojo (falla) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('error');
                    $('#erroresEnc').hide();
                    $('#erroresEnc').fadeIn(1000);

                    // Mostrar el mensaje de Error
                    $('#erroresEnc').show();
                    alert("Comuniquese con la auxiliar, Existio un error al grabar la encuesta!.");
                    break;

                case "1": // 0: Significa que la encuesta se grabo Exitosamente en MysQL

                    // Colocar fondo verde (exito) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('success');
                    $('#erroresEnc').show();

                    // Ocultar el boton Grabar encuesta
                    $('#grabarEnc').hide();

                    // Mostrar el boton de nueva encuesta
                    $('#divNuevaEnc').show();

                    grabarEncuesta4DEnFirma();

                    break;

                default:
                    // Colocar fondo rojo (falla) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('error');
                    $('#erroresEnc').hide();
                    $('#erroresEnc').fadeIn(1000);

                    // Mostrar el mensaje de Error
                    $('#erroresEnc').show();
                    alert("Comuniquese con la auxiliar, Existio un error al grabar la encuesta!.");
            }


        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {

            $('#erroresEnc').hide();
            $('#erroresEnc').fadeIn(1000);
            $('#erroresEnc').removeClass().addClass('error').text('Error al grabar la encuesta. Avise a la Auxiliar de enfermeria[#grabarEnc.clic]').show(500);


        }
    });  // Ajax grabarEncuestaMySQL
}







function grabarEncuesta4DEnFirma() {

    // Si graba la firma exitosamente proceda a grabar la encuesta
$('#erroresEnc').hide();
$('#erroresEnc').html("Grabando Encuesta ...");
$('#erroresEnc').show(500);

        $('#erroresEnc').fadeOut(1000);

        $.ajax({
            type:'POST',
            url:"../ajax/grabarEncuesta4D.php",
            dataType:'html',
            data:{
                num_ot:$('#num_ot').val(),
                encAceptar:"1",//$('#encAceptar').val(),
                encComentarios:"",//$('#encComentarios').val(),
                encEstado:"OK"//, $('#encEstado').val()
            },
            success:function (data) {
 //console.log("al grabar encuesta 4d "+vDonanteEncuesta.usuario+" "+data);

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


                        //if (vDonanteEncuesta.usuario =="donante"){
//alert("Grabada al encuesta");
$('#num_ot').value = "";//inicializar el numero de la orden de trabajo .
 //                          document.forms[0].action='../apl/menuDonante.php';//+"?num_ot="+vNumOT;
                            document.forms[0].action='../../dona.html';//+"?num_ot="+vNumOT;
                            document.forms[0].submit();
 
                        //}


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