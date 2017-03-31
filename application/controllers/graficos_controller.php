<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graficos_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('graficos_model');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
    }
    public function index(){
        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/main');
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_main');
    }
    public function GrfmetaVendedores()
    {
        $this->graficos_model->GrfmetaVendedores();
    }
    public function GrfmetaVendedores2()
    {
        $this->graficos_model->GrfmetaVendedores2();
    }
}