<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klien extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('klien_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('klien/klien_view',$data);
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
                $this->load->view('klien/klien_tambah_view',$data);
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
                $this->load->view('klien/klien_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->klien_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
        $id_client   = $this->input->post('id_client',TRUE);
        $result = $this->klien_model->detail($id_client)->row_array();
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
        
        $path = './uploads/img_klien/';    
        
        $data['nama']        = $this->input->post('nama',TRUE);
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
         $configSize1['source_image']    = './uploads/img_klien/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_klien/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();
         
         
        $result = $this->klien_model->simpan($data,$nama_file);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        $path = './uploads/img_klien/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['id_klien']   = $this->input->post('id_klien',TRUE);
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
         $configSize1['source_image']    = './uploads/img_klien/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_klien/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('gambar_asli',TRUE);
        }

        $result = $this->klien_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    public function hapus(){
        $id_klien   = $this->input->post('id_klien',TRUE);
        
        $img = $this->klien_model->detail($id_klien)->row_array();
        
        $result = $this->klien_model->hapus($id_klien);
        
        
        if($result == true){
            $path = './uploads/img_klien/';
            unlink($path.$img['nama']);
            unlink($path.'rz_'.$img['nama']);
        }
        
        echo json_encode($result);
    }
    
}
