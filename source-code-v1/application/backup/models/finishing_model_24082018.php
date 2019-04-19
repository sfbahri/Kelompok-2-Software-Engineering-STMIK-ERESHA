<?php 
class Finishing_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM {PRE}produksi_detail WHERE finishing_status = 1 AND is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function data_detail($kode_produksi){
        $sql = "SELECT 	DATE_FORMAT(a.tgl_serah_terima, '%d-%b-%Y') tgl_serah_terima,
                        b.nama as nama_produksi,
                        b.qrcode,
                        a.jumlah as jumlah_akhir_finishing,
                        a.berat,
                        a.catatan
                FROM produksi_finishing as a
                INNER JOIN produksi as b ON a.kode_produksi = b.kode and b.is_deleted = 0
                WHERE a.kode_produksi = '$kode_produksi' AND a.is_deleted = 0";
        //$sql = "SELECT *,DATE_FORMAT(tgl_serah_terima, '%d-%b-%Y') tgl_serah_terima FROM produksi_finishing WHERE kode_produksi = $kode_produksi AND is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $tgl_serah_terima;
        if($data['tgl_serah_terima'] == ''){
            $tgl_serah_terima = 'NULL,';
        }else{
            $tgl_serah_terima = "DATE_FORMAT(STR_TO_DATE('$data[tgl_serah_terima]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        
        $sql = "UPDATE  produksi_finishing SET      tgl_serah_terima = $tgl_serah_terima
                                                    jenis_barang     = '$data[jenis_barang]',
                                                    berat            = '$data[berat]',
                                                    jumlah           = '$data[jumlah_akhir]',
                                                    catatan          = '$data[catatan]',
                                                    gambar           = '$nama_file',
                                                    updated_by       = '$user_nik',
                                                    updated_at       = NOW() WHERE kode_produksi = '$data[kode_produksi]'";

        $sql2 = "UPDATE  produksi SET   small_warna_1_jumlah_akhir = '$data[small_warna_1_jumlah_akhir]',
                                        small_warna_2_jumlah_akhir = '$data[small_warna_2_jumlah_akhir]',
                                        large_warna_1_jumlah_akhir = '$data[large_warna_1_jumlah_akhir]',
                                        large_warna_2_jumlah_akhir = '$data[large_warna_2_jumlah_akhir]',
                                        stok_status                = '1',
                                        updated_by                 = '$user_nik',
                                        updated_at                 = NOW() WHERE kode = '$data[kode_produksi]'";
        
        $this->db->query($sql2);
        
        
        //update produk header
        $total_stok = $data['small_warna_1_jumlah_akhir']+$data['small_warna_2_jumlah_akhir']+$data['large_warna_1_jumlah_akhir']+$data['large_warna_2_jumlah_akhir'];

        $sql23 = "UPDATE  produk_header SET S1_jumlah = '$data[small_warna_1_jumlah_akhir]',
                                            S2_jumlah = '$data[small_warna_2_jumlah_akhir]',
                                            L1_jumlah = '$data[large_warna_1_jumlah_akhir]',
                                            L2_jumlah = '$data[large_warna_2_jumlah_akhir]',
                                            stok      = '$total_stok',
                                            stok_at   = NOW(),
                                            updated_by                 = '$user_nik',
                                            updated_at                 = NOW() WHERE kode_produksi = '$data[kode_produksi]'";
        
        $this->db->query($sql23);
        
        
        return $this->db->query($sql);
    }
    
    
    function get_kode_produk_header($kode_produksi){
        $sql = "SELECT kode FROM produk_header where kode_produksi = '$kode_produksi'";
        return $this->db->query($sql);
    }
    
    function created_label($img_qrcode,$kode_produksi,$kode_produksi_produk,$inisial){
        
        $user_nik = $this->user_nik();
        
        $sql1 = "SELECT stok_at,kode,nama FROM produk_header WHERE kode_produksi = '$kode_produksi'";
        $r = $this->db->query($sql1)->row_array();
        
        $kodeproduksi = $r['kode'];
        $nama = $r['nama'];
        
        if($r['stok_at'] == null){
            
            $sql = "INSERT INTO produk (kode_produk_header,
                                    nama,
                                    inisial,
                                    kode,
                                    stok,
                                    img_qrcode,
                                    created_by,
                                    created_at) 
                            VALUES ('$kodeproduksi',
                                    '$nama',
                                    '$inisial',
                                    '$kode_produksi_produk',
                                    '1',
                                    '$img_qrcode',
                                    '$user_nik',
                                    NOW())";
            return $this->db->query($sql);
            
        }else{
            
            
        }
        
        
    }
    
    
}
?>