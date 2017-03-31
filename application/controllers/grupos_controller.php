<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('grupos_model');
    }
    public function index()
    {        
        $data['dato'] = $this->grupos_model->getSac();
        $data['data'] = $this->grupos_model->getGrupos();
        $data['vendedor'] = $this->grupos_model->getVendedores();
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/grupos/grupos',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_grupos');
    }
    public function nuevoGrupo()
    {
        $query = $this->grupos_model->guardarGrupos($_POST['grupo'],$_POST['usuario']);
        redirect('grupos','refresh');
    }
}
?>