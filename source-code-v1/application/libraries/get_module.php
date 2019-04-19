<?php
class Get_module {
   
   public $ci;

    public function __construct() {
      $CI = & get_instance();
      $CI->load->model('module_model');
      $this->ci = $CI;
    }


   function get_nama_module($id_parent){
        $res = $this->ci->module_model->get_nama_module($id_parent)->row_array();
        $data =  json_encode($res);
        $decoded = json_decode( $data, TRUE );
        print_r($decoded['name']);
    }


}