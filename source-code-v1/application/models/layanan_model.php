<?php 
class Layanan_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function simpan($data,$nama_file){
        $user_id = $this->userid();

        $sql = "INSERT INTO layanan (judul,icon,deskripsi,created_by,created_at) VALUES ('$data[judul]','$data[icon]','$data[deskripsi]',$user_id,NOW())";
        return $this->db->query($sql);
    }
    
    function data(){
        $sql = "SELECT * FROM layanan WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function detail($id_layanan){
        $sql = "SELECT * FROM layanan WHERE is_deleted = 0 and id = $id_layanan";
        return $this->db->query($sql);
    }
    
    
    function update($data,$nama_file){
        
        $user_id = $this->userid();
        
        $sql = "UPDATE layanan SET judul     = '$data[judul]',
                                deskripsi   = '$data[deskripsi]',
                                icon      = '$data[icon]',
                                updated_by  = '$user_id',
                                updated_at  = NOW() WHERE id = '$data[id_layanan]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_layanan){

        $sql = "DELETE FROM layanan where id = '$id_layanan'";
        
        return $this->db->query($sql);
        
        
    }
    
    
}
?>