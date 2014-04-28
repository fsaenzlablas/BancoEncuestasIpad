$(document).ready(

    function () {

        $('#divReiniciarEnc').show();

        $('#reiniciarEnc').click(function () {
            reiniciarEncuesta()
        });


        $('#cancelarLogin').click(function () {

            cancelarLogin();

        });

        $('#grabarEnc').click(function () {

            grabarEncuesta();

        });

        $('#anteriorPreg').click(function () {

            showPreguntaAnterior();

        });


        $('#login').click(function () {

            validarLogin();

        });


        $('#terminarEnc').click(function () {

            terminarEncuesta();

        });


        $('#validarEnc').click(function () {

            validarEncuesta();

        });


        $('#cancelarValidar').click(function () {

            cancelarValidar();

        });


        $('#loginValidar').click(function () {

            validarLogin2();

        });

        $('#nuevaEnc').click(function () {

            if (confirm('Esta seguro de comenzar una nueva encuesta?')) {
                document.forms[0].action='../../dona.html';//'../apl/login.php';
                document.forms[0].submit();
            }

        });



        $('#nuevoDonante').click(function () {

            if (confirm('Esta seguro de ingresar demograficos')) {

                document.forms[0].action='../apl/FormularioCompleto.php';
                document.forms[0].submit();

              }

        });

       $('#nuevoEncPosDonacion').click(function () {

            if (confirm('Esta seguro de llenar otra encuesta pos donacion?')) {
$('#tipoEncuestaDemo').val("1");
                document.forms[0].action='../apl/Encuesta.php';
                document.forms[0].submit();

              }

        });


       $('#nuevaEncuesta').click(function () {

            if (confirm('Esta seguro de llenar otra encuesta?')) {
// 10 de marzo , aqui se pueden grabar las respuestas .

$('#tipoEncuestaDemo').val("0");
                document.forms[0].action='../../dona.html';//'../apl/Encuesta.php';
                document.forms[0].submit();

              }

        });





    } // Ready funcion
); // Ready


function reiniciarEncuesta() {

    if (confirm('Realmente quiere reiniciar la encuesta? (requiere llamar a la auxiliar)')) {

        $('#divButtons').hide();
        $('#divLogin').show();
        $('#reiniciarEnc').hide();
        $('#usuario').focus();
        $('#usuario').select();

    }

    return false;

}

function cancelarLogin() {

    $('#divButtons').show();
    $('#divLogin').hide();
    $('#reiniciarEnc').show();

}

function cancelarValidar() {

    $('#divButtons').show();
    $('#divLoginValidar').hide();
    $('#validarEnc').show();

}
function grabarEncuesta() {


    var rta = "NA";

    //save our canvas to a data URL and open in a new browser window
    if (!confirm("Esta Seguro(a) que sus respuestas son correctas?")) {
        return;
    }

    grabarEncuestaMySQL();

}


function grabarEncuestaMySQL() {


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


function showPreguntaAnterior() {

    $("#revisarRespuestas").attr("method", "POST");
    $("#revisarRespuestas").attr("action", "../apl/det_encuesta.php");
    $('#revisarRespuestas').submit();

    return true;
}



function validarLogin() {


        $('#erroresEnc').hide();
        $('#erroresEnc').html("Validando acceso ...");
        $('#erroresEnc').show(500);

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

                        configAndGo();
                        break;

                    case '2': // Login no exitoso

                        $('#erroresEnc').hide();
                        $('#password').val("")
                        $('#erroresEnc').html(data.substring(2));
                        $('#erroresEnc').show();
                        break;
                }

            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {

                $('#erroresEnc').fadeIn(1000);
                $('#erroresEnc').removeClass().addClass('error').text('Error al validar usuario. Informe a sistemas').show(500);

            }
        });


}


function validarLogin2() {



        $('#erroresEnc').hide();
        $('#erroresEnc').html("Validando acceso ...");
        $('#erroresEnc').show(500);

        $.ajax({
            type : 'POST',
            url : "../ajax/validar_usuario2.php",
            dataType : 'html',
            data: {
                num_ot: $('#num_ot').val(),
                usuario: $('#usuarioValidar').val(),
                password: $('#passwordValidar').val()
            },
            success : function(data){
                switch (data.substring(0,1)) {
                    case '1' : // Login exitoso

                        $('#erroresEnc').hide();
                        $('#passwordValidar').val("")

                        $('#revisarRespuestas').attr('action', '../apl/validarEncuesta.php')
                        $('#revisarRespuestas').submit();

                        break;

                    case '2': // Login no exitoso


                        $('#erroresEnc').hide();
                        $('#passwordValidar').val("")
                        $('#erroresEnc').removeClass().addClass('error').text(data.substring(2)).show(500);
                        $('#erroresEnc').show();
                        break;
                }

            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {

                $('#erroresEnc').fadeIn(1000);
                $('#erroresEnc').removeClass().addClass('error').text('Error al validar usuario. Informe a sistemas. validarLogin2()').show(500);

            }
        });



}


function configAndGo() {

    $.ajax({
        type : 'POST',
        url : "../ajax/configEncuesta.php",
        dataType : 'html',
        data: {
            num_ot :  $('#num_ot').val()
        },
        success : function(data){

            showPrimeraPregunta()

        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#erroresEnc').fadeIn(1000);
            $('#erroresEnc').removeClass().addClass('error').text('Error al configurar encuesta la busqueda. Informe a sistemas [validarLogin()]').show(500);

        }
    });

}


function showPrimeraPregunta() {

    var primera_preg = $("#primera_preg").val();
    $("#go").val(primera_preg);
    $("#revisarRespuestas").attr("method", "POST");
    $("#revisarRespuestas").attr("action", "../apl/det_encuesta.php");
    $('#revisarRespuestas').submit();

    return true;
}


function terminarEncuesta() {

   grabarEncuestaMySQL()
   return true;
}



/*
 * Gabar la encuesta en 4D
 */


function grabarEncuestaMySQL () {


    $.ajax({
        type : 'POST',
        url : "../ajax/grabarEncuestaMySQL.php",
        dataType : 'html',
        data: {
            num_ot: $('#num_ot').val()
        },
        success : function(data){
            $('#erroresEnc').html("");
            $('#erroresEnc').hide();

            switch (data.substring(0,1)) {

                case "F":

                    // F: Significa existio una falla en MySQL que esta abajo o no disponible

                    // Colocar fondo rojo (falla) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('error');
                    $('#erroresEnc').hide();
                    $('#erroresEnc').fadeIn(1000);

                    // Mostrar el mensaje de Error
                    $('#erroresEnc').show();
                    alert ("Comuniquese con la auxiliar, Existio un error al grabar la encuesta!.");
                    break;

                case "1": // 0: Significa que la encuesta se grabo Exitosamente en MysQL

                    // Colocar fondo verde (exito) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('success');
                    $('#erroresEnc').show();

                    // Ocultar el boton terminar  encuesta y los botones de reiniciar y Anterior
                    $('#terminarEnc').hide();
                    $('#divReiniciarEnc').hide();
                    $('#divAnteriorPreg').hide();
                    $('#divNuevaEnc').show();

                    // Mostrar los botones de validar encuesta
                    $('#divValidarEnc').show();

                    break;

                default:
                    // Colocar fondo rojo (falla) al mensaje
                    $('#erroresEnc').html(data.substring(2));
                    $('#erroresEnc').removeClass().addClass('error');
                    $('#erroresEnc').hide();
                    $('#erroresEnc').fadeIn(1000);

                    // Mostrar el mensaje de Error
                    $('#erroresEnc').show();
                    alert ("Comuniquese con la auxiliar, Existio un error al grabar la encuesta!.");
            }



        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {

            $('#erroresEnc').hide();
            $('#erroresEnc').fadeIn(1000);
            $('#erroresEnc').removeClass().addClass('error').text('Error al grabar la encuesta. Avise a la Auxiliar de enfermeria [grabarEncuestaMySQL()]').show(500);


        }
    });  // Ajax grabarEncuesta
}



function validarEncuesta() {

    $('#divValidarEnc').show();
    $('#validarEnc').hide();

    $('#divButtons').hide();
    $('#divValidarEnc').show();
    $('#divLoginValidar').show();

    $('#usuarioValidar').focus();
    $('#usuarioValidar').select();


    return false;

}


function irADemograficos() {

     
    if (confirm('Esta seguro ingresar demograficos?')) {

        document.forms[0].action='../apl/FormularioCompleto.php';
        document.forms[0].submit();
        

    }

}

function irAEncuesta() {

     
    if (confirm('Esta seguro de llenar otra encuesta?')) {
       // $('#tipoEncuesta').val("0");
        tipoencuesta.value = "0";
        document.forms[0].action='../apl/Encuesta.php';
        document.forms[0].submit();
        

    }

}

function irAEncuestaPosDonacion() {

     
    if (confirm('Esta seguro de llenar la encuesta pos donacion?')) {
        //$('#tipoEncuesta').val("1");
        tipoencuesta.value = "1";
        document.forms[0].action='../apl/Encuesta.php';
        document.forms[0].submit();
        

    }

}