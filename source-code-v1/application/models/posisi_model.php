<?php 
class Posisi_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
    
    function data($data){
        $sql = "SELECT * FROM posisi WHERE is_deleted = 0 ORDER BY id ASC";  
        return $this->db->query($sql);
    }
    
    function detail($data){
        $sql = "SELECT * FROM posisi WHERE id = '$data[id_posisi]' and  is_deleted = 0";  
        return $this->db->query($sql);
    }
      
    function simpan($data){ 
        
        $sql ="INSERT INTO posisi (nama_posisi) VALUES ('$data[nama]')";     
           
        return $this->db->query($sql);
    }
    
    
    function update($data){

        $id_posisi    = $data['id_posisi'];
        $nama_posisi  = $data['nama_posisi'];

        $sql3 = "UPDATE posisi SET nama_posisi = '$nama_posisi' WHERE id = '$id_posisi'";
        return $this->db->query($sql3);


    }

    function hapus($data){

        $id_posisi    = $data['id_posisi'];

        $sql3 = "UPDATE posisi SET is_deleted = '0' WHERE id = '$id_posisi'";
        return $this->db->query($sql3);


    }
    
}
?>