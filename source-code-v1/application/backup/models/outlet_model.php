<?php 
class Outlet_model extends CI_Model{ 
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_select(){
        $sql = "SELECT * FROM outlet WHERE is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function get_alamat($id_outlet){
        $sql = "SELECT * FROM outlet WHERE is_deleted = 0 and id = '$id_outlet' ";
        return $this->db->query($sql);
    }
    
}
?>