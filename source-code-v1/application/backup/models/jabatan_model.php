<?php 
class jabatan_model extends CI_Model{ 
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_jabatan(){
        $sql = "SELECT * FROM karyawan_jabatan WHERE is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function jabatan_get_nik(){
        $sql = "SELECT MAX(nik) as nik FROM jabatan WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function jabatan_simpan($data){
        //
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO karyawan_jabatan (
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
    
    function jabatan_update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE karyawan_jabatan SET
                               nama             = '$data[nama]',
                               updated_by       = '$user_nik',
                               updated_at       = NOW()
                              WHERE id = '$data[id]' ";
                    
        return $this->db->query($sql);
        
    }
            
    function jabatan_detail($id){
        $sql = "SELECT * FROM karyawan_jabatan where id = '$id'";
        return $this->db->query($sql);
    }
    
}
?>