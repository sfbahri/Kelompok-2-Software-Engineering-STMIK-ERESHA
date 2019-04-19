<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sewing extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('sewing_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('sewing/sewing_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->sewing_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->sewing_model->data_detail($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    public function cutting_simpan_bahan_baku(){
        $data['id_produksi_detail'] = $this->input->post('id_produksi_detail',TRUE);
        $data['id_bahan_baku']      = $this->input->post('id_bahan_baku',TRUE);
        $result = $this->cutting_model->cutting_simpan_bahan_baku($data);
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
                $this->load->view('sewing/sewing_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function simpan(){
        
           
        $data['tgl_mulai']       = $this->input->post('tgl_mulai',TRUE);
        $data['tgl_diambil']     = $this->input->post('tgl_diambil',TRUE);
        $data['vendor']          = $this->input->post('vendor',TRUE);
        $data['kas']             = $this->input->post('kas',TRUE);
        $data['biaya']           = $this->input->post('biaya',TRUE);
        $data['pic']           = $this->input->post('pic',TRUE);
        $data['id_produksi_detail']       = $this->input->post('id_produksi_detail',TRUE);
        $result = $this->sewing_model->simpan($data);
        echo json_encode($result);    
        
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
        
        $data['tgl_mulai']                  = $this->input->post('tgl_mulai_sewing',TRUE);
        $data['tgl_kirim']                = $this->input->post('tgl_kirim_sewing',TRUE);
        $data['vendor']                     = $this->input->post('vendor_sewing',TRUE);
        $data['biaya']                      = $this->input->post('biaya_sewing',TRUE);
        $data['pic']                      = $this->input->post('pic_sewing',TRUE);
        $data['jenis_barang']               = $this->input->post('jenis_barang_sewing',TRUE);
        $data['berat']                      = $this->input->post('berat_sewing',TRUE);
        $data['qty_awal']                   = $this->input->post('jumlah_akhir_sewing',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_sewing',TRUE);
        
        
        $data['c_gambar']                   = $this->input->post('c_gambar_sewing',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_sewing"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_sewing');
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
            $nama_file = $this->input->post('c_gambar_sewing_asli',TRUE);
        }

        $result = $this->sewing_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
}
