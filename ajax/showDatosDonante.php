<?php
//var_dump($_POST);
$num_ot = $_POST['num_ot'];

if (isset($_SESSION[$num_ot]['encOtDon'])) {

    $htmlCode = <<< HTML
    <div class='datosDonante'>
        CEDULA:  <strong>{$_SESSION[$num_ot]['encCCDon']} </strong>
        NOMBRES: <strong>{$_SESSION[$num_ot]['encNombreDon']} {$_SESSION[$num_ot]['encApellido1Don']} {$_SESSION[$num_ot]['encApellido2Don']}  </strong> Sexo:  <strong>{$_SESSION[$num_ot]['encSexDonante']} </strong>
        Consecutivo donaci&oacute;n: <strong> {$num_ot} </strong>
        <br>Bacteriologa responsable:  {$_SESSION[$num_ot]['nom_bact']}
    </div>
HTML;

    echo $htmlCode;
}

?>