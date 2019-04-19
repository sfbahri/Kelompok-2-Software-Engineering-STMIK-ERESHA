<?php 
class Web_produk_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
  
        $sql = "SELECT a.*,
                    FORMAT(a.harga, 0) AS hargas,
                    b.nama as nama_vendor,
                    c.nama as nama_kategori
                FROM produk_header as a
                LEFT JOIN vendor as b ON a.id_vendor = b.id and b.is_deleted = 0
                LEFT JOIN web_kategori as c ON a.kategori = c.id and c.is_deleted = 0
                WHERE a.is_deleted = 0 and a.website = 1 ORDER by a.id ASC";
        
        return $this->db->query($sql);
        
    }
    
    
    function data_select(){
  
        $sql = "SELECT  a.nama,
                        a.id,
                        a.kode
                FROM produk_header as a
                WHERE a.is_deleted = 0 and a.website = 0 ORDER by a.nama ASC";
        
        return $this->db->query($sql);
        
    }
    
    function update_publish_keweb($data){
        $user_nik = $this->user_nik();
        $sql1 = "UPDATE produk_header SET   website    = '1',
                                            kategori   = '$data[kategori]',
                                            updated_by = '$user_nik',
                                            updated_at = NOW() WHERE kode = '$data[kode_produk]'";
        return $this->db->query($sql1);
    }
    
    function data_select_kategori(){
        
        $sql = "SELECT  a.id,
                        a.nama as nama_kategori
                FROM web_kategori as a
                WHERE a.is_deleted = 0 and a.id_menu = 0 ORDER by a.nama ASC";
        
        return $this->db->query($sql);
        
    }
    
    function actives($kode,$id_status){

        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produk_header SET website_publish  = '$id_status',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE kode = '$kode'";

        return $this->db->query($sql);

    }
    
    function hapus($data){

        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produk_header SET website_publish  = '0',
                                        website = 0,
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE kode = '$data[kode]'";

        return $this->db->query($sql);

    }
    
    function details($data){
        $sql = "SELECT a.*,
                        FORMAT(a.web_harga, 0) AS web_harga,
                        FORMAT(a.web_harga_diskon, 0) AS web_harga_diskon,
                        b.nama as nama_vendor,
                        a.nama as nama_produk
                    FROM produk_header as a
                   LEFT JOIN vendor as b ON a.id_vendor = b.id and b.is_deleted = 0
                   WHERE a.is_deleted = 0 and a.kode = '$data[kode_produk]'";
        
        return $this->db->query($sql);
    }
    
    function detail_gambar($kode){
        $sql = "SELECT gambar,path,id FROM produk_gambar where kode_produk_header = '$kode' and is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function simpan_size_warna_stok($data){
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO web_produk_sws (kode,
                                    kode_produk_header,
                                    id_produk_gambar,
                                    size,
                                    warna,
                                    stok,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[kode_produk]',
                                    '$data[id_gambar]',
                                    '$data[size]',
                                    '$data[nama_warna]',
                                    '$data[stok]',
                                    '$user_nik',
                                    NOW())";
                                    
        return $this->db->query($sql);
    }
    
    function data_size_warna_stok($kode_produk){
        $sql = "SELECT * FROM web_produk_sws where kode_produk_header = '$kode_produk' and is_deleted = 0 ORDER BY created_at ASC";
        return $this->db->query($sql);
    }
    
    function web_update_produk($data){
     
        $user_nik = $this->user_nik();
        
        $harga = str_replace(",","",$data['harga']);
        $harga_diskon = str_replace(",","",$data['harga_diskon']);
        
        $sql = "UPDATE produk_header SET web_harga          = '$harga',
                                        web_harga_diskon    = '$harga_diskon',
                                        deskripsi           = '$data[deskripsi]',
                                        nama                = '$data[nama]',
                                        updated_at          = NOW(),
                                        updated_by          = '$user_nik'
                                WHERE kode = '$data[kode]'";

        return $this->db->query($sql);
        
    }
    
}
?>