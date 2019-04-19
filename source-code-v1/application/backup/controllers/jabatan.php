<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {
    
    public function __construct(){
        parent::__construct();      
        $this->load->model('main_model');
        $this->load->model('jabatan_model');
        $this->load->model('module_model');
        $this->load->library('cipasswordhash');
    }

    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('karyawan_jabatan/data_jabatan',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function data_jabatan(){
        $result = $this->jabatan_model->data_jabatan()->result_array();
        echo json_encode($result);
    }
    
    public function jabatan_detail(){
        $id   = $this->input->post('id',TRUE);
        $result = $this->jabatan_model->jabatan_detail($id)->row_array();
        echo json_encode($result);
    }

    public function jabatan_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('karyawan_jabatan/jabatan_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function jabatan_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('karyawan_jabatan/jabatan_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function jabatan_simpan(){
        $data['nama']        = $this->input->post('nama',TRUE);
        $result = $this->jabatan_model->jabatan_simpan($data);
        echo json_encode($result);
        
    }

    
    public function jabatan_update(){
        
        $key = $this->config->item('encryption_key');

        $data['id']         = $this->input->post('id',TRUE);
        $data['nama']        = $this->input->post('nama',TRUE);
       

        $result = $this->jabatan_model->jabatan_update($data);
        echo json_encode($result);
        
    }

    
    
}
