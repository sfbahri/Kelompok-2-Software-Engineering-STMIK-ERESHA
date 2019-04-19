<?php 
class Login_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
            
    function authlogin($datapost){
        
        $sql = "SELECT  b.nama,
                        b.email,
                        b.nik,
                        a.token,
                        a.aktif,
                        b.id_outlet
                FROM users AS a
                INNER JOIN karyawan AS b ON a.`nik` = b.`nik` AND b.`is_deleted` = 0
                WHERE a.nik = '$datapost[nik]' AND a.password = '$datapost[password]' AND a.`is_deleted` = 0 AND a.`aktif` = 1";

//        $sql = "SELECT  a.id as id_users,
//                        a.username,
//                        a.email,
//                        a.nama,
//                        a.password,
//                        a.confirmation_token,
//                        a.status,
//                        a.avatar,
//                        a.is_deleted,
//                        a.id_level
//                    FROM users as a
//                    WHERE a.status = 1 and a.is_deleted = 0 and a.username ='$datapost[nik]' AND a.password = '$datapost[password]'";
        
        $return = $this->db->query($sql);
        
        return $return;
        
    }
    
    function update_token($sf_nik,$sf_token){
        
        $sql = "UPDATE users SET token = '$sf_token', login_lst = NOW(), login_exp = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE nik = $sf_nik and is_deleted = '0' and aktif = '1'";
        
        return $this->db->query($sql);

    }
    
    function ubah_password_simpan($password_baru){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE users SET password = '$password_baru', updated_at = NOW() WHERE nik = '$user_nik'";
        
        return $this->db->query($sql);
    }
    
    function aksiresetpassword($email,$token){
        
        $sql = "UPDATE users SET token = '$token', updated_at = NOW(), status = '0', password = NULL  WHERE email = '$email'";
        
        $return = $this->db->query($sql);
     
        return $return;
        
    }
    
    
    function check_token($token){
        $sql = "SELECT * FROM users WHERE token = '$token' and is_deleted = '0' and aktif = '1'";
        return $this->db->query($sql)->num_rows();
        
    }
    
    function check_email($email){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        return $this->db->query($sql)->num_rows();
        
    }
    
    function users_detail($email){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        return $this->db->query($sql)->row_array();
        
    }
    
    function reset_password($email,$password_baru){
        $sql = "UPDATE users SET password = '$password_baru' WHERE email = '$email'";
        return $this->db->query($sql);
    }
    
    function resettoken($token,$token_baru){
        $sql = "UPDATE users SET confirmation_token = '$token_baru' WHERE confirmation_token = '$token' and status = '1'";
        return $return = $this->db->query($sql);
    }
}
?>