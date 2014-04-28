<?php
@session_start();//29 oct 2013

// ------------------------------------------------------------------------
// Programa: grabarEncuesta.php
//
// El programa realiza la grabacion de la encuesta en 4D,bcoreg la encuesta esta
// validada y no hay problema en grabarla. se consume un servicio web en
// 4D para ello.
// ------------------------------------------------------------------------

$donante = $_POST['donante'];


$codigos_bact=array();
$nombres_bact=array();


include_once("../class/class.PopUp.php");
include_once "../lib/shared/ez_sql_core.php";
include_once("../lib/ez_sql_mysql.php");
$db = new ezSQL_mysql(EZSQL_DB_USER, EZSQL_DB_PASSWORD, EZSQL_DB_NAME, EZSQL_DB_HOST);


  
//$sql = "SELECT * FROM banco_componentes ORDER BY posicion;";

$codigosParametros = array();
$preguntaPC = 0;
$preguntaPL = 0;
$preguntaTR = 0;

$encontradoPC = 0;
$encontradoPL = 0;
$encontradoTR = 0;
$comma_separated = "";
$sqlParametros = "SELECT * FROM banco_parametros ";
if ($parametros = $db->get_results($sqlParametros, ARRAY_A)) {
    foreach ($parametros as $parametro) {
        $vCod1 = $parametro['Pregunta_pc'];
        $vCod2 = $parametro['Pregunta_pl'];
        $vCod3 = $parametro['Pregunta_tr'];
        
        $comma_separated = " $vCod1, $vCod2 , $vCod3 ";//son enteros .
  
        $preguntaPC = $parametro['Pregunta_pc'];
        $preguntaPL =$parametro['Pregunta_pl'];
        $preguntaTR =$parametro['Pregunta_tr'];


     }
}
$arrCodEncuesta = array();
$arrValorEncuesta = array();

$vCodigoFiltrados = "";

$cmsSQl="";

if ($comma_separated!=""){//count($codigosParametros)>0){
   // $comma_separated = implode(",", $codigosParametros);
    //
    //  $sql = "SELECT * FROM banco_encuesta_enc_tmp e  WHERE e.Nro_Consecutivo = '$donante' AND e.Observaciones='SIN CONFIRMAR'";
  $sql = "SELECT * FROM banco_mvto_encuesta_tmp e  WHERE e.nro_Consecutivo = '$donante' ";//AND e.Observaciones='SIN CONFIRMAR'";
    if ($comma_separated != ""){
        $sql .=  " AND e.codigo IN ( $comma_separated ) AND e.valor ='SI' ";

    }
    //$cmsSQl= $sql;


    $vCodigoFiltrados = $sql;
    if ($arrRespEncuesta = $db->get_results($sql, ARRAY_A)) {
        foreach ($arrRespEncuesta as $encabeza) {
            if ( $encabeza['codigo'] == $preguntaPL){
                $encontradoPL = 1;

            }
            if ( $encabeza['codigo'] == $preguntaPC){
                $encontradoPC = 2;
            }
           if ( $encabeza['codigo'] == $preguntaTR){
                $encontradoTR = 4;
            }

            $cmsSQl .= " ".$encabeza['codigo'] ;
            array_push($arrCodEncuesta, $encabeza['codigo']);
            array_push($arrValorEncuesta, $encabeza['valor']);
           // $vCodigoFiltrados .= $encabeza['codigo'];
        }
    }

}




$sql = "SELECT * FROM banco_componentes ORDER BY codigo;";

// ------------------------------------------------------------------------
// Invocar la funcion para buscar los Usuarios
// ------------------------------------------------------------------------

$cadbact = "";
$c=",";
$comilla2=chr(34);// comilla doble "

$codEncuesta="";


$sumaPreguntasComponentes =$encontradoPC+$encontradoPL+$encontradoTR;
if ($users = $db->get_results($sql, ARRAY_A)) {
    $numItems = count($users);
    $i=0;
    foreach ($users as $user) {
        $i++;
        //$user['codigo'].posic
        $vValido= 1;

        if ($sumaPreguntasComponentes>0){
            $codEncuesta = $user['codigo'];
            if (($codEncuesta==4)||($codEncuesta==5)){
                 $vValido= 0;    
            }else if (($codEncuesta!=6) && ($codEncuesta!=7)){
                  
            }else if ( ($encontradoPL==0) or ($sumaPreguntasComponentes>1) ){
                        $vValido= 0; //   
            }


           
        }
         //$codigosParametros.
        if ($vValido==1){
            if ($cadbact!=""){
                $cadbact.=",";
            }
            $cadbact.=" { ";
            $cadbact.=$comilla2."codigo".$comilla2." : ".$comilla2.$user['codigo'].$comilla2;
            $cadbact.=$c.$comilla2."descripcion".$comilla2.": ".$comilla2.$user['descripcion'].$comilla2;
            $cadbact.=$c.$comilla2."relacion".$comilla2.": ".$comilla2.$user['relacion'].$comilla2;
            $cadbact.=$c.$comilla2."activo".$comilla2.": ".$comilla2."1".$comilla2;

            $cadbact.=$c.$comilla2."valido".$comilla2.": ".$comilla2.$cmsSQl.$comilla2;

            $cadbact.=" } ";
        }

    }



}


//  echo "{ 'componentes':[$cadbact] ,'filtro': '$vCodigoFiltrados' }";
//,'filtro': '$vCodigoFiltrados'
echo "{ 'componentes':[$cadbact]  }";

?>


