$(document).ready(

    function(){
  

        // ----------------------------------------------------------------------
        // Responder al evento click de busqueda del donante, por su numero
        // consecutivo de donacion
        // ----------------------------------------------------------------------

        donante=$('#num_ot').val();
        $('#num_ot').focus();
        
        
        $('#PageRefresh').click(function() {

            location.reload();

        });


        // -----
        
        $("#bconsultar").click(

            
            function(){

                $('#num_ot').val($('#num_ot').val().toUpperCase())
                
                
                $('#waiting').show();
                $('#detalleDonante').hide();
                $('#detalleDonante').html('');
                
                $.ajax({
                    type : 'POST',
                    url : "../ajax/getEncuesta.php",
                    dataType : 'html',
                    data: {
                        donante: $('#num_ot').val()
                    },
                    success : function(data){

                        $('#waiting').hide();
                        
                        switch (data.substring(0,1)) {

                            case "0": // Indica que el numero de OT Donante no existe o ya se respondio y valido
                                jAlert(data.substring(2), 'Error');

                                $('#detalleDonante').hide();
                                $('#bacteriologas').hide();
                                $('#divVerEnc').hide();
                           

                                $('#num_ot').focus();
                                $('#num_ot').select();
                                break;

                            case "1": // Indica que la encuesta NO esta contestada
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#bacteriologas').show();
                           
                                $('#divVerEnc').hide();

                                break;

                            case "2": // Indica que la encuesta ESTA contestada pero NO esta validada
                                
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#Responsable').hide();
                                $('#divVerEnc').show();

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
        // -----

 
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
                        donante: $('#num_ot').val()
                    },
                    success : function(data){

                        $('#waiting').hide();
                        
                        switch (data.substring(0,1)) {

                            case "0": // Indica que el numero de OT Donante no existe o ya se respondio y valido
                                jAlert(data.substring(2), 'Error');

                                $('#detalleDonante').hide();
                                $('#bacteriologas').hide();
                                $('#divValidarEnc').hide();
                            

                                $('#num_ot').focus();
                                $('#num_ot').select();
                                break;

                            case "1": // Indica que la encuesta NO esta contestada
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#bacteriologas').show();
                            
                                $('#divValidarEnc').hide();

                                break;

                            case "2": // Indica que la encuesta ESTA contestada pero NO esta validada
                                
                                $('#detalleDonante').html(data.substring(2));
                                $('#detalleDonante').show();
                                $('#Responsable').hide();
                            
                                $('#divValidarEnc').show();

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
        // Codigo a realizar cuando se hace clic en el boton VER Encuesta
        // ----------------------------------------------------------------------------------------------

        $("#verEncuesta").click(
            function(){
                $('#consultar').attr('action', '../apl/mostrarEncuesta.php')
                $('#consultar').submit();
                return false;
            }

        );


     $("#nuevaEnc").click(
            function(){
                $('#mostrarEnc').attr('action', '../apl/consultar.php')
                $('#mostrarEnc').submit();
                return false;
            }

       );
      

        



    } // Ready funcion
    ); // Ready





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

            $('#detalleEncuesta').html(data);
            $('#detalleEncuesta').show();

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
           
            $('#message').fadeIn(1000);
            $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas [mostrarRespuestas]').show(500);
            $('#detalleEncuesta').hide();

        }
    });
 

    return false;
}

