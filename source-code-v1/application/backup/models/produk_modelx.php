<?php 
class Produk_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }

    function data_produk($kode){
        $sql = "SELECT * FROM produk WHERE is_deleted = 0 and kode_produksi = $kode ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function data(){
        
        $sql = "SELECT  a.`kode_produksi`,
                        a.`kode`,
                        a.`beli`,
                        b.`gambar`,
                        a.`harga`,
                        FORMAT(a.harga, 0) AS hargas,
                        a.`img_qrcode`,
                        b.`qrcode`
                FROM produk AS a
                INNER JOIN produksi AS b ON a.`kode_produksi` = b.`kode` AND b.`is_deleted` = 0
                WHERE a.`is_deleted` = 0";
        return $this->db->query($sql);
        
//        $sql = "SELECT * FROM produk WHERE is_deleted = 0 ORDER by id ASC";
//        /*$sql = "SELECT 
//                        *,(SELECT COUNT(a.kode) AS total_produk FROM produk AS a WHERE a.kode_produksi = b.kode_produksi AND a.is_deleted = 0) totalproduk 
//                        FROM produk AS b WHERE b.is_deleted = 0 ORDER BY b.id ASC";*/
//                        //AND b.kode_produksi = '3282120180610'
//        return $this->db->query($sql);
    }

    function data_detail($kode_produksi){
        $sql = "SELECT * FROM produk WHERE is_deleted = 0 and kode_produksi = '$kode_produksi' ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function cari($data){
        $sql = "SELECT * FROM produk WHERE kode = '$data[kode_produk]' and is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function cek_produk($kodeproduk){
        $sql = "SELECT * FROM produk WHERE kode = '$kodeproduk'";
        return $this->db->query($sql);
    }
    
    function cek_gudang($kodeproduk){
        
        $user = $this->session->userdata('sess_id_users');
        
        $sql = "UPDATE  produk SET     cek_gudang = 1,
                                        updated_by       = '$user',
                                        updated_at       = NOW() WHERE kode = '$kodeproduk'";
        
        return $this->db->query($sql);
    }


    function created_label($img_qrcode,$kode_produksi_produk,$data){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO produk (kode_produksi,
                                    kode,
                                    harga,
                                    stok,
                                    img_qrcode,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode_produksi]',
                                    '$kode_produksi_produk',
                                    '$data[harga]',
                                    '1',
                                    '$img_qrcode',
                                    '$user_nik',
                                    NOW())";
                                    
        return $this->db->query($sql);
    }
    
}
?>