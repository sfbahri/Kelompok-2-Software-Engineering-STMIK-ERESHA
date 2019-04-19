<?php 
class Agama_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_select(){
        $sql = "SELECT * FROM agama WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
}
?>