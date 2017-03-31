<?php
class Pedidos_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function pedidos()
    {
        $query = $this->db->get('pedido');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    
}