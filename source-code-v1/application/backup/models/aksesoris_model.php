<?php 
class Aksesoris_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT *,format(harga, 0) as hargas,DATE_FORMAT(tanggal, '%d-%b-%Y') tgl,format(stok_awal, 0) as stok_awals,format(stok_akhir, 0) as stok_akhirs FROM aksesoris WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function data_by_kode_produksi($kode_produksi){
        $sql = "SELECT a.*,b.*,format(a.harga, 0) as hargas
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
    
    function detail($id_aksesoris){
        $sql = "SELECT *,format(harga, 0) as harga,harga as hargas,DATE_FORMAT(tanggal, '%d-%b-%Y') tgl,format(stok_awal, 0) as stok_awals,format(stok_akhir, 0) as stok_akhirs FROM aksesoris WHERE is_deleted = 0 and id = $id_aksesoris ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function detail_cetak($kode){
        $sql = "SELECT *,format(harga, 0) as harga,harga as hargas,DATE_FORMAT(tanggal, '%d-%b-%Y') tgl,format(stok_awal, 0) as stok_awals,format(stok_akhir, 0) as stok_akhirs FROM aksesoris WHERE is_deleted = 0 and kode = '$kode' ORDER by id ASC";
        return $this->db->query($sql);
    }
            
    function simpan($data,$nama_file){
        $user_nik = $this->user_nik();
        $harga = str_replace(",","",$data['harga']);
        $jumlah = str_replace(",","",$data['jumlah']);
        
        $sql = "INSERT INTO aksesoris (nama,stok_awal,stok_akhir,harga,tanggal,satuan,gambar,created_by,created_at,kode,img_qrcode) VALUES ('$data[nama]','$jumlah','$jumlah','$harga',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[satuan]','$nama_file',$user_nik,NOW(),'$data[kode]','$data[nama_qrcode]')";
        return $this->db->query($sql);
    }
    
    function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $jumlah = str_replace(",","",$data['jumlah']);
        $harga = str_replace(",","",$data['harga']);
        
        $sql = "UPDATE aksesoris SET nama  = '$data[nama]',
                                        stok_awal  = '$jumlah',
                                        satuan  = '$data[satuan]',
                                        harga  = '$harga',
                                        tanggal = DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),
                                        gambar  = '$nama_file',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$data[id_aksesoris]'";
        // harga  = '$data[harga]',
        return $this->db->query($sql);
    }
    
    function hapus($id_aksesoris){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE aksesoris SET is_deleted  = '1',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$id_aksesoris'";

        return $this->db->query($sql);
        
    }
    
    
    
    /*PRODUKSI AKSESORIS*/
    
    function data_detail($kode_produksi){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai,
                DATE_FORMAT(tgl_ambil, '%d-%b-%Y') tgl_ambil,format(biaya, 0) as biaya_aksesoris FROM produksi_aksesoris WHERE kode_produksi = $kode_produksi AND is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $tgl_mulai;
        if($data['tgl_mulai'] == ''){
            $tgl_mulai = 'NULL,';
        }else{
            $tgl_mulai = "DATE_FORMAT(STR_TO_DATE('$data[tgl_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        $tgl_diambil;
        if($data['tgl_diambil'] == ''){
            $tgl_diambil = 'NULL,';
        }else{
            $tgl_diambil = "DATE_FORMAT(STR_TO_DATE('$data[tgl_diambil]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        $biaya_aksesoris = str_replace(",","",$data['biaya']);
        
        $sql = "UPDATE  produksi_aksesoris SET  tgl_mulai        = $tgl_mulai
                                                tgl_ambil        = $tgl_diambil
                                                id_vendor        = '$data[vendor]',
                                                biaya            = '$biaya_aksesoris',
                                                jenis_barang     = '$data[jenis_barang]',
                                                pic              = '$data[pic]',
                                                berat            = '$data[berat]',
                                                jumlah           = '$data[jumlah]',
                                                gambar           = '$nama_file',
                                                updated_by       = '$user_nik',
                                                updated_at       = NOW() WHERE kode_produksi = '$data[kode_produksi]'";

        return $this->db->query($sql);
    }
    
    //================================= FINANCE ===============================/
    
    function finance_update($data){
        
        $user_nik = $this->user_nik();
        
        $harga_aks = str_replace(",","",$data['harga']);
        
        $sql = "UPDATE aksesoris SET    harga  = '$harga_aks',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$data[id_aksesoris]'";
        //  satuan  = '$data[satuan]',
        return $this->db->query($sql);
    }
    
}
?>