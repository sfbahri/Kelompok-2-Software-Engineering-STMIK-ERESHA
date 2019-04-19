<?php 
class Slider_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function data($data){
        $sql = "SELECT gambar,id FROM slider WHERE is_deleted = 0 ORDER BY id DESC";
        return $this->db->query($sql);
    }
    
    function proses_upload_media2($data){
        $user_id = $this->userid();
        $sql = "INSERT INTO slider (gambar,
                                        path,
                                        created_by,
                                        created_at)
                                VALUES ('$data[gambar]',
                                        '$data[path]',
                                        '$user_id',
                                        NOW())";
        
        return $this->db->query($sql);
        
    }
    
    function gambar_hapus($data){
        $user_id = $this->userid();
        
        $sql = "UPDATE slider SET is_deleted = 1 , updated_by = '$user_id', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }

    function detail_kata($id_slider){
        $sql = "SELECT id,kata_1,kata_2,kata_3 FROM slider WHERE id = '$id_slider' and is_deleted = 0 ";
        return $this->db->query($sql);
    }

    function update($id_slider,$kata_1,$kata_2,$kata_3){

        $user_id = $this->userid();

        $sql = "UPDATE slider SET kata_1 = '$kata_1', kata_2 = '$kata_2', kata_3 = '$kata_3' , updated_by = '$user_id', updated_at = NOW() WHERE id = '$id_slider'";
        
        return $this->db->query($sql);

    }
}
?>