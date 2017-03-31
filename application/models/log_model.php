<?php
class Log_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function guardarLog($modulo,$accion)
    {
    	$datos = array('Usuario' => $this->session->userdata('UserN'),
    				   'Fecha' => date('Y-m-d H:i:s'),
    				   'Modulo' =>$modulo,
    				   'Accion' =>$accion);
    	if ($this->session->userdata('logged')!=0) {
    		$this->db->insert('log',$datos);
    	}
    }
    public function rutas()
    {
    	$this->db->distinct();
    	$this->db->select('Usuario');
    	$query = $this->db->get('log');
    	
    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
    public function log()
    {
    	$query = $this->db->get('Log');
    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
}