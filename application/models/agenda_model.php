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
    public function ajaxCalendario($IdPlan)
    {
        $query = $this->db->query("SELECT * FROM agenda WHERE  IdPlan='".$IdPlan."'");

        $json = array();
        $i=0;
        $segundo=0;
        $array = array("Lunes","Martes","Miercoles","Jueves","Viernes");
        if($query->num_rows() > 0){
            $this->db->where('IdPlan',$query->result_array()[0]['IdPlan']);
            $query2 = $this->db->get('vclientes');
            $fecha = $this->generarFecha($query->result_array()[0]['Inicia'],$query->result_array()[0]['Termina']);
            $hora = "00:00:00";
            if($query2->num_rows() > 0){
                foreach ($query2->result_array() as $key ) {
                    //echo $key['Lunes'];
                    $porciones = explode("-", $key['Lunes']);
                    for ($f=0; $f <count($porciones) ; $f++) { 
                        $json['Analisis'][$i]['title'] =  $porciones[$f];
                        $json['Analisis'][$i]['start'] = $fecha[0]." ".$hora;
                        $json['Analisis'][$i]['end'] =  $fecha[0];
                        $json['Analisis'][$i]['color'] =  '#3B91AD';
                        $hora = date('H:i:s', strtotime($hora) + 1800);
                        $i++;
                    }$hora = "00:00:00";
                    $porciones = explode("-", $key['Martes']);
                    for ($f=0; $f <count($porciones) ; $f++) { 
                        $json['Analisis'][$i]['title'] =  $porciones[$f];                        
                        $json['Analisis'][$i]['start'] = $fecha[1]." ".$hora;
                        $json['Analisis'][$i]['end'] =  $fecha[1];
                        $json['Analisis'][$i]['color'] =  '#3B91AD';
                        $hora = date('H:i:s', strtotime($hora) + 1800);
                        $i++;
                    }$hora = "00:00:00";
                    $porciones = explode("-", $key['Miercoles']);
                    for ($f=0; $f <count($porciones) ; $f++) { 
                        $json['Analisis'][$i]['title'] =  $porciones[$f];                        
                        $json['Analisis'][$i]['start'] = $fecha[2]." ".$hora;
                        $json['Analisis'][$i]['end'] =  $fecha[2];
                        $json['Analisis'][$i]['color'] =  '#3B91AD';
                        $hora = date('H:i:s', strtotime($hora) + 1800);
                        $i++;
                    }$hora = "00:00:00";
                    $porciones = explode("-", $key['Jueves']);
                    for ($f=0; $f <count($porciones) ; $f++) { 
                        $json['Analisis'][$i]['title'] =  $porciones[$f];                        
                        $json['Analisis'][$i]['start'] = $fecha[3]." ".$hora;
                        $json['Analisis'][$i]['end'] =  $fecha[3];
                        $json['Analisis'][$i]['color'] =  '#3B91AD';
                        $hora = date('H:i:s', strtotime($hora) + 1800);
                        $i++;
                    }$hora = "00:00:00";
                    $porciones = explode("-", $key['Viernes']);
                    for ($f=0; $f <count($porciones) ; $f++) {
                        $json['Analisis'][$i]['title'] =  $porciones[$f];
                        $json['Analisis'][$i]['start'] = $fecha[4]." ".$hora;
                        $json['Analisis'][$i]['end'] =  $fecha[4];
                        $json['Analisis'][$i]['color'] =  '#3B91AD';
                        $hora = date('H:i:s', strtotime($hora) + 1800);
                        $i++;
                    }
                }
            }
        }
        echo json_encode($json['Analisis']);
    }
    public function generarFecha($fechauno,$fechados)
    {
        $pila = array();  
        $fechaaamostar =$fechauno;
        while(strtotime($fechados) >= strtotime($fechauno)){     
            if(strtotime($fechados) != strtotime($fechaaamostar)){
                array_push($pila, $fechaaamostar);            
                $fechaaamostar = date("Y-m-d", strtotime($fechaaamostar . " + 1 day"));
            }else{
                array_push($pila, $fechaaamostar);            
                break;
            }
        }
        return $pila;
    }
    public function guardarComentario($IdPlan,$Comentario)
    {
        $datos = array('Comentario' => strtoupper($Comentario));
        $this->db->where('IdPlan',$IdPlan);
        $query = $this->db->update('agenda',$datos);
        echo $query;
    }
    public function traerComentario($IdPlan)
    {
        $this->db->where('IdPlan',$IdPlan);
        $this->db->select('Comentario');
        $query = $this->db->get('Agenda');
        if ($query->num_rows()>0) {
            if ($query->result_array()[0]['Comentario'] !="") {
                echo $query->result_array()[0]['Comentario'];
            }else{
                echo "NO HAY COMENTARIO";
            }
        }else{
            echo "No hay comentario";
        }
    }
}
?>