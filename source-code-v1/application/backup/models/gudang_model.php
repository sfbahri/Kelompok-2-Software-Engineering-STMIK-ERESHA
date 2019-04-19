<?php 
class Gudang_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT  a.kode,
                        a.qrcode,
                        a.stok_awal,
			a.stok_akhir,
                        b.jumlah,
                        b.catatan,
                        a.gambar,
                        a.nama,
                        DATE_FORMAT(a.tgl_mulai, '%d-%b-%Y') tgl_mulai,
                        a.status as status_produksi,
                        a.gudang_in,
                        DATE_FORMAT(a.gudang_in_at, '%d-%b-%Y') cek_gudang_tanggal
                FROM produksi AS a
                LEFT JOIN produksi_finishing AS b ON a.`kode` = b.kode_produksi AND b.is_deleted = 0
                WHERE a.status = 5 AND a.is_deleted = 0 ORDER BY a.id ASC";
        return $this->db->query($sql);
    }
    
    function cek_produksi($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE  produksi SET gudang_in            = 1,
                                    gudang_in_at = NOW(),
                                    updated_by               = '$user_nik',
                                    updated_at               = NOW() WHERE kode = '$data[kodeproduksi]'";

        return $this->db->query($sql);
    }
    
    function cek_produk($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE  produk SET gudang_in            = 1,
                                    gudang_in_at = NOW(),
                                    updated_by               = '$user_nik',
                                    updated_at               = NOW() WHERE kode = '$data[kode_produk]'";

        return $this->db->query($sql);
        
    }
    
     function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $sql2 = "SELECT * FROM {PRE}produksi_detail WHERE id = $data[id_produksi_detail] AND is_deleted = 0";
        $r = $this->db->query($sql2)->row_array();
        
        $sql2 = "INSERT INTO {PRE}produk (kode_produk,stok,status,created_by,created_at) VALUES ('$r[kode_produksi_detail]','$data[jumlah_barang]',1,$user_nik,NOW())";
        $this->db->query($sql2);
        
        
        $sql = "UPDATE {PRE}produksi_detail SET finishing_status            = 4,
                                                catatan_cek_barang = '$data[catatan]',
                                                updated_by               = '$user_nik',
                                                updated_at               = NOW() WHERE id = '$data[id_produksi_detail]'";

        return $this->db->query($sql);
    }
    
     //cetak resi//
    function data_resi($kode){
        $sql = "SELECT  o.*,
                        o.id_order as ido,
                        p.id as idp,p.nama as nmp,
                        jp.id as idjp,jp.nama as nmjp,jp.kode as kjp,
                        jk.id as idjk,jk.nama as nmjk,
                        DATE_FORMAT(o.tgl_order, '%d-%b-%Y') tgl_kirim,
                        format(o.total, 0) as hargas
                FROM order_header as o 
                LEFT JOIN pelanggan as p ON o.id_pelanggan = p.id
                LEFT JOIN jenis_pengiriman as jp ON o.id_jenis_pengiriman = jp.id
                LEFT JOIN jenis_kurir as jk ON o.id_jenis_kurir = jk.id

                WHERE  o.is_deleted = 0 And o.no_nota='$kode'";
        return $this->db->query($sql);
    }

    //End cetak resi//
    
    
    function update_kelola_stok($data){
        $user_nik = $this->user_nik();
        
        if($data['id_outlet'] == 4){
            $harga = '50000';
            $sql = "UPDATE  produk SET  id_outlet = '$data[id_outlet]',
                                        harga     = '$harga',
                                        updated_by       = '$user_nik ',
                                        updated_at       = NOW() WHERE kode = '$data[kode_produk]'";
        
            return $this->db->query($sql);
        }else{
            $sql = "UPDATE  produk SET     id_outlet = '$data[id_outlet]',
                                        updated_by       = '$user_nik ',
                                        updated_at       = NOW() WHERE kode = '$data[kode_produk]'";
        
            return $this->db->query($sql);
        }
        
        
    }
    
    
    function data_resi_detail($no_nota){

        $sql = "SELECT a.*,format(a.harga, 0) as hargas,c.nama as nama_produk ,c.nama as nama_produks,COUNT(a.qty) as count_qty,format(SUM(a.harga), 0) as count_harga
                    FROM order_detail as a
                    INNER JOIN produk_header as c ON a.kode_produk_header = c.kode and c.is_deleted = 0
                    where a.no_nota = '$no_nota' and a.is_deleted = 0 GROUP BY a.kode_produk_header";
        
        return $this->db->query($sql);
    }
    
    
}
?>