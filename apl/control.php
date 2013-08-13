<?php
/* 
 * Rutina para Mostrar  las respuestas que lleva un donante
 * Sirve para hacer debugger
 */
$num_ot=$_GET['num_ot'];

?>
<table border="1" style="font-size: 9px">
    <tr>

        <th>SESSION['secuencias']</th>
        <th>SESSION['codigos_pre']</th>
        <th>SESSION['descripciones']</th>

        <th>SESSION['tipos']</th>


        <th>SESSION['criticidades']</th>

        <th>SESSION['resperadas']</th>
        <th>SESSION['rdonante']</th>
        <th>SESSION['selecciones']</th>
        <th>SESSION['objresp']</th>
        <th>SESSION['tipos_sig']</th>
        <th>SESSION['cod_sig']</th>


    </tr>
    <?php
    for ($i = 0; $i < sizeof($_SESSION[$num_ot]['codigos_pre']); $i++) {
    ?>

        <tr>

        <?php
        $html = "";
        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['secuencias'][$i];
        $html.="</td>";

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['codigos_pre'][$i];
        $html.="</td>";

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['descripciones'][$i];
        $html.="</td>";

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['tipos'][$i];
        $html.="</td>";


        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['criticidades'][$i];
        $html.="</td>";


        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['resperadas'][$i];
        $html.="</td>";

        if (($_SESSION[$num_ot]['criticidades'][$i] == "0" ) or ($_SESSION[$num_ot]['criticidades'][$i] == "1" )) {

            if ($_SESSION[$num_ot]['resperadas'][$i] != $_SESSION[$num_ot]['rdonante'][$i]) {

                $html.="<td bgcolor='#FFFF00'>&nbsp;";
                $html.="{$_SESSION[$num_ot]['rdonante'][$i]}";
                $html.="</td>";
            } else {
                $html.="<td>&nbsp;";
                $html.="<font color='black'>{$_SESSION[$num_ot]['rdonante'][$i]}</font>";
                $html.="</td>";
            }
        } else {

            if ($_SESSION[$num_ot]['resperadas'][$i] != $_SESSION[$num_ot]['rdonante'][$i]) {

               $html.="<td bgcolor='#993333'>&nbsp;";
               $html.="<font color='white'>{$_SESSION[$num_ot]['rdonante'][$i]}</font>";
               $html.="</td>";
            } else {
                $html.="<td bgcolor='#FFCCCC'>&nbsp;";
                $html.="<font color='black'>{$_SESSION[$num_ot]['rdonante'][$i]}</font>";
                $html.="</td>";
            }
        }

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['selecciones'][$i];
        $html.="</td>";


        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['objresp'][$i];
        $html.="</td>";

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['tipos_sig'][$i];
        $html.="</td>";

        $html.="<td>&nbsp;";
        $html.=$_SESSION[$num_ot]['cod_sig'][$i];
        $html.="</td>";
        echo $html;
    }
        ?>

    </tr>


</table>

<?php

?>