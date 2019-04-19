<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrscan extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('qrscan/qrscan_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
     
}
