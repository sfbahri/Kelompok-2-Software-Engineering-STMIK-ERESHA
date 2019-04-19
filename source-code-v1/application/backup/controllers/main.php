<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('profil_model');
        $this->load->model('module_model');
        $this->load->library('session');

    }
  
    public function page(){
        $token  = $_GET['token'];
        $nik    = $_GET['nik'];
        $acv    = $_GET['acv'];
        
        $res_token = $this->main_model->check_token_main($token,$nik);
        $res_passtoken = $this->main_model->check_passusertoken($token,$nik,$acv);
        $data['tokens'] = $token;

        if($res_passtoken == '1'){
            //auth token
            if($res_token == '1'){
                $r = $this->profil_model->get_avatar($nik);
                $data['img_foto'] = $r['img_foto'];
                $data['modules'] = $this->module_model->get_module()->result_array();
                $this->load->view('main/main_view',$data);
            }else{
                //echo "1";
                redirect(base_url('main/logout'));
            } 
        }else{
            //echo "2";
            redirect(base_url('main/logout'));
        }         
        
    }
    
    public function error_page(){
        $this->load->view('main/main_error_page_view');
    }

    public function logout(){

            $nama_lengkap = $this->session->userdata('sess_full_name');
            $username     = $this->session->userdata('sess_username');
            
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
    
}
