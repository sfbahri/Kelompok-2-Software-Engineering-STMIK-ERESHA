<?php 
class Main_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function check_token_main($token,$username){
         $sql = "SELECT * FROM accs WHERE token = '$token' and username = '$username' and is_deleted = '0' and aktif = '1'";
        return $this->db->query($sql)->num_rows();
    }
    
    function check_passusertoken($token,$username,$aktif){

        if($aktif == 1){//ini kalo aktif
            $sql = "SELECT * FROM accs WHERE token = '$token' and username = '$username' and is_deleted = '0' and aktif = '1'";
            return $this->db->query($sql)->num_rows();
        }else{
            return '0';
        }
    }
    
    function check_token($token){
        $sql = "SELECT * FROM accs WHERE token = '$token' and is_deleted = '0' and aktif = '1'";
        return $this->db->query($sql)->num_rows();
        
    }

    function users_module(){

        $id_users = 13;

         $sql = "SELECT c.id_groups
                        FROM users as a
                        INNER JOIN users_groups as b ON a.id = b.id_users
                        INNER JOIN permission as c ON b.id_groups = c.id_groups and c.is_deleted = 0
                        WHERE a.is_deleted = 0 and a.id = '$id_users'";
        return $this->db->query($sql);
    }


    

}
?>