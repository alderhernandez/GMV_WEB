<?php
class Reportes_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function pedidos_por_vendedor($fecha1,$fecha2)
    {
        $i=0;
        $json = array();
        $query = $this->db->query("SELECT VENDEDOR,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=1 THEN IDPEDIDO END) AS ENE,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=2 THEN IDPEDIDO END)  AS FEB,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=3 THEN IDPEDIDO END)  AS MAR,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=4 THEN IDPEDIDO END)  AS ABR,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=5 THEN IDPEDIDO END)  AS MAY,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=6 THEN IDPEDIDO END)  AS JUN,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=7 THEN IDPEDIDO END)  AS JUL,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=8 THEN IDPEDIDO END)  AS AGO,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=9 THEN IDPEDIDO END)  AS SEP,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=10 THEN IDPEDIDO END)  AS OCT,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=11 THEN IDPEDIDO END)  AS NOV,
                                            COUNT(CASE WHEN MONTH(FECHA_CREADA)=12 THEN IDPEDIDO END)  AS DIC
                                            FROM pedido
                                            WHERE FECHA_CREADA BETWEEN '".$fecha1."' AND '".$fecha2." 23:59:59'
                                            GROUP BY VENDEDOR");
                                   
        //echo $fecha1;
        if ($query->num_rows()>0) {
            foreach($query->result_array() as $key){
                $json['data'][$i]['VENDEDOR'] = '<p class="bold noMargen">'.$key['VENDEDOR']."</p>";
                $json['data'][$i]['ENE'] = $key['ENE'];
                $json['data'][$i]['FEB'] = $key['FEB'];
                $json['data'][$i]['MAR'] = $key['MAR'];
                $json['data'][$i]['ABR'] = $key['ABR'];
                $json['data'][$i]['MAY'] = $key['MAY'];
                $json['data'][$i]['JUN'] = $key['JUN'];
                $json['data'][$i]['JUL'] = $key['JUL'];
                $json['data'][$i]['AGO'] = $key['AGO'];
                $json['data'][$i]['SEP'] = $key['SEP'];
                $json['data'][$i]['OCT'] = $key['OCT'];
                $json['data'][$i]['NOV'] = $key['NOV'];
                $json['data'][$i]['DIC'] = $key['DIC'];
                $i++;
            }
        }
            $json['columns'][0]['data'] = "VENDEDOR";
            $json['columns'][0]['name'] = "VENDEDOR";
            $json['columns'][1]['data'] = "ENE";
            $json['columns'][1]['name'] = "ENE";
            $json['columns'][2]['data'] = "FEB";
            $json['columns'][2]['name'] = "FEB";
            $json['columns'][3]['data'] = "MAR";
            $json['columns'][3]['name'] = "MAR";
            $json['columns'][4]['data'] = "ABR";
            $json['columns'][4]['name'] = "ABR";
            $json['columns'][5]['data'] = "MAY";
            $json['columns'][5]['name'] = "MAY";
            $json['columns'][6]['data'] = "JUN";
            $json['columns'][6]['name'] = "JUN";
            $json['columns'][7]['data'] = "JUL";
            $json['columns'][7]['name'] = "JUL";
            $json['columns'][8]['data'] = "AGO";
            $json['columns'][8]['name'] = "AGO";
            $json['columns'][9]['data'] = "SEP";
            $json['columns'][9]['name'] = "SEP";
            $json['columns'][10]['data'] = "OCT";
            $json['columns'][10]['name'] = "OCT";
            $json['columns'][11]['data'] = "NOV";
            $json['columns'][11]['name'] = "NOV";
            $json['columns'][12]['data'] = "DIC";
            $json['columns'][12]['name'] = "DIC";
        echo json_encode($json);
        $this->sqlsrv->close();
    }
}