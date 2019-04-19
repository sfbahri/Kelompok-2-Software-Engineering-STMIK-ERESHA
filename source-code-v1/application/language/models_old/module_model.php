<?php 
class Module_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
    
    function data(){
        $sql = "SELECT * FROM module WHERE is_deleted = 0 ORDER BY id ASC ";
        
        return $this->db->query($sql);
    }
    
    function detail($data){
        $sql = "SELECT * FROM module WHERE id = '$data[id]' and is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function get_module(){

        $username = $this->username();    
        if(empty($username)){
            redirect(base_url('main/logout'));
        }else{
            
            $sql = "SELECT a.id,
                        a.name,
                        a.name,
                        a.controller,
                        a.position,
                        a.have_child,
                        a.parent,
                        a.icon,
                        b.cbx
                    FROM module AS a
                    INNER JOIN module_permission AS b ON a.id = b.id_module
                    INNER JOIN accs AS c ON b.`id_module_role` = c.`id_module_role` AND c.is_deleted = 0 AND c.`username` = '$username'
                    WHERE a.is_deleted = 0  
                    GROUP BY a.id";

            return $this->db->query($sql);

        }
        
    }
    
    
    
    function simpan($data){
        //$sql = "SELECT * FROM module WHERE is_deleted = 0 ORDER BY id ASC ";
        $user_nik = $this->username();    
        
        $sql ="INSERT INTO module (icon,
                                            name,
                                            controller,
                                            position,
                                            have_child,
                                            parent,
                                            sequence,
                                            created_by,
                                            created_at) 
                                    VALUES ('$data[icon]',
                                            '$data[nama]',
                                            '$data[link]',
                                            '1',
                                            '$data[punya_sub]',
                                            '0',
                                            '0',
                                            '$user_nik',
                                            NOW())";     
           
        return $this->db->query($sql);
    }
    
    
    function module_update($data){
        
        $username = $this->username();
        
        $sql = "UPDATE module SET name       = '$data[nama]',
                                controller   = '$data[controller]',
                                icon         = '$data[icon]',
                                have_child   = '$data[punya_sub]',
                                updated_by   = '$username',
                                updated_at   = NOW() WHERE id = '$data[id_module]'";
        
        return $this->db->query($sql);
    }
    
    function module_sub_simpan($data){
        
        $user_nik = $this->username();
        
        $sql ="INSERT INTO module (name,
                                    controller,
                                    position,
                                    have_child,
                                    parent,
                                    sequence,
                                    created_by,
                                    created_at) 
                                    VALUES ('$data[nama]',
                                            '$data[nama_controller]',
                                            '2',
                                            'N',
                                            '$data[id_module]',
                                            '0',
                                            '$user_nik',
                                            NOW())";     
           
        return $this->db->query($sql);
        
    }
    
    function data_module_sub($data){
        $sql = "SELECT * FROM module WHERE parent = '$data[id_module]' AND  is_deleted = 0 ORDER BY id ASC ";
        return $this->db->query($sql);
    }
    
    function module_sub_update($data){
        
        $username = $this->username();
        
        $sql = "UPDATE module SET name          = '$data[nama]',
                                        controller         = '$data[nama_controller]',
                                        updated_by          = '$username',
                                        updated_at          = NOW() WHERE id = '$data[id_module_sub]'";
        
        return $this->db->query($sql);
    }
    
    
    function module_sub_hapus($data){
        
        $username = $this->username();
        
        $sql = "UPDATE module SET is_deleted          = '1',updated_by          = '$username',
                                        updated_at          = NOW() WHERE id = '$data[id_module_sub]'";
        
        return $this->db->query($sql);
    }
    
    function get_module_all(){

        $sql = "SELECT * FROM module AS a WHERE a.is_deleted = 0  ";

 
        $return = $this->db->query($sql);
       
        return $return;
        
    }
    
    function get_module_permission_users($id_role){

        
        $sql = "SELECT  a.name,
                        a.controller,
                        a.id as id_modules,
                        a.*,
                        (SELECT b.cbx FROM module_permission AS b WHERE a.id = b.`id_module` AND b.id_module_role = $id_role) cbx
                FROM module AS a 
                WHERE a.`is_deleted` = 0";
        
        return $this->db->query($sql);
       
    }
    
    
    function get_module_master(){
        
        $sql = "SELECT * FROM module WHERE is_deleted = '0' ORDER BY id";
        
        $return = $this->db->query($sql);
       
        return $return;
        
    }
    
    
    
    
    

}
?>