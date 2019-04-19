<?php 
class Member_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_select(){
        $sql = "SELECT * FROM users WHERE is_deleted = 0 and id_level = 7 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->user_nik();

        $sql = "INSERT INTO users (nama,nohp,email,status,id_level,created_by,created_at) VALUES ('$data[nama]','$data[nohp]','$data[email]',1,7,$user_nik,NOW())";
        return $this->db->query($sql);
    }
    
}
?>