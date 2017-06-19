<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_controller extends CI_Controller
{
 public function __construct(){
        parent::__construct();
        $this->load->library('session');

        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('reportes_model');
    }

    public function index()
    {

    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/reportes/reportes');
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_reportes');
    }

    public function pedidos_por_vendedor($f1,$f2)
    {
        $this->reportes_model->pedidos_por_vendedor(date('Y-m-d',strtotime($f1)),date('Y-m-d',strtotime($f2)));
    }
}
?>