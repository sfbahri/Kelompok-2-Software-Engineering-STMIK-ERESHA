<?php 
class Berita_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function userid(){
        return $this->session->userdata('sess_id');
    }
    
    function simpan($data,$nama_file){
        $user_nik = $this->userid();

        $sql = "INSERT INTO berita (judul,gambar,deskripsi,created_by,created_at) VALUES ('$data[judul]','$nama_file','$data[deskripsi]',$user_nik,NOW())";
        return $this->db->query($sql);
    }
    
    function data(){
        $sql = "SELECT * FROM berita WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function detail($id_berita){
        $sql = "SELECT * FROM berita WHERE is_deleted = 0 and id = $id_berita";
        return $this->db->query($sql);
    }
    
    
    function update($data,$nama_file){
        
        $user_id = $this->userid();
        
        $sql = "UPDATE berita SET judul     = '$data[judul]',
                                deskripsi   = '$data[deskripsi]',
                                gambar      = '$nama_file',
                                updated_by  = '$user_id',
                                updated_at  = NOW() WHERE id = '$data[id_berita]'";
        return $this->db->query($sql);
    }
    
    function hapus($id_berita){

        $sql = "DELETE FROM berita where id = '$id_berita'";
        
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
    
    function detail_cetak($kode){
        $sql = "SELECT *,format(harga, 0) as harga,harga as hargas,DATE_FORMAT(tanggal, '%d-%b-%Y') tgl,format(stok_awal, 0) as stok_awals,format(stok_akhir, 0) as stok_akhirs FROM aksesoris WHERE is_deleted = 0 and kode = '$kode' ORDER by id ASC";
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