<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kloter extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('kloter_model');
        
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kloter/kloter_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->kloter_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('kloter/kloter_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('kloter/kloter_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function rute(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('kloter/kloter_rute_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function detail(){
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $result = $this->kloter_model->detail($id_kloter)->row_array();
        echo json_encode($result);
    }
    
    public function kloter_rute_data(){
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $result = $this->kloter_model->kloter_rute_data($id_kloter)->result_array();
        echo json_encode($result);
    }
    
    public function kloter_rute_detail(){
        $id_kloter  = $this->input->post('id_kloter',TRUE);
        $id_rute    = $this->input->post('id_rute',TRUE);
        $result = $this->kloter_model->kloter_rute_detail($id_kloter,$id_rute)->row_array();
        echo json_encode($result);
    }


    public function simpan(){
        
        $data['nama']             = $this->input->post('nama',TRUE);
        $data['tgl_berangkat']    = $this->input->post('tgl_berangkat',TRUE);
        $data['tgl_pulang']       = $this->input->post('tgl_pulang',TRUE);
        
        $result = $this->kloter_model->simpan($data);
        echo json_encode($result);
        
    }
    
    public function simpan_rute(){
        
        $data['dari']      = $this->input->post('dari',TRUE);
        $data['kemana']    = $this->input->post('kemana',TRUE);
        $data['jam']       = $this->input->post('jam',TRUE);
        $data['id_kloter'] = $this->input->post('id_kloter',TRUE);
        
        $result = $this->kloter_model->simpan_rute($data);
        echo json_encode($result);
        
    }
    
    public function update_rute(){
        
        $data['dari']      = $this->input->post('dari',TRUE);
        $data['kemana']    = $this->input->post('kemana',TRUE);
        $data['jam']       = $this->input->post('jam',TRUE);
        $data['id_kloter'] = $this->input->post('id_kloter',TRUE);
        $data['idrute'] = $this->input->post('idrute',TRUE);
        
        $result = $this->kloter_model->update_rute($data);
        echo json_encode($result);
        
    }
    
    public function hapus_rute(){
        
        $data['id_kloter'] = $this->input->post('id_kloter',TRUE);
        $data['idrute'] = $this->input->post('id_rute',TRUE);
        
        $result = $this->kloter_model->hapus_rute($data);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        
        $data['id_kloter']        = $this->input->post('id_kloter',TRUE);
        $data['nama']             = $this->input->post('nama',TRUE);
        $data['tgl_berangkat']    = $this->input->post('tgl_berangkat',TRUE);
        $data['tgl_pulang']       = $this->input->post('tgl_pulang',TRUE);
        
        $result = $this->kloter_model->update($data);
        echo json_encode($result);
        
    }
    
    
    public function hapus(){
        
        $data['id_kloter']        = $this->input->post('id_kloter',TRUE);
        $result = $this->kloter_model->hapus($data);
        echo json_encode($result);
        
    }
    
    
    public function data_rute_penerbangan(){
        $result = $this->kloter_model->data_rute_penerbangan()->result_array();
        echo json_encode($result);
    }
    
    public function simpan_kodepnr(){
        
        $data['id_rute']        = $this->input->post('id_rute',TRUE);
        $data['maskapai']       = $this->input->post('post_1',TRUE);
        $data['kodepnr']        = $this->input->post('post_2',TRUE);
        $data['flight']         = $this->input->post('post_3',TRUE);
        $data['departure']    = $this->input->post('post_4',TRUE);
        $data['arrival']      = $this->input->post('post_5',TRUE);
        
        
        $result = $this->kloter_model->simpan_kodepnr($data);
        echo json_encode($result);
    
        
    }
    
    
}
