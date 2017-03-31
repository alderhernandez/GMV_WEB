<?php
class Cobros_model extends CI_Model
{
	public function __construct(){
        parent::__construct();
        $this->load->database();            
    }
    public function cobros()
    {
    	$query = $this->db->get('cobros');
    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
}
?>