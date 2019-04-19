<?php 
class Warna_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM warna WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_select(){
        $sql = "SELECT * FROM warna WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO warna (inisial,nama,created_by,created_at) VALUES ('$data[inisial]','$data[nama]','$user_nik',NOW())";
        return $this->db->query($sql);
    }
    
    function detail($id_vendor){
        $sql = "SELECT * FROM warna WHERE is_deleted = 0 and id = $id_vendor";
        return $this->db->query($sql);
    }
    
    function update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE warna SET  inisial        = '$data[inisial]',
                                        nama     = '$data[nama]',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$data[id_warna]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_warna){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE warna SET  is_deleted        = '1',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$id_warna'";
        return $this->db->query($sql);
    }
    
}
?>