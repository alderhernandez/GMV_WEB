<?php
class Graficos_model extends CI_Model
{
	public $serverName = "192.168.1.112";
    public  $connectionInfo = array( "Database"=>"PRODUCCION", "UID"=>"sa", "PWD"=>"Server2012!" );
    public  $conn; 
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
    }
    public function GrfmetaVendedores()
    {
        $bln = array();
        //$bln['name'][] = 'alder';
        //$rows['name'] = 'VENDEDOR';
        $i=0;
        
            $array = $this->sqlsrv->fetchArray("SELECT CodVendedor,RecuperadoCredito FROM RECUPERADO");
            if (count($array)>0) {
                foreach($array as $key){
                    $bln['name'][] = $key['CodVendedor'];
                    $bln['data'][] = $key['RecuperadoCredito'];
                    $rows['data'][] = $key['CodVendedor'];
                    $i++;
                }
            }
        $rslt = array();
        array_push($rslt,$rows);
        array_push($rslt,$bln);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
    }
    public function GrfmetaVendedores2()
    {
        $bln = array();
        $i=0;
        
            $array = $this->sqlsrv->fetchArray("SELECT CodVendedor,RecuperadoContado FROM RECUPERADO");
            if (count($array)>0) {
                foreach($array as $key){
                    $bln['name'][] = $key['CodVendedor'];
                    $bln['data'][] = $key['RecuperadoContado'];
                    $rows['data'][] = $key['CodVendedor'];
                    $i++;
                }
            }
        $rslt = array();
        array_push($rslt,$rows);
        array_push($rslt,$bln);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
    }

}