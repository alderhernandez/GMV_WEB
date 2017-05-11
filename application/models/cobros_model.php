<?php
class Cobros_model extends CI_Model
{
	public function __construct(){
        parent::__construct();
        $this->load->database();            
    }
    public function cobros(){

        if ($this->session->userdata('RolUser')==2){
            $query = $this->db->query("SELECT RUTA FROM view_misRutas
                                        WHERE IdResponsable = '".$this->session->userdata('id')."'");
            if ($query->num_rows()>0) {
                $query = $this->db->query("SELECT * FROM cobros WHERE RUTA IN (".$query->result_array()[0]['RUTA'].")");                
            }
        }else{
            $query = $this->db->query('SELECT * FROM cobros ORDER BY FECHA LIMIT 50');
        }

    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
    public function searchCobros($f1 = '',$f2 = ''){
        $i=0;
        $json = array();

        if (!empty($f1)) {
            $query= $this->db->query("SELECT * FROM cobros WHERE date(FECHA) BETWEEN '".date('Y-m-d',strtotime($f1))."' AND '".date('Y-m-d',strtotime($f2))."'");
        }else{
            $query= $this->db->query("SELECT * FROM cobros");
        }
        
        if($query->num_rows() > 0){
            foreach($query->result_array() as $key){
                $json['data'][$i]['IDCOBRO'] = '<p class="noMargen negra">'.$key['IDCOBRO'].'</p>';
                $json['data'][$i]['CLIENTE'] = $key['CLIENTE'];
                $json['data'][$i]['VENDEDOR'] = $key['RUTA'];
                $json['data'][$i]['TOTAL'] = number_format($key['IMPORTE'],2);
                $json['data'][$i]['TIPOPAGO'] = $key['TIPO'];
                $json['data'][$i]['OBSERVACION'] = $key['OBSERVACION'];
                $json['data'][$i]['FECHA'] = $key['FECHA'];
                $i++;
            }
        }
        echo json_encode($json);
    }
}
?>