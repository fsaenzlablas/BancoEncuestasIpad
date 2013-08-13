<?php


/**
 * Clase que permite hacer accesos via ODBC a Informix
 *
 * @author Jaime Alvarez
 */
require_once("../lib/nusoap.php");

class InformixDB {

    private $ipAddress;
    private $connName;
    private $wsdl;

    function __construct($ipAddress="131.1.18.12", $connName="informix") {
        $this->wsdl="http://".$ipAddress."/movil/wsInfoPac.php?wsdl";
    }

    
    function getData($historia) {

        
        $param=array();
        
        $param['tipoBusq'] = 'HC';
        //$param['nomTabla'] = 'inpaci';
        $param['nomTabla'] = 'inpac';
        $param['numDoc'] = $historia;

        //var_dump($param);
        //var_dump($this->wsdl);
        
        $client = new nusoap_client($this->wsdl, TRUE);
        $resultado = $client->call("buscarPac",$param);

        return $resultado;
      
    }

}

?>
