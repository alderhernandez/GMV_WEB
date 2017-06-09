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
        $this->load->model('agenda_model');
    }
    public function index(){
        $data['data'] = $this->pedidos_model->pedidos();
        //$data['ruta'] = $this->agenda_model->traerRutas();
        $data['pendientes'] = $this->pedidos_model->pedidosPendientes();
        //print_r($data['data']);
    	$this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/pedidos/pedidos',$data);
        $this->load->view('footer/footer');
        $this->load->view('jsview/js_pedido');
    }
    public function detallePedido($id)
    {
        $this->pedidos_model->detallePedido($id);        
    }
    public function cabeceraPedido()
    {
        $id=$this->input->post('name');
        $data['sc_get']=$this->pedidos_model->cabeceraPedido($id);
        $sc=json_encode($data['sc_get']);
        echo $sc;
    }
    public function UpdateEstado($estado,$idPedido)
    {
        $this->pedidos_model->UpdateEstado($estado,$idPedido);
    }
    public function ajaxGrafica()
    {
        $this->pedidos_model->ajaxGrafica();
    }
    public function ajaxGraficaColum()
    {
        $this->pedidos_model->ajaxGraficaColum();
    }
    public function ajaxPedidoComen($id)
    {
        $this->pedidos_model->ajaxPedidoComen($id);
    }
    public function ajaxPedidoComenAnu($id)
    {
        $this->pedidos_model->ajaxPedidoComenAnu($id);
    }
    public function ajaxAnulacion()
    {
        $this->pedidos_model->ajaxAnulacion($this->input->post('idPedido'),$this->input->post('comentario'));
    }
    public function ajaxConfirmacion()
    {
        $this->pedidos_model->ajaxConfirmacion($this->input->post('idPedido'),$this->input->post('comentario'));
    }
    public function ajaxPedidoSearch()
    {
        $this->pedidos_model->ajaxPedidoSearch($_POST['f1'],$_POST['f2'],$_POST['tipo']);
    }
}
?>