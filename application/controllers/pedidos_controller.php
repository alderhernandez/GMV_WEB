<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){
            redirect(base_url().'index.php/login','refresh');
        }
    }
    public function index()
    {
        $data['data'] = $this->pedidos_model->pedidos();
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/pedidos/pedidos',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_monitoreo');
    }
}
?>