<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finishing extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('finishing_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('finishing/finishing_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->finishing_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->finishing_model->data_detail($kode_produksi)->row_array();
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
                $this->load->view('finishing/finishing_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function update(){
        $path = './uploads/produksi/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['tgl_serah_terima']           = $this->input->post('tgl_serah_terima',TRUE);
        $data['jenis_barang']               = $this->input->post('jenis_barang_finishing',TRUE);
        $data['berat']                      = $this->input->post('berat_finishing',TRUE);
        $data['jumlah_akhir']               = $this->input->post('jumlah_akhir_finishing',TRUE);
        $data['catatan']                    = $this->input->post('catatan_finishing',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_finishing',TRUE);
        
        //stok terakhir
        $data['small_warna_1_jumlah_akhir']              = $this->input->post('small_warna_1_jumlah_akhir',TRUE);
        $data['small_warna_2_jumlah_akhir']              = $this->input->post('small_warna_2_jumlah_akhir',TRUE);
        $data['large_warna_1_jumlah_akhir']              = $this->input->post('large_warna_1_jumlah_akhir',TRUE);
        $data['large_warna_2_jumlah_akhir']              = $this->input->post('large_warna_2_jumlah_akhir',TRUE);
        
        $data['c_gambar']                   = $this->input->post('c_gambar_finishing',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_finishing"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_finishing');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/produksi/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/produksi/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('c_gambar_finishing_asli',TRUE);
        }

        $result = $this->finishing_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
}
