<?php 
class Web_slider_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function get_outlet(){
        return $this->session->userdata('sess_outlet');
    }
    
    function data($data){
        $sql = "SELECT gambar,id FROM web_slider WHERE is_deleted = 0 ORDER BY id DESC";
        return $this->db->query($sql);
    }
    
    function proses_upload_media2($data){
        $user_nik = $this->user_nik();
        $sql = "INSERT INTO web_slider (gambar,
                                        path,
                                        created_by,
                                        created_at)
                                VALUES ('$data[gambar]',
                                        '$data[path]',
                                        '$user_nik',
                                        NOW())";
        
        return $this->db->query($sql);
        
    }
    
    function gambar_hapus($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE web_slider SET is_deleted = 1 , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
}
?>