<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('pelanggan_model');
    }

    public function data_select(){
        $result = $this->pelanggan_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function simpan(){

        $data['nama']        = $this->input->post('nama',TRUE);
        $data['alamat']      = $this->input->post('alamat',TRUE);
        $data['nohp']        = $this->input->post('nohp',TRUE);
        $data['email']       = $this->input->post('email',TRUE);

        $result = $this->pelanggan_model->simpan($data);
        echo json_encode($result);
        
    }
    
    function get_detail_pelanggan(){
        $id_pelanggan        = $this->input->post('id_pelanggan',TRUE);
        $result = $this->pelanggan_model->get_detail_pelanggan($id_pelanggan)->row_array();
        echo json_encode($result);
    }
    
    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('pelanggan/pelanggan_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function data_pelanggan(){
        $result = $this->pelanggan_model->data_pelanggan()->result_array();
        echo json_encode($result);
    }
    
    public function pelanggan_detail(){
        $id   = $this->input->post('id',TRUE);
        $result = $this->pelanggan_model->pelanggan_detail($id)->row_array();
        echo json_encode($result);
    }

    public function pelanggan_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('pelanggan/pelanggan_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function pelanggan_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('pelanggan/pelanggan_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function pelanggan_simpan(){
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['alamat']      = $this->input->post('alamat',TRUE);
        $data['no_hp']       = $this->input->post('no_hp',TRUE);
        $data['email']       = $this->input->post('email',TRUE);
        $data['limit']       = $this->input->post('limit',TRUE);
        $result = $this->pelanggan_model->pelanggan_simpan($data);
        echo json_encode($result);
        
    }

    
    public function pelanggan_update(){
        
        $key = $this->config->item('encryption_key');

        $data['id']          = $this->input->post('id',TRUE);
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['alamat']      = $this->input->post('alamat',TRUE);
        $data['no_hp']       = $this->input->post('no_hp',TRUE);
        $data['email']       = $this->input->post('email',TRUE);
        $data['limit']       = $this->input->post('limit',TRUE);
       

        $result = $this->pelanggan_model->pelanggan_update($data);
        echo json_encode($result);
        
    }
    
    
}
