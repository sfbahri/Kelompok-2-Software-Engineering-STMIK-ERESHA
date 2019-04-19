<?php 
class Kloter_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
    
    function data(){
        $sql = "SELECT id,nama,DATE_FORMAT(tgl_berangkat, '%d-%b-%Y') tgl_berangkat,DATE_FORMAT(tgl_pulang, '%d-%b-%Y') tgl_pulang FROM kloter WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function detail($id_kloter){
        $sql = "SELECT id,nama,DATE_FORMAT(tgl_berangkat, '%d-%b-%Y') tgl_berangkat,DATE_FORMAT(tgl_pulang, '%d-%b-%Y') tgl_pulang FROM kloter WHERE is_deleted = 0 and id = '$id_kloter'";
        return $this->db->query($sql);
    }
    
    function kloter_rute_data($id_kloter){
        $sql = "SELECT * FROM kloter_rute WHERE is_deleted = 0 and id_kloter = '$id_kloter'";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $username = $this->username();    
        
        $sql ="INSERT INTO kloter (nama,
                                tgl_berangkat,
                                tgl_pulang,
                                created_by,
                                created_at) 
                            VALUES ('$data[nama]',
                                DATE_FORMAT(STR_TO_DATE('$data[tgl_berangkat]', '%d-%b-%Y'),'%Y-%m-%d'),
                                DATE_FORMAT(STR_TO_DATE('$data[tgl_pulang]', '%d-%b-%Y'),'%Y-%m-%d'),
                                '$username',
                                NOW())";     
           
        return $this->db->query($sql);
    }
    
    function kloter_rute_detail($id_kloter,$id_rute){
        $sql = "SELECT * FROM kloter_rute WHERE is_deleted = 0 and id_kloter = '$id_kloter' and id = '$id_rute'";
        return $this->db->query($sql);
    }
            
    function simpan_rute($data){
        
        $username = $this->username(); 
        
        $sql ="INSERT INTO kloter_rute (id_kloter,
                                dari,
                                ke,
                                jam,
                                created_by,
                                created_at) 
                            VALUES ('$data[id_kloter]',
                                '$data[dari]',
                                '$data[kemana]',
                                '$data[jam]',
                                '$username',
                                NOW())";     
           
        return $this->db->query($sql);
    }
    
    function update_rute($data){
        
        $username = $this->username(); 
        
        $sql = "UPDATE kloter_rute SET dari  = '$data[dari]',
                                ke           = '$data[kemana]',
                                jam          = '$data[jam]',
                                updated_by   = '$username',
                                updated_at   = NOW() WHERE id_kloter = '$data[id_kloter]' and id = '$data[idrute]'";
        
        return $this->db->query($sql);
    }
    
    function hapus_rute($data){
        
        $username = $this->username(); 
        
        $sql = "UPDATE kloter_rute SET is_deleted  = '1',
                                updated_by   = '$username',
                                updated_at   = NOW() WHERE id_kloter = '$data[id_kloter]' and id = '$data[idrute]'";
        
        return $this->db->query($sql);
    }
    
    function update($data){
        $username = $this->username();
        
        $sql = "UPDATE kloter SET nama       = '$data[nama]',
                                tgl_berangkat= DATE_FORMAT(STR_TO_DATE('$data[tgl_berangkat]', '%d-%b-%Y'),'%Y-%m-%d'),
                                tgl_pulang   = DATE_FORMAT(STR_TO_DATE('$data[tgl_pulang]', '%d-%b-%Y'),'%Y-%m-%d'),
                                updated_by   = '$username',
                                updated_at   = NOW() WHERE id = '$data[id_kloter]'";
        
        return $this->db->query($sql);
    }
    
    function hapus($data){
        $username = $this->username();
        
        $sql = "UPDATE kloter SET is_deleted   = 1,
                                updated_by   = '$username',
                                updated_at   = NOW() WHERE id = '$data[id_kloter]'";
        
        return $this->db->query($sql);
    }
    
    function data_rute_penerbangan(){
        
        $username = $this->username();
        
        $sql = "SELECT id_kloter FROM jamaah WHERE id = '$username'";
        $k = $this->db->query($sql)->row_array();
        
        $sql2 = "SELECT * FROM kloter_rute WHERE id_kloter = '$k[id_kloter]'";
        return $this->db->query($sql2);
        
    }
    
    function simpan_kodepnr($data){
        
        $username = $this->username();
        
        $sql = "SELECT id_kloter,id_idxj FROM jamaah WHERE id = '$username'";
        $k = $this->db->query($sql)->row_array();
        
        $idkloter       = $k['id_kloter'];
        $id_jamaah      = $k['id_idxj'];
        $idrute         = $data['id_rute'];
        $kode_jamaah    = $this->username();
        
        $sql2 ="INSERT INTO jamaah_pnr (id_kloter,
                                id_jamaah,
                                kode_jamaah,
                                id_kloter_rute,
                                maskapai,
                                pnr,
                                flight,
                                departure,
                                arrival,
                                created_by,
                                created_at) 
                            VALUES ('$idkloter',
                                '$id_jamaah',
                                '$kode_jamaah',
                                '$idrute',
                                '$data[maskapai]',
                                '$data[kodepnr]',
                                '$data[flight]',
                                '$data[departure]',
                                '$data[arrival]',
                                '$username',
                                NOW())";     
           
        return $this->db->query($sql2);
        
    }
}
?>