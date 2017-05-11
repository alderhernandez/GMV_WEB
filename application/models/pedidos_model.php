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

        $this->db->where('IDPEDIDO',$id);
        $query= $this->db->get('pedido_detalle');
        if($query->num_rows() > 0){
            $datos = array('ESTADO' => 2);
            $this->db->update('pedido', $datos, array('IDPEDIDO' => $id));
            $rempla = array('.00',',');
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
}