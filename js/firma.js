$(document).ready(

    function () {


        $('#revisarResp').click(function() {

            submitToRevisarEncuestas()

        });



    } // Ready funcion
); // Ready



function submitToRevisarEncuestas() {

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

                mostrarRespuestas()

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