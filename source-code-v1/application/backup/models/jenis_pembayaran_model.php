<?php 
class Jenis_pembayaran_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_select(){
        $sql = "SELECT * FROM jenis_pembayaran WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
}
?>