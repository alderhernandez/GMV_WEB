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
    public function getVendedoresGrupoAct($IdGrupo)
    {
        $i = 0;
        $json = array();
        $query = $this->db->query('SELECT * FROM usuario WHERE Rol ="1" AND ACTIVO = 1 
                                    AND IdUser NOT IN (SELECT IdVendedor FROM view_GrupoAsignacion WHERE IdGrupo ="'.$IdGrupo.'")');
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
        $query = $this->db->get('view_GrupoAsignacion');
        if ($query->num_rows()>0) {
            foreach ($query->result_array() as $key) {
                $json['data'][$i]['IDUSUARIO'] = $key['IdVendedor'];
                $json['data'][$i]['IDVENDEDOR'] = $key['IdVendedor'];
                $json['data'][$i]['NOMBRE'] = $key['Ruta']." ".$key['NombreRuta'];
                $i++;
            }
        }
        echo json_encode($json);
    }
}
?>