<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_controller extends CI_Controller
{
 public function __construct(){
        parent::__construct();
        $this->load->library('session');

        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('agenda_model');
        $this->load->model('datos_model');
    }

    public function index(){
        $data['ruta'] = $this->agenda_model->traerRutas();
        $data['agendas'] = $this->datos_model->traerAgenda();
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/agenda/agenda',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_agenda');
    }
    public function cargaPlan(){
        
    }
    public function ajaxCalendario($IdPlan){
        $this->agenda_model->ajaxCalendario($IdPlan);
    }
}
 ?>