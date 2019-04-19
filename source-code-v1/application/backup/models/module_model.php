<?php 
class Module_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM module WHERE is_deleted = 0 ORDER BY id ASC ";
        
        return $this->db->query($sql);
    }
    
    function detail($data){
        $sql = "SELECT * FROM module WHERE id = '$data[id]' and is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        //$sql = "SELECT * FROM module WHERE is_deleted = 0 ORDER BY id ASC ";
        $user_nik = $this->user_nik();    
        
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
                                            '#',
                                            '1',
                                            '$data[punya_sub]',
                                            '0',
                                            '0',
                                            '$user_nik',
                                            NOW())";     
           
        return $this->db->query($sql);
    }
    
    function module_sub_simpan($data){
        
        $user_nik = $this->user_nik();
        
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
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE module SET name          = '$data[nama]',
                                        controller         = '$data[nama_controller]',
                                        updated_by          = '$user_nik',
                                        updated_at          = NOW() WHERE id = '$data[id_module_sub]'";
        
        return $this->db->query($sql);
    }
    
    
    function module_sub_hapus($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE module SET is_deleted          = '1',updated_by          = '$user_nik',
                                        updated_at          = NOW() WHERE id = '$data[id_module_sub]'";
        
        return $this->db->query($sql);
    }
    
    function get_module(){

        $user_nik = $this->user_nik();    
        if(empty($user_nik)){
            redirect(base_url('main/logout'));
        }else{
            
            $sql = "SELECT a.id,
                        a.name,
                        a.name,
                        a.controller,
                        a.position,
                        a.have_child,
                        a.parent,
                        b.nik,
                        a.icon,
                        b.cbx
                    FROM module AS a
                    INNER JOIN module_permission AS b ON a.id = b.id_module AND b.nik = $user_nik
                    WHERE a.is_deleted = 0  
                    GROUP BY a.id";

            $return = $this->db->query($sql);

            return $return;
        }
        
    }
    
    function get_module_all(){

        $sql = "SELECT * FROM module AS a WHERE a.is_deleted = 0  ";

 
        $return = $this->db->query($sql);
       
        return $return;
        
    }
    
    function get_module_permission_users($nik){

        
        $sql = "SELECT  a.name,
                        a.controller,
                        a.id as id_modules,
                        a.*,
                        (SELECT b.cbx FROM module_permission AS b WHERE a.id = b.`id_module` AND b.nik = $nik) cbx
                FROM module AS a 
                WHERE a.`is_deleted` = 0";
        
        //$sql = "SELECT * FROM module_permission where id_users = $user_id";

 
        $return = $this->db->query($sql);
       
        return $return;
        
    }
    
    
    function get_module_master(){
        
        $sql = "SELECT * FROM module WHERE is_deleted = '0' ORDER BY id";
        
        $return = $this->db->query($sql);
       
        return $return;
        
    }
    
    
    
    function update_users_akses($data){

        $user_nik = $this->user_nik();
        $id_users    = $data['idusers'];
        $cbx_module  = $data['cbx_module'];

        //kita hapus dulu module_permission yang sebelumnya, baru insert ulang yang baru
        $sql3 = "DELETE FROM module_permission WHERE nik = $id_users";
        $hasil = $this->db->query($sql3);


        //ini insert ulang
        $i = 0;
        foreach ($cbx_module as $i => $r){
            $cbx  = isset($r) ? "1" : "0";
            $sql_permission ="INSERT INTO module_permission (nik,id_module,cbx) VALUES ('$id_users','".$r."','".$cbx."')";     
            $this->db->query($sql_permission);
        }

        return $hasil;

    }
    

}
?>