<?php 
class Profil_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function get_avatar($nik){
        $sql = "SELECT img_foto FROM karyawan WHERE nik = '$nik' and is_deleted = '0'";
        return $this->db->query($sql)->row_array();
    }
    
    
    function data_profil(){

    	//$username           = $this->session->userdata('sess_username');
	//$password           = $this->session->userdata('sess_password');
	$user_nik             = $this->session->userdata('sess_nik');

        
        $sql = "SELECT * FROM users WHERE id = '$user_nik' and status = '1' and is_deleted = '0'";
        return $this->db->query($sql)->row_array();
        
    }
    

    function update_profil($data){
        $user_nik = $this->session->userdata('sess_nik');
        $sql = "UPDATE users SET   username    = '$data[nama_pengguna]',
                                        email       = '$data[email]',
                                        fullname   = UPPER('$data[nama_lengkap]'),
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() 
                                WHERE id = $data[id_users] and is_deleted = 0 and status = 1";
        
            $return = $this->db->query($sql);
           
            return $return;
        
        
    }

    function ubah_katasandi($kata_sandi){
            $user_nik = $this->session->userdata('sess_nik');
            $sql = "UPDATE users SET   password    = '$kata_sandi',
                                        updated_by  = '$user_id',
                                        updated_at  = NOW() 
                                WHERE id = $user_nik";
        
            $return = $this->db->query($sql);
            
            
            return $return;
        

    }
    
    
    function ubah_foto($data){
            $user_nik = $this->session->userdata('sess_nik');
            
            $sql = "UPDATE users SET   avatar    = '$data[avatar]',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() 
                                WHERE id = $data[idusers]";
        
            $return = $this->db->query($sql);
            
            return $return;
        

    }

}
?>