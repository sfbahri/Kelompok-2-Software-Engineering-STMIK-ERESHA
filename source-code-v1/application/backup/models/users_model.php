<?php 
class Users_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT  b.nama,
                        b.nik,
                        b.email,
                        b.no_hp,
                        a.aktif
                FROM users as a 
                INNER JOIN karyawan as b ON a.nik = b.nik and b.is_deleted = 0
                WHERE a.is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function data_by_kode_produksi($kode_produksi){
        $sql = "SELECT a.*,b.*
        FROM produksi_trans_aksesoris AS a 
        INNER JOIN aksesoris AS b ON a.`id_aksesoris` = b.`id` AND b.`is_deleted` = 0
        WHERE a.`is_deleted` = 0 and a.kode_produksi = $kode_produksi ORDER BY a.`id` ASC";
        return $this->db->query($sql);
    }
    
    function data_by_kode_produksi2($kode_produksi){
        $sql = "SELECT SUM(a.`harga`) tot_harga_aksesoris
        FROM produksi_trans_aksesoris AS a 
        INNER JOIN aksesoris AS b ON a.`id_aksesoris` = b.`id` AND b.`is_deleted` = 0
        WHERE a.`is_deleted` = 0 and a.kode_produksi = $kode_produksi ORDER BY a.`id` ASC";
        return $this->db->query($sql);
    }
    
    function data_select(){
        $sql = "SELECT *,DATE_FORMAT(tanggal, '%d-%b-%Y') tgl FROM aksesoris WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
            
    function detail($nik){
        
        $sql = "SELECT  b.nama,
                        b.nik,
                        b.email,
                        b.no_hp,
                        a.aktif
                FROM users as a 
                INNER JOIN karyawan as b ON a.nik = b.nik and b.is_deleted = 0
                WHERE a.is_deleted = 0 and a.nik = '$nik'";
        
        //$sql = "SELECT * FROM users WHERE is_deleted = 0 and id = $id_users ORDER by id ASC";
        return $this->db->query($sql);
    }
            
    function simpan($data,$nama_file){
        
        $user_nik = $this->user_nik();

        $sql = "INSERT INTO users (fullname,username,password,nohp,email,status,created_by,created_at) VALUES ('$data[nama]','$data[username]','$data[password]','$data[nohp]','$data[email]',1,$user_nik,NOW())";
        return $this->db->query($sql);
    }
    
    function update($data){
        
        $user_nik = $this->user_nik();

        $sql = "UPDATE users SET        fullname  = '$data[nama]',
                                        nohp  = '$data[nohp]',
                                        email = '$data[email]',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$data[id_users]'";

        return $this->db->query($sql);
    }
    
    function hapus($id_users){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE users SET is_deleted  = '1',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE nik = '$id_users'";

        return $this->db->query($sql);
        
    }

    function actives($nik,$id_status){

        $user_nik = $this->user_nik();
        
        $sql = "UPDATE users SET aktif  = '$id_status',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE nik = '$nik'";

        return $this->db->query($sql);

    }
    
}
?>