<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Identitas extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('identitas_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('identitas/identitas_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    public function detail(){
        $result = $this->identitas_model->detail()->row_array();
        echo json_encode($result);
    }
    
    
    public function update(){
    
        $path = './uploads/img_logo/';
        
        //ini kode random untuk paspor
        $token2 = "";
        $codeAlphabet1    = "ABCDEFGH";
        $codeAlphabet1   .= "12345678";
        $max1 = strlen($codeAlphabet1) - 1;
        for ($i=0; $i < 5; $i++) {
            $token2 .= $codeAlphabet1[mt_rand(0, $max1)];
        } 
        
        $data['id_identitas']            = $this->input->post('id_identitas',TRUE);
        $data['title']                   = $this->input->post('title',TRUE);
        $data['nama_perusahaan']         = $this->input->post('nama_perusahaan',TRUE);
        $data['no_telp_1']               = $this->input->post('no_telp_1',TRUE);
        $data['no_telp_2']               = $this->input->post('no_telp_2',TRUE);
        $data['email']                   = $this->input->post('email',TRUE);
        $data['maps']                    = $this->input->post('maps',TRUE);
        $data['facebook']                = $this->input->post('facebook',TRUE);
        $data['twitter']                 = $this->input->post('twitter',TRUE);
        $data['instagram']               = $this->input->post('instagram',TRUE);
        $data['profil_singkat']          = $this->input->post('profil_singkat');
        $data['profil_visi']             = $this->input->post('profil_visi');
        $data['profil_misi']             = $this->input->post('profil_misi');
        $data['keyword']                 = $this->input->post('keyword',TRUE);
        $data['alamat']                  = $this->input->post('alamat',TRUE);
        $data['waktu_layanan']           = $this->input->post('waktu_layanan',TRUE);
        
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = $date.time().'_'.$token2;
        //data['img_foto']    = $nama_file;  
        
        
        if($_FILES["gambar"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images1           = $this->upload->data();
        $data['img_foto']        = $result_images1['file_name']; 

        }else{
            $data['img_foto'] = $this->input->post('foto_asli',TRUE);
        }

        
        $result = $this->identitas_model->update($data);
        echo json_encode($result);
    }
    
}
