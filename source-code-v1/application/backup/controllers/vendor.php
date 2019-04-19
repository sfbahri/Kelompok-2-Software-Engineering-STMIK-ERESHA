<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('vendor_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('vendor/vendor_view',$data);
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
                $this->load->view('vendor/vendor_tambah_view',$data);
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
                $this->load->view('vendor/vendor_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->vendor_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->vendor_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
        $id_vendor   = $this->input->post('id_vendor',TRUE);
        $result = $this->vendor_model->detail($id_vendor)->row_array();
        echo json_encode($result);
    }


    public function simpan(){
        
        $data['nama']       = $this->input->post('nama',TRUE);
        $data['no_telp']    = $this->input->post('no_telp',TRUE);
        $data['email']      = $this->input->post('email',TRUE);
        $data['alamat']     = $this->input->post('alamat',TRUE);
       
        $result = $this->vendor_model->simpan($data);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        
        $data['nama']       = $this->input->post('nama',TRUE);
        $data['no_telp']    = $this->input->post('no_telp',TRUE);
        $data['email']      = $this->input->post('email',TRUE);
        $data['alamat']     = $this->input->post('alamat',TRUE);
        $data['id_vendor']  = $this->input->post('id_vendor',TRUE);
        
        $result = $this->vendor_model->update($data);
        echo json_encode($result);
        
    }
    
    
    public function hapus(){
        
        $id_vendor  = $this->input->post('id_vendor',TRUE);
        
        $result = $this->vendor_model->hapus($id_vendor);
        echo json_encode($result);
        
    }
    
    
}
