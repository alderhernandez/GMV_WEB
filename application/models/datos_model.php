<?php
class datos_model extends CI_Model
{
    public $serverName = "192.168.1.112";
    public  $connectionInfo = array( "Database"=>"PRODUCCION", "UID"=>"erpadmin", "PWD"=>"qaz123*+" );
    public  $conn; 

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
    }
    public function getDatos(){
        $array = $this->sqlsrv->fetchArray("SELECT * FROM metacuota WHERE Estado = '1'");
        return $array;
    }

    public function metaCuota($tipo,$fecha){        
    	$query = $this->sqlsrv->fetchArray("SELECT * FROM metacuota WHERE MONTH(Fecha) = '".date('m',strtotime($fecha))."'
    								        AND YEAR(Fecha)='".date('Y',strtotime($fecha))."' AND Tipo = '".$tipo."'");
    	if (count($query) > 0) {
            $stmt = sqlsrv_query($this->conn, "DELETE FROM MetaCuota WHERE IdPeriodo='".$query[0]['IdPeriodo']."'");
    	}
        $stmt = sqlsrv_query($this->conn,   "UPDATE MetaCuota SET Estado = 0 WHERE Tipo ='".$tipo."'");
        $stmt = sqlsrv_query($this->conn,   "INSERT INTO MetaCuota (Tipo,Descripcion,Fecha,Estado)
                                            VALUES ('".$tipo."','".$tipo."-".$fecha."','".date('Y-m-d',strtotime($fecha))."',1)");
    }

    public function subir($CodVendedor,$NombreVendedor,$Cliente,$NombreCliente,$MVenta,$NumFact,$MFactura,$Promedio){
    	$query = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) AS IdPeriodo FROM MetaCuota WHERE Tipo = 'META'");
        $stmt = sqlsrv_query($this->conn,   "INSERT INTO metas (CodVendedor,NombreVendedor,CodCliente,
                                            NombreCliente,MontoVenta,NumItemFac,MontoXFac,PromItemXFac,Usuario,FHGrabacion,IdPeriodo)
                                            VALUES ('".$CodVendedor."','".utf8_encode($NombreVendedor)."','".$Cliente."','".utf8_encode(str_replace("'", "", $NombreCliente))."'
                                            ,".$MVenta.",".$NumFact.",".$MFactura.",".$Promedio.",'".$this->session->userdata('id')."',".date('Y-m-d').",'".$query[0]['IdPeriodo']."')");
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }

    public function subir2($CodVendedor,$NombreVendedor,$CodCliente,$NombreCliente,$meta){
    	$query = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) AS IdPeriodo FROM MetaCuota WHERE Tipo = 'CUOTA'");
        $stmt = sqlsrv_query($this->conn,   "INSERT INTO CUOTAXPRODUCTO (CodVendedor,NombreVendedor,CodProducto,NombreProducto,Meta,FHGrabacion,IdPeriodo)
                                            VALUES ('".$CodVendedor."','".utf8_encode($NombreVendedor)."','".$CodCliente."','".utf8_encode(str_replace("'", "", $NombreCliente))."'
                                            ,'".$meta."','".date('Y-m-d')."','".$query[0]['IdPeriodo']."')");
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
    public function subirRecuperacion($CodVendedor,$NombreVendedor,$ReCredito,$ReContado,$fecha){
        $array = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) AS IdPeriodo FROM metacuota WHERE Estado='1' AND Tipo = 'RECUPERADO'");
        if (count($array)>0) {
            $serverName = "192.168.1.112";
            $connectionInfo = array( "Database"=>"PRODUCCION", "UID"=>"sa", "PWD"=>"Server2012!" );
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            if( $conn === false ) {
                 die( print_r( sqlsrv_errors(), true));
            }
            $sql = "INSERT INTO RECUPERADO (CodVendedor,NombreVendedor,RecuperadoCredito,RecuperadoContado,IdPeriodo)
                                VALUES ('".$CodVendedor."','".$CodVendedor."','".$ReCredito."','".$ReContado."','".$array[0]['IdPeriodo']."')";
            $stmt = sqlsrv_query( $conn, $sql);

            if( $stmt === false ) {
                 die( print_r( sqlsrv_errors(), true));
            }
        }
        
    }
    public function crearMetaCuota($fecha){
        $array = $this->sqlsrv->fetchArray("SELECT IdPeriodo FROM metacuota WHERE Tipo='RECUPERADO'
                            AND MONTH(Fecha) = MONTH('".date('d-m-Y',strtotime($fecha))."')
                            AND YEAR(Fecha) = YEAR('".date('d-m-Y',strtotime($fecha))."')");
        if (count($array)>0) {
            $this->sqlsrv->query("INSERT INTO metaCuota (Tipo,Descripcion, Fecha) VALUES ('RECUPERADO','META DE ".$fecha."','".$fecha."')");
            $this->sqlsrv->query("DELETE FROM RECUPERADO WHERE IdPeriodo='".$array[0]['IdPeriodo']."'");
        }
    }
    public function vistaPrevia($fecha,$tabla,$tipo){
        $query = $this->sqlsrv->fetchArray("SELECT * FROM metacuota WHERE MONTH(Fecha) = '".date('m',strtotime($fecha))."'
                                     AND YEAR(Fecha)='".date('Y',strtotime($fecha))."' AND Tipo = '".$tipo."'");
        if (count($query) > 0) {
            $query = $this->sqlsrv->fetchArray("SELECT * FROM ".$tabla." WHERE IdPeriodo = ".$query[0]['IdPeriodo']."");
            if (count($query) > 0) {
                return $query;
            }
        }return 0;
    }
    public function descartarDatos($id,$tabla){
        $stmt = $this->sqlsrv->query("DELETE FROM ".$tabla." WHERE IdPeriodo='".$id."'");
        $stmt = $this->sqlsrv->query("DELETE FROM metacuota WHERE IdPeriodo='".$id."'");
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        $this->reactivar();
    }
    public function reactivar(){
        $array1 = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) AS IdPeriodo FROM metacuota WHERE Tipo = 'META'");
        //echo count($array);
        if (@$array1[0]['IdPeriodo'] != "") {
            $this->sqlsrv->query("UPDATE metacuota SET Estado = 1 WHERE IdPeriodo = ".$array1[0]['IdPeriodo']."");
        }
        $array2 = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) AS IdPeriodo FROM metacuota WHERE Tipo = 'CUOTA'");
        if (@$array2[0]['IdPeriodo'] != "") {
            $this->sqlsrv->query("UPDATE metacuota SET Estado = 1 WHERE IdPeriodo = '".$array2[0]['IdPeriodo']."'");
        }
    }
    public function viewDatos($id,$tipo)
    {
        switch ($tipo) {
            case 'META':
                $vista = "VIEW_IMV_METAS";
                break;
            case 'CUOTA':
                $vista = "VIEW_IMV_CUOTA";
                break;
            default:
                $vista = "VIEW_IMV_RECUPERACION";
                break;
        }
        $i=0;
        $json = array();
        $array = $this->sqlsrv->fetchArray("SELECT * FROM dbo.".$vista." WHERE IdPeriodo = ".$id."");

        if (count($array)>0) {            

              if ($tipo=="META"){
                foreach($array as $key){
                    $json['data'][$i]['Tipo'] = $key['Tipo'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['NombreVendedor'] = $key['NombreVendedor'];
                    $json['data'][$i]['CodCliente'] = $key['CodCliente'];
                    $json['data'][$i]['NombreCliente'] = $key['NombreCliente'];
                    $json['data'][$i]['MontoVenta'] = number_format($key['MontoVenta'],0);
                    $json['data'][$i]['NumItemFac'] = $key['NumItemFac'];
                    $json['data'][$i]['MontoXFac'] = number_format($key['MontoXFac'],0);
                    $json['data'][$i]['PromItemXFac'] = $key['PromItemXFac'];
                    $i++;
                }
                $json['columns'][0]['data'] = "Tipo";
                $json['columns'][0]['name'] = "TIPO";
                $json['columns'][1]['data'] = "CodVendedor";
                $json['columns'][1]['name'] = "COD. VENDEDOR";
                $json['columns'][2]['data'] = "NombreVendedor";
                $json['columns'][2]['name'] = "VENDEDOR";
                $json['columns'][3]['data'] = "CodCliente";
                $json['columns'][3]['name'] = "COD CLIENTE";
                $json['columns'][4]['data'] = "NombreCliente";
                $json['columns'][4]['name'] = "CLIENTE";
                $json['columns'][5]['data'] = "MontoVenta";
                $json['columns'][5]['name'] = "MONTO VENTA";
                $json['columns'][6]['data'] = "NumItemFac";
                $json['columns'][6]['name'] = "NUM. ITEM X FACTURA";
                $json['columns'][7]['data'] = "MontoXFac";
                $json['columns'][7]['name'] = "MONTO X FACTURA";
                $json['columns'][8]['data'] = "PromItemXFac";
                $json['columns'][8]['name'] = "PROMEDIO ITEM X FACTURA";
            }else if ($tipo=="RECUPERADO"){
                foreach($array as $key){
                    $json['data'][$i]['Tipo'] = $key['Tipo'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['NombreVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['CodCliente'] = $key['CodCliente'];
                    $json['data'][$i]['NombreCliente'] = $key['NombreCliente'];
                    $json['data'][$i]['ReCredito'] = number_format($key['RecuperadoCredito'],0);
                    $json['data'][$i]['ReContado'] = number_format($key['RecuperadoContado'],0);
                    $i++;
                }
                $json['columns'][0]['data'] = "Tipo";
                $json['columns'][0]['name'] = "TIPO";
                $json['columns'][1]['data'] = "CodVendedor";
                $json['columns'][1]['name'] = "COD. VENDEDOR";
                $json['columns'][2]['data'] = "NombreVendedor";
                $json['columns'][2]['name'] = "VENDEDOR";
                $json['columns'][3]['data'] = "CodCliente";
                $json['columns'][3]['name'] = "COD CLIENTE";
                $json['columns'][4]['data'] = "NombreCliente";
                $json['columns'][4]['name'] = "CLIENTE";
                $json['columns'][5]['data'] = "ReCredito";
                $json['columns'][5]['name'] = "REC CREDITO";
                $json['columns'][6]['data'] = "ReContado";
                $json['columns'][6]['name'] = "REC CONTADO";
            }
            else{
                foreach($array as $key){
                    $json['data'][$i]['Tipo'] = $key['Tipo'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['NombreVendedor'] = $key['NombreVendedor'];
                    $json['data'][$i]['CodProducto'] = $key['CodProducto'];
                    $json['data'][$i]['NombreProducto'] = $key['NombreProducto'];
                    $json['data'][$i]['Meta'] = $key['Meta'];                 
                    $i++;
                }
                $json['columns'][0]['data'] = "Tipo";
                $json['columns'][0]['name'] = "TIPO";
                $json['columns'][1]['data'] = "CodVendedor";
                $json['columns'][1]['name'] = "COD. VENDEDOR";
                $json['columns'][2]['data'] = "NombreVendedor";
                $json['columns'][2]['name'] = "VENDEDOR";
                $json['columns'][3]['data'] = "CodProducto";
                $json['columns'][3]['name'] = "COD PRODUCTO";
                $json['columns'][4]['data'] = "NombreProducto";
                $json['columns'][4]['name'] = "DESCRIPCIÓN";
                $json['columns'][5]['data'] = "Meta";
                $json['columns'][5]['name'] = "META";
            }
        echo json_encode($json);
    }
    }
}
?>