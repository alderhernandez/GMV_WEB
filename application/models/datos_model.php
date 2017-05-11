<?php
class datos_model extends CI_Model
{
    public $serverName = "192.168.1.112";
    public  $connectionInfo = array( "Database"=>"PRODUCCION", "UID"=>"erpadmin", "PWD"=>"qaz123*+" );
    public  $conn; 

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
    }
    public function traerAgenda()
    {
        $this->db->where('Estado',1);
        $query = $this->db->get('agenda');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function guardarAgenda($nombre,$ruta,$f1,$f2){
        $datos = array('Estado' => 0);
        $this->db->update('agenda',$datos, array('Ruta' => $ruta));

        $datos = array( 'Vendedor' => $nombre,
                        'Ruta' => $ruta,
                        'Inicia' => date('Y-m-d',strtotime(str_replace("/", "-", $f1))),
                        'Termina' => date('Y-m-d',strtotime(str_replace("/", "-", $f2))),
                        'Zona' => $ruta,
                        'Estado' => 1
                    );
        $query = $this->db->insert('agenda',$datos);
    }
    public function guardarDetAgenda($d1,$d2,$d3,$d4,$d5,$comentarios,$ruta){
        $query = $this->db->query("SELECT IdPlan FROM agenda WHERE Estado = 1 AND Ruta = '".$ruta."'");
        if ($query->num_rows()>0) {
            $datos = array( 'IdPlan' => $query->result_array()[0]['IdPlan'],
                            'Lunes' => $d1,
                            'Martes' => $d2,
                            'Miercoles' => $d3,
                            'Jueves' => $d4,
                            'Viernes' => $d5,
                            'Obervaciones' => $comentarios
                        );
            $this->db->insert('vclientes',$datos);
        }
    }
}
?>