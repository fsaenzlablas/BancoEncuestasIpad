<?php

for ($i = 0; $i < sizeof($_SESSION['secuencias']); $i++) {
    $htmlCode = "<br>";

    $htmlCode .= "<table border='0' width='100%'>";

    $p=$_SESSION['codigos_pre'][$i];

    if ($i==0) {
        $_SESSION['primera_preg']=$p;
    }

    $htmlCode .= "<tr id='pregunta_$p'>";
    //$htmlCode .= "<td id='pregunta_{$p}_col1'  width='20%' align='center'><h3>{$_SESSION['secuencias'][$i]}/CodPreg:{$p}</h3></td>";
    $htmlCode .= "<td id='pregunta_{$p}_col1'  width='20%' align='center'><h3>{$_SESSION['secuencias'][$i]}</h3></td>";
    $htmlCode .= "<td id='pregunta_{$p}_col2'  width='80%' align='left'><h3>{$_SESSION['descripciones'][$i]}</h3></td>";
    $htmlCode .= "</tr>";

    $htmlCode .= "<tr id='respuesta_$p' >";
    $htmlCode .= "<td id='respuesta_{$p}_col1' width='20%' align='center'><img id='imagen_{$p}' width='40' height='40' src='../css/images/sinrespuesta.jpg' ></img></td>";
    $htmlCode .= "<td id='respuesta_{$p}_col2' width='80%' align='center'>{$_SESSION['objresp'][$i]}</td>";
    $htmlCode .= "</tr>";

    $htmlCode .= "</table>";
    $_SESSION['tmp']=$htmlCode;
   

    echo $htmlCode;
    
}
?>
