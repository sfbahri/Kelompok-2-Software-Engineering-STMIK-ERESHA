<?php 
class Pelanggan_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_select(){
        $sql = "SELECT * FROM pelanggan WHERE is_deleted = 0 ORDER by nama ASC";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->user_nik();

        $sql = "INSERT INTO pelanggan (nama,nohp,email,alamat,created_by,created_at) VALUES ('$data[nama]','$data[nohp]','$data[email]','$data[alamat]',$user_nik,NOW())";
        return $this->db->query($sql);
    }
    
    function get_detail_pelanggan($id_pelanggan){
         $sql = "SELECT * FROM pelanggan WHERE id= '$id_pelanggan' ";
        return $this->db->query($sql);
    }
    
    
    function data_pelanggan(){
        $sql = "SELECT * FROM pelanggan WHERE is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function pelanggan_get_nik(){
        $sql = "SELECT MAX(nik) as nik FROM pelanggan WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function pelanggan_simpan($data){
        //
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO pelanggan (
                              id,
                              nama,
                              email,
                              nohp,
                              alamat,
                              saldo_limit,
                              created_by,
                              created_at,
                              ) 
                            VALUES (
                                    '',
                                    '$data[nama]',
                                    '$data[email]',
                                    '$data[no_hp]',
                                    '$data[alamat]',
                                    '$data[limit]',
                                    '$user_nik',
                                    NOW())";
        
        return $this->db->query($sql);
        
    }
    
    function pelanggan_update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE pelanggan SET
                               nama            = '$data[nama]',
                               email           = '$data[email]',
                               alamat          = '$data[alamat]',
                               nohp            = '$data[no_hp]',
                               saldo_limit     ='$data[limit]',
                               updated_by      = '$user_nik',
                               updated_at      = NOW() WHERE id = '$data[id]' ";
                    
        return $this->db->query($sql);
        
    }
            
    function pelanggan_detail($id){
        $sql = "SELECT * FROM pelanggan where id = '$id'";
        return $this->db->query($sql);
    }
}
?>