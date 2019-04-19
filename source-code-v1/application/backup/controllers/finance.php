<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('finance_model');
    }

    public function input_harga_dasar(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('finance/input_harga_dasar_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->finance_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('finance/popup_input_harga_dasar_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function simpan(){
        
           
        $data['kode_produk']       = $this->input->post('kode_produk',TRUE);
        $data['harga_modal']     = $this->input->post('harga_modal',TRUE);
        $data['harga_jual']          = $this->input->post('harga_jual',TRUE);
        $result = $this->finance_model->simpan($data);
        echo json_encode($result);    
        
    }
    
}
