    function Donante(){
      this.orden = "";
      this.fecha = "";

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
      this.componentes = "";
    this.otcodBarras = "";
    this.impBarras = "";


      this.usuario = "";
      this.peso =0;
      this.fcardiaca =0;
      this.pasistolica =0;
      this.padiastolica =0;
      this.temperatura =0;
      this.hemoglobina =0;
      this.hematocrito =0;

      this.enfermerafisico="";

      this.gsanguineo="";
      this.rh="";
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


    var infoEncuesta2 ="";

    var vDonante = new Donante();
    var vArrBacteriologas = [];//new Bacteriologa();
    var vArrComponentes = [];
    var vArrComponentesSeleccionados = [];

    var actualizarEdad = 1;
    var vMostrarEFisico = 1; //ocultar  campos del examen fisico


    var malasEncuesta = 0;
    var cambiadosComponentes = 0;

    var vEsDonacionHoy = false;

    var vCampoFisico = ""; //sin ningun campo seleccionado

    $(document).ready(



        function(){

        getBacteriologasMovil() ;
        getEnfermerasMovil();
    //alert("esperar");

        $codBact = $('#txtCodBacteriologa').val();//viene de getMenuDonante.
      //  alert($codBact );
      //wsItxtCodBacteriologa
    vDonante.bacteriologa = $codBact ;

    $nomBact = fLeerVariableSesion('nombrebacteriologa');
    console.log("Nombre bact "+$nomBact);
      //$codBact =
               $nomBact= "<div id='idNomBacteriologa'><label id ='idNomBacteriologa'>"+$nomBact+"</label></div>";
                $('#idNomBacteriologa').hide();
            $('#idNomBacteriologa').html($nomBact);
            $('#idNomBacteriologa').show()  ;

      //alert($codBact);
      if ($codBact!=""){
      //  alert("<"+$codBact+">");
        $posicionBact = fBuscarXCodigoBact($codBact);
        fActualizarNomBact($posicionBact);


      }//else{alert("sin bact");}



        getBcoEps();
        fGet100AAAA();
        getBcoCategorias();
        getBcoReacciones();
        fLlenarMeses();
        fLlenarInfoPopups();

        //fGetInfoComponentes();

        $vUsuarioEncuesta = $('#usuarioencuesta').val();//viene de getMenuDonante.
         console.log("viende de la pagina menu "+$('#bacteriologa').val());

        switch($vUsuarioEncuesta){
          case "donante" :
            vMostrarEFisico =0;
            vEstadoDem = ocultarMostrarDemograficos(1);
            vEstadoBac = ocultarMostrarBacteriologa(0);

            break;
          default ://si es una bacteriologa oculta todo hasta que digite el codigo de la bacteriologa .

          //ya la clave se digito

                  vEstadoDem = ocultarMostrarDemograficos(1);
            vEstadoBac = ocultarMostrarBacteriologa(0);

            //vEstadoDem = ocultarMostrarDemograficos(0);
            //vEstadoBac = ocultarMostrarBacteriologa(1);
            vMostrarEFisico = 0;
            break;

        }
        vDonante.usuario = $vUsuarioEncuesta;

          vMostrarEFisico2=ocultarExamenFisico(vMostrarEFisico);

    //alert($vUsuarioEncuesta+" LA CEDULA "+$('#cc_paciente').val());

          //Traer la informacion de la cedula digitada .
          if ($('#cc_paciente').val() != ""){

            vDonante.cedula = $('#cc_paciente').val() ;
            $vSoloLectura = false;

            if ($vUsuarioEncuesta=="donante") {
              console.log(vDonante.cedula+" usuario donate ");
              actualizarCampoTextoSoloLectura($('#cc_paciente').val(),'txtCedula');
              $vSoloLectura = true;
            }else{

              actualizarCampoTexto($('#cc_paciente').val(),'txtCedula','text');
            }



            var result =getInfoDonante();

          }

          $('idExamenFisico').hide();


      vHoy = new Date();
      var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-18,0,-1);
      //actualizarCampoFecha(fechaStr,'txtFechaNat');

    if (vDonante.usuario=="donante"){
      //alert(vDonante.usuario);
      $('#idInfoBact').hide();
      $('#idInfoOTs').hide();

    }else{
      $('#idInfoBact').show();
      $('#idInfoOTs').show();

    }

    if (vDonante.bacteriologa!=""){
    //  $.mobile.changePage('FormularioCompleto.php#paginaClaveUsuario','slide');
    //  $.mobile.changePage('#pagina1','slide');

    }



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
        vDonante.nombres = vDonante.nombres.toUpperCase();
        console.log("en mayuscula"+vDonante.nombres);
        actualizarCampoTexto(vDonante.nombres,'txtNombre','text');

      });




      $('#txtApellido1').change(function(e) {
        vDonante.apellido1 = e.target.value;
        vDonante.apellido1 = vDonante.apellido1.toUpperCase();
        actualizarCampoTexto(vDonante.apellido1,'txtApellido1','text');

      });


      $('#txtApellido2').change(function(e) {
        vDonante.apellido2 = e.target.value;
        vDonante.apellido2 = vDonante.apellido2.toUpperCase();
        actualizarCampoTexto(vDonante.apellido2,'txtApellido2','text');

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


    $('#miEdadTeclado').change(function(e) {
        vEdadTeclado = parseInt(e.target.value);
        if (vDonante.edad!=vEdadTeclado){
          vDonante.edad = vEdadTeclado;
          vHoy = new Date();
          var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
          actualizarCampoFecha(fechaStr,'txtFechaNat');
                vDonante.fechanat = fechaStr;
                console.log(fechaStr);
        }
    });


    $('[id^="radio-Genero-"]').click(function(e){//Los botones de radio del genero empiezan con un id parecido
      vDonante.genero=e.target.value;
     }
     );

    $('[id^="radio-GS-"]').click(function(e){//Los botones de radio del grupo sanguineo empiezan con un id parecido
      vDonante.gsanguineo=e.target.value;
     }
     );

    $('[id^="radio-RH-"]').click(function(e){//Los botones de radio del rh empiezan con un id parecido
      vDonante.rh=e.target.value;
    //  alert(vDonante.rh);
     }
     );


       $("#miEdadTeclado").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [ 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                 // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    // TECLADO VIRTUAL
        $('#miEdadTeclado').click(function(){
          return;

              $('#n_keypad').fadeToggle('fast');
              if ((vDonante.edad==0)||(vDonante.edad==18)){
                $('#miEdadTeclado').val('');//empezar sin informacion.
              }else{
                $('#miEdadTeclado').val(vDonante.edad);//empezar con lo digitado

              }

          });
          $('.done').click(function(){
              $('#n_keypad').hide('fast');
              vEdadTeclado = parseInt($('#miEdadTeclado').val());

        if (vDonante.edad!=vEdadTeclado){
          vDonante.edad = vEdadTeclado;
          vHoy = new Date();
          var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
          actualizarCampoFecha(fechaStr,'txtFechaNat');
                vDonante.fechanat = fechaStr;
                console.log(fechaStr);
        }


          });

          $('.cancelar').click(function(){
              $('#n_keypad').hide('fast');
              $('#miEdadTeclado').val(vDonante.edad);
          });


          $('.numero').click(function(){
            if (!isNaN($('#miEdadTeclado').val())) {
               if (parseInt($('#miEdadTeclado').val()) == 0) {
                 $('#miEdadTeclado').val($(this).text());
               } else {

                if ($('#miEdadTeclado').val().length <=1 ){
                  $('#miEdadTeclado').val($('#miEdadTeclado').val() + $(this).text());
                }

               }
            }
          });
          $('.neg').click(function(){
              if (!isNaN($('#miEdadTeclado').val()) && $('#miEdadTeclado').val().length > 0) {
                if (parseInt($('#miEdadTeclado').val()) > 18) {
                  $('#miEdadTeclado').val(parseInt($('#miEdadTeclado').val()) - 1);
                }
              }
          });
          $('.pos').click(function(){
              if (!isNaN($('#miEdadTeclado').val()) && $('#miEdadTeclado').val().length > 0) {
                if (parseInt($('#miEdadTeclado').val())<80){
                  $('#miEdadTeclado').val(parseInt($('#miEdadTeclado').val()) + 1);
                }

              }
          });
          $('.del').click(function(){
              $('#miEdadTeclado').val($('#miEdadTeclado').val().substring(0,$('#miEdadTeclado').val().length - 1));
          });
          $('.clear').click(function(){
              $('#miEdadTeclado').val('');
          });
          $('.zero').click(function(){
            if (!isNaN($('#miEdadTeclado').val())) {
              if (parseInt($('#miEdadTeclado').val()) != 0) {

                if ($('#miEdadTeclado').val().length <=1 ){
                  $('#miEdadTeclado').val($('#miEdadTeclado').val() + $(this).text());
                }




              }
            }
          });

    // FIN TECLADO VIRTUAL



    //Teclado virtual Fisico


          $('#miEFisicoTeclado').click(function(){
              $('#n_tecladoEFisico').fadeToggle('fast');
               $('#miEFisicoTeclado').val('');//empezar sin informacion.


          });

          $('.cVlrEFisico').click(function(e){
            vCampoFisico = e.target.id;
    var $nomCampoEFisico =e.target.id ;
    var $valorCampoEFisico = $('#'+e.target.id).val();

    $nomCampoEFisico= $nomCampoEFisico.replace('mi','');
    $nomCampoEFisico= $nomCampoEFisico.replace('Teclado','');
    //alert($nomCampoEFisico);
    $('#miLabelEFisicoTeclado').val($nomCampoEFisico);//titulo del campo

            //alert(vCampoFisico);
              $('#n_tecladoEFisico').fadeToggle('fast');
              if ($valorCampoEFisico==0){
                 $('#miEFisicoTeclado').val('');//empezar sin informacion.
              }else{
                 $('#miEFisicoTeclado').val($valorCampoEFisico);//empezar sin informacion.
              }


               $('#miEFisicoTeclado').show('fast');
                $('#miLabelEFisicoTeclado').show('fast');
        });



          $('.doneFisico').click(function(){
                     $('#miEFisicoTeclado').hide('fast');
            $('#'+vCampoFisico).val($('#miEFisicoTeclado').val() );

              $('#n_tecladoEFisico').hide('fast');
               $('#miLabelEFisicoTeclado').hide('fast');



    //alert($('#miEFisicoTeclado').val());


              var  vValorTeclado = $('#miEFisicoTeclado').val();//parseInt($('#miEFisicoTeclado').val());
             // alert(vValorTeclado);

              if (vCampoFisico=="miPesoTeclado"){
                vDonante.peso = vValorTeclado;
                var result =fEventoCambiarPeso();
              }else if (vCampoFisico=="miFCardiacaTeclado"){
                vDonante.fcardiaca =vValorTeclado;
                var result =fEventoCambiarFCardiaca();

              }else if (vCampoFisico=="miPASistolicaTeclado"){
                vDonante.pasistolica =vValorTeclado;
                var result = fEventoCambiarPSistolica();
              }else if (vCampoFisico=="miPADiastolicaTeclado"){
                vDonante.padiastolica =vValorTeclado;
                var result =fEventoCambiarPDiastolica();
              }else if (vCampoFisico=="miHemoglobinaTeclado"){
                vDonante.hemoglobina =vValorTeclado;
                var result = fEventoCambiarHemoglobina();
              }else if (vCampoFisico=="miHematocritoTeclado"){
                vDonante.hematocrito =vValorTeclado;
                var result =fEventoCambiarHematocrito();
              }else if (vCampoFisico=="miTemperaturaTeclado"){
                vDonante.temperatura =vValorTeclado;
                var result = fEventoCambiarTemperatura();
              }
    //alert($('.cVlrEFisico').val());

          });

          $('.cancelarFisico').click(function(){
                       $('#miEFisicoTeclado').hide('fast');

              $('#n_tecladoEFisico').hide('fast');
                $('#miLabelEFisicoTeclado').hide('fast');
          //  $('#miEFisicoTeclado').val(vDonante.edad);
          });

          $('.clearFisico').click(function(){
              $('#miEFisicoTeclado').val('');
          });


          $('.numeroFisico').click(function(){
            if (!isNaN($('#miEFisicoTeclado').val())) {
               if (parseInt($('#miEFisicoTeclado').val()) == 0) {
                 $('#miEFisicoTeclado').val($(this).text());
               } else {

                if ($('#miEFisicoTeclado').val().length <=3 ){
                  $('#miEFisicoTeclado').val($('#miEFisicoTeclado').val() + $(this).text());
                }

               }
            }
          });
          $('.negFisico').click(function(){
              if (!isNaN($('#miEFisicoTeclado').val()) && $('#miEFisicoTeclado').val().length > 0) {
                if (parseInt($('#miEFisicoTeclado').val()) > 0) {
                  $('#miEFisicoTeclado').val(parseInt($('#miEFisicoTeclado').val()) - 1);
                }
              }
          });
          $('.posFisico').click(function(){
              if (!isNaN($('#miEFisicoTeclado').val()) && $('#miEFisicoTeclado').val().length > 0) {
                //if (parseInt($('#miEFisicoTeclado').val())<80){
                  $('#miEFisicoTeclado').val(parseInt($('#miEFisicoTeclado').val()) + 1);
                //}

              }
          });
          $('.delFisico').click(function(){
              $('#miEFisicoTeclado').val($('#miEFisicoTeclado').val().substring(0,$('#miEFisicoTeclado').val().length - 1));
          });
          $('.decimalFisico').click(function(){//clearFisico
              $valCad = $('#miEFisicoTeclado').val();
              $posPunto = $valCad.indexOf(".");

    $valLabel = $('#miLabelEFisicoTeclado').val();

              if ($posPunto>=0){

              }else if (($valLabel=="Hemoglobina") ||($valLabel=="Hematocrito")|| ($valLabel=="Temperatura")){
                $('#miEFisicoTeclado').val($('#miEFisicoTeclado').val() + ".");
              }
              //$('#miEFisicoTeclado').val('');
          });
          $('.zeroFisico').click(function(){
            if (!isNaN($('#miEFisicoTeclado').val())) {
              if (parseInt($('#miEFisicoTeclado').val()) != 0) {

                if ($('#miEFisicoTeclado').val().length <=3 ){
                  $('#miEFisicoTeclado').val($('#miEFisicoTeclado').val() + $(this).text());
                }




              }
            }
          });

    //Fin teclado Virtual


    /*  $('#textarea_reaccion').change(function(e) {
        vDonante.reaccion = e.target.value;
      });*/

      $('#txtFechaNat').change(function(e) {
        var vHoy = new Date();
        vDonante.fechanat = e.target.value;
        var fecha = new Date(e.target.value);
    //    alert(e.target.value);
        vDonante.edad = vHoy.getFullYear()-fecha.getFullYear();
        console.log("la edad "+vDonante.edad );

        $vEdad = vDonante.edad;
      //  jAlert("la edad del paciente "+$vEdad , "Informaci&oacute;n");
        $vEdadUnidad = $vEdad % 10;
        $vEdad = $vEdad -$vEdadUnidad;

      //  actualizarPopUp($vEdad,'poPedad');
      //  actualizarPopUp($vEdadUnidad,'poPedadunidad');

      });



    function fBuscarXClave(clave,usuario){

       var i=0;
        var $posBact =-1;
        encontrado=0;

        while ((i<vArrBacteriologas.length)&&(encontrado==0)){
              if (clave==vArrBacteriologas[i].secreto){
                encontrado = 1;
                $posBact=i;
            }
            i++;
        }



      return $posBact;

    }


    function fBuscarXCodigoBact(codigo){

       var i=0;
        var $posBact =-1;
        encontrado=0;
    console.log("buscando");
        while ((i<vArrBacteriologas.length)&&(encontrado==0)){
              if (codigo==vArrBacteriologas[i].codigo){
                encontrado = 1;
                $posBact=i;
            }
            console.log(vArrBacteriologas[i].codigo+" == "+codigo);
            i++;
        }

    console.log("terminado "+$posBact);


      return $posBact;

    }


    function fActualizarNomBact(posicionBact){
    //  alert("posbact "+posicionBact);
      if (posicionBact>=0){
                codigoBact=vArrBacteriologas[posicionBact].codigo;
                vDonante.bacteriologa= vArrBacteriologas[posicionBact].codigo;
                vEstadoDem = ocultarMostrarDemograficos(1);//mostrar los datos que puede modificar una bacteriologa .
                vMostrarEFisico=ocultarExamenFisico(1);

                  txtCodBacteriologa.value = vArrBacteriologas[posicionBact].codigo;
    console.log("la bacteriologa "+vArrBacteriologas[posicionBact].nombre);
                $nomBact= "<div id='idNomBacteriologa'><label id ='idNomBacteriologa'>"+vArrBacteriologas[posicionBact].nombre+"</label></div>";
                $('#idNomBacteriologa').hide();
            $('#idNomBacteriologa').html($nomBact);
            $('#idNomBacteriologa').show()  ;
              // var result =seleccBacteriologa(vDonante.bacteriologa);

             $('#txtCodBacteriologa').hide();



      }
    }

      $('#txtCodBacteriologa').change(function(e) {
        var posBact = -1;
        posBact= fBuscarXClave(e.target.value,"");
          var codigoBact="";
          vMostrarEFisico = 1;//la bacteriologa ingresa el examen fisico .

             if (posBact>=0){//el codigo es el correcto

                txtCodBacteriologa.value = vArrBacteriologas[posBact].codigo;
                codigoBact=vArrBacteriologas[posBact].codigo;
                vDonante.bacteriologa= vArrBacteriologas[posBact].codigo;
                vEstadoDem = ocultarMostrarDemograficos(1);//mostrar los datos que puede modificar una bacteriologa .
                vMostrarEFisico=ocultarExamenFisico(1);

        //console.log(e.target.value+" "+vArrBacteriologas[posBact].nombre+" posicion "+posBact+ " "+txtCodBacteriologa.value);

                $nomBact= "<div id='idNomBacteriologa'><label id ='idNomBacteriologa'>"+vArrBacteriologas[posBact].nombre+"</label></div>";
                $('#idNomBacteriologa').hide();
            $('#idNomBacteriologa').html($nomBact);
            $('#idNomBacteriologa').show()  ;

            }else{//volver a dejar el codigo que estaba.
                txtCodBacteriologa.value=vDonante.bacteriologa;//"";

            }

            var result =seleccBacteriologa(vDonante.bacteriologa);

      });





      $('#textarea_comentaFisico').change(function(e) {
        vDonante.comentarios = e.target.value;
      });


      $('#poPpeso').change(function(e) {
        var result =fEventoCambiarPeso();
    /*
        var sel = e.target.options[e.target.selectedIndex].value;

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



      $('#idprinters').change(function(e) {//seleccionar la impresora de codigo de barras.
        //alert( e.target.value);
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
          vHoy = new Date();
          var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
          actualizarCampoFecha(fechaStr,'txtFechaNat');
                vDonante.fechanat = fechaStr;
                console.log(fechaStr);
        }

      });

      $('#poPedadunidad').change(function(e) {
        var result =fEventoCambiarEdad();
        if (result>=0){
          vHoy = new Date();
          var fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),-vDonante.edad,0,-1);
          actualizarCampoFecha(fechaStr,'txtFechaNat');
                vDonante.fechanat = fechaStr;
                console.log(fechaStr);
        }
      });

      $('#poPsistolica').change(function(e) {
        var result = fEventoCambiarPSistolica();
      });

    /*  $('#infoComponentes').change(function(e) {
        jAlert("clik en componentes", "Informaci&oacute;n");
        //var result = fEventoCambiarPSistolica();
      });*/


      $('#idOTxImprimir').change(function(e) {
        vDonante.otcodBarras= e.target.value;
      });


        $('.sure-do').click(function() {//ok del dialogo de impresion de los codigos de barras
          var vIpImpresora ;
          vIpImpresora= $('#idprinters :selected').val();
          impCodBarra(vDonante.otcodBarras,vIpImpresora);
      });


      $('#radio-ExamenFisico').click(function(e) {
        alert( e.target.value);
      });


      $('#radio-ExamenFisico').change(function(e) {
        alert( e.target.value);
      });




     $('#popEnfermeras').change(function(e) {
        vDonante.enfermerafisico = e.target.options[e.target.selectedIndex].value;
       // alert(vDonante.enfermerafisico);

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
        $('#poPhematocrito').hide();
        $('#poPhematocrito_dec').hide();
        var result = fEventoCambiarHemoglobina();
        $('#poPhematocrito').show();
        $('#poPhematocrito_dec').show();

      //  $('#poPhematocrito').selectmenu('refresh');
      //  $('#poPhematocrito_dec').selectmenu('refresh');
      });

      $('#poPhemoglobina_dec').change(function(e) {
        $('#poPhematocrito').hide();
        $('#poPhematocrito_dec').hide();
        var result = fEventoCambiarHemoglobina();
        $('#poPhematocrito').show();
        $('#poPhematocrito_dec').show();

      //  $('#poPhematocrito').selectmenu('refresh');
      //  $('#poPhematocrito_dec').select('refresh');

      });

      $('#poPhematocrito').change(function(e) {
        var result = fEventoCambiarHematocrito();
      });

      $('#popRes_1').change(function(e) {
        jAlert("Cambio", "Informaci&oacute;n");
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
       // alert(vDonante.genero);
        //alert(vDonante.genero);Masculino o Femenino
      });





      $('#detalleRespBact').change(function(e) {
            var i=0;
            var posBact =-1;
            encontrado=0;
            while ((i<vArrBacteriologas.length)&&(encontrado==0)){
          //      console.log(e.target.options[e.target.selectedIndex].value+" "+vArrBacteriologas[i].codigo);
                if ( e.target.options[e.target.selectedIndex].value==vArrBacteriologas[i].codigo){
                    encontrado = 1;
                    posBact=i;
                }
                i++;
            }
            if (posBact>=0){
               // alert(vArrBacteriologas[posBact].codigo+" "+vArrBacteriologas[posBact].secreto+" "+vArrBacteriologas[posBact].nombre);

            }
        seleccBacteriologa(vDonante.bacteriologa);//Impedir que se cambie la bacteriologa ,solo puede ser seleccionada ingresando el codigo
        $('#detalleRespBact').prop('disabled', 'disabled');
      });


    $('#infoComponentes').change(function(e) {

      console.log("antes "+vArrComponentesSeleccionados);
      var $cadComponentesInicio = vArrComponentesSeleccionados.toString();

      var i=0;
      var posBact =-1;
      encontrado=0;//componente ya seleccionado
      while ((i<vArrComponentes.length)&&(encontrado==0)){
         // console.log(e.target.options[e.target.selectedIndex].value+" "+vArrComponentes[i].codigo);
          if ( e.target.options[e.target.selectedIndex].value==vArrComponentes[i].codigo){
              encontrado = 1;
              posBact=i;
          }
          i++;
      }//while ((i<vArrComponentes.length)&&(encontrado==0)){

      if (posBact>=0){



    //                alert(vArrComponentes[posBact].codigo+" "+vArrComponentes[posBact].descripcion+" "+vArrComponentes[posBact].relacion);
        $string = vArrComponentes[posBact].relacion;
        var arrCoComponentes = [];//componentes que se pueden seleccionar con el seleccionado actualmente .
        var arrCoSelComponente = [];// componentes de & , es decir si ya esta seleccionado y se selecciona otro
        //componente que lo incluye no lo desmarca .
        for (var $i=0;$i<$string.length;$i++){//recorrer la cadena del item seleccionado
          //+1-2-3-4-5+6-7-8-9-10-11-12-13-14
          //&1&2-3-4+5+6-7-8-9-10-11-12-13-14

            var  $cadOpera = $string.substr($i+2,1);
            if ( $cadOpera=="&")$wl=1;
            else if ($cadOpera=="+")$wl=1;
            else if ($cadOpera=="-")$wl=1;
            else $wl=2;


            if ($string.substr($i,1)=="+"){
              var $componenteStr = $string.substr($i+1,$wl);
              arrCoComponentes.push($componenteStr)//componentes que se pueden seleccionar
            }else if ($string.substr($i,1)=="&"){
              var $componenteStr = $string.substr($i+1,$wl);
              arrCoSelComponente.push($componenteStr);//componente ya seleccionado , que no se debe desseleccionar.
            //                        alert($componenteStr);
            }
        }//for (var $i=0;$i<$string.length;$i++){//recorrer la cadena del item seleccionado
        //            vArrComponentes[i].codigo
                //    for($i;$i<count(arrCoComponentes);i++){

                 //   }


        $cadTipo= $('#infoComponentes').html();
        $cadOriginal = $cadTipo;
        var $cadNomComponentes = "<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>";
        var $arrValoresSeleccionados = [];
        var $cadNomLista = "<li><a href='#' ></a></li>";
        $cadNomLista += "<li><a href='#' ></a></li>";
        $cadNomLista += "<li><a href='#' ></a></li>";

        $cadNomLista="</br></br>";

        $('#infoComponentes :selected').each(function(i, selected){
            $arrValoresSeleccionados.push($(selected).val());
      //                  jAlert("sseleccionados "+$(selected).val());
         });

        for(var $k=0;$k<vArrComponentesSeleccionados.length;$k++){
        //                    jAlert("CON EL ARREGLO  "+vArrComponentesSeleccionados[$k]);

        }

        $('#infoComponentes option').each(function(i, selected){
              var $posComponente= arrCoComponentes.indexOf($(selected).val());
              var $posSelComponente = arrCoSelComponente.indexOf($(selected).val());
              var $posEnYaSeleccionados = vArrComponentesSeleccionados.indexOf($(selected).val());

              $valor=$(selected).val();
              if (e.target.options[e.target.selectedIndex].value==$valor){//valor actualmente señalado .
                  $cadTipo=$cadTipo.replace("value=\""+$valor+"\"","value=\""+$valor+"\" selected");
                  $cadNomLista += "<li><a href='#' >"+$(selected).text()+"</a></li>";

                  if (vArrComponentesSeleccionados.indexOf($(selected).val())<0){
                  vArrComponentesSeleccionados.push($(selected).val());
                  }
              }else if ($posComponente>=0){

                  if (vArrComponentesSeleccionados.indexOf($(selected).val())<0){
                    vArrComponentesSeleccionados.push($(selected).val());
                  }
                  $cadTipo=$cadTipo.replace("value=\""+$valor+"\" selected","value=\""+$valor+"\"");
                  $cadTipo=$cadTipo.replace("value=\""+$valor+"\"","value=\""+$valor+"\" selected");

                  $cadNomLista += "<li><a href='#' >"+$(selected).text()+"</a></li>";

                  // $cadNomComponentes += "<li class='ui-li ui-li-static ui-btn-up-c'>"+$(selected).text()+"</li>";
                  //                        $(selected).checked =true;
              }else if(($posSelComponente>=0) && ($posEnYaSeleccionados>=0)) {


                   $cadNomLista += "<li><a href='#' >"+$(selected).text()+"</a></li>";
              }else{
                    $cadTipo=$cadTipo.replace("value=\""+$valor+"\" selected","value=\""+$valor+"\"");
                  //                        $(selected).checked =false;

                    var pos = vArrComponentesSeleccionados.indexOf( $(selected).val() );
                    pos > -1 && vArrComponentesSeleccionados.splice( pos, 1 );
              }


        });


     $cadNomLista = "<div id='popNomComponentes'><ul data-role='listview' >"+$cadNomLista +"</ul></div>";

    //$cadNomComponentes = "<fieldset data-role='fieldcontain' data-type='horizontal'>"+$cadNomComponentes+"</fieldset>";

    $('#popNomComponentes').hide();
        $('#popNomComponentes').html($cadNomLista );//$cadNomComponentes
        $('#popNomComponentes').show();
        }
      console.log("despues "+vArrComponentesSeleccionados);

    });






    //Seleccionar del listado de consecutivos de donacion
      $('#popOrdenes').change(function(e) {


        txtOrden.value =  e.target.options[e.target.selectedIndex].value;
        vDonante.orden = e.target.options[e.target.selectedIndex].value;
        console.log(vDonante.orden);

        vTextFecha = e.target.options[e.target.selectedIndex].text;
        arr1=vTextFecha.split(" ");
        if (arr1.length>1){
          txtFecha.value =arr1[1];
          vDonante.fecha = arr1[1];//asignar la fecha de donacion
          getInfoDonante();

        }else{txtFecha.value="";}
      });




      $('#botonEncuesta2').click(function(e) {
        jAlert("Dialogo");
    //      });

            $('dialog-modal').dialog();
       //close click
    //     $("#dialogo").dialog();
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
    //        return false;


      });





        } // Ready funcion
    ); // Ready


    function irExamenFisico(){
      //alert(vDonante.orden);
      //console.log("ir al examen fisico"+vDonante.orden);

      if (vDonante.encuestaOK=="PE"){
        //fMostrarAlerta("Falta contestar la encuesta");
        //return;
      }


      if (vDonante.orden!=""){
        //fMostrarAlerta("porque no funciona");
        $vNomPaciente = '<label class="label-Demografico">'+vDonante.nombres+" "+vDonante.apellido1+" "+vDonante.apellido2+" #"+vDonante.orden+'</label><br>';
        $('#idNomPacienteEFisico').html($vNomPaciente);
        //botonGrabarEFisico si la fecha es diferente a hoy .
        vHoy = new Date();
        var $fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),0,0,0);
        console.log($fechaStr+" iguales en ex. fisico "+vDonante.fecha);
        if (vDonante.fecha != $fechaStr){
          vEsDonacionHoy = false;
           //$('#botonGrabarEFisico').attr("disabled","disabled");
          //$('#botonGrabarEFisico').hide();

        }{ vEsDonacionHoy = true;
          //$('#botonGrabarEFisico').attr("disabled",false);
        }
        showComponentes();

        $.mobile.changePage('#paginaEFisico','slide');//importante las mayusculas.
      }else{
        jAlert("Falta el número de Orden","Examen Fisico");
      }
      return;
    }


    function fMostrarAlerta(mensaje){

      if (mensaje!=""){
        $cadImpBarras = '<label>'+mensaje+'</label><br>';
        $('#idMsgAlerta').html($cadImpBarras);//$cad2+
        $.mobile.changePage('#PaginaAlerta','slide');
      }
      return;
    }




    function fEventoCambiarPeso(){
      var respuesta = -1;
      //var valorUnidad = $('#poPpesounidad :selected').val();
      //var valor = $('#poPpeso :selected').val();
      //if ( !isNaN(valor) ){
        var suma = parseFloat(vDonante.peso) ;//parseInt(valor)+parseInt(valorUnidad);
        var varresul = fCambioPeso(suma);
        //console.log(suma) ;
        ((varresul == true)||(vDonante.comentarios!="")) ? respuesta = 1 : respuesta = 0;

      //}
      return respuesta;//información pendiente por ingresar
    }

    function fEventoCambiarTemperatura(){

      var respuesta = -1;
      //var valorUnidad = $('#poPtemperatura_dec :selected').val();
      //var valor = $('#poPtemperatura :selected').val();
      //if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.temperatura);//parseInt(valor)+(parseInt(valorUnidad)/10);
        var varresul = fCambioTemperatura(suma);
        ((varresul == true)||(vDonante.comentarios!="")) ? respuesta = 1 : respuesta = 0;

      //}
      return respuesta;//información pendiente por ingresar
    }

    function cambiarResp(){
      jAlert("enter ", "Informaci&oacute;n");
    }


    function fEventoCambiarEdad(){
      var respuesta = -1;
      var valorUnidad = $('#poPedadunidad :selected').val();
      var valor = $('#poPedad :selected').val();
      if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseInt(valor)+parseInt(valorUnidad);
        var varresul = fCambioEdad(suma);
      //  console.log(suma) ;
        (varresul == true) ? respuesta = 1 : respuesta = 0;
        vDonante.edad=suma;
      }
      return respuesta;//información pendiente por ingresar

    }

    function fEventoCambiarPSistolica(){
      var respuesta = -1;
    //  var valorUnidad = $('#poPsistolicaunidad :selected').val();
    //  var valor = $('#poPsistolica :selected').val();
    //  if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.pasistolica);//parseInt(valor)+parseInt(valorUnidad);
        var varresul = fCambioPresionASistolica(suma);
        console.log(suma) ;
        ((varresul == true)||(vDonante.comentarios!=""))  ? respuesta = 1 : respuesta = 0;

    //  }
      return respuesta;//información pendiente por ingresar

    }
    function fEventoCambiarPDiastolica(){
      var respuesta = -1;
    //  var valorUnidad = $('#poPdiastolicaunidad :selected').val();
    //  var valor = $('#poPdiastolica :selected').val();
    //  if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.padiastolica);//parseInt(valor)+parseInt(valorUnidad);
        var varresul = fCambioPresionADiastolica(suma);
        //console.log(suma) ;
        ((varresul == true)||(vDonante.comentarios!=""))  ? respuesta = 1 : respuesta = 0;
      //}
      return respuesta;//información pendiente por ingresar

    }

    function fEventoCambiarHematocrito(){
      var respuesta = -1;
    //  var valorUnidad = $('#poPhematocrito_dec :selected').val();
    //  var valor = $('#poPhematocrito :selected').val();
      var genero = $('#popGenero :selected').val();
    //  if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.hematocrito);//parseInt(valor)+(parseInt(valorUnidad)/10);
        var varresul = fCambioHematocrito(suma,genero);
        ((varresul == true)||(vDonante.comentarios!=""))  ? respuesta = 1 : respuesta = 0;
    //  }
      return respuesta;//información pendiente por ingresar
    }

    function fEventoCambiarHemoglobina(){
      var respuesta = -1;
    //  var valorUnidad = $('#poPhemoglobina_dec :selected').val();
    //  var valor = $('#poPhemoglobina :selected').val();
      var genero = $('#popGenero :selected').val();
    //  if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.hemoglobina);//parseInt(valor)+(parseInt(valorUnidad)/10);

        var varresul = fCambioHemoglobina(suma,genero);
        var vHematocrito = 3*suma;
        vDonante.hematocrito = vHematocrito.toString();
        $posPunto2=vDonante.hematocrito.indexOf(".");
        if ($posPunto2>=0){
          vDonante.hematocrito= vDonante.hematocrito.substr(0,$posPunto2+2) ;
        }
    $('#miHematocritoTeclado').val(vDonante.hematocrito);
    //    actualizarPopUp(parseInt(vHematocrito),'poPhematocrito');
    //    actualizarPopUp(parseInt((vHematocrito*10)%10) ,'poPhematocrito_dec');

        //console.log(genero+" "+suma+" hematocrito "+vHematocrito) ;
        ((varresul == true)||(vDonante.comentarios!="")) ? respuesta = 1 : respuesta = 0;

    //  }
      return respuesta;//información pendiente por ingresar

    }

    function fEventoCambiarFCardiaca(){
      var respuesta = -1;


      //var valorUnidad = $('#poPfcardiacaunidad :selected').val();
      //var valor = $('#poPfcardiaca :selected').val();
    //  if ( (!isNaN(valor)) && (!isNaN(valorUnidad)) ){
        var suma = parseFloat(vDonante.fcardiaca);//parseInt(valor)+parseInt(valorUnidad);

        var varresul = fCambioFcardiaca(suma);
        ((varresul == true)||(vDonante.comentarios!="")) ? respuesta = 1 : respuesta = 0;

      // }
      return respuesta;//información pendiente por ingresar

    }


    function fSumarAFecha(fecha,annos,meses,dias){
      vHoy = new Date(fecha);
      var vHacexxx = new Date(vHoy.getFullYear()+annos, vHoy.getMonth()+meses, vHoy.getDate()+dias);
      console.log(vHacexxx);
      var fechaStr =  vHacexxx.getFullYear()+'-';
      mes = vHacexxx.getMonth()+1;//los meses empiezan en cero.
      console.log("mes "+mes);
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
    //  alert(valor);
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
    //      cadena +="<option value='"+ key +"'>"+ value +"</option>";
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
        //  alert(peticion.responseText);
        jAlert("hola");
        }
      }
    }

    function procesarLlenarEdades(){

      var cadena = "";
      for(i=0;i<10;i++){
          cadena +="<option value='"+ i +"'>"+i +"</option>";

      }
    //  alert(cadena);
      cadena1 = "<select name='poPedaddec' id='poPedaddec' >"+cadena+"</select>";
      cadena2 = "<select name='poPedadunid' id='poPedadunid' >"+cadena+"</select>";
      document.write(cadena1);
    //  $('#poPedaddec').html(cadena2);
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
    //       vObjPop = eval('('+data+')');//convierte el texto a JSON
                $('#poPtemperatura').html(vObjPop.temperatura);
                $('#poPtemperatura').show();
                $('#poPtemperatura_dec').html(vObjPop.temperaturaDecimal);
                $('#poPtemperatura_dec').show();


                $('#poPpeso').html(vObjPop.peso);
                $('#popGenero').html(vObjPop.genero);
                $('#popGenero').hide();//no mostrarlo nunca.

                $('#popTipoDonacion').html(vObjPop.tipodonacion);

                $('#popGrupoSanguineo').html(vObjPop.gsanguineo);
                $('#popGrupoSanguineo').hide();//no mostrar nunca
                $('#popRH').html(vObjPop.rh);
                $('#popRH').hide();//no mostrar nunca

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
    //alert(data);
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
                $('#detalleRespBact').hide();//no se muestre nunca

                $('#idBactXClave').html(cadBact);



    for (i=0;i<vArrBacteriologas.length;i++){
    console.log(vArrBacteriologas[i].codigo);
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


    function getEnfermerasMovil() {


        $('#waiting').show();

        $.ajax({
            type : 'POST',
            url : "../ajax/getEnfermerasMovil.php",
            dataType : 'html',
            data: {

            },
            success : function(data){
    //alert(data);
                $('#waiting').hide();

                var obj = eval('('+data+')');//convierte el texto a JSON

                var cadBact;
                cadBact = "<div id=\"popEnfermeras\" >";
                cadBact += "<select name=\"popEnfermeras\" id=\"popEnfermeras\" >";
                cadBact += "<option >Enfermeras</option>";
                for (var i=0;i<obj.bacteriologas.length;i++){

                    cadBact +=  "<option value=\""+obj.bacteriologas[i]['codigo']+"\">"+obj.bacteriologas[i]['nombre']+"</option>";
                     console.log(obj.bacteriologas[i]['codigo']);
                }

                cadBact += "</select>";
                cadBact += "  </div>";

                $('#popEnfermeras').html(cadBact);
                $('#popEnfermeras').show();

                $('#popEnfermeras').html(cadBact);





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
                txtEdad : vDonante.edad,

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

                var obj = eval('('+data+')');//convierte el texto a JSON
                // revisar siempre que el html de 4D este activo .
                $nombreHtml = "<div id='txtApellido1'><input type='text' name='txtApellido1' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+obj.apellido1+"' /></div>";

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
                vDonante.componentes = obj.componentes ;

                vDonante.peso =obj.peso;
                vDonante.fcardiaca =obj.fcardiaca;
                vDonante.pasistolica =obj.psistolica;
                vDonante.padiastolica =obj.pdiastolica;
                vDonante.hemoglobina =obj.hemoglobina;
                vDonante.hematocrito =obj.hematocrito;
                vDonante.temperatura =obj.temperatura;
                vDonante.enfermerafisico = obj.enfermerafisico;//9 abril

    //radio-Genero-M
    //vDonante.genero
    $vGeneroM=false;
    $vGeneroF=false;
    $vGeneroSx=false;

    if (vDonante.genero=="Masculino"){
      $vGeneroM=true;

    }else if (vDonante.genero=="Femenino"){
      $vGeneroF=true;

    }else{
      $vGeneroSx=true;

    }
    $('#radio-Genero-M').attr('checked', $vGeneroM).checkboxradio("refresh");
    $('#radio-Genero-F').attr('checked', $vGeneroF).checkboxradio("refresh");
    $('#radio-Genero-Sx').attr('checked', $vGeneroSx).checkboxradio("refresh");

    vDonante.gsanguineo=obj.gsanguineo;
    if (vDonante.gsanguineo=="O"){
      $('#radio-GS-O').attr('checked', true).checkboxradio("refresh");
    }else if (vDonante.gsanguineo=="A"){
      $('#radio-GS-A').attr('checked', true).checkboxradio("refresh");
    }else if (vDonante.gsanguineo=="B"){
      $('#radio-GS-B').attr('checked', true).checkboxradio("refresh");
    }else if (vDonante.gsanguineo=="AB"){
      $('#radio-GS-AB').attr('checked', true).checkboxradio("refresh");
    }else{
      $('#radio-GS-Sin').attr('checked', true).checkboxradio("refresh");

    }
    vDonante.rh=obj.rh;
    if (vDonante.rh=="POSITIVO"){
      $('#radio-RH-P').attr('checked', true).checkboxradio("refresh");
    }else if (vDonante.rh=="NEGATIVO"){
      $('#radio-RH-N').attr('checked', true).checkboxradio("refresh");
    }else{
      $('#radio-RH-Sin').attr('checked', true).checkboxradio("refresh");

    }






                $('#miPesoTeclado').val(vDonante.peso);
                $('#miFCardiacaTeclado').val(vDonante.fcardiaca);
                $('#miPASistolicaTeclado').val(vDonante.pasistolica);
                $('#miPADiastolicaTeclado').val(vDonante.padiastolica);

                $('#miHemoglobinaTeclado').val(vDonante.hemoglobina);
                $('#miHematocritoTeclado').val(vDonante.hematocrito);

                $('#miTemperaturaTeclado').val(vDonante.temperatura);




                $("#bIrExamenFisico").prop('value', 'Ex.Fisico <'+vDonante.examenfisicoOK+'>');
                if (vDonante.examenfisicoOK=="OK"){$("#bIrExamenFisico").css("background-color", "green");}
                else { $("#bIrExamenFisico").css("background-color", "red"); }
                $("#bIrExamenFisico").button('refresh');

                $("#botonEncuesta").prop('value', 'Encuesta<'+vDonante.encuestaOK+'>');
                if (vDonante.encuestaOK=="OK"){$("#botonEncuesta").css("background-color", "green");}
                else { $("#botonEncuesta").css("background-color", "red"); }
                $("#botonEncuesta").button('refresh');


                if (vDonante.componentes!=""){
                  vArrComponentesSeleccionados = vDonante.componentes.split(",");//[];
                }
                $('#bComponentes').text="Componentes "+vArrComponentesSeleccionados.length;
                $("#bComponentes").prop('value', 'Componentes <'+vArrComponentesSeleccionados.length+'>');
                if (vArrComponentesSeleccionados.length>0){$("#bComponentes").css("background-color", "green");}
                else { $("#bComponentes").css("background-color", "red"); }
                $("#bComponentes").button('refresh');


                console.log("Componentes "+vArrComponentesSeleccionados.length) ;

                vHoy = new Date();
                var $fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),0,0,0);
                console.log("iguales fechas "+$fechaStr+" orden "+obj.orden+" fecha "+obj.fecha);
                vOrdenDeHoy = "";

                if ($fechaStr == obj.fecha  ){

                  vDonante.orden = obj.orden;//borra la informacion del donante .
                  vDonante.fecha = obj.fecha;
                  txtOrden.value =vDonante.orden;
                  txtFecha.value =  vDonante.fecha;
                  actualizarCampoTexto(vDonante.orden,'txtOrden','text');
                  actualizarCampoFecha(vDonante.fecha,'txtFecha');
                  vOrdenDeHoy = vDonante.orden;
                }


     //                   vDonante.bacteriologa= obj.bacteriologa;

                if (((vDonante.bacteriologa=="")||(vDonante.bacteriologa!=obj.bacteriologa)) &&(obj.bacteriologa!="")){
                    vDonante.bacteriologa= obj.bacteriologa;
                  actualizarCampoTexto(vDonante.bacteriologa,'txtCodBacteriologa',"password");
                  actualizarPopUp(vDonante.bacteriologa,'detalleRespBact');

                }

                if (vDonante.enfermerafisico!=""){
                  actualizarPopUp(vDonante.enfermerafisico,'popEnfermeras');
                }
                $('#miEdadTeclado').val(vDonante.edad);

                actualizarCampoTexto(vDonante.nombres,'txtNombre','text');
                actualizarCampoTexto(vDonante.apellido1,'txtApellido1','text');
                actualizarCampoTexto(vDonante.apellido2,'txtApellido2','text');
                actualizarCampoTexto(vDonante.telefonos,'txtTelefonos','text');
                actualizarCampoTexto(vDonante.direccion,'txtDireccion','text');

                actualizarPopUp(vDonante.genero,'popGenero');

                $cadyyyy=$('#poPyear').html();
                $cadmes=$('#poPmonth').html();
                $caddia=$('#poPday').html();
            //    console.log("aqui");

                $vFechaNat = vDonante.fechanat;
                arr1=$vFechaNat.split("-");


                $vEdad = vDonante.edad;
                $vEdadUnidad = $vEdad % 10;
                $vEdad = $vEdad -$vEdadUnidad;

                actualizarEdad=0;//no actualizar automaticamente
                //18 de marzo 2014
                //actualizarPopUp($vEdad,'poPedad');
                //actualizarPopUp($vEdadUnidad,'poPedadunidad');
                //alert("fecha nat "+vDonante.fechanat);
                actualizarCampoFecha(vDonante.fechanat,'txtFechaNat');

                actualizarEdad=1;

                $('#txtNombre').show();
                //                 $('#txtInfoDonante').html(data);
                $('#txtInfoDonante').show();


                cadOrdenes = "<div id=\"popOrdenes\" >";
                cadOrdenes += "<select name=\"popOrdenes\" id=\"popOrdenes\" >";
                cadOrdenes += "<option >Ordenes</option>";
                var arrOrdenes = $.map(obj.ordenes, function (item, index) { return [[item.orden, item.fecha, item.estado]]; });
                for (var i=0;i<obj.ordenes.length;i++){
                  vClave="";
                  vValor="";
                  $seleccionado = "";
                  for(key in obj.ordenes[i]){

                    if (obj.ordenes[i].hasOwnProperty(key)){
                      if (key == "orden"){
                        vClave=obj.ordenes[i][key];
                        if (vOrdenDeHoy==vClave){
                          $seleccionado="selected";
                        }
                        vValor=vClave+ " ";
                      }else{
                        vValor+=obj.ordenes[i][key]+" ";
                      }

                    }

                  }
                  cadOrdenes +=  "<option value=\""+vClave+"\""+ $seleccionado+" >"+vValor+"</option>";

                }

                cadOrdenes += "</select>";
                cadOrdenes += "  </div>";



               $('#popOrdenes').html(cadOrdenes);
               $('#popOrdenes').show();


              actualizarPopUp(obj.gsanguineo,'popGrupoSanguineo');
              actualizarPopUp(obj.rh,'popRH');
              $('#popGenero').hide();//no mostrarlo nunca.
              $('#popGrupoSanguineo').hide();//no mostrar nunca
              $('#popRH').hide();//no mostrar nunca

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
              actualizarCampoTexto(vDonante.comentarios,'textarea_comentaFisico','text');

    /*
          actualizarPopUp(obj.peso-(obj.peso % 10),'poPpeso');
          actualizarPopUp(obj.peso % 10,'poPpesounidad');

          actualizarPopUp(obj.pdiastolica-(obj.pdiastolica % 10),'poPdiastolica');
          actualizarPopUp(obj.pdiastolica % 10,'poPdiastolicaunidad');

          actualizarPopUp(obj.psistolica-(obj.psistolica % 10),'poPsistolica');
          actualizarPopUp(obj.psistolica % 10,'poPsistolicaunidad');

          actualizarPopUp(parseInt(obj.temperatura),'poPtemperatura');
          actualizarPopUp(parseInt((obj.temperatura*10)%10) ,'poPtemperatura_dec');

          actualizarPopUp(parseInt(obj.hemoglobina),'poPhemoglobina');
          actualizarPopUp(parseInt((obj.hemoglobina *10 )%10) ,'poPhemoglobina_dec'); */

      //console.log("decimal hemoglobina "+obj.hemoglobina+" es "+parseInt((obj.hemoglobina-parseInt(obj.hemoglobina))*10));
      //console.log("diferencia "+(obj.hemoglobina-parseInt(obj.hemoglobina)));
      //console.log("parse int "+parseInt(obj.hemoglobina));

      /*    actualizarPopUp(parseInt(obj.hematocrito),'poPhematocrito');
          actualizarPopUp(parseInt((obj.hematocrito*10)%10) ,'poPhematocrito_dec');

          actualizarPopUp(obj.fcardiaca-(obj.fcardiaca % 10),'poPfcardiaca');
          actualizarPopUp(obj.fcardiaca % 10,'poPfcardiacaunidad');*/

    /*
          $('#idEncuestaTxt').css('background-color','blue');
          $('#idPerfilTxt').css('background-color','red');
          $('#idFenotipoTxt').css('background-color','blue');
          $('#idEFisicoTxt').css('background-color','red');*/

            if (( (vDonante.cedula == "") || (vDonante.cedula!=obj.cedula) ) && (obj.cedula!="")) {
              vDonante.cedula = obj.cedula;
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
      //    console.log("popuup "+$cadTipo);
        $('#'+campohtml).html($cadTipo);
    //    $('#'+campohtml).refresh();
    }

    function actualizarCampoTexto(campovalor, campohtml, tipocampo){
      $('#'+campohtml).html("<div id='"+campohtml+"' data-role='content'><input type='"+tipocampo+"' name='"+campohtml+"' id='"+campohtml+"'  class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+campovalor+"' /></div>")  ;

    }

    function actualizarCampoTextoSoloLectura(campovalor, campohtml){
      $('#'+campohtml).html("<div id='"+campohtml+"' data-role='content'><input type='text' name='"+campohtml+"' id='"+campohtml+"' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset' value = '"+campovalor+"' readonly /></div>")  ;

    }

    function actualizarCampoFecha(campovalor, campohtml){
      var cad = $('#'+campohtml).html();
    //    alert(cad);
    //    $('#'+campohtml).val(campovalor);
        $('#'+campohtml).html("<div id='"+campohtml+"'><input type='date' name='"+campohtml+"' id='"+campohtml+"'  value = '"+campovalor+"' format='yyyy-mm-dd' class='ui-input-text ui-body-c ui-corner-all ui-shadow-inset'/></div>")  ;
    }

    function cancelarDonante(){
        if (confirm('Desea salir al menu principal ?')) {
    //    getInfoDonante();
            document.forms[0].action='../../dona.html';//'../apl/login.php';
            document.forms[0].submit();
        }

    }

    function inicializarCampos(){
        if (confirm('Desea cancelar Inicializar los Campos?')) {
    //    getInfoDonante();

          document.forms[0].action='../apl/FormularioCompleto.php';
          //alert(vDonante.usuario);
          console.log(vDonante.cedula );
        if (vDonante.usuario =="donante"){
          txtCedula.value = vDonante.cedula ;
          cc_paciente.value = vDonante.cedula ;
        }else{
          txtCedula.value = "";
          cc_paciente.value ="";
        }
    //            cc_paciente.value = "";


            document.forms[0].submit();
        }

    }





    function grabarDonante() {

    //alert($('#txtCodBacteriologa').val());

      console.log("en ventana " +txtFechaNat.value +" en variable"+vDonante.fechanat);

      console.log("comentario examen fisico "+textarea_comentaFisico);
    //return ;


    //alert(vDonante.orden);

      var multipleValues = vArrComponentesSeleccionados.toString();
      //alert(multipleValues);
      //return ;

     //   jAlert("fecha nat "+vDonante.fechanat);
      arregloCampos = ["txtCedula","txtNombre","txtApellido1","txtDireccion","txtTelefonos"];
      salir = 1;

    //alert(vDonante.apellido2);

      if (vDonante.cedula==""){
        salir=1;
        //jAlert("sin Cedula", "Informaci&oacute;n");
        jAlert("Sin Cédula","Grabar");
      }else if(vDonante.nombres==""){

      //  $.mobile.changePage('#miAlerta','slide');
    //    jAlert("sin Nombres ",  'Informaci&oacute;n');
        jAlert("Sin Nombres","Grabar");

      }else if(vDonante.apellido1==""){
        jAlert("Sin Primer Apellido","Grabar");

      }else if(vDonante.direccion==""){
        jAlert("Sin Dirección","Grabar");
      }else if (vDonante.telefonos==""){
        jAlert("Sin Telefonos","Grabar");

      }else if (vDonante.empresa==""){
        jAlert("Sin Eps","Grabar");

      }else if (vDonante.gsanguineo==""){
      //($('#popGrupoSanguineo :selected').val() ==""){
          salir = 1;
          jAlert("Falta Grupo Sanguineo","Grabar");//fMostrarAlerta
      }else if (vDonante.rh==""){
        //(($('#popRH :selected').val() != "POSITIVO" ) && ($('#popRH :selected').val() != "NEGATIVO" )){
          salir = 1;
          jAlert("Falta RH","Grabar");//fMostrarAlerta
      }else if (vDonante.edad<18){
          salir = 1;
          jAlert("Edad NO permitida","Grabar");
      }else if (vDonante.genero==""){
          salir = 1;
          jAlert("Sin Genero","Grabar");

      }
      else{
        var informacion ="";
        informacion="Nombre :"+vDonante.nombres+" "+vDonante.apellido1+" eps "+vDonante.empresa+" Donante:"+vDonante.orden;
        //alert(informacion);
        salir = 0;
      }




      if (salir == 1){

      }else if (vMostrarEFisico == 0){//solo se ingresan los demograficos del paciente .

        if  (vDonante.edad<18){//(fEventoCambiarEdad()!=1){
          salir = 1;
          jAlert("Edad NO permitida","Grabar");
        }

      }else{//informacion del examen fisico


        if (vDonante.categoria==""){
          jAlert("Sin Categoria","Examen Fisico");
          salir = 1;
        }else if (vDonante.tipodonacion==""){
          salir = 1;
          jAlert("sin Tipo de Donación","Examen Fisico");
        }


        if  (vDonante.edad<18){//(fEventoCambiarEdad()!=1){
          salir = 1;
          jAlert("Edad NO permitida","Grabar");
        }
        var codBacteriologa = $('#detalleRespBact :selected').val();
        if (vDonante.bacteriologa==""){
          salir = 1;
          jAlert("Falta seleccionar la Bacteriologa","Examen Fisico");
        }else {}//alert(vDonante.bacteriologa);

        if (salir != 0){//falta informacion no hacer validaciones todavia

        }else if (fEventoCambiarPeso()==0){
          salir = 1;
          jAlert("Peso NO permitido","Examen Fisico");
        }else if (fEventoCambiarPSistolica()==0){
          salir = 1;
          jAlert("Presion Arterial Sistolica NO permitida","Examen Fisico");
        }else if (fEventoCambiarPDiastolica()==0){
          salir = 1;
          jAlert("Presion Arterial Diastolica NO permitida","Examen Fisico");
        }else if (fEventoCambiarFCardiaca()==0){
          salir = 1;
          jAlert("Frecuencia Cardiaca NO permitida","Examen Fisico");
        }else if (fEventoCambiarHemoglobina()==0){
          salir = 1;
          jAlert("Hemoglobina NO permitida","Examen Fisico");
        }else if (fEventoCambiarHematocrito()==0){
          salir = 1;
          jAlert("Hematocrito NO permitido","Examen Fisico");
        }else if (fEventoCambiarTemperatura()==0){
          salir = 1;
          jAlert("Temperatura NO permitida","Examen Fisico");

        }else{salir = 0;}

      }

      if (salir == 0){

        if (vDonante.usuario != "donante" ){
          if ( (vDonante.orden=="") && (vDonante.cedula!="") ){
            if (confirm('El donante ya tiene ingreso de hoy?')) {
              return ;
            }
          }

        }

        if  (vDonante.edad<18){//(fEventoCambiarEdad()!=1){
          salir = 1;
          jAlert("Edad NO permitida","Menor de Edad");
          return ;
        }

    //$varActualizado = fActualizarVarSesion("GeneroDonante",vDonante.genero);
    //se lee de la base de datos.
    //alert(vDonante.orden);

          if (confirm('Esta seguro de grabar el donante?')) {

               // var $arrPeso=  vDonante.peso.split(".");


    //          document.forms[0].action='../apl/grabarBancoRegistro.php';
    //          document.forms[0].submit();
                var arrComponentesSel = [];
                /*
                $('#infoComponentes :selected').each(function(i, selected){
                    arrComponentesSel[i] = $(selected).val();//text
                });*/


                //var multipleValues =arrComponentesSel.join(",");
    //jAlert("componentes sel "+multipleValues, "Informaci&oacute;n");
    console.log("la orden creada es la "+vDonante.orden);
    $.ajax({
        type : 'POST',
        url : "../apl/grabarBancoRegistro.php",
        dataType : 'html',
        data: {

           // infoComponentes :multipleValues,

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

            txtFechaNat : vDonante.fechanat,//$('#txtFechaNat').val() ,
            txtEdad : vDonante.edad,

        popGenero : vDonante.genero,//$('#popGenero :selected').val() ,
        popGrupoSanguineo : vDonante.gsanguineo,// $('#popGrupoSanguineo :selected').val() ,
        popRH : vDonante.rh,//$('#popRH :selected').val() ,
        popTipoDonacion : $('#popTipoDonacion :selected').val() ,
        popCategorias : vDonante.categoria,//$('#Categorias :selected').val() ,
        EPS : vDonante.empresa,//$('#EPS :selected').val() ,
        txtE_Mail : vDonante.email,//$$('#txtE_Mail').val() ,
        txtReceptor :vDonante.receptor,//$ $('#txtReceptor').val() ,
        textarea_observaciones :vDonante.observaciones,//$ $('#textarea_observaciones').val() ,
        textarea_reaccion :vDonante.reaccion,//$ $('#textarea_reaccion').val() ,

        poPpeso : vDonante.peso,//$('#poPpeso :selected').val() ,
        poPpesounidad : "0",//$('#poPpesounidad :selected').val() ,
        poPtemperatura : vDonante.temperatura,//$('#poPtemperatura :selected').val() ,
        poPtemperatura_dec : "0",//$('#poPtemperatura_dec :selected').val() ,
        poPsistolica : vDonante.pasistolica,//$('#poPsistolica :selected').val() ,
        poPsistolicaunidad : "0",//$('#poPsistolicaunidad :selected').val() ,
        poPdiastolica :vDonante.padiastolica,// $('#poPdiastolica :selected').val() ,

        poPdiastolicaunidad :"0", //$('#poPdiastolicaunidad :selected').val() ,
        poPhemoglobina : vDonante.hemoglobina,//$('#poPhemoglobina :selected').val() ,
        poPhemoglobina_dec : "0",//$('#poPhemoglobina_dec :selected').val() ,
        poPhematocrito : vDonante.hematocrito,//$('#poPhematocrito :selected').val() ,
        poPhematocrito_dec :"0", //$('#poPhematocrito_dec :selected').val() ,
        poPfcardiaca : vDonante.fcardiaca,//$('#poPfcardiaca :selected').val() ,
        poPfcardiacaunidad : "0",//$('#poPfcardiacaunidad :selected').val() ,

        textarea_comentaFisico : vDonante.comentarios,//$$('#textarea_comentaFisico').val() ,

        Componentes : multipleValues,//$('#Componentes :selected').val() ,
        idEncuestaTxt : vDonante.encuestaOK,//$('#idEncuestaTxt').val() ,
        idPerfilTxt : vDonante.perfilOK,//$('#idPerfilTxt').val() ,
        idFenotipoTxt :vDonante.fenotipoOK,// $('#idFenotipoTxt').val() ,
        idEFisicoTxt :vDonante.examenfisicoOK,// $('#idEFisicoTxt').val(),

        idwsAuxiliarEFisico : vDonante.enfermerafisico//""//18-03-2014 por ahora en blanco .
      },
        success : function(data){
          var obj = eval('('+data+')');//convierte el texto a JSON

        if (vDonante.orden==""){//Nueva orden
          alert("Orden creada: "+obj.orden);
          vDonante.orden = obj.orden;//data;
          if (confirm('Desea llenar la encuesta?')) {



             $.ajax({
                  type : 'POST',

                  url : "../ajax/configEncuesta.php",
                  dataType : 'html',
                  data: {
                      num_ot :  vDonante.orden , //$('#num_ot').val(),
                      cod_bact: vDonante.bacteriologa,
                      nom_bact: $('#detalleRespBact option:selected').text(),
                      tipoEncuesta : "0"//siempre es la inicial

                  },
                  success : function(data){
                    //alert(data);
                    //vDonante.orden = data;
                    //jAlert("orden "+vDonante.orden);
                      num_ot.value = vDonante.orden;
                      txtOrden.value = vDonante.orden;//13 NOV
                      $('#num_ot').val(vDonante.orden);
                      usuarioencuesta.value ="donante";
                      //tipoEncuesta.value ="0";
                      $('#tipoEncuesta').val("0");//siempre es la inicial
                      //console.log (tipoEncuesta);
                       document.forms[0].action='../apl/det_encuesta.php';//'../apl/encuesta.php';
                       document.forms[0].submit();

                  },
                  error : function(XMLHttpRequest, textStatus, errorThrown) {
                      $('#message').fadeIn(1000);
                      $('#message').removeClass().addClass('error').text('Error al ejecutar el metodo empezarEncuesta. Informe a sistemas [ vDonante.orden ] [#login.clic]').show(500);
                      $('#detalleDonante').hide();


                  }
              });




            //empezarEncuesta();


            //document.forms[0].action='../apl/menuDonante.php';

               //document.forms[0].submit();

          }else{

            //        jAlert("re-donante");
            vDonante.orden= obj.orden;//9 de enero 2014
            vDonante.encuestaOK = obj.Encuesta;
                      console.log(data);
            console.log(obj);
            num_ot.value = vDonante.orden;
            txtOrden.value = vDonante.orden;//13 NOV
            //          document.forms[0].action='../apl/formulariocompleto.php';
            //            document.forms[0].submit();

          }


        }else{

          console.log(data);
          console.log(obj);

          vDonante.encuestaOK = obj.Encuesta;
          vDonante.examenfisicoOK = obj.EFisico;
          actualizarCampoTextoSoloLectura(vDonante.encuestaOK,'idEncuestaTxt');//
                actualizarCampoTextoSoloLectura(vDonante.examenfisicoOK,'idEFisicoTxt');

          vDonante.orden= obj.orden;//9 de enero 2014

    //alert(vDonante.orden);


            if (vDonante.examenfisicoOK=="OK"){
              //p.css("background-color", "green");

            }
    //   alert("estado examenf isico "+vDonante.examenfisicoOK);
          $("#bIrExamenFisico").prop('value', 'Ex.Fisico <'+vDonante.examenfisicoOK+'>');
          if (vDonante.examenfisicoOK=="OK"){$("#bIrExamenFisico").css("background-color", "green");}
          else { $("#bIrExamenFisico").css("background-color", "red"); }
          $("#bIrExamenFisico").button('refresh');

          $("#botonEncuesta").prop('value', 'Encuesta<'+vDonante.encuestaOK+'>');
          if (vDonante.encuestaOK=="OK"){$("#botonEncuesta").css("background-color", "green");}
          else { $("#botonEncuesta").css("background-color", "red"); }
          $("#botonEncuesta").button('refresh');


          if (vDonante.componentes!=""){
            //vArrComponentesSeleccionados = vDonante.componentes.split(",");//[];
          }
          $('#bComponentes').text="Componentes "+vArrComponentesSeleccionados.length;
          $("#bComponentes").prop('value', 'Componentes <'+vArrComponentesSeleccionados.length+'>');
          if (vArrComponentesSeleccionados.length>0){$("#bComponentes").css("background-color", "green");}
          else { $("#bComponentes").css("background-color", "red"); }
          $("#bComponentes").button('refresh');

          if (vDonante.componentes != vArrComponentesSeleccionados.toString()){

              vDonante.componentes = vArrComponentesSeleccionados.toString();
              //imprimir los componentes
                    var vIpImpresora ;
              vIpImpresora= $('#idprinters :selected').val();
              if (vArrComponentesSeleccionados.toString()!=""){
                  impCodBarra(vDonante.orden,vIpImpresora);
              }



          }



          jAlert("Orden actualizada :"+obj.orden, "Informaci&oacute;n");


        }

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
                cadBact = "<div id='infoComponentes' >";//class='dialogo'
                cadBact += "<select name='infoComponentes' id='infoComponentes'  >";
                cadBact += "<option>Componentes</option>";
                for (var i=0;i<obj.componentes.length;i++){
                    var vComponentes = new Componentes();
                    vComponentes.codigo = obj.componentes[i]["codigo"];
                    vComponentes.descripcion = obj.componentes[i]["descripcion"];
                    vComponentes.relacion = obj.componentes[i]["relacion"];

                    cadBact +=  "<option value='"+vComponentes.codigo+"'>"+vComponentes.descripcion +"</option>";
                    vArrComponentes.push(vComponentes);
                }
                cadBact += "</select>";
                cadBact += "  </div>";

                $('#infoComponentes').hide();
                $('#infoComponentes').html(cadBact);
      //          $('#infoComponentes').html(data);
                $('#infoComponentes').show();

            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                $('#waiting').hide();
                $('#message').fadeOut(400);
                $('#message').fadeIn(400);
                $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                $('#infoComponentes').hide();

            }
        });

        return false;
    }


    function seleccBacteriologa(codBact){//Seleccionar la bacteriologa del popup menu.

    //    jAlert("para cambiar la bact "+codBact, "Informaci&oacute;n");

      $cadSelect = $('#detalleRespBact').html();
      $cadSelect=$cadSelect.replace("selected","");
      $cadSelect=$cadSelect.replace("value=\""+codBact+"\"","value=\""+codBact+"\" selected");
      $('#detalleRespBact').html($cadSelect);
      vDonante.bacteriologa =$('#detalleRespBact :selected').val() ;// e.target.value;


    //  jAlert("Para seleccionar digite el codigo de la bacteriologa", "Informaci&oacute;n");
    //  console.log("acutalizado "+txtCodBacteriologa.value);

      return false;
    }


    function ocultarExamenFisico(vMostrar){
    //    jAlert("ocultando", "Informaci&oacute;n");
    //    $('#idExamenFisico').hide();
      var rows = $('table.Demograficos tr');
        var eFisico = rows.filter('.eFisico');

        var rows2 = $('table.DatosBusqueda tr');
      var eFisico2 = rows2.filter('.eFisico');

      var rows3 = $('div');
      var eDemograficos = rows3.filter('.cDemograficos');

      switch(vMostrar){
        case 1:
          var vTxtBtn = "Mostrar E.Fisico";
          eFisico.show();
              eFisico2.show();
              eDemograficos.show();
          break;
        default:
          var vTxtBtn = "Ocultar E.Fisico";
          eFisico.hide();
              eFisico2.hide();
              eDemograficos.hide();
          break;

      }
      $('#bExamenFisico').value=vTxtBtn;
      return 1-vMostrar;//prender o apagar.


    }


    function ocultarMostrarDemograficos (vMostrar){
      var rows = $('table.Demograficos tr');
        var eDemograficos = rows.filter('.eDemograficos');

      var vsoloBact = $('.cSoloBacteriologa');

      switch (vMostrar) {
        case 0:
          eDemograficos.hide();
          vsoloBact.show();

          break;
        default :
          eDemograficos.show();
          vsoloBact.hide();
          break;
      }
      return 1-vMostrar;

    }


    function ocultarMostrarBacteriologa (vMostrar){
      var rows = $('table.Demograficos tr');
        var eBacteriologa = rows.filter('.eBacteriologaLlenar');
        //var eBact2 = $('table.Demograficos tr');
      switch (vMostrar) {
        case 0:
          eBacteriologa.hide();
          break;
        default :
          eBacteriologa.show();
          break;
      }
      return 1-vMostrar;
    }




    function mostrarDlgImpBarras(){

      $numOT = $('#txtOrden').val();
      vDonante.otcodBarras=$numOT;
      $cadImpBarras = '<textarea  name="idOTxImprimir" id="idOTxImprimir" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset"  >'+$numOT+'</textarea>';
      $('#idOTxImprimir').html($cadImpBarras);//$cad2+
      //$("#txtDialogo").attr('readonly','false');
      //$("#idOTxImprimir").attr('readonly','false');

      //$( "#miAlerta" ).popup( "open" );
    //  $.mobile.changePage('#paginaClaveUsuario','slide');

      $.mobile.changePage('#miAlerta','slide');

      return ;

    }


    function imprimirCodBarras(){

      mostrarDlgImpBarras();


      return;

    }

    function impCodBarra(codBarra,impresora){

        if (codBarra!=""){

            $.ajax({
                type : 'POST',
                url : "../ajax/imprimirCodBarrasDonante.php",
                dataType : 'html',
                data: {
                    txtOrden : codBarra,//"0071734BD"// ,"0071734BD"//
                    txtcualimpresora : impresora
                },
                success : function(data){
                  var obj = eval('('+data+')');//convierte el texto a JSON
                  if (obj.resultado==codBarra){
                    jAlert("Impresos los codigos de barras del donante # "+codBarra, "Barras "+codBarra);
                  }
                    //alert(data+" "+codBarra);

                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('No se encontro Donante').show(500);

                }
            });
        }

      return;
    }




    function showDialog()//encuesta del donante .
    {




      getMaxCriticidad();


        var infoEncuesta = "";

    //jAlert("enencuesta");

        if ($('#txtOrden').val()!= ""){
            $('#waiting').show();

            $.ajax({
                type : 'POST',
                url : "../ajax/ShowRespEncuestaDemograficos.php",
                dataType : 'html',
                data: {
                    num_ot : $('#txtOrden').val()//"0071734BD"// ,"0071734BD"//
                },
                success : function(data){
                  //alert(data);
                    infoEncuesta  = data;
                    infoEncuesta2 = data;
     //$('#pagina2').hide();
                    $('#waiting').hide();

                    $('#infoDlgEncuesta').html(data);
     //               $('#pagina2').show();


     $.mobile.changePage('#pagina2','slide');

    //$('#pagina1').hide();
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al buscar la encuesta').show(500);


                }
            });


    //jAlert("infomracion data "+infoEncuesta2, "Informaci&oacute;n");
    /*
            if (1){//(infoEncuesta!=""){
                $("#infoDlgEncuesta").dialog({
                  resizable :false,
                    height: 400,
                    width: 800,
                    modal: true,

                    buttons: {
                  Salir: function() {
                    $( this ).dialog( "close" );
                  }
                }

                });

            }else jAlert("No se encontro informacion de la encuesta", "Informaci&oacute;n");
    */
        }else{
            jAlert("Falta Seleccionar un número de encuesta","Encuesta");
        }


    }


    function showComponentes()

    //Boton de componentes
    {

      if (vDonante.orden==""){
        jAlert("Falta  el Numero de la Orden","Componentes");
        return;

      }

        if (vDonante.examenfisicoOK=="PE"){
          //jAlert("Falta  el Examen Fisico","Componentes");
          //return;
        }else if (vDonante.examenfisicoOK=="RE"){
        //  jAlert("Donante Rechazado por Examen Fisico","Componentes");
        //  return;

        }
    //alert("en componentes");

        var infoEncuesta = "";


        vHoy = new Date();
        var $fechaStr = fSumarAFecha(vHoy.toString('yyyy-mm-dd'),0,0,0);
        console.log("sumar fecha "+$fechaStr);
        var $arrHoy=  $fechaStr.split("-");
        var $fecha2Hoy = "";
        for ($i=0;$i<$arrHoy.length;$i++){
          switch ($i){
            case 0:
              $fecha2Hoy = $arrHoy[$i];
              break;
            case 1:
              $numMes = parseInt($arrHoy[$i])+1;
              $numMes = parseInt($arrHoy[$i]);
              if ($numMes<10){
                $mesStr = "0"+$numMes;
              }else{
                $mesStr = $numMes;
              }
              $fecha2Hoy += "-"+($mesStr);
              break;
            case 2:
              $fecha2Hoy += "-"+$arrHoy[$i];
              break;


          }

        }

       console.log("fecha hoy"+$fecha2Hoy);

        $vNomComponentes = "";
        $arr1Componetes= vArrComponentesSeleccionados;


        if (vDonante.orden!= ""){//$('#txtOrden').val()
            $('#waiting').show();

            $.ajax({
                type : 'POST',
                url : "../ajax/GetInfoComponentes.php",
                dataType : 'html',
                data: {
                  donante : vDonante.orden
                },
                success : function(data){


                    $('#waiting').hide();

                    var obj = eval('('+data+')');//convierte el texto a JSON

                    var cadBact="";
                    cadBact = "<div id=\"infoComponentes\">";

                   //cadBact += "<div class='ui-select'><div class='ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c' data-theme='c' data-iconpos='right' data-icon='arrow-d' data-wrapperels='span' data-iconshadow='true' data-shadow='true' data-corners='true'><span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'><span>PLAQUETAS MANUALES</span></span><span class='ui-icon ui-icon-arrow-d ui-icon-shadow'>&nbsp;</span></span>";

                    console.log($fechaStr+" == "+$('#txtFecha').val());
                    if ($fecha2Hoy == $('#txtFecha').val()  ){//OJO no usar txtFecha.value
                      cadBact += "<select name=\"infoComponentes\" id=\"infoComponentes\" > ";
                      cadBact +=  "<option>COMPONENTES</option>";

                    }
                   // $ccJqmovil= "<div class='ui-select'><div data-corners='true' data-shadow='true' data-iconshadow='true' data-wrapperels='span' data-icon='arrow-d' data-iconpos='right' data-theme='c' class='ui-btn ui-shadow ui-btn-corner-all ui-btn-icon-right ui-btn-up-c'><span class='ui-btn-inner ui-btn-corner-all'><span class='ui-btn-text'><span>".$this->Name."</span></span><span class='ui-icon ui-icon-arrow-d ui-icon-shadow'>&nbsp;</span></span>";



                   // cadBact += "<option >Componentes</option>";
                    //cad2 = "<br><table  width = '98%' background='../Movil4.jpg' border='1' >";
                    console.log(obj.componentes);

                    for (var i=0;i<obj.componentes.length;i++){
                        var vComponentes = new Componentes();
                        vComponentes.codigo = obj.componentes[i]["codigo"];
                        vComponentes.descripcion = obj.componentes[i]["descripcion"];
                        vComponentes.relacion = obj.componentes[i]["relacion"];

                        //console.log(obj.componentes[i]["codigo"]);
                        if ($arr1Componetes.indexOf(vComponentes.codigo)>=0){
                          if ($vNomComponentes==""){

                            $vNomComponentes="<br><div id='popNomComponentes' >"+"<ul data-role='listview' data-inset='true'  class='ui-listview ui-listview-inset ui-corner-all ui-shadow' style='padding:10px;'>";
                          }
                          $vNomComponentes += "<li class='ui-li ui-li-static ui-btn-up-c' > "+obj.componentes[i]["descripcion"]+"</li> ";
                          //$vNomComponentes += "</td></tr> ";
                          //vArrComponentesSeleccionados.push(vComponentes.codigo );

                        }

                        if ($fecha2Hoy == $('#txtFecha').val()  ){//OJO no usar txtFecha.value
                          cadBact +=  "<option value=\""+vComponentes.codigo+"\">"+vComponentes.descripcion +"</option>";
                      }
                        vArrComponentes.push(vComponentes);
                        //$cad2 += "<tr><td> "+obj.componentes[i]["descripcion"]+"</td></tr> ";
                    }


                    //$cad2 += "</table>";
                    if ($fecha2Hoy == $('#txtFecha').val()  ){
                      cadBact += "</select>";
                    }

                     cadBact += "  </div>";

                    if ($vNomComponentes!=""){

                        $vNomComponentes += "</ul>";
                        cadBact += "<br><br>"+$vNomComponentes;
                    }else{

                      cadBact += "<div id='popNomComponentes'></div>";//aqui van los elementos seleccionados.
                    }

                    console.log("los componentes "+$vNomComponentes) ;
                    console.log("los componentes "+cadBact) ;

                    $('#infoComponentes').html(cadBact);//$cad2+
                    $('#infoComponentes').show();
                    if ($vNomComponentes!=""){

                     }else{
                      $vNomComponentes = "<div id='popNomComponentes'></div>";
                    }
                     //$('#popNomComponentes').html($vNomComponentes);//$cad2+

                    //$('#popNomComponentes').show();


        //console.log(cadBact);

        //$('.Demograficos').hide();



              //  $.mobile.changePage('#pagina3','slide');

                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                    $('#infoComponentes').hide();

                }
            });



        }else{
          jAlert("Falta Seleccionar un numero de encuesta","Componentes");
          //  jAlert("Falta Seleccionar un numero de encuesta", "Informaci&oacute;n");
        }


    }


    function actualizarEstadoEncuesta($vOrden ,$vEstado , $vObservacion) {

      if ($vOrden=="") return ;

      $.ajax({
              type : 'POST',
              url : "../ajax/actualizarEstadoEncuesta.php",
              dataType : 'html',
              data: {
                wsTxtOrden : $vOrden,
                wsTxtObservaciones : $vObservacion,
                wsTxtEstado : $vEstado


              },
              success : function(data){
                //alert(data+" "+$valor);
                var vObj = eval('('+data+')');
                jAlert("actualizado a :"+vObj.estado, "Informaci&oacute;n");

                actualizarCampoTextoSoloLectura(vDonante.encuestaOK,'idEncuestaTxt');//
                  $('#waiting').hide();


            $("#botonEncuesta").prop('value', 'Encuesta<'+vDonante.encuestaOK+'>');
            if (vDonante.encuestaOK=="OK"){$("#botonEncuesta").css("background-color", "green");}
            else { $("#botonEncuesta").css("background-color", "red"); }
            $("#botonEncuesta").button('refresh');


              },

                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al actualizar la encuesta').show(500);


                }
            });
    }




    function getMaxCriticidad() {

      if ($('#txtOrden').val()=="") return ;

      $.ajax({
              type : 'POST',
              url : "../ajax/getEncuestaCriticidad.php",
              dataType : 'html',
              data: {
                wsTxtOrden : $('#txtOrden').val(),

              },
              success : function(data){
                //alert(data+" "+$valor);
                var vObj = eval('('+data+')');
                malasEncuesta = vObj.criticidad;
                  $('#waiting').hide();
              },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al actualizar la encuesta').show(500);


                }
            });
    }


     function clickSi($p , $valorInic){
        //jAlert("CLARO QUE "+$p);
      $nomPop = '#popRes_'+$p+' :selected';
      $valor = $($nomPop).val();


      if (confirm('Desea actualizar a '+$valor+'?')) {
        //jAlert("valor "+$valor, "Informaci&oacute;n");

        $.ajax({
              type : 'POST',
              url : "../ajax/actualizarRespuestaEnc4d.php",
              dataType : 'html',
              data: {
                wsTxtOrden : $('#txtOrden').val(),
                wsTxtPregunta : $p,
                wsTxtRespuestaEnc : $valor

              },
              success : function(data){
                //alert(data+" "+$valor);
                var vObjActualizaEnc = eval('('+data+')');
                $carita = vObjActualizaEnc.carita;

    //jAlert("../css/images/"+$carita, "Informaci&oacute;n");

            $('#imagen_'+$p).hide();
                $('#imagen_'+$p).attr("src", "../css/images/"+$carita);
                if ($carita =="feliz.png") $("#imagen_"+$p).css("background", "#a5e283");
              else  $("#imagen_"+$p).css("background", "#ea7e7e");

    $('#imagen_'+$p).show();

             //console.log(data);

                if (vObjActualizaEnc.respuesta != $valor){
                  jAlert("No se actualizo la respuesta", "Informaci&oacute;n");
                  //vObjActualizaEnc.ctamalas
                }
                console.log("malas "+vObjActualizaEnc.malas);
                malasEncuesta = vObjActualizaEnc.malas;
                  $('#waiting').hide();
              },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#waiting').hide();
                    $('#message').fadeOut(400);
                    $('#message').fadeIn(400);
                    $('#message').removeClass().addClass('error').text('Error al actualizar la encuesta').show(500);


                }
            });



        //actualizar el valor

      }else{
        //actualizarPopUp("SI",'popRes_'+$p);
        if ($valorInic==1) actualizarPopUp("SI",'popRes_'+$p);
        else if ($valorInic==0)  actualizarPopUp("NO",'popRes_'+$p);

      }

    }

    function clickOpcionesEnc($p){
      clickSi($p , -1);

    //    alert($p);//clickOpcionesEnc
    }


    function clickAceptarEncDemo(){

    //Rechazar o Aceptar
      $vEstadoDef ="";
      var $vEstado =$('#encAceptarDemo :selected').val();// $('#encAceptarDemo :selected').text();
      if (malasEncuesta==0){
    //se puede hacer cualqueira de las 2
        if ($vEstado=="1") $vEstadoDef ="OK";
        else $vEstadoDef ="RE";
      }else if (malasEncuesta==1){
    //aceptar solo si es condicional
        if ($vEstado=="1") $vEstadoDef ="OC";
        else $vEstadoDef ="RE";
      }else{
        $vEstadoDef = "RE";
      }
      console.log("de aceptar con malas "+malasEncuesta);
    console.log(encComentarios.value);
      console.log($vEstado+" "+$vEstadoDef+" "+$('#txtOrden').val());
    //return ;

      if (confirm('Desea actualizar el estado de la encuesta a :'+$vEstadoDef+'?')) {
        vDonante.encuestaOK = $vEstadoDef;
        actualizarEstadoEncuesta($('#txtOrden').val(),$vEstadoDef, encComentarios.value);

      }


    }

    function irAEncuesta(){



      tipoencuesta.value = "0";
      num_ot.value = vDonante.orden;
      $('#num_ot').val(vDonante.orden);

      $('#tipoEncuesta').val("0");
      document.forms[0].action='../apl/det_encuesta.php';//encuesta.php';
      document.forms[0].submit();

      //empezarEncuesta();

    }

    function irAMenuPpal(){
      tipoencuesta.value = "0";
      num_ot.value = "";
      $('#num_ot').val("");

      $('#tipoEncuesta').val("0");
    //  document.forms[0].action='../apl/menuDonante.php';
      document.forms[0].action='../../dona.html';
      document.forms[0].submit();

    }

    function irAEncuestaPosDonacion(){
      tipoencuesta.value = "1";
      //$('#tipoEncuesta').val("1");

      document.forms[0].action='../apl/det_encuesta.php';//'../apl/encuesta.php';
      document.forms[0].submit();

    }


    function mostrarHeaderBuscar(){

    }


    function empezarEncuesta() {//copiada de encuesta.js

    num_ot.value = vDonante.orden;
                txtOrden.value = vDonante.orden;//13 NOV
                $('#num_ot').val(vDonante.orden);

        document.forms[0].action='../apl/det_encuesta.php';//'../apl/encuesta.php';
      document.forms[0].submit();



      //  showPregunta(0)
    }


    function corregirCedula(){
      num_ot.value = vDonante.orden;
      var $numCedula = vDonante.cedula;


      if ($numCedula==""){
        jAlert("No se ha ingresado el numero de la cedula", "ID");

        }else {
          $nuevaCedula = prompt("Digite el nuevo numero de ID",$numCedula);
          if ($nuevaCedula=="") return;
          if ($nuevaCedula===vDonante.cedula){
            jAlert("No hay cambio", "Informaci&oacute;n");
            return;
          }

          if (confirm("Desea actualizar el ingreso "+vDonante.orden+" con la cedula "+$nuevaCedula )){

          $.ajax({
                  type : 'POST',
                  url : "../ajax/actualizarCedula.php",
                  dataType : 'html',
                  data: {
                    wsTxtOrden : vDonante.orden,
                    wsTxtCedula : vDonante.cedula,
                    wsTxtNuevaCedula : $nuevaCedula

                  },
                  success : function(data){
                    //alert(data+" "+$valor);
                    var vObj = eval('('+data+')');
                    console.log(data);
                    if (vObj.error==""){
                      vDonante.cedula = vObj.cedula ;//$nuevaCedula;
                      actualizarCampoTexto(vDonante.cedula,'txtCedula','text');
                      jAlert("Actualizada a:"+vDonante.cedula, "ID");
                    }else {
                      jAlert("No se pudo actualizar el numero de cedula", "ID");
                    }
                      $('#waiting').hide();

                  },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        $('#waiting').hide();
                        $('#message').fadeOut(400);
                        $('#message').fadeIn(400);
                        $('#message').removeClass().addClass('error').text('Error al actualizar el numero de la cedula').show(500);


                    }
                });



          }
        }


    }



    $('.volverDeComponentes').click(function() {//ok del dialogo
    //  $('#bComponentes').text="Componentes "+vArrComponentesSeleccionados.length;
      $("#bComponentes").prop('value', 'Componentes <'+vArrComponentesSeleccionados.length+'>');
        jAlert("componetes seleccionados"+vArrComponentesSeleccionados.length,"Componentes")

      $("#bComponentes").button('refresh');

    });



    function fGrabarComponentes(){
      if (vEsDonacionHoy){
        $.mobile.changePage('#pagina1','slide');
        grabarDonante();


      }else{ jAlert("La Donación no es de Hoy","Componentes");}

    }
    function fGrabarEncuesta(){
      if (vEsDonacionHoy){
        $.mobile.changePage('#pagina1','slide');
        grabarDonante();


      }else{ jAlert("La Donación no es de Hoy","Encuesta");}

    }

    function fGrabarExFisico(){


      //alert("grabando ");
      if (vEsDonacionHoy){
        $.mobile.changePage('#pagina1','slide');
        grabarDonante();

      }else{ jAlert("La Donación no es de Hoy","Examen Fisico");}
    }




    function fSalirExamenFisico(){
      $.mobile.changePage('#pagina1','slide');
    }


    $('.verificar-clave').click(function() {//verificar la clave de la bacteriologa
      //verificar-clave
        vBactSel = $('#idBactXClave :selected').val();
       $clave = $('#idClaveUsuario').val();
      $.mobile.changePage('#pagina1','slide');

      //alert("Sale de verificar la clave");

     });


    function fLeerVariableSesion(variable ){

      var respuesta = "";
      //  alert("variable "+variable+" valor "+valorVar);
       $('#waiting').show();

        var $actualizado;
        $actualizado = 0;

        $var1 = variable;


        $.ajax({
            type : 'POST',
            url : "../ajax/getVariableSesion.php",
            dataType : 'html',
            data: {
                nombrevar : $var1
            },
            success : function(data){
       //         alert(data);
                respuesta = data;
                $actualizado = 1;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                $('#waiting').hide();
                $('#message').fadeOut(400);
                $('#message').fadeIn(400);
                $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                $('#detalleRespBact').hide();
                $actualizado = -1;
            }
        });


     // alert(" en xsaaaacccttuaa "+$actualizado);

       return respuesta;
    }



    function fActualizarVarSesion(variable , valorVar){

      //  alert("variable "+variable+" valor "+valorVar);
       $('#waiting').show();

        var $actualizado;
        $actualizado = 0;

        $var1 = variable;
        $valor = valorVar;


        $.ajax({
            type : 'POST',
            url : "../ajax/actualizarvarsesion.php",
            dataType : 'html',
            data: {
                nombrevar : $var1 ,
                valorvar : $valor
            },
            success : function(data){
     //           alert(data);
                $actualizado = 1;
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                $('#waiting').hide();
                $('#message').fadeOut(400);
                $('#message').fadeIn(400);
                $('#message').removeClass().addClass('error').text('Error al ejecutar la busqueda. Informe a sistemas').show(500);
                $('#detalleRespBact').hide();
                $actualizado = -1;
            }
        });


     // alert(" en xsaaaacccttuaa "+$actualizado);

       return $actualizado;
    }

