<?php

//
// buscar y mostrar la siguiente pregunta o al codigo de la pregunta que se le asigne manualmente
// en el URL
//

//echo "Anterior:" .$_SESSION[$num_ot]['cod_ant'];

//
// buscar y mostrar la siguiente pregunta o al codigo de la pregunta que se le asigne manualmente
// en el URL
//
@session_start();//29 oct 2013

$num_ot = $_POST['num_ot'];

if (isset($_POST['go'])) {

    $key = array_search($_POST['go'], $_SESSION[$num_ot]['codigos_pre']);

} else {

    if (isset($_SESSION[$num_ot]["current"])) {
        $keyCurrent = array_search($_SESSION[$num_ot]["current"], $_SESSION[$num_ot]['codigos_pre']);

        $key = ($keyCurrent == 0)? 0 : ($keyCurrent-1);
        // Si la pregunta es de seleccion salte una mas a la izquierda

        if ($_SESSION[$num_ot]["tipos"][$key] == "SELECCION") {
            $_SESSION[$num_ot]["rdonante"][$key]="";
            $key=$key-1;
        }


    } else {
        $key = 0;
    }
}


$_SESSION[$num_ot]["jaime"]=" Current Leido:  {$_SESSION[$num_ot]["current"]}  / El key actual: {$keyCurrent}  / El key Generado:  {$key}";


$htmlCode = "<br>";

$htmlCode .= "<table border='0' width='100%'>";

$p = $_SESSION[$num_ot]['codigos_pre'][$key];

$htmlCode .= "<tr id='pregunta_$p'>";
//$htmlCode .= "<td id='pregunta_{$p}_col1'  width='20%' align='center'><h3>{$_SESSION[$num_ot]['secuencias'][$i]}/CodPreg:{$p}</h3></td>";
$htmlCode .= "<td id='pregunta_{$p}_col1'  width='10%' align='center'><h3>{$_SESSION[$num_ot]['secuencias'][$key]}</h3></td>";
$htmlCode .= "<td id='pregunta_{$p}_col2'  width='90%' align='left' class='descPreg'><h3>{$_SESSION[$num_ot]['descripciones'][$key]}</h3></td>";
$htmlCode .= "</tr>";

$htmlCode .= "<tr id='respuesta_$p' >";
$htmlCode .= "<td id='respuesta_{$p}_col1' width='10%' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/sinrespuesta.jpg' /></td>";
$htmlCode .= "<td id='respuesta_{$p}_col2' width='90%' align='center'>{$_SESSION[$num_ot]['objresp'][$key]}</td>";
$htmlCode .= "</tr>";

$htmlCode .= "</table>";

$_SESSION[$num_ot]["rdonante"][$keyCurrent]="";
$_SESSION[$num_ot]["rdonante"][$key]="";

unset($_SESSION[$num_ot]["current"]);
$_SESSION[$num_ot]["current"]=$_SESSION[$num_ot]['codigos_pre'][$key];

$_SESSION[$num_ot]['tmp'] = $htmlCode;

echo $htmlCode;
?>
