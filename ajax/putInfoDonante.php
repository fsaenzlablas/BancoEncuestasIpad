<?php



        $_SESSION[$donante]['encOtDon'] = $_POST['num_ot'];
        $_SESSION[$donante]['encCCDon'] = $_POST['cedula'];

        $_SESSION[$donante]['encNombreDon'] = $_POST['nombres'];
        $_SESSION[$donante]['encApellido1Don'] = $_POST['apellido1'];
        $_SESSION[$donante]['encApellido2Don'] = $_POST['apellido2'];
        $_SESSION[$donante]['encReceptor'] = $_POST['receptor'];
        $_SESSION[$donante]['encSexDonante'] = $_POST['sexo'];
        $_SESSION[$donante]['cod_bact'] = $_POST['codbact'];

        
?>
