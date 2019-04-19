<?php 
class Divisi_model extends CI_Model{ 
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_divisi(){
        $sql = "SELECT * FROM karyawan_divisi WHERE is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function divisi_get_nik(){
        $sql = "SELECT MAX(nik) as nik FROM divisi WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function divisi_simpan($data){
        //
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO karyawan_divisi (
                              id,
                              nama,
                              is_deleted,
                              created_by,
                              created_at,
                              updated_by,
                              updated_at
                              ) 
                            VALUES (
                                    '',
                                    '$data[nama]',
                                    '',
                                    '$user_nik',
                                    NOW(),
                                    '',
                                    ''
                                        )";
        
        return $this->db->query($sql);
        
    }
    
    function divisi_update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE karyawan_divisi SET
                               nama             = '$data[nama]',
                               updated_by       = '$user_nik',
                               updated_at       = NOW()
                              WHERE id = '$data[id]' ";
                    
        return $this->db->query($sql);
        
    }
            
    function divisi_detail($id){
        $sql = "SELECT * FROM karyawan_divisi where id = '$id'";
        return $this->db->query($sql);
    }
    
}
?>