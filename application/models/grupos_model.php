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
        $datos = array('NombreGrupo' => $nombre,
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
                                    ');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
    public function getVendedores(){
        $this->db->where('Rol',1);
        $this->db->where('Activo',1);
        $query = $this->db->get('Usuario');
        if ($query->num_rows()>0) {
            return $query->result_array();
        }return 0;
    }
}
?>