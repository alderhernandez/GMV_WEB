<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged')==0){ //No aceptar a usuarios sin loguearse
            redirect(base_url().'index.php/login','refresh');
        }
        $this->load->model('datos_model');
        $this->load->model('agenda_model');
        $this->load->library('session');
        require_once(APPPATH.'libraries/Excel/reader.php');
    }
    public function index()
    {
        $data['ruta'] = $this->agenda_model->traerRutas();
        $data['agendas'] = $this->datos_model->traerAgenda();

        $this->load->view('header/header');
        $this->load->view('pages/menu');
        $this->load->view('pages/datos/datos',$data);
        $this->load->view('footer/footer'); 
        $this->load->view('jsview/js_datos'); 
    }
    
    public function subirPlan(){
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP-1251');
        $data->read($_FILES["file"]['tmp_name']);
        error_reporting(E_ALL ^ E_NOTICE);

        $nombre = $data->sheets[0]['cells'][5][2];
        $ruta = $data->sheets[0]['cells'][5][5];
        $f1 = $data->sheets[0]['cells'][7][2];
        $f2 = $data->sheets[0]['cells'][7][5];
        $d1;$d2;$d3;$d4;$d5;
        $comentarios;


        if ($nombre!="" && $ruta!="" && $f1!="" && $f2!="") {
        $this->datos_model->guardarAgenda($nombre,$ruta,$f1,$f2);
            for ($i=10; $i <= 30; $i++){
                if ($data->sheets[0]['cells'][$i][1]!="") {
                    $d1 .=$this->concat($data->sheets[0]['cells'][$i][1])."-";
                }
                if ($data->sheets[0]['cells'][$i][2]!="") {
                    $d2 .=$this->concat($data->sheets[0]['cells'][$i][2])."-";
                }
                if ($data->sheets[0]['cells'][$i][3]!="") {
                    $d3 .=$this->concat($data->sheets[0]['cells'][$i][3])."-";
                }
                if ($data->sheets[0]['cells'][$i][4]!="") {
                    $d4 .=$this->concat($data->sheets[0]['cells'][$i][4])."-";
                }
                if ($data->sheets[0]['cells'][$i][5]!="") {
                    $d5 .=$this->concat($data->sheets[0]['cells'][$i][5])."-";
                }
                if ($data->sheets[0]['cells'][$i][6]!="") {
                    $comentarios .=$data->sheets[0]['cells'][$i][6]."|-|";
                }
            }
        }
        
        for ($e=1; $e <=5 ; $e++) { 
            $variable = "d".$e."";
            $$variable = substr($$variable, 0, -1);
        }
        $this->datos_model->guardarDetAgenda($d1,$d2,$d3,$d4,$d5,$comentarios,$ruta);
        redirect('carga','refresh');
    }

    public function concat($IdCliente){

            switch (strlen($IdCliente)) {
            case '1':
                $IdCliente  ="0000".$IdCliente;
            break;
            case '2':
                $IdCliente  ="000".$IdCliente;
            break;
            case '3':
                $IdCliente  ="00".$IdCliente;
            break;
            case '4':
                $IdCliente  ="0".$IdCliente;
            break;
            case '5':
                $IdCliente  =$IdCliente;
            break;
        }
        return $IdCliente;
    }
}
?>