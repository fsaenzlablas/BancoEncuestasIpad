




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Laboratorio Medico las Americas</title>

      
        <script>
        function irALogin(){
            
                  //document.forms[0].action='../encuestas/apl/login.php';
                  document.forms[0].action='../../dona.html';
                 document.forms[0].submit();
        }

        
        
        </script>

    </head>


    <body >
        <!-- onload="irALogin();"-->
        

         <form name='login' action="login.php" method="post"  target="_self"  >
            <input type='hidden'   id='eFisico' name='eFisico' class='normal-field' value='0' />

         </form>
            
        <script>
        //alert("hola");
        irALogin();
        </script>

    </body>
</html>
