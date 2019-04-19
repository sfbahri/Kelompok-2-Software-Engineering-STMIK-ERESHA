<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_baku extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('bahan_baku_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('bahan_baku/bahan_baku_view',$data);
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
                $this->load->view('bahan_baku/bahan_baku_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->bahan_baku_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->bahan_baku_model->data_select()->result_array();
        echo json_encode($result);
    }
    

    public function detail(){
        $id_bahan_baku        = $this->input->post('id_bahan_baku',TRUE);
        $result = $this->bahan_baku_model->detail($id_bahan_baku)->row_array();
        echo json_encode($result);
    }
    
    public function simpan(){
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['jenis']       = $this->input->post('jenis',TRUE);
        $data['warna']       = $this->input->post('warna',TRUE);
        $data['no_faktur']   = $this->input->post('no_faktur',TRUE);
        $data['tanggal']     = $this->input->post('tanggal',TRUE);
        $data['jumlah']      = $this->input->post('jumlah',TRUE);
        $data['satuan']      = $this->input->post('satuan',TRUE);
       
        $result = $this->bahan_baku_model->simpan($data);
        echo json_encode($result);
        
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
                $this->load->view('bahan_baku/bahan_baku_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function update(){
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['jenis']       = $this->input->post('jenis',TRUE);
        $data['warna']       = $this->input->post('warna',TRUE);
        $data['no_faktur']   = $this->input->post('no_faktur',TRUE);
        $data['tanggal']     = $this->input->post('tanggal',TRUE);
        $data['jumlah']      = $this->input->post('jumlah',TRUE);
        $data['satuan']      = $this->input->post('satuan',TRUE);
        $data['id_bahan_baku']     = $this->input->post('id_bahan_baku',TRUE);
       
        $result = $this->bahan_baku_model->update($data);
        echo json_encode($result);
        
    }
    
    public function hapus(){

        $id_bahan_baku     = $this->input->post('id_bahan_baku',TRUE);
        $result = $this->bahan_baku_model->hapus($id_bahan_baku);
        echo json_encode($result);
        
    }
    
    
}
