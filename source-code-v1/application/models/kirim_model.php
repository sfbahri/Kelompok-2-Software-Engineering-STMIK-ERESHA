<?php 
class Kirim_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    
    function pesan_data(){
        
         $sql ="SELECT * FROM pesan where is_deleted = 0 ORDER BY id DESC";     
        
        return $this->db->query($sql);

    } 

    function survey_data(){
        
        $sql ="SELECT a.*,b.judul
                FROM layanan_booking as a
                INNER JOIN layanan as b ON a.id_layanan = b.id and b.is_deleted = 0
                WHERE a.is_deleted = 0 ORDER BY id DESC";     
        
        return $this->db->query($sql);

    }
}
?>