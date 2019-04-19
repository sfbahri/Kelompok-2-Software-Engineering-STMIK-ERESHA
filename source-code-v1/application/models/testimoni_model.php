<?php 
class Testimoni_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function simpan($data,$nama_file){
        $user_nik = $this->userid();

        $sql = "INSERT INTO testimoni (nama,perusahaan,jabatan,deskripsi,foto,created_by,created_at) VALUES ('$data[nama]','$data[perusahaan],'$data[jabatan]','$data[deskripsi]','$nama_file',$user_nik,NOW())";

        return $this->db->query($sql);
    }

    function data(){
        $sql = "SELECT * FROM testimoni where is_deleted = 0 ORDER BY id ASC";
        return $this->db->query($sql);
    }
    
    function detail($id_testimoni){
        $sql = "SELECT * FROM testimoni WHERE is_deleted = 0 and id = $id_testimoni";
        return $this->db->query($sql);
    }
    
    
    function update($data,$nama_file){
        
        $user_id = $this->userid();
        
        $sql = "UPDATE testimoni SET nama     = '$data[nama]',
                                perusahaan    = '$data[perusahaan]',
                                jabatan       = '$data[jabatan]',
                                deskripsi     = '$data[deskripsi]',
                                foto          = '$nama_file',
                                updated_by  = '$user_id',
                                updated_at  = NOW() WHERE id = '$data[id_testimoni]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_testimoni){

        $sql = "DELETE FROM testimoni where id = '$id_testimoni'";
        
        return $this->db->query($sql);
        
        
    }
    
    
    
}
?>