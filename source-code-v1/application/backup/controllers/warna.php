<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warna extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('warna_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('warna/warna_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('warna/warna_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('warna/warna_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->warna_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->warna_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
        $id_warna   = $this->input->post('id_warna',TRUE);
        $result = $this->warna_model->detail($id_warna)->row_array();
        echo json_encode($result);
    }


    public function simpan(){
        
        $data['inisial'] = $this->input->post('inisial',TRUE);
        $data['nama']    = $this->input->post('nama',TRUE);
       
        $result = $this->warna_model->simpan($data);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        
        $data['inisial'] = $this->input->post('inisial',TRUE);
        $data['nama']    = $this->input->post('nama',TRUE);
       
        $data['id_warna']  = $this->input->post('id_warna',TRUE);
        
        $result = $this->warna_model->update($data);
        echo json_encode($result);
        
    }
    
    
    public function hapus(){
        
        $id_warna  = $this->input->post('id_warna',TRUE);
        
        $result = $this->warna_model->hapus($id_warna);
        echo json_encode($result);
        
    }
    
    
}
