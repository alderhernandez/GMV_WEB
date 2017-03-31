<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoreo_controller extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('monitoreo_model');
    }
    public function index()
    {
        $data = $this->monitoreo_model->monitereo();
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/monitoreo/monitoreo',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_monitoreo');
    }
    public function detalleMonitoreo($vendedor,$tipo)
    {
        $this->monitoreo_model->detalleMonitoreo($vendedor,$tipo);
    }
    public function metaCobroCliente($vendedor)
    {
        $this->monitoreo_model->metaCobroCliente($vendedor);
    }
    public function ventaValores($vendedor)
    {
        $this->monitoreo_model->ventaValores($vendedor);
    }
    public function itemFacturados($vendedor)
    {
        $this->monitoreo_model->itemFacturados($vendedor);
    }
    public function montoFactura($vendedor)
    {
        $this->monitoreo_model->montoFactura($vendedor);
    }
    public function promedioItemFact($vendedor)
    {
        $this->monitoreo_model->promedioItemFact($vendedor);
    }
}
?>