<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi_sub extends CI_Controller {
    
    public function __construct(){
        parent::__construct();      
        $this->load->model('main_model');
        $this->load->model('divisi_sub_model');
        $this->load->model('module_model');
        $this->load->library('cipasswordhash');
    }

    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('karyawan_divisi_sub/data_divisi_sub',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function data_divisi_sub(){
        $result = $this->divisi_sub_model->data_divisi_sub()->result_array();
        echo json_encode($result);
    }
     public function ambil_divisi_sub(){
        $id = $this->input->post('id',TRUE);
        $result = $this->divisi_sub_model->ambil_divisi_sub($id)->result_array();
        echo json_encode($result);
    }
    
    public function divisi_sub_detail(){
        $id   = $this->input->post('id',TRUE);
        $result = $this->divisi_sub_model->divisi_sub_detail($id)->row_array();
        echo json_encode($result);
    }

    public function divisi_sub_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('karyawan_divisi_sub/divisi_sub_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function divisi_sub_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('karyawan_divisi_sub/divisi_sub_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function divisi_sub_simpan(){
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['id_divisi']        = $this->input->post('id_divisi',TRUE);
        $result = $this->divisi_sub_model->divisi_sub_simpan($data);
        echo json_encode($result);
        
    }

    
    public function divisi_sub_update(){
        
        $key = $this->config->item('encryption_key');

        $data['id']         = $this->input->post('id',TRUE);
        $data['id_divisi']  = $this->input->post('id_divisi',TRUE);
        $data['nama']       = $this->input->post('nama',TRUE);
       

        $result = $this->divisi_sub_model->divisi_sub_update($data);
        echo json_encode($result);
        
    }

    
    
}
