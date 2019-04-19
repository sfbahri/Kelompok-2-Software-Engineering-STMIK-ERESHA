<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_produk extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('web_produk_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('web/produk/produk_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function update(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('web/produk/produk_update_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->web_produk_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->web_produk_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function data_select_kategori(){
        $result = $this->web_produk_model->data_select_kategori()->result_array();
        echo json_encode($result);
    }
    
    
    public function update_publish_keweb(){
        $data['kode_produk']  = $this->input->post('kode_produk',TRUE);
        $data['kategori']     = $this->input->post('kategori',TRUE);
        $result = $this->web_produk_model->update_publish_keweb($data);
        echo json_encode($result);
    }


    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('web/produk/produk_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function actives(){
        $kode   = $this->input->post('kode',TRUE);
        $id_status   = $this->input->post('id_status',TRUE);
        
        $result = $this->web_produk_model->actives($kode,$id_status);
        echo json_encode($result);
    }
    
    public function hapus(){
        $data['kode']  = $this->input->post('kode',TRUE);
        $result = $this->web_produk_model->hapus($data);
        echo json_encode($result);
    }
    
    public function details(){
        $data['kode_produk'] = $this->input->post('kode_produk',TRUE);
        $result = $this->web_produk_model->details($data)->row_array();
        echo json_encode($result);
    }
    
    public function detail_gambar(){
        $kode = $this->input->post('kode_produk',TRUE);
        $result = $this->web_produk_model->detail_gambar($kode)->result_array();
        echo json_encode($result);
    }
    
    public function simpan_size_warna_stok(){
        
        //ini kode random untuk token
            $tokensss = "";
            $codeAlphabetPrd.= "ABCDEFGHIJKLMNOPQRSTYUOPMNC";
            $codeAlphabetPrd.= "abcdeefghijklmnoprwqmcubejy";
            $codeAlphabetPrd.= "0123456789";
            $maxprd = strlen($codeAlphabetPrd) - 1;
            for ($i=0; $i < 10; $i++) {
                $tokensss .= $codeAlphabetPrd[mt_rand(0, $maxprd)];
            } 
            $today = date("Ymd");
        //ini kode random untuk token
            
            
            //ini kode random untuk token
            $tokensss2 = "";
            $codeAlphabetPrd2.= "ABCDEFGHIJKLMNOPQRSTYUOPMNC";
            $codeAlphabetPrd2.= "abcdeefghijklmnoprwqmcubejy";
            $codeAlphabetPrd2.= "0123456789";
            $maxprd2 = strlen($codeAlphabetPrd2) - 1;
            for ($i=0; $i < 4; $i++) {
                $tokensss2 .= $codeAlphabetPrd2[mt_rand(0, $maxprd2)];
            } 
        //ini kode random untuk token
        
        
        $data['size']           = $this->input->post('size',TRUE);
        $data['stok']           = $this->input->post('stok',TRUE);
        $data['nama_warna']     = $this->input->post('nama_warna',TRUE);
        $data['id_gambar']      = $this->input->post('id_gambar',TRUE);
        $data['kode_produk']    = $this->input->post('kode_produk',TRUE);
        $data['kode']           = $tokensss2.'_'.$this->input->post('kode_produk',TRUE).'_'.$tokensss.'_'.$today;
        
        
        $result = $this->web_produk_model->simpan_size_warna_stok($data);
        echo json_encode($result);
    }
    
    
    public function data_size_warna_stok(){
        $kode_produk = $this->input->post('kode_produk',TRUE);
        $result = $this->web_produk_model->data_size_warna_stok($kode_produk)->result_array();
        echo json_encode($result);
    }
    
    public function web_update_produk(){
        
        $data['kode']           = $this->input->post('kode',TRUE);
        $data['nama']           = $this->input->post('nama',TRUE);
        $data['harga']          = $this->input->post('harga',TRUE);
        $data['harga_diskon']   = $this->input->post('harga_diskon',TRUE);
        $data['deskripsi']      = $this->input->post('deskripsi',FALSE);
        
        
        $result = $this->web_produk_model->web_update_produk($data);
        echo json_encode($result);
        
    }
    
    
}
