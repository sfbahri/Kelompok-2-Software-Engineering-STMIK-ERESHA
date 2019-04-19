<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('slider_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('slider/slider_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    public function katakata_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('slider/slider_kata_kata_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }

    public function data(){
        $result = $this->slider_model->data()->result_array();
        echo json_encode($result);
    }

    public function detail_kata(){
        $id_slider  = $this->input->post('id_slider',TRUE);
        $result = $this->slider_model->detail_kata($id_slider)->row_array();
        echo json_encode($result);
    }

    public function update(){
        $id_slider  = $this->input->post('id_slider',TRUE);
        $kata_1  = $this->input->post('kata_1',TRUE);
        $kata_2  = $this->input->post('kata_2',TRUE);
        $kata_3  = $this->input->post('kata_3',TRUE);
        $result = $this->slider_model->update($id_slider,$kata_1,$kata_2,$kata_3);
        echo json_encode($result);
    }
    
    
    function proses_upload_media2(){

        
        $nama_file  = $this->input->post('nama_file',TRUE);

        $config['upload_path']   = getcwd() .'/uploads/img_slider/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name']     = $nama_file;
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
            $d = $this->upload->data('file_name');
            $data['path']       = '/uploads/img_slider/'.$d['file_name'].'';
            $data['gambar']     = $d['file_name'];
            
            /* start : resize images */
            $config2['image_library']    = 'gd2';
            $config2['source_image']     = './uploads/img_slider/'.$data['gambar'];
            $config2['file_name']        = 'rz_'.$data['gambar'];
            $config2['create_thumb']     = FALSE;
            $config2['maintain_ratio']   = TRUE;
            $config2['width']            = 150;
            $config2['height']           = 150;
            $config2['new_image']        = './uploads/img_slider/rz_'.$data['gambar'];
            
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
            
            $this->slider_model->proses_upload_media2($data);
        }
    }
    
    function gambar_hapus(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->slider_model->gambar_hapus($data);
        echo json_encode($result);
    }
}
