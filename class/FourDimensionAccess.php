<?php

/**
 * 4th Dimension Database
 *
 * @author Jaime Alvarez
 *
 */
include_once '../lib/nusoap/lib/nusoap.php';

class FourDimensionAccess {

    private $ipAddress;
    private $port;
    private $path4D;
    private $nameSpace = "http://www.lmla.com/namespace/default";
    private $server4D;
    private $client;

    function __construct($ipAddress="131.1.18.6", $port="8083") {
    //function __construct($ipAddress="131.1.18.103", $port="8081") {

        $this->ipAddress = $ipAddress;
        $this->port = $port;
        $this->server4D = "http://".$this->ipAddress . ":" . $this->port;
        $this->path4D = $this->server4D . '/4DSOAP';

    }

    function connect() {

               
        $this->client = new nusoap_client($this->path4D,false);
        
        $err = $this->client->getError();
        if ($err) {
            $html= '<h2>Constructor error</h2><pre>' . $err . '</pre>';
            $html.= '<h2>Debug</h2><pre>' . htmlspecialchars($this->client->getDebug(), ENT_QUOTES) . '</pre>';
            return $html;
         }
         
        return $this->client;
    }

    function disconnect() {
        unset($this->client);
    }

    function call4DWebServer( $method, $parameters=array()) {

        //print_r($parameters);
        return @$this->client->call($method, $parameters, $this->nameSpace);

    }
    
    function getServer() {
        return $this->ipAddress. ":" . $this->port;
    }

}

?>
