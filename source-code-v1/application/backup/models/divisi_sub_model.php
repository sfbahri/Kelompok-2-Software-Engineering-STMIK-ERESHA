<?php 
class divisi_sub_model extends CI_Model{ 
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data_divisi_sub(){
        
        $sql = "SELECT a.id as id_sub,a.nama as nm_sub,
                       b.id as id_div,b.nama as nm_div
                    FROM karyawan_divisi_sub as a 
                    INNER JOIN karyawan_divisi as b ON a.id_divisi = b.id
                    WHERE a.is_deleted = 0";

        return $this->db->query($sql);
    }
    function ambil_divisi_sub($data){
        
        $sql = "SELECT *
                FROM karyawan_divisi_sub 
                WHERE is_deleted = 0 AND id_divisi=$data";

        return $this->db->query($sql);
    }
    function divisi_sub_get_nik(){
        $sql = "SELECT MAX(nik) as nik FROM divisi_sub WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function divisi_sub_simpan($data){
        //
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO karyawan_divisi_sub (
                              id,
                              id_divisi,
                              nama,
                              is_deleted,
                              created_by,
                              created_at,
                              updated_by,
                              updated_at
                              ) 
                            VALUES (
                                    '',
                                    $data[id_divisi],
                                    '$data[nama]',
                                    '',
                                    '$user_nik',
                                    NOW(),
                                    '',
                                    ''
                                        )";
        
        return $this->db->query($sql);
        
    }
    
    function divisi_sub_update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE karyawan_divisi_sub SET
                              id_divisi        = '$data[id_divisi]',
                              nama             = '$data[nama]',
                              updated_by       = '$user_nik',
                              updated_at       = NOW()
                WHERE id = '$data[id]' ";
                    
        return $this->db->query($sql);
        
    }
            
    function divisi_sub_detail($id){
        $sql = "SELECT * FROM karyawan_divisi_sub
                    WHERE id = '$id'";
        return $this->db->query($sql);
    }
    
}
?>