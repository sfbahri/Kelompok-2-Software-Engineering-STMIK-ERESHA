<?php 
class Bahan_baku_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT *,DATE_FORMAT(tgl_sampai, '%d-%b-%Y') tgl_sampai FROM bahan_baku WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function data_detail($kode_bahan_baku){
        $sql = "SELECT *,seq FROM bahan_baku WHERE is_deleted = 0 and kode = '$kode_bahan_baku'";
        return $this->db->query($sql);
    }
    
    function data_detail_cetak($kode_bahan_baku){
        $sql = "SELECT * FROM bahan_baku_detail WHERE is_deleted = 0 and kode = '$kode_bahan_baku'";
        return $this->db->query($sql);
    }
    
    function data_by_kode_produksi($kode_produksi){
        $sql = "SELECT a.*,b.*,format(a.harga, 0) as hargas
        FROM produksi_trans_bahan_baku AS a 
        INNER JOIN bahan_baku_detail AS b ON a.`kode_bahan_baku` = b.`kode` AND b.`is_deleted` = 0
        WHERE a.`is_deleted` = 0 and a.kode_produksi = $kode_produksi ORDER BY a.`id` ASC";
        return $this->db->query($sql);
    }
    
    function data_by_kode_produksi2($kode_produksi){
        $sql = "SELECT SUM(a.`harga`) tot_harga_bahan_baku
        FROM produksi_trans_bahan_baku AS a 
        INNER JOIN bahan_baku_detail AS b ON a.`kode_bahan_baku` = b.`kode` AND b.`is_deleted` = 0
        WHERE a.`is_deleted` = 0 AND a.kode_produksi = $kode_produksi ORDER BY a.`id` ASC";
        return $this->db->query($sql);
    }
    
    function data_select(){
        $sql = "SELECT * FROM bahan_baku_detail WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO bahan_baku (kode,tgl_sampai,img_qrcode,seq,created_by,created_at) VALUES ('$data[kode]',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[nama_qrcode]',1,$user_nik,NOW())";
        return $this->db->query($sql);
    }
    
    function detail($id_bahan_baku){
        $sql = "SELECT *,DATE_FORMAT(tgl_sampai, '%d-%b-%Y') tgl_sampai FROM bahan_baku WHERE is_deleted = 0 and id = $id_bahan_baku ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function update($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku SET  nama    = '$data[nama]',
                                        jenis       = '$data[jenis]',
                                        warna       = '$data[warna]',
                                        no_faktur   = '$data[no_faktur]',
                                        jumlah      = '$data[jumlah]',
                                        satuan      = '$data[satuan]',
                                        tgl_sampai  = DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$data[id_bahan_baku]'";
        
        return $this->db->query($sql);
    }
    
    
    function hapus($id_bahan_baku){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku SET  is_deleted    = '1',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE id = '$id_bahan_baku'";
        
        return $this->db->query($sql);
    }
    
    
    function cek_tanggal($tanggal){
        $sql = "SELECT * FROM bahan_baku WHERE is_deleted = 0 and tgl_sampai = DATE_FORMAT(STR_TO_DATE('$tanggal', '%d-%b-%Y'),'%Y-%m-%d')";
        return $this->db->query($sql);
    }
    
    
    
    /*==================== BAHAN BAKU DETAIL =================================*/
    
    function bahanbaku_detail($kode_bahan_baku_detail){
        $sql = "SELECT *,format(harga, 0) as harga,DATE_FORMAT(tgl_kirim, '%d-%b-%Y') tgl_kirim FROM bahan_baku_detail WHERE is_deleted = 0 and kode = $kode_bahan_baku_detail";
        return $this->db->query($sql);
    }
    
    function data_bahan_baku_detail($kode_bahan_baku){
        $sql = "SELECT *,format(harga, 0) as hargas FROM bahan_baku_detail WHERE is_deleted = 0 and kode_bahan_baku = $kode_bahan_baku ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function simpan_bahan_baku_detail($data){
        
        $user_nik = $this->user_nik();
        
        $seq_update = $data['seq'] + 1;
        
        $sql2 = "UPDATE bahan_baku SET  seq    = '$seq_update',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE kode = '$data[kode_bahan_baku]'";
        
        $this->db->query($sql2);
        
        
        $harga = str_replace(",","",$data['harga']);
        
        $sql = "INSERT INTO bahan_baku_detail (kode_bahan_baku,
                                                    kode,
                                                    img_qrcode,
                                                    nama,
                                                    jenis,
                                                    warna,
                                                    satuan,
                                                    harga,
                                                    stok_rol_awal,
                                                    stok_rol_akhir,
                                                    stok_kilo_awal,
                                                    stok_kilo_akhir,
                                                    no_faktur,
                                                    created_by,
                                                    created_at) 
                                            VALUES ('$data[kode_bahan_baku]',
                                                    '$data[kode_bahan_baku_detail]',
                                                    '$data[nama_qrcode]',
                                                    '$data[nama]',
                                                    '$data[jenis]',
                                                    '$data[warna]',
                                                    '$data[satuan]',
                                                    '0',
                                                    '$data[jumlah_rol]',
                                                    '$data[jumlah_rol]',
                                                    '$data[jumlah_kilo]',
                                                    '$data[jumlah_kilo]',
                                                    '$data[no_faktur]',
                                                    '$user_nik',
                                                    NOW())";
        return $this->db->query($sql);
        
    }
    
    
    function update_bahan_baku_detail($data){
        
        $user_nik = $this->user_nik();
        
        $harga = str_replace(",","",$data['harga']);
        
        $sql = "UPDATE bahan_baku_detail  SET  nama                 = '$data[nama]',
                                                    jenis           = '$data[jenis]',
                                                    warna           = '$data[warna]',
                                                    satuan          = '$data[satuan]',
                                                    stok_rol_awal   = '$data[jumlah_rol]',
                                                    stok_kilo_awal  = '$data[jumlah_kilo]',
                                                    stok_rol_akhir  = '$data[jumlah_rol]',
                                                    stok_kilo_akhir = '$data[jumlah_kilo]',
                                                    updated_by      = '$user_nik',
                                                    updated_at      = NOW() WHERE kode = '$data[kode]'"; 
                  
        return $this->db->query($sql);
        
    }
    
    
  
    
    /*==================== BAHAN BAKU DETAIL =================================*/
    
    
    
    
    // ======================FINANCE BAHAN BAKU ======================= //
    
    function finance_input_harga_bahan_baku($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku_detail  SET   harga           = '$data[harga]',
                                                updated_by      = '$user_nik',
                                                updated_at      = NOW() WHERE kode = '$data[kode_bahan_bakau_detail]'"; 
                  
        return $this->db->query($sql);
    }
    
    
    
    //==PO ORDER BAHAN BAKU
    function cek_order_po($po_bulan,$po_tahun){
        $sql = "SELECT * FROM bahan_baku WHERE is_deleted = 0 and po_bulan = '$po_bulan' and po_tahun = '$po_tahun'";
        return $this->db->query($sql);
    }
    
    
    function bahan_baku_po_simpan($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO bahan_baku (kode,po_bulan,po_tahun,img_qrcode,seq,created_by,created_at,status) VALUES ('$data[kode]','$data[po_bulan]','$data[po_tahun]','$data[nama_qrcode]',1,$user_nik,NOW(),1)";
        return $this->db->query($sql);
    }
    
    function bahan_baku_po_data(){
        $sql = "SELECT *,
CASE
                WHEN po_bulan = 01 THEN 'Januari'
                WHEN po_bulan = 02 THEN 'Februari'
                WHEN po_bulan = 03 THEN 'Maret'
                WHEN po_bulan = 04 THEN 'April'
                WHEN po_bulan = 05 THEN 'Mei'
	        WHEN po_bulan = 06 THEN 'Juni'
		WHEN po_bulan = 07 THEN 'Juli'
		WHEN po_bulan = 08 THEN 'Agustus'
		WHEN po_bulan = 09 THEN 'September'
		WHEN po_bulan = 10 THEN 'Oktober'
		WHEN po_bulan = 11 THEN 'November'
		WHEN po_bulan = 12 THEN 'Desember'
                ELSE 'Tidak Nama Bulan'
                END as pobulan,
            DATE_FORMAT(tgl_sampai, '%d-%b-%Y') tgl_sampai
            FROM bahan_baku 
            WHERE is_deleted = 0 
            ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    
    function simpan_bahan_baku_detail_po($data){
        
        $user_nik = $this->user_nik();
        
        $seq_update = $data['seq'] + 1;
        
        $sql2 = "UPDATE bahan_baku SET  seq    = '$seq_update',
                                        updated_by  = '$user_nik',
                                        updated_at  = NOW() WHERE kode = '$data[kode_bahan_baku]'";
        
        $this->db->query($sql2);
        
        
        $harga = str_replace(",","",$data['harga']);
        
        $noso = $data['no_so'].$data['nourut'];
        
        $sql = "INSERT INTO bahan_baku_detail (kode_bahan_baku,
                                                    kode,
                                                    img_qrcode,
                                                    nama,
                                                    jenis,
                                                    warna,
                                                    satuan,
                                                    harga,
                                                    stok_rol_awal,
                                                    stok_rol_akhir,
                                                    stok_kilo_awal,
                                                    stok_kilo_akhir,
                                                    noso,
                                                    nourut,
                                                    kategori,
                                                    tgl_kirim,
                                                    created_by,
                                                    created_at,
                                                    status) 
                                            VALUES ('$data[kode_bahan_baku]',
                                                    '$data[kode_bahan_baku_detail]',
                                                    '$data[nama_qrcode]',
                                                    '$data[nama]',
                                                    '$data[jenis]',
                                                    '$data[warna]',
                                                    '$data[satuan]',
                                                    '0',
                                                    '$data[jumlah_rol]',
                                                    '$data[jumlah_rol]',
                                                    '$data[jumlah_kilo]',
                                                    '$data[jumlah_kilo]',
                                                    '$noso',
                                                    '$data[kategori]',
                                                    '$data[nourut]',
                                                    DATE_FORMAT(STR_TO_DATE('$data[tgl_kirim]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                    '$user_nik',
                                                    NOW(),1)";
        return $this->db->query($sql);
        
    }
    
    
    function update_bahan_baku_detail_po($data){
        
        $user_nik = $this->user_nik();
        
        $harga = str_replace(",","",$data['harga']);
        
        $noso = $data['no_so'].$data['nourut'];
        
        $sql = "UPDATE bahan_baku_detail  SET  nama                 = '$data[nama]',
                                                    jenis           = '$data[jenis]',
                                                    warna           = '$data[warna]',
                                                    satuan          = '$data[satuan]',
                                                    harga           = '$harga',
                                                    nourut          = '$data[nourut]',
                                                    tgl_kirim       = DATE_FORMAT(STR_TO_DATE('$data[tgl_kirim]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                    kategori        = '$data[kategori]',
                                                    noso            = '$noso',
                                                    stok_rol_awal   = '$data[jumlah_rol]',
                                                    stok_kilo_awal  = '$data[jumlah_kilo]',
                                                    stok_rol_akhir  = '$data[jumlah_rol]',
                                                    stok_kilo_akhir = '$data[jumlah_kilo]',
                                                    updated_by      = '$user_nik',
                                                    updated_at      = NOW() WHERE kode = '$data[kode]'"; 
                  
        return $this->db->query($sql);
        
    }
    
    function update_status_bahan_baku_produksi($kode_bahan_baku){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku_detail  SET   tgl_terima_produksi = NOW(),
                                                updated_by          = '$user_nik',
                                                updated_at          = NOW() WHERE kode = '$kode_bahan_baku'"; 
                  
        return $this->db->query($sql);
    }
    
    function update_status_bahan_baku_finance($kode_bahan_baku){
        
         $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku_detail  SET   tgl_terima = NOW(),
                                                updated_by          = '$user_nik',
                                                updated_at          = NOW() WHERE kode = '$kode_bahan_baku'"; 
                  
        return $this->db->query($sql);
        
    }
    
    function update_status_order($kode_bahan_baku){
        
         $user_nik = $this->user_nik();
        
        $sql = "UPDATE bahan_baku  SET   status = 2,
                                                updated_by          = '$user_nik',
                                                updated_at          = NOW() WHERE kode = '$kode_bahan_baku'"; 
                  
        return $this->db->query($sql);
        
    }
    
}
?>