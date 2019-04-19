<?php 
class Pelamar_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }

    function pelamar_data(){

        $sql = "SELECT * FROM employee where is_deleted = 0";
        return $this->db->query($sql);

    }

}
?>