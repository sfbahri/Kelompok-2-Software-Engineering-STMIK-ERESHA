<?php 
class Media_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function album_simpan($nama_album){
        
        $userid = $this->userid();  
        
        $sql ="INSERT INTO album (nama,created_by,created_at) VALUES ('$nama_album','$userid',NOW())";     
           
        return $this->db->query($sql);
        
    }
    
    function get_data_album(){
        
        $sql = "SELECT id,nama,DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') tglcreated FROM album where is_deleted = 0";
        return $this->db->query($sql);
        
    }
    
    function album_detail($id_album){
        $sql = "SELECT id,nama FROM album where is_deleted = 0 and id = '$id_album'";
        return $this->db->query($sql);
    }
    
    function get_data_galeri($id_album){
        $sql = "SELECT * FROM galeri where is_deleted = 0 and id_album = '$id_album'";
        return $this->db->query($sql);
    }
    
    function album_update($id_album,$nama_album){
        
        $userid = $this->userid();
        
        $sql = "UPDATE album SET nama  = '$nama_album',
                                updated_by   = '$userid',
                                updated_at   = NOW() WHERE id = '$id_album'";
        
        return $this->db->query($sql);
    }
    
    function album_hapus($id_album){
        
        $userid = $this->userid();
        
        $sql = "UPDATE album SET is_deleted = 1,updated_by   = '$userid',updated_at   = NOW() WHERE id = '$id_album'";
        
        return $this->db->query($sql);
    }
    
    function proses_upload_media_galeri($data){
        $userid = $this->userid();
        $paths = 'uploads/img_galeri/'.$data['img_nama'];
        $sql = "INSERT INTO galeri (id_album,
                                    nama,
                                    path,
                                    created_by,
                                    created_at)
                            VALUES ('$data[id_album]',
                                    '$data[img_nama]',
                                    '$paths',
                                    '$userid',
                                    NOW())";
        
        return $this->db->query($sql);
        
    }
    
    function media_galeri_hapus($data){
        $userid = $this->userid();
        
        $sql = "DELETE FROM galeri where id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    function get_detail_images($id_galeri){
        $sql = "SELECT * FROM galeri where id = '$id_galeri'";
        
        return $this->db->query($sql);
    }
    
}
?>