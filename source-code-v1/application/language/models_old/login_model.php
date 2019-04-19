<?php 
class Login_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
            
    function authlogin($datapost){
        
        $sql = "SELECT  a.`username`,
                        b.`nama` as nama_admin,
                        c.`nama` as nama,
                        a.token,
                        a.aktif,
                        b.id as id_admin,
                        c.id as id_jamaah,
                        a.id_module_role
                FROM accs AS a
                LEFT JOIN admin AS b ON a.`username` = b.`id` AND b.`is_deleted` = 0
                LEFT JOIN jamaah AS c ON a.`username` = c.`id` AND c.`is_deleted` = 0
                WHERE a.username = '$datapost[username]' AND a.password = '$datapost[password]' AND a.`is_deleted` = 0 AND a.`aktif` = 1";
        
        $return = $this->db->query($sql);
        
        return $return;
        
    }
    
    function update_token($sf_username,$sf_token){
        
        $sql = "UPDATE accs SET token = '$sf_token', login_lst = NOW(), login_exp = DATE_ADD(NOW(), INTERVAL 4 HOUR) WHERE username = '$sf_username' and is_deleted = '0' and aktif = '1'";
        
        return $this->db->query($sql);

    }
    
    function ubah_password_simpan($password_baru){
        $username = $this->username();
        
        $sql = "UPDATE accs SET password = '$password_baru', updated_at = NOW() WHERE username = '$username'";
        
        return $this->db->query($sql);
    }
    
    function aksiresetpassword($email,$token){
        
        $sql = "UPDATE accs SET token = '$token', updated_at = NOW(), status = '0', password = NULL  WHERE email = '$email'";
        
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