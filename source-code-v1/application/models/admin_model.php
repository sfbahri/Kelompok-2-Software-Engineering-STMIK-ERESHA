<?php 
class Admin_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
    
    function data(){
        $sql = "SELECT * FROM admin WHERE is_deleted = 0  and id <> 'superadmin'";
        return $this->db->query($sql);
    }
    
    function detail($id_admin){
        $sql = "SELECT * FROM admin WHERE is_deleted = 0 and id = '$id_admin'";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->username();
        
        $sql ="INSERT INTO admin (id,
                                    nama,
                                    email,
                                    created_by,
                                    created_at) 
                                    VALUES ('$data[id_admin]',
                                            '$data[nama]',
                                            '$data[email]',
                                            '$user_nik',
                                            NOW())";     
        
        //insert ke user login
        $sql1 = "INSERT INTO accs (username,
                                    password,
                                    id_module_role,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[id_admin]',
                                    '$data[password]',
                                    '2',
                                    '$user_nik',
                                    NOW())";
        
        $this->db->query($sql1);
        
        
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
}
?>