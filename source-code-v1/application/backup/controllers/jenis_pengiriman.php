<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_pengiriman extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('jenis_pengiriman_model');
    }

    public function data_select(){
        $result = $this->jenis_pengiriman_model->data_select()->result_array();
        echo json_encode($result);
    }
    
}
