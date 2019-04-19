<?php
class Lib_history {
   
   public $ci;

    public function __construct() {
      $CI = & get_instance();
      $CI->load->model('catatan_model');
      $this->ci = $CI;
    }


   function insert_history($usd,$ipd,$acv){
        $this->ci->catatan_model->insert_history($usd,$ipd,$acv);
    }


}