<?php
class Monitoreo_model extends CI_Model
{
	public $serverName = "192.168.1.112";
    public  $connectionInfo = array( "Database"=>"PRODUCCION", "UID"=>"sa", "PWD"=>"Server2012!" );
    public  $conn; 
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
    }
    public function monitereo(){
        $json = array();
        $i=0;
    	$array = $this->sqlsrv->fetchArray("SELECT * FROM VIEW_IMV_MONITOREO ORDER BY VENDEDOR ASC");
        
    	if (count($array)>0) {
            foreach ($array as $key ){
                $json['datos'][$i]['VENDEDOR'] = $key['VENDEDOR'];
                $json['datos'][$i]['NUMCLIENTE'] = $key['NUMCLIENTE'];
                $json['datos'][$i]['NO_ITEM_FACT'] = $key['NO_ITEM_FACT'];
                $json['datos'][$i]['VENTA_TOTAL'] = $key['VENTA_TOTAL'];
                $json['datos'][$i]['PROMEDIO_X_ITEM'] = $key['PROMEDIO_X_ITEM'];
                $json['datos'][$i]['PROMEDIO_X_FACTURA'] = $key['PROMEDIO_X_FACTURA'];                
                $json['datos'][$i]['RECEFECTIVO'] = "<a  onclick='getDetalle(".'"'.$key['VENDEDOR'].'",'.'"RECUPERACION EFECTIVO"'.','.'"1"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $json['datos'][$i]['ITEM_X_CLIENTE'] = "<a  onclick='getDetalle(".'"'.$key['VENDEDOR'].'",'.'"# ITEM POR CLIENTE"'.','.'"2"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $json['datos'][$i]['VENTAS_X_ARTICULO'] = "<a  onclick='getDetalle(".'"'.$key['VENDEDOR'].'",'.'"VENTAS POR ARTÍCULO"'.','.'"3"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $json['datos'][$i]['VENTAS_X_CLIENTE'] = "<a  onclick='getDetalle(".'"'.$key['VENDEDOR'].'",'.'"VENTAS POR CLIENTE"'.','.'"4"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $json['datos'][$i]['CLIENTES'] = "<a  onclick='getCliente(".'"'.$key['VENDEDOR'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $json['datos'][$i]['CUOTAXPRODUCTO'] = "<a  onclick='getDetalle(".'"'.$key['VENDEDOR'].'",'.'"CUOTA POR PROCUTO"'.','.'"5"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $i++;
            }
    		return $json;
    	}return 0;
    }
    public function recEfectivo($VENDEDOR)
    {
        $array = $this->sqlsrv->fetchArray("EXEC ");
    }
    public function detalleMonitoreo($VENDEDOR,$TIPO){        
        $json = array();
        $i=0;
        
        if ($TIPO=="1"){
            $array = $this->sqlsrv->fetchArray("EXEC SP_APP_VENTAS_RecuperacionVend '".date('Y-m-d')."',".$VENDEDOR."");
            if (count($array)>0) {            
                foreach($array as $key){
                    $json['data'][$i]['ID'] = $key['IdPeriodo'];
                    $json['data'][$i]['DESCRIPCION'] = $key['Descripcion'];
                    $json['data'][$i]['CodVendedor'] = $key['CodVendedor'];
                    $json['data'][$i]['RecuperadoCredito'] = number_format($key['RecuperadoCredito'],2);
                    $json['data'][$i]['RecuperadoContado'] = number_format($key['RecuperadoContado'],2);
                    $i++;
                }
                $json['columns'][0]['data'] = "ID";
                $json['columns'][0]['name'] = "ID";
                $json['columns'][1]['data'] = "DESCRIPCION";
                $json['columns'][1]['name'] = "DESCRIPCIÓN";
                $json['columns'][2]['data'] = "CodVendedor";
                $json['columns'][2]['name'] = "COD VENDEDOR";
                $json['columns'][3]['data'] = "RecuperadoCredito";
                $json['columns'][3]['name'] = "RECUPERADO CREDITO";
                $json['columns'][4]['data'] = "RecuperadoContado";
                $json['columns'][4]['name'] = "RECUPERADO CONTADO";
                echo json_encode($json);
            }
        }
        if ($TIPO=="2"){
                $array = $this->sqlsrv->fetchArray("SELECT CODIGO,[Cod. Cliente] AS CLIENTE,CLIENTE AS NOMBRECLIENTE, COUNT(DISTINCT ARTICULO) AS CANTIDAD, COUNT(DISTINCT FACTURA) AS FACTURA FROM dbo.app_ventas_master_detalle_vtas
                                                    WHERE CODIGO='".$VENDEDOR."'
                                                    GROUP BY [Cod. Cliente],CLIENTE,CODIGO");
                if(count($array)>0){
                    foreach($array as $key){
                        $json['data'][$i]['ID'] = $key['CODIGO'];
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NOMBRECLIENTE'];
                        $json['data'][$i]['CANTIDAD'] = $key['CANTIDAD'];
                        $json['data'][$i]['FACTURA'] = $key['FACTURA'];
                        $i++;
                    }
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "VENDEDOR";
                    $json['columns'][1]['data'] = "CLIENTE";
                    $json['columns'][1]['name'] = "COD CLIENTE";
                    $json['columns'][2]['data'] = "NOMBRECLIENTE";
                    $json['columns'][2]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][3]['data'] = "CANTIDAD";
                    $json['columns'][3]['name'] = "CANTIDAD";
                    $json['columns'][4]['data'] = "FACTURA";
                    $json['columns'][4]['name'] = "# DE FACTURAS";
                    echo json_encode($json);
                }
        }
        if ($TIPO=="3"){
                $array = $this->sqlsrv->fetchArray("SELECT CODIGO,ARTICULO,DESCRIPCION,SUM(Venta) AS VENTA,COUNT(DISTINCT FACTURA) AS CANTFACTURADA, SUM(CANTIDAD) UNIDADES FROM dbo.app_ventas_master_detalle_vtas
                                                    WHERE CODIGO='".$VENDEDOR."'
                                                    GROUP BY ARTICULO,DESCRIPCION,CODIGO");
                if(count($array)>0){
                    foreach($array as $key){
                        $json['data'][$i]['ID'] = $key['CODIGO'];
                        $json['data'][$i]['ARTICULO'] = $key['ARTICULO'];
                        $json['data'][$i]['DESCRIPCION'] = $key['DESCRIPCION'];
                        $json['data'][$i]['VENTA'] = number_format($key['VENTA'],2);
                        $json['data'][$i]['CANTFACTURADA'] = number_format($key['CANTFACTURADA'],0);
                        $json['data'][$i]['UNIDADES'] = number_format($key['UNIDADES'],2);
                        $i++;
                    }
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "VENDEDOR";
                    $json['columns'][1]['data'] = "ARTICULO";
                    $json['columns'][1]['name'] = "ARTÍCULO";
                    $json['columns'][2]['data'] = "DESCRIPCION";
                    $json['columns'][2]['name'] = "DESCRIPCIÓN";
                    $json['columns'][3]['data'] = "VENTA";
                    $json['columns'][3]['name'] = "VENTA";
                    $json['columns'][4]['data'] = "CANTFACTURADA";
                    $json['columns'][4]['name'] = "# DE FACTURAS";
                    $json['columns'][5]['data'] = "UNIDADES";
                    $json['columns'][5]['name'] = "UNIDADES";
                    echo json_encode($json);
                }
        }
        if ($TIPO=="4"){
                $array = $this->sqlsrv->fetchArray("SELECT CODIGO,[Cod. Cliente] AS CODCLIENTE,CLIENTE,SUM(Venta) AS VENTA,COUNT(DISTINCT FACTURA) AS FACTURA FROM dbo.app_ventas_master_detalle_vtas
                                                    WHERE CODIGO='".$VENDEDOR."'
                                                    GROUP BY [Cod. Cliente],CLIENTE,CODIGO");
                if(count($array)>0){
                    foreach($array as $key){
                        $json['data'][$i]['ID'] = '<p class="negra noMargen">'.$key['CODIGO'].'</p>';
                        $json['data'][$i]['CODCLIENTE'] = $key['CODCLIENTE'];
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['VENTA'] = '<p class="negra noMargen">'.number_format($key['VENTA'],2).'</p>';
                        $json['data'][$i]['FACTURA'] = '<p class="negra noMargen">'.number_format($key['FACTURA'],0).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "VENDEDOR";
                    $json['columns'][1]['data'] = "CODCLIENTE";
                    $json['columns'][1]['name'] = "COD CLIENTE";
                    $json['columns'][2]['data'] = "CLIENTE";
                    $json['columns'][2]['name'] = "CLIENTE";
                    $json['columns'][3]['data'] = "VENTA";
                    $json['columns'][3]['name'] = "VENTA";
                    $json['columns'][4]['data'] = "FACTURA";
                    $json['columns'][4]['name'] = "FACTURAS";
                    echo json_encode($json);
                }
        }if ($TIPO=="5"){

                $array = $this->sqlsrv->fetchArray("SELECT MAX(IdPeriodo) as IdPeriodo FROM metacuota WHERE MONTH(Fecha) = '".date('m')."' AND YEAR(Fecha) = '".date('Y')."'
                                                    AND Tipo = 'CUOTA'");
                if(count($array)>0){
                    $array = $this->sqlsrv->fetchArray("SELECT CodVendedor,CodProducto,NombreProducto,Meta FROM cuotaxproducto
                                                    WHERE CodVendedor = '".$VENDEDOR."' AND IdPeriodo = '".$array[0]['IdPeriodo']."'");
                    if(count($array)>0){
                        foreach($array as $key){
                            $json['data'][$i]['ID'] = '<p class="negra noMargen">'.$key['CodVendedor'].'</p>';
                            $json['data'][$i]['CODCLIENTE'] = $key['CodProducto'];
                            $json['data'][$i]['CLIENTE'] = $key['NombreProducto'];
                            $json['data'][$i]['VENTA'] = '<p class="negra noMargen">'.number_format($key['Meta'],2).'</p>';
                            $i++;
                        }
                        $json['columns'][0]['data'] = "ID";
                        $json['columns'][0]['name'] = "VENDEDOR";
                        $json['columns'][1]['data'] = "CODCLIENTE";
                        $json['columns'][1]['name'] = "COD ARTICULO";
                        $json['columns'][2]['data'] = "CLIENTE";
                        $json['columns'][2]['name'] = "NOMBRE ARTICULO";
                        $json['columns'][3]['data'] = "VENTA";
                        $json['columns'][3]['name'] = "META";
                        echo json_encode($json);
                    }
                }
        }
        if (count($array)==0){
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
        }
        
    }
    public function metaCobroCliente($VENDEDOR){
        $json = array();
        $i=0;
        $array = $this->sqlsrv->fetchArray("SELECT CLIENTE,NombreCliente,MetaCobro,Recuperado3MA,RecuperadoAct from dbo.app_ventas_carga_recuperacion_lp
                                            WHERE VENDEDOR='".$VENDEDOR."'");
                if(count($array)>0){
                    foreach($array as $key){                        
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NombreCliente'];
                        $json['data'][$i]['META'] = number_format($key['MetaCobro'],2);
                        $json['data'][$i]['3MA'] = number_format($key['Recuperado3MA'],2);
                        $json['data'][$i]['ACTUAL'] = number_format($key['RecuperadoAct'],2);
                        $json['data'][$i]['PENDIENTE'] = (($key['MetaCobro']-$key['RecuperadoAct'])<=0) ? '<p class="noMargen negra green-text">'.number_format($key['MetaCobro']-$key['RecuperadoAct'],2).'</p>':'<p class="noMargen negra red-text">'.number_format($key['MetaCobro']-$key['RecuperadoAct'],2).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "CLIENTE";
                    $json['columns'][0]['name'] = "COD CLIENTE";
                    $json['columns'][1]['data'] = "NOMBRECLIENTE";
                    $json['columns'][1]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][2]['data'] = "3MA";
                    $json['columns'][2]['name'] = "ANTERIOR";
                    $json['columns'][3]['data'] = "META";
                    $json['columns'][3]['name'] = "META";
                    $json['columns'][4]['data'] = "ACTUAL";
                    $json['columns'][4]['name'] = "ACTUAL";
                    $json['columns'][5]['data'] = "PENDIENTE";
                    $json['columns'][5]['name'] = "PENDIENTE";
                    echo json_encode($json);
                }else{
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
                }
    }
    public function ventaValores($VENDEDOR)
    {
        $json = array();
        $i=0;
        $array = $this->sqlsrv->fetchArray("SELECT CLIENTE,NombreCliente, MetaVentaEnValores,VentaEnValores3MAnt,VentaEnValoresAct FROM dbo.app_ventas_carga_indicadores_lp 
                                            WHERE VENDEDOR='".$VENDEDOR."'");
                if(count($array)>0){
                    foreach($array as $key){                        
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NombreCliente'];
                        $json['data'][$i]['META'] = number_format($key['MetaVentaEnValores'],2);
                        $json['data'][$i]['3MA'] = number_format($key['VentaEnValores3MAnt'],2);
                        $json['data'][$i]['ACTUAL'] = number_format($key['VentaEnValoresAct'],2);
                        $json['data'][$i]['PENDIENTE'] = (($key['MetaVentaEnValores']-$key['VentaEnValoresAct'])<=0) ? '<p class="noMargen negra green-text">'.number_format($key['MetaVentaEnValores']-$key['VentaEnValoresAct'],2).'</p>':'<p class="noMargen negra red-text">'.number_format($key['MetaVentaEnValores']-$key['VentaEnValoresAct'],2).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "CLIENTE";
                    $json['columns'][0]['name'] = "COD CLIENTE";
                    $json['columns'][1]['data'] = "NOMBRECLIENTE";
                    $json['columns'][1]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][2]['data'] = "3MA";
                    $json['columns'][2]['name'] = "PROMEDIO 3 MESES ANTERIORES";
                    $json['columns'][3]['data'] = "META";
                    $json['columns'][3]['name'] = "META";
                    $json['columns'][4]['data'] = "ACTUAL";
                    $json['columns'][4]['name'] = "ACTUAL";
                    $json['columns'][5]['data'] = "PENDIENTE";
                    $json['columns'][5]['name'] = "PENDIENTE";
                    echo json_encode($json);
                }else{
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
                }
    }
    public function itemFacturados($VENDEDOR)
    {
        $json = array();
        $i=0;
        $array = $this->sqlsrv->fetchArray("SELECT CLIENTE,NombreCliente, MetaNumItemFac,NumItemFac3MAnt,NumItemFacAct FROM dbo.app_ventas_carga_indicadores_lp
                                            WHERE VENDEDOR='".$VENDEDOR."'");
                if(count($array)>0){
                    foreach($array as $key){                        
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NombreCliente'];
                        $json['data'][$i]['META'] = number_format($key['MetaNumItemFac'],2);
                        $json['data'][$i]['3MA'] = number_format($key['NumItemFac3MAnt'],2);
                        $json['data'][$i]['ACTUAL'] = number_format($key['NumItemFacAct'],2);
                        $json['data'][$i]['PENDIENTE'] = (($key['MetaNumItemFac']-$key['NumItemFacAct'])<=0) ? '<p class="noMargen negra green-text">'.number_format($key['MetaNumItemFac']-$key['NumItemFacAct'],2).'</p>':'<p class="noMargen negra red-text">'.number_format($key['MetaNumItemFac']-$key['NumItemFacAct'],2).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "CLIENTE";
                    $json['columns'][0]['name'] = "COD CLIENTE";
                    $json['columns'][1]['data'] = "NOMBRECLIENTE";
                    $json['columns'][1]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][2]['data'] = "3MA";
                    $json['columns'][2]['name'] = "ANTERIOR";
                    $json['columns'][3]['data'] = "META";
                    $json['columns'][3]['name'] = "META";
                    $json['columns'][4]['data'] = "ACTUAL";
                    $json['columns'][4]['name'] = "ACTUAL";
                    $json['columns'][5]['data'] = "PENDIENTE";
                    $json['columns'][5]['name'] = "PENDIENTE";
                    echo json_encode($json);
                }else{
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
                }
    }
    public function montoFactura($VENDEDOR)
    {
        $json = array();
        $i=0;
        $array = $this->sqlsrv->fetchArray("SELECT CLIENTE,NombreCliente, MetaPromVtaPorFac,PromVtaPorFacAnt,PromVtaPorFacAct FROM dbo.app_ventas_carga_indicadores_lp 
                                            WHERE VENDEDOR='".$VENDEDOR."'");
                if(count($array)>0){
                    foreach($array as $key){                        
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NombreCliente'];
                        $json['data'][$i]['META'] = number_format($key['MetaPromVtaPorFac'],2);
                        $json['data'][$i]['3MA'] = number_format($key['PromVtaPorFacAnt'],2);
                        $json['data'][$i]['ACTUAL'] = number_format($key['PromVtaPorFacAct'],2);
                        $json['data'][$i]['PENDIENTE'] = (($key['MetaPromVtaPorFac']-$key['PromVtaPorFacAct'])<=0) ? '<p class="noMargen negra green-text">'.number_format($key['MetaPromVtaPorFac']-$key['PromVtaPorFacAct'],2).'</p>':'<p class="noMargen negra red-text">'.number_format($key['MetaPromVtaPorFac']-$key['PromVtaPorFacAct'],2).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "CLIENTE";
                    $json['columns'][0]['name'] = "COD CLIENTE";
                    $json['columns'][1]['data'] = "NOMBRECLIENTE";
                    $json['columns'][1]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][2]['data'] = "3MA";
                    $json['columns'][2]['name'] = "ANTERIOR";
                    $json['columns'][3]['data'] = "META";
                    $json['columns'][3]['name'] = "META";
                    $json['columns'][4]['data'] = "ACTUAL";
                    $json['columns'][4]['name'] = "ACTUAL";
                    $json['columns'][5]['data'] = "PENDIENTE";
                    $json['columns'][5]['name'] = "PENDIENTE";
                    echo json_encode($json);
                }else{
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
                }
    }
    public function promedioItemFact($VENDEDOR)
    {
        $json = array();
        $i=0;
        $array = $this->sqlsrv->fetchArray("SELECT CLIENTE,NombreCliente, MetaPromItemPorFac,PromItemPorFacAnt,PromItemPorFacAct FROM dbo.app_ventas_carga_indicadores_lp
                                            WHERE VENDEDOR='".$VENDEDOR."'");
                if(count($array)>0){
                    foreach($array as $key){                        
                        $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                        $json['data'][$i]['NOMBRECLIENTE'] = $key['NombreCliente'];
                        $json['data'][$i]['META'] = number_format($key['MetaPromItemPorFac'],2);
                        $json['data'][$i]['3MA'] = number_format($key['PromItemPorFacAnt'],2);
                        $json['data'][$i]['ACTUAL'] = number_format($key['PromItemPorFacAct'],2);
                        $json['data'][$i]['PENDIENTE'] = (($key['MetaPromItemPorFac']-$key['PromItemPorFacAct'])<=0) ? '<p class="noMargen negra green-text">'.number_format($key['MetaPromItemPorFac']-$key['PromItemPorFacAct'],2).'</p>':'<p class="noMargen negra red-text">'.number_format($key['MetaPromItemPorFac']-$key['PromItemPorFacAct'],2).'</p>';
                        $i++;
                    }
                    $json['columns'][0]['data'] = "CLIENTE";
                    $json['columns'][0]['name'] = "COD CLIENTE";
                    $json['columns'][1]['data'] = "NOMBRECLIENTE";
                    $json['columns'][1]['name'] = "NOMBRE CLIENTE";
                    $json['columns'][2]['data'] = "3MA";
                    $json['columns'][2]['name'] = "ANTERIOR";
                    $json['columns'][3]['data'] = "META";
                    $json['columns'][3]['name'] = "META";
                    $json['columns'][4]['data'] = "ACTUAL";
                    $json['columns'][4]['name'] = "ACTUAL";
                    $json['columns'][5]['data'] = "PENDIENTE";
                    $json['columns'][5]['name'] = "PENDIENTE";
                    echo json_encode($json);
                }else{
                    $json['data'][0]['ID'] = "0";
                    $json['data'][0]['EKISDE'] = "NO HAY DATOS";
                    $json['columns'][0]['data'] = "ID";
                    $json['columns'][0]['name'] = "RESULTADOS";
                    $json['columns'][1]['data'] = "EKISDE";
                    $json['columns'][1]['name'] = "MENSAJE";
                    echo json_encode($json);
                }
    }
}
?>