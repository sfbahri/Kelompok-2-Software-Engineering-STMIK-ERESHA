<?php 
class Klien_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function simpan($data,$nama_file){
        $user_nik = $this->userid();

        $sql = "INSERT INTO klien (nama,gambar,created_by,created_at) VALUES ('$data[nama]','$nama_file',$user_nik,NOW())";

        return $this->db->query($sql);
    }

    function data(){
        $sql = "SELECT * FROM klien where is_deleted = 0 ORDER BY id ASC";
        return $this->db->query($sql);
    }
    
    function detail($id_client){
        $sql = "SELECT * FROM klien WHERE is_deleted = 0 and id = $id_client";
        return $this->db->query($sql);
    }
    
    
    function update($data,$nama_file){
        
        $user_id = $this->userid();
        
        $sql = "UPDATE klien SET nama      = '$data[nama]',
                                gambar      = '$nama_file',
                                updated_by  = '$user_id',
                                updated_at  = NOW() WHERE id = '$data[id_klien]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_client){

        $sql = "DELETE FROM klien where id = '$id_client'";
        
        return $this->db->query($sql);
        
        
    }
    
    
    
}
?>