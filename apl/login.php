<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Laboratorio Medico las Americas</title>

        <link href="../css/login.css" rel="stylesheet" type="text/css">

		<script>
		function irADemograficos(){
			
//			if (confirm('Desea ir a los Demograficos del Donante?')) {

		   	//	window.open("loginDemograficos.php", "_self", "");
				  document.forms[0].action='../apl/validarlogindemograficos.php';
			     document.forms[0].submit();
//			}
		}
		function irEncuestaPostDonacion(){
//			alert('auotoexclusion');
			tipoencuesta.value = "1";
//			alert(tipoencuesta.value);
			 document.forms[0].action='../apl/validar_login.php';
		     document.forms[0].submit();
			

		}
		
		
		</script>

    </head>
    <?php
    include_once("../class/FourDimensionAccess.php");
    $database = new FourDimensionAccess();
    $server = $database->getServer();
    ?>

    <body onLoad="javascript:document.login.usuario.focus()">

        <form name='login' action="validar_login.php" method="post"  target="_self"  >

            <img src= "../css/images/logo.jpg" width='246' height='82' border='0'>

            <div class="blue">
                Sistema de Encuestas Banco de Sangre
            </div>

            <table>
                <tr >
                    <td width="20%" align="right">
                        <span class="text-login "></span>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr >
                    <td width="45%" align="right">
                        <span class="text-login ">Usuario:</span>
                    </td>
                    <td>
                        <input name="usuario" id="usuario" class="input-field" />
                    </td>
                </tr>
                <tr >
                    <td width="20%" align="right">
                        <span class="text-login "></span>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td width="45%" align="right">
                        <span class="text-login ">Contrase&ntilde;a:</span>
                    </td>
                    <td>
                        <input name="password" id="password" type="password" class="input-field" />
                       <input name="tipoencuesta" id="tipoencuesta" type="hidden" value="0" />

                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <br>
                        <?php if (isset($_GET["login"]) and ($_GET['login'] == "NO")) { ?>
                            <div class="error">Usuario o Contrase&ntilde;a Errada</div>
                        <?php } ?>
                        <br>

                    </td>
                </tr>


                <tr>
                    <td  colspan="2"  align="center">

                        <input type="button"  class="boton1" name="botDemograficos"  value="Ingresar Demograficos" onClick="irADemograficos();" >
                        <input type="submit"  class="boton1" name="botingresar"  value="Ingresar"  >
                        <input type="button"  class="boton1" name="botAutoexclusion"  value="Auto-exclusi&oacute;n Post-Donaci&oacute;n" onClick="irEncuestaPostDonacion();" >
                    </td>
 
                </tr>




                <tr>

                <tr>
                    <td colspan="2" align="center"> Ingrese usuario y password  <?php echo "4D Server: " . $server; ?> </td>
                </tr>

            </table>
        </form>

    </body>
</html>
