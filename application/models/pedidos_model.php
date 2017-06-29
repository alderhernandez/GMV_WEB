<?php
class Pedidos_model extends CI_Model
{
    public $rErick = "'F05','F09','F10','F11','F19','F20'";
    public $rVeronica = "'F03','F06','F07','F08','F13','F14'";
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function pedidos()
    {
        if ($this->session->userdata('RolUser')==2) {
            $query = $this->db->query("SELECT RUTA FROM view_misRutas
                                        WHERE IdResponsable = '".$this->session->userdata('id')."'");
            if ($query->num_rows()>0) {
                $query = $this->db->query("SELECT * FROM pedido WHERE VENDEDOR IN (".$query->result_array()[0]['RUTA'].") ORDER BY ESTADO LIMIT 200");                
            }
        }else if($this->session->userdata('RolUser') == 4 && $this->session->userdata('id') == 24){
                $query = $this->db->query("SELECT * FROM pedido WHERE VENDEDOR IN (".$this->rErick.") ORDER BY ESTADO");
        }else if($this->session->userdata('RolUser') == 4 && $this->session->userdata('id') == 17){
                $query = $this->db->query("SELECT * FROM pedido WHERE VENDEDOR IN (".$this->rVeronica.") ORDER BY ESTADO");
        }else{
            $query = $this->db->get('pedido');
        }        
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function detallePedido($id){
        $i=0;
        $json = array();
        $rempla = array('.00',',');

        $this->db->where('IDPEDIDO',$id);
        $query= $this->db->get('pedido_detalle');
        if($query->num_rows() > 0){
            
            $update = $this->db->query("SELECT ESTADO FROM pedido WHERE IDPEDIDO='".$id."' AND ESTADO IN ('3','4')");

            
            if ($update->num_rows() == 0) {
                if ($this->session->userdata('RolUser') == '2' || $this->session->userdata('RolUser') == '3') {

                    $datos = array('ESTADO' => 2);
                    $this->db->update('pedido', $datos, array('IDPEDIDO' => $id));
                }
            }
                        
            foreach($query->result_array() as $key){
                $json['data'][$i]['ARTICULO'] = $key['ARTICULO'];
                $json['data'][$i]['DESCRIPCION'] = '<p class="bold">'.$key['DESCRIPCION'].'</p>';
                $json['data'][$i]['CANTIDAD'] = number_format($key['CANTIDAD'],0);
                $json['data'][$i]['PRECIO'] = $key['TOTAL'];
                $json['data'][$i]['TOTAL'] = number_format($key['CANTIDAD']*str_replace($rempla, '', $key['TOTAL']),2);
                //number_format($key['CANTIDAD']*$key['TOTAL'],2,',','');
                //$json['data'][$i]['TOTAL'] = str_replace($rempla, '', $key['TOTAL'])."asda";
                $json['data'][$i]['BONIFICADO'] = $key['BONIFICADO'];
                $i++;
            }
        }
        echo json_encode($json);
    }
    public function cabeceraPedido($id)
    {
        $this->db->where('idPedido',$id);
        $query=$this->db->get('pedido');
        if ($query->num_rows()>0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function UpdateEstado($estado,$idPedido)
    {
        $data = array('Estado' => $estado);
        $this->db->where('idPedido',$idPedido);
        $this->db->update('pedido',$data);
    }
    
    public function pedidosPendientes(){
        if ($this->session->userdata('RolUser') == "2") {
            $query = $this->db->query("SELECT COUNT(IDPEDIDO) PENDIENTE, (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '3' 
                                    AND RESPONSABLE = '".$this->session->userdata('UserN')."') PROCESADO,
                                    (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '2' AND RESPONSABLE = '".$this->session->userdata('UserN')."')
                                    VISUALIZADO FROM pedido WHERE ESTADO IN ('1', '2') AND RESPONSABLE = '".$this->session->userdata('UserN')."'");
        }else{
        $query = $this->db->query("SELECT COUNT(IDPEDIDO) PENDIENTE, (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '3') PROCESADO,
                                (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '2') VISUALIZADO FROM pedido WHERE ESTADO IN ('1', '2')");
        }
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function ajaxGrafica()
    {
        $json = array();
        
        $query = $this->db->query("SELECT COUNT(IDPEDIDO) PENDIENTE, 
                                (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '3' AND FECHA_CREADA BETWEEN  SUBDATE(CURDATE(), DAYOFMONTH(CURDATE()) - 1) AND CURDATE()) PROCESADO,
                                (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '2' AND FECHA_CREADA BETWEEN  SUBDATE(CURDATE(), DAYOFMONTH(CURDATE()) - 1) AND CURDATE()) VISUALIZADO,
                                (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '4' AND FECHA_CREADA BETWEEN  SUBDATE(CURDATE(), DAYOFMONTH(CURDATE()) - 1) AND CURDATE()) ANULADO 
                                FROM pedido WHERE ESTADO IN ('1', '2')
                                AND FECHA_CREADA BETWEEN  SUBDATE(CURDATE(), DAYOFMONTH(CURDATE()) - 1) AND CURDATE()");
        if ($query->num_rows()>0) {
                $json[0][0] = "PENDIENTES";
                $json[0][1] = intval($query->result_array()[0]['PENDIENTE']);
                $json[1][0] = "PROCESADO";
                $json[1][1] = intval($query->result_array()[0]['PROCESADO']);
                $json[2][0] = "VISUALIZADOS";
                $json[2][1] = intval($query->result_array()[0]['VISUALIZADO']);
                $json[3][0] = "ANULADOS";
                $json[3][1] = intval($query->result_array()[0]['ANULADO']);
        }
        echo json_encode($json);
    }
    public function ajaxGraficaColum()
    {
        $json = array();
        $i = 0;
        $query = $this->db->query("CALL sp_Grafica_Pedido_Vendedor()");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json['name'][] = $query->result_array()[$i]['RUTA'];
                $json['data'][] = intval($query->result_array()[$i]['CANTIDAD']);

                $i++;
            }
        }
        echo json_encode($json);
    }
    public function ajaxGraficaLogaritmica()
    {
     $json = array();
        $i = 0;
        $query = $this->db->query("CALL sp_Grafica_Pedido_Vendedor()");
        if($query->num_rows()>0){
            foreach ($query->result_array() as $key) {
                $json['name'][0][] = $query->result_array()[$i]['RUTA'];
                $json['data'][0][] = intval($query->result_array()[$i]['CANTIDAD']);

                $i++;
            }
        }
        
        echo json_encode($json);
    }
    public function ajaxPedidoComen($id)
    {
        $this->db->where('IDPEDIDO',$id);
        $query = $this->db->get('pedido');
        if ($query->num_rows()>0) {
            echo strtoupper($query->result_array()[0]['COMENTARIO']);
        }
    }
    public function ajaxPedidoComenAnu($id)
    {
        $this->db->where('IDPEDIDO',$id);
        $query = $this->db->get('anulaciones');
        if ($query->num_rows()>0) {
            echo strtoupper($query->result_array()[0]['COMENTARIO']);
        }   
    }
    public function ajaxAnulacion($idPedido,$comentario){
        if ($this->session->userdata('RolUser') == "2" || $this->session->userdata('RolUser') == "3") {
        $query = $this->db->query("UPDATE pedido SET ESTADO = '4' WHERE IDPEDIDO = '".$idPedido."'");
        if ($query) {
            $datos = array('IDPEDIDO' => $idPedido,
                            'IDUSER' => $this->session->userdata('id'),
                            'COMENTARIO' => $comentario,
                            'FECHA' => date('Y-m-d H:i:s') 
                        );
            $query = $this->db->insert('anulaciones',$datos);
        }
            echo $query;
        }
    }
    public function ajaxConfirmacion($idPedido,$comentario)
    {
        if ($this->session->userdata('RolUser') == "2" || $this->session->userdata('RolUser') == "3") {
            $datos = array('COMENTARIO_CONFIR' => $comentario,
                        'ESTADO' => 3,
                        'FECHA_ULTIMA_ACTUALIZACION' => date('Y-m-d H:i:s')
                    );
            $this->db->where('IDPEDIDO',$idPedido);
            $query = $this->db->update('pedido',$datos);
        }
        echo $query;
    }
    public function ajaxPedidoSearch($f1 = "",$f2 = "", $tipo)
    {
        $json = array();
        $i = 0;
        $consulta = "SELECT * FROM pedido ";
        if($tipo != '7'){
            $consulta .= "WHERE ESTADO = '".$tipo."' ";
        }else{
            $consulta .= "WHERE ESTADO IN ('1','2','3','4') ";
        }
            if($f1 != '' && $f2 != ''){
            $consulta .= "AND FECHA_CREADA BETWEEN '".date('Y-m-d H:i:s',strtotime($f1))."' AND '".date('Y-m-d H:i:s',strtotime($f2." 23:59:59"))."' ";
        }
        if ($this->session->userdata('RolUser')==2) {
            $query = $this->db->query("SELECT RUTA FROM view_misRutas
                                        WHERE IdResponsable = '".$this->session->userdata('id')."'");
            if ($query->num_rows()>0) {
                $consulta .= "AND VENDEDOR IN (".$query->result_array()[0]['RUTA'].")";
            }
        }
        if ($this->session->userdata('RolUser')==4 && $this->session->userdata('id') == 24) {
            $consulta .= "AND VENDEDOR IN (".$this->rErick.")";
        }
        if ($this->session->userdata('RolUser')==4 && $this->session->userdata('id') == 17) {
            $consulta .= "AND VENDEDOR IN (".$this->rVeronica.")";
        }
        //echo $consulta;
        $query = $this->db->query($consulta);        
        if ($query->num_rows()>0) {
            foreach($query->result_array() as $key){
                switch ($key['ESTADO']) {
                                        case '1':
                                            $estado2 = '<i class="material-icons">check</i>';
                                            break;
                                        case '2':
                                            $estado2 = '<i class="material-icons">done_all</i>';
                                            break;
                                        case '3':
                                            $estado2 = '<i class="green-text material-icons">done_all</i>';
                                            break;
                                        case '4':
                                            $estado2 = '<i class="red-text material-icons">done_all</i>';
                                            break;
                                        default:
                                            $estado2 = 'ERROR AL OBTENER ESTADO';
                                            break;
                                    }
                                    switch ($key['ESTADO']) {
                                        case '1':
                                            $estado = '<p class="noMargen">PENDIENTE</p>';
                                            break;
                                        case '2':
                                            $estado = '<p class="noMargen">VISUALIZADO</p>';
                                            break;
                                        case '3':
                                            $estado = '<p class="green-text noMargen">PROCESADO</p>';
                                            break;
                                        case '4':
                                            $estado = '<p class="red-text noMargen">ANULADO</p>';
                                            break;
                                        default:
                                            $estado = 'ERROR AL OBTENER ESTADO';
                                            break;
                                    }
                $json['data'][$i]['IDPEDIDO'] = '<p class="negra noMargen">'.$key['IDPEDIDO'].'</p>';
                $json['data'][$i]['VENDEDOR'] = $key['VENDEDOR'];                
                $json['data'][$i]['RESPONSABLE'] = $key['RESPONSABLE'];
                $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                $json['data'][$i]['NOMBRE'] = $key['NOMBRE'];
                $json['data'][$i]['FECHA'] = $key['FECHA_CREADA'];
                $json['data'][$i]['MONTO'] = number_format($key['MONTO'],4);
                $json['data'][$i]['ESTADO'] = $estado;
                $json['data'][$i]['ICONO'] = $estado2;
                $json['data'][$i]['VER'] = "<a  onclick='getview(".'"'.$key['IDPEDIDO'].'"'.",".'"'.$key['NOMBRE']." ".$key['CLIENTE'].'"'.",".'"'.$key['VENDEDOR'].'"'.",".'"'.$key['ESTADO'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>";
                $i++;
            }    
        }else{
                $json['data'][$i]['IDPEDIDO'] = '-';
                $json['data'][$i]['VENDEDOR'] = "-";
                $json['data'][$i]['RESPONSABLE'] = "-";
                $json['data'][$i]['CLIENTE'] = "-";
                $json['data'][$i]['NOMBRE'] = "NO HAY DATOS";
                $json['data'][$i]['FECHA'] = "-";
                $json['data'][$i]['MONTO'] = "-";
                $json['data'][$i]['ESTADO'] = "-";
                $json['data'][$i]['ICONO'] = "-";
                $json['data'][$i]['VER'] = "-";
        }
        //echo $consulta;
        echo json_encode($json);
    }

}