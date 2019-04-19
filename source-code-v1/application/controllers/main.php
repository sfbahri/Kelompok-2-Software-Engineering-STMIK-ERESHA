<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('module_model');
        $this->load->library('session');

    }
  
    public function page(){
        $token       = $_GET['TokEn'];
        $idus        = $_GET['IdUs'];
        $acv         = $_GET['AkTif'];
        
        $res_token = $this->main_model->check_token_main($token,$idus);
        $res_passtoken = $this->main_model->check_passusertoken($token,$idus,$acv);
        $data['tokens'] = $token;

        if($res_passtoken == '1'){
            //auth token
            if($res_token == '1'){
                $data['modules'] = $this->module_model->get_module()->result_array();
                $this->load->view('main/main_view',$data);
            }else{
                redirect(base_url('main/logout'));
            } 
        }else{
            redirect(base_url('main/logout'));
        }         
        
    }

    public function logout(){

            $nama_lengkap = $this->session->userdata('sess_nama');
            $username     = $this->session->userdata('sess_username');
            
        $this->session->sess_destroy();
        redirect(base_url('login/adminwebs'));
    }
    
    public function error_page(){
        $this->load->view('main/main_error_page_view');
    }
}
