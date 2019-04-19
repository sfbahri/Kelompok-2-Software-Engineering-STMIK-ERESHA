<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('outlet_model');
    }

    public function data_select(){

        $result = $this->outlet_model->data_select()->result_array();
        echo json_encode($result);

    }
    
}
