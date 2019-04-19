<?php 
class Vendor_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM vendor WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_select(){
        $sql = "SELECT * FROM vendor WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO vendor (nama,no_telp,email,alamat,created_by,created_at) VALUES ('$data[nama]','$data[no_telp]','$data[email]','$data[alamat]','$user_nik',NOW())";
        return $this->db->query($sql);
    }
    
    function detail($id_vendor){
        $sql = "SELECT * FROM vendor WHERE is_deleted = 0 and id = $id_vendor";
        return $this->db->query($sql);
    }
    
    function update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE vendor SET  nama        = '$data[nama]',
                                        no_telp     = '$data[no_telp]',
                                        email       = '$data[email]',
                                        alamat      = '$data[alamat]',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$data[id_vendor]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_vendor){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE vendor SET  is_deleted        = '1',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$id_vendor'";
        return $this->db->query($sql);
    }
    
}
?>