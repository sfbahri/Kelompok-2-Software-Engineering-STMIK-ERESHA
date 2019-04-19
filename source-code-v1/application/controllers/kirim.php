<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('kirim_model');
    }


    function kirim_page(){
        
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kirim/kirim_page_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    function pesan_data(){
        $result = $this->kirim_model->pesan_data()->result_array();
        echo json_encode($result);
    }

    function survey_data(){
        $result = $this->kirim_model->survey_data()->result_array();
        echo json_encode($result);
    }
    

    function kirim_page_survey(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kirim/kirim_page_survey_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }


        
    }
}
