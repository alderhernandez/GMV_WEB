<?php
class Pedidos_model extends CI_Model
{
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
                $query = $this->db->query("SELECT * FROM pedido WHERE VENDEDOR IN (".$query->result_array()[0]['RUTA'].")");                
            }
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
            
            $update = $this->db->query("SELECT ESTADO FROM pedido WHERE IDPEDIDO='".$id."' AND ESTADO = '3' ");

            
            if ($update->num_rows() == 0) {
                if ($this->session->userdata('RolUser') == '2') {

                    $datos = array('ESTADO' => 2);
                    $this->db->update('pedido', $datos, array('IDPEDIDO' => $id));
                }
            }
                        
            foreach($query->result_array() as $key){
                $json['data'][$i]['ARTICULO'] = $key['ARTICULO'];
                $json['data'][$i]['DESCRIPCION'] = '<p class="negra">'.$key['DESCRIPCION'].'</p>';
                $json['data'][$i]['CANTIDAD'] = number_format($key['CANTIDAD'],0);
                $json['data'][$i]['PRECIO'] = $key['TOTAL'];
                $json['data'][$i]['TOTAL'] = number_format($key['CANTIDAD']*str_replace($rempla, '', $key['TOTAL']),2);//number_format($key['CANTIDAD']*$key['TOTAL'],2,',','');
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
        
        $query = $this->db->query("SELECT COUNT(IDPEDIDO) PENDIENTE, (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '3') PROCESADO,
                                (SELECT COUNT(IDPEDIDO) FROM PEDIDO WHERE ESTADO = '2') VISUALIZADO FROM pedido WHERE ESTADO IN ('1', '2') ");
        if ($query->num_rows()>0) {
                $json[0][0] = "PENDIENTES";
                $json[0][1] = intval($query->result_array()[0]['PENDIENTE']);
                $json[1][0] = "PROCESADO";
                $json[1][1] = intval($query->result_array()[0]['PROCESADO']);
                $json[2][0] = "VISUALIZADOS";
                $json[2][1] = intval($query->result_array()[0]['VISUALIZADO']);
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
    public function ajaxPedidoComen($id)
    {
        $this->db->where('IDPEDIDO',$id);
        $query = $this->db->get('pedido');
        if ($query->num_rows()>0) {
            echo strtoupper($query->result_array()[0]['COMENTARIO']);
        }
    }
}