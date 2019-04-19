<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('media_model');
        
    }
    
    public function album(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('media/album_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function album_simpan(){
        $nama_album  = $this->input->post('nama_album',TRUE);
        echo json_encode($this->media_model->album_simpan($nama_album));
    }
    
    public function album_detail(){
        $id_album  = $this->input->post('id_album',TRUE);
        echo json_encode($this->media_model->album_detail($id_album)->row_array());
    }
    
    public function album_update(){
        $id_album  = $this->input->post('id_album',TRUE);
        $nama_album  = $this->input->post('nama_album',TRUE);
        $result = $this->media_model->album_update($id_album,$nama_album);
        echo json_encode($result);
    }
    
    public function album_hapus(){
        $id_album  = $this->input->post('id_album',TRUE);
        $result = $this->media_model->album_hapus($id_album);
        echo json_encode($result);
    }
    
    public function album_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('media/album_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function album_galeri_list(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('media/album_upload_gambar_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
   
    
    public function get_data_album(){
        $result = $this->media_model->get_data_album()->result_array();
        echo json_encode($result);
    }
    
    
    public function get_data_galeri(){
        $id_album   = $this->input->post('id_album',TRUE);
        $result = $this->media_model->get_data_galeri($id_album)->result_array();
        echo json_encode($result);
    }
            
    function proses_upload_media_galeri(){
        
        $nama_file  = $this->input->post('nama_file',TRUE);
        $id_album   = $this->input->post('id_album',TRUE);

        $config['upload_path']   = getcwd() .'/uploads/img_galeri/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name']     = $nama_file;
        $this->load->library('upload',$config);
        
        /* start : resize images */
//        $config2['image_library']    = 'gd2';
//        $config2['source_image']     = './uploads/produksi/'.$nama_file;
//        $config2['file_name']        = 'rz_'.$nama_file;
//        $config2['create_thumb']     = TRUE;
//        $config2['maintain_ratio']   = TRUE;
//        $config2['width']            = 150;
//        $config2['height']           = 150;
//        $this->image_lib->clear();
//        $this->load->library('image_lib', $config2);
//        $this->image_lib->resize();
        /* end : resize images */
        
        if($this->upload->do_upload('userfile')){
            $d = $this->upload->data('file_name');
            $data['path']       = 'uploads/img_galeri/'.$d['file_name'].'';
            $data['gambar']     = $d['file_name'];
            
            /* start : resize images */
            $config2['image_library']    = 'gd2';
            $config2['source_image']     = './uploads/img_galeri/'.$data['gambar'];
            $config2['file_name']        = 'rz_'.$data['gambar'];
            $config2['create_thumb']     = FALSE;
            $config2['maintain_ratio']   = TRUE;
            $config2['width']            = 150;
            $config2['height']           = 150;
            $config2['new_image']        = './uploads/img_galeri/rz_'.$data['gambar'];
            
            $this->load->library('image_lib', $config2);
            $this->image_lib->resize();
            /* end : resize images */
            
            
            /*token kode*/
            $token = "";
            $codeAlphabet = "33434343556789934343434567812345667980909";
            $codeAlphabet.= "54979319491320389885589989898989867733333";
            $codeAlphabet.= "0123456789";
            $codeAlphabet.= "4535345345345345";
            $codeAlphabet.= "748274928746974687486347354653473483764837";

            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 

            $today = date("Ymd");
            $data['img_nama'] = $nama_file;
            //$data['img_kode'] = $today.$token;
            $data['id_album'] = $id_album;
            
            
            $this->media_model->proses_upload_media_galeri($data);
        }
    }

    function media_galeri_hapus(){
        $data['id']     = $this->input->post('id',TRUE);
        
        $img = $this->media_model->get_detail_images($this->input->post('id',TRUE))->row_array();
        
        $result = $this->media_model->media_galeri_hapus($data);
        
        if($result == true){
            $path = './uploads/img_galeri/';
            unlink($path.$img['nama']);
            unlink($path.'rz_'.$img['nama']);
        }
        
        echo json_encode($result);
    }
    
}
