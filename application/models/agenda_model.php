<?php 
class Agenda_model extends CI_Model
{
	public function __construct(){
        parent::__construct();
        $this->load->database();            
    }
    public function traerRutas()
    {
    	$this->db->where('Rol',1);
    	$query = $this->db->get('usuario');
    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
}
?>