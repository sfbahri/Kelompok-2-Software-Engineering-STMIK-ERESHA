<?php 
class Identitas_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function detail(){
        $sql = "SELECT * FROM identitas WHERE id_identitas = 1";
        return $this->db->query($sql);
    }
    
    function update($data){
        
        $user_id = $this->userid(); 
        
        $sql = "UPDATE identitas SET title          = '$data[title]',
                                nama                = '$data[nama_perusahaan]',
                                no_telp1            = '$data[no_telp_1]',
                                no_telp2            = '$data[no_telp_2]',
                                email               = '$data[email]',
                                maps                = '$data[maps]',
                                facebook            = '$data[facebook]',
                                twitter             = '$data[twitter]',
                                instagram           = '$data[instagram]',
                                profil_singkat      = '$data[profil_singkat]',
                                profil_visi         = '$data[profil_visi]',
                                profil_misi         = '$data[profil_misi]',
                                keywordseo          = '$data[keyword]',
                                alamat              = '$data[alamat]',
                                waktu_layanan       = '$data[waktu_layanan]',
                                logo                = '$data[img_foto]' WHERE id_identitas = '$data[id_identitas]'";
        
        return $this->db->query($sql);
        
    }
}
?>