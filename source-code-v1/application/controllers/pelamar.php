<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelamar extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('pelamar_model');
        
    }

    public function index(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('pelamar/pelamar_view',$data);
        }else{
           // echo "<script> window.location = 'main/logout' </script>";
        }

    }

    public function pelamar_data(){
        $result = $this->pelamar_model->pelamar_data()->result_array();
        echo json_encode($result);
    }
   
    
}
