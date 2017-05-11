<?php
class Grupos_model extends CI_Model
{
	public function __construct(){
        parent::__construct();
        $this->load->database();            
    }
    public function getSac()
    {
    	$this->db->where('Rol',2);
    	$this->db->where('Activo',1);
    	$query = $this->db->get('usuario');
    	if ($query->num_rows()>0) {
    		return $query->result_array();
    	}return 0;
    }
    public function guardarGrupos($nombre,$id){

        $query = $this->db->query("UPDATE grupos SET Estado = 0 WHERE IdResponsable = '".$id."'");
        $datos = array('NombreGrupo' => strtoupper($nombre),
                       'IdResponsable' =>$id,
                       'Estado' =>1,
                       'FechaCreada' => date('Y-m-d H:i:s')
                );
        $this->db->insert('grupos',$datos);
    }
    public function getGrupos(){
        $query = $this->db->query('SELECT
                                    grupos.IdGrupo,
                                    grupos.NombreGrupo,
                                    grupos.Estado,
                                    grupos.FechaCreada,
                                    CONCAT(usuario.Usuario," | ",usuario.Nombre) AS Responsable
                                    FROM grupos
                                    INNER JOIN usuario ON usuario.IdUser = grupos.IdResponsable
                                    WHERE Estado = 1');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function getVendedoresGrupoAct($IdGrupo)
    {
        $i = 0;
        $json = array();
        $query = $this->db->query('SELECT * FROM usuario WHERE Rol ="1" AND ACTIVO = 1 
                                    AND IdUser NOT IN (SELECT IdVendedor FROM view_GrupoAsignacion WHERE IdGrupo ="'.$IdGrupo.'" AND EstadoVendedor =1)');
            if ($query->num_rows()>0) {
                foreach ($query->result_array() as $key) {
                    $json['data'][$i]['IDUSUARIO'] = $key['IdUser'];
                    $json['data'][$i]['RUTA'] = $key['Usuario'];
                    $json['data'][$i]['NOMBRE'] = $key['Nombre'];
                    $i++;
                }
            }

        echo json_encode($json);
    }
    public function getVendedoresGrupo($IdGrupo)
    {
        $i = 0;
        $json = array();
        $this->db->where('IdGrupo',$IdGrupo);
        $this->db->where('EstadoVendedor',1);
        $query = $this->db->get('view_GrupoAsignacion');
        if ($query->num_rows()>0) {
            foreach ($query->result_array() as $key) {
                $json['data'][$i]['IDUSUARIO'] = $key['IdVendedor'];
                $json['data'][$i]['IDVENDEDOR'] = $key['Ruta'];
                $json['data'][$i]['NOMBRE'] = $key['Ruta']." ".$key['NombreRuta'];
                $i++;
            }
        }else{
            $json['data'][$i]['IDUSUARIO'] = "-";
                $json['data'][$i]['IDVENDEDOR'] = "NO HAY DATOS";
                $json['data'][$i]['NOMBRE'] = "-";
        }
        echo json_encode($json);
    }
    public function editarGrupo($grupo){
        $datos = explode(",", $grupo[0]);
        //$update = $this->db->query("UPDATE grupo_asignacion SET Estado = 0 WHERE IdGrupo = '".$datos[0]."'");
        $this->db->where('IdGrupo',$datos[0]);
        $this->db->delete('grupo_asignacion');
        for ($i = 0; $i <count($grupo); $i++) {
            $datos = explode(",", $grupo[$i]);
            
            //echo $datos[1];
            /*$this->db->where('IdGrupo',$datos[0]);
            $this->db->where('IdVendedor',$datos[1]);
            $query = $this->db->get('grupo_asignacion');
            if ($query->num_rows()>0) {
                $data = array('Estado' => 1, 'FechaCreada' => date("Y-m-d"));
                $this->db->where('IdGrupo',$datos[0]);
                $this->db->where('IdVendedor',$datos[1]);
                $query = $this->db->update('grupo_asignacion',$data);
            }else{*/
            if ($datos[1]) {            
                $data = array( 'IdGrupo' => $datos[0],
                                'IdVendedor' => $datos[1],
                                'Estado' => 1,
                                'FechaCreada' => date("Y-m-d")
                            );

                //$this->db->where('IdVendedor',$datos[1]);
                $query = $this->db->insert('grupo_asignacion',$data);
            }                
            //}
        }
        echo $query;
    }
}
?>