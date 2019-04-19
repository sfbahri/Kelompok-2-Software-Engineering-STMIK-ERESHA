<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('testimoni_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('testimoni/testimoni_view',$data);
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
                $this->load->view('testimoni/testimoni_tambah_view',$data);
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
                $this->load->view('testimoni/testimoni_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->testimoni_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function detail(){
        $id_testimoni   = $this->input->post('id_testimoni',TRUE);
        $result = $this->testimoni_model->detail($id_testimoni)->row_array();
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
        
        $path = './uploads/img_testimoni/';    
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['perusahaan']  = $this->input->post('perusahaan',TRUE);
        $data['jabatan']     = $this->input->post('jabatan',TRUE);
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
         $configSize1['source_image']    = './uploads/img_testimoni/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_testimoni/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();
         
         
        $result = $this->testimoni_model->simpan($data,$nama_file);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        $path = './uploads/img_testimoni/';

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
        $data['perusahaan']  = $this->input->post('perusahaan',TRUE);
        $data['jabatan']     = $this->input->post('jabatan',TRUE);
        $data['deskripsi']   = $this->input->post('deskripsi');
        $data['id_testimoni']= $this->input->post('id_testimoni',TRUE);
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $data['menu']      = $this->input->post('menu',TRUE);
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
         $configSize1['source_image']    = './uploads/img_testimoni/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/img_testimoni/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('gambar_asli',TRUE);
        }

        $result = $this->testimoni_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    public function hapus(){
        $id_testimoni   = $this->input->post('id_testimoni',TRUE);
        
        $img = $this->testimoni_model->detail($id_testimoni)->row_array();
        
        $result = $this->testimoni_model->hapus($id_testimoni);
        
        
        if($result == true){
            $path = './uploads/img_testimoni/';
            unlink($path.$img['nama']);
            unlink($path.'rz_'.$img['nama']);
        }
        
        echo json_encode($result);
    }
    
}
