<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {
    
    public function __construct(){
        parent::__construct();      
        $this->load->model('main_model');
        $this->load->model('divisi_model');
        $this->load->model('module_model');
        $this->load->library('cipasswordhash');
    }

    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('karyawan_divisi/data_divisi',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function data_divisi(){
        $result = $this->divisi_model->data_divisi()->result_array();
        echo json_encode($result);
    }
    
    public function divisi_detail(){
        $id   = $this->input->post('id',TRUE);
        $result = $this->divisi_model->divisi_detail($id)->row_array();
        echo json_encode($result);
    }

    public function divisi_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('karyawan_divisi/divisi_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function divisi_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('karyawan_divisi/divisi_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function divisi_simpan(){
        $data['nama']        = $this->input->post('nama',TRUE);
        $result = $this->divisi_model->divisi_simpan($data);
        echo json_encode($result);
        
    }

    
    public function divisi_update(){
        
        $key = $this->config->item('encryption_key');

        $data['id']         = $this->input->post('id',TRUE);
        $data['nama']        = $this->input->post('nama',TRUE);
       

        $result = $this->divisi_model->divisi_update($data);
        echo json_encode($result);
        
    }

    
    
}
