<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('member_model');
    }

    public function data_select(){
        $result = $this->member_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function simpan(){

        $data['nama']        = $this->input->post('nama',TRUE);
        $data['alamat']      = $this->input->post('alamat',TRUE);
        $data['nohp']        = $this->input->post('nohp',TRUE);
        $data['email']       = $this->input->post('email',TRUE);

        $result = $this->member_model->simpan($data);
        echo json_encode($result);
        
    }
    
}
