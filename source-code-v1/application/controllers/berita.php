<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('berita_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('berita/berita_view',$data);
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
                $this->load->view('berita/berita_tambah_view',$data);
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
                $this->load->view('berita/berita_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->berita_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
        $id_berita   = $this->input->post('id_berita',TRUE);
        $result = $this->berita_model->detail($id_berita)->row_array();
        echo json_encode($result);
    }

    public function simpan(){
  
        //ini kode random untuk token
        $token = "";
        $codeAlphabet = "abcdefghijklmnopqrstu";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 
        //ini kode random untuk token
        
        $path = './uploads/img_berita/';    
        
        $data['judul']       = $this->input->post('judul',TRUE);
        $data['deskripsi']   = $this->input->post('deskripsi');
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = 'img_'.$date.time().$token;
        $data['kode']        = $date.time().$token;
        $nama_file;

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images  = $this->upload->data();
        $nama_file = $result_images['file_name']; 

        $this->load->library('image_lib');

         /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/img_berita/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_berita/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();
         
         
        $result = $this->berita_model->simpan($data,$nama_file);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        $path = './uploads/img_berita/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['judul']       = $this->input->post('judul',TRUE);
        $data['deskripsi']   = $this->input->post('deskripsi');
        $data['id_berita']   = $this->input->post('id_berita',TRUE);
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = 'img_'.$date.time().$token;
        $nama_file;

        
        
        if($_FILES["gambar"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');
        
       // var_dump($this->upload->data());exit();

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/img_berita/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_berita/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('gambar_asli',TRUE);
        }

        $result = $this->berita_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    public function hapus(){
        $id_berita   = $this->input->post('id_berita',TRUE);
        
        $img = $this->berita_model->detail($id_berita)->row_array();
        
        $result = $this->berita_model->hapus($id_berita);
        
        
        if($result == true){
            $path = './uploads/img_berita/';
            unlink($path.$img['nama']);
            unlink($path.'rz_'.$img['nama']);
        }
        
        echo json_encode($result);
    }
    
    
    
    
    
    
    /*PRODUKSI AKSESORIS*/
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->aksesoris_model->data_detail($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    
    public function data_update(){
        $path = './uploads/produk/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['tgl_mulai']                  = $this->input->post('tgl_mulai_aksesoris',TRUE);
        $data['tgl_diambil']                = $this->input->post('tgl_diambil_aksesoris',TRUE);
        $data['vendor']                     = $this->input->post('vendor_aksesoris',TRUE);
        $data['biaya']                      = $this->input->post('biaya_aksesoris',TRUE);
        $data['jenis_barang']               = $this->input->post('jenis_barang_aksesoris',TRUE);
        $data['pic']                        = $this->input->post('pic_aksesoris',TRUE);
        $data['berat']                      = $this->input->post('berat_aksesoris',TRUE);
        $data['jumlah']                     = $this->input->post('jumlah_akhir_aksesoris',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_aksesoris',TRUE);
        
        
        $data['c_gambar']                   = $this->input->post('c_gambar_aksesoris',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_aksesoris"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_aksesoris');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/produk/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/produk/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('c_gambar_aksesoris_asli',TRUE);
        }

        $result = $this->aksesoris_model->data_update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    // ================== FINANCE =========================== //
    public function finance_index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('aksesoris/aksesoris_finance_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function finance_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('aksesoris/aksesoris_edit_finance_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function finance_update(){
        
        $data['harga']       = $this->input->post('harga',TRUE);
        $data['id_aksesoris']     = $this->input->post('id_aksesoris',TRUE);
        $result = $this->aksesoris_model->finance_update($data);
        echo json_encode($result);
    }
    
}
