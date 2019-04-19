<?php 
class Produksi_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai FROM produksi WHERE is_deleted = 0 ORDER by id,created_at ASC";
        return $this->db->query($sql);
    }
    
    function data_produksi_finance(){
        //status 5 itu artinya sudah finisihing
        //dan gudang in = 1, artinya barang sudah masuk ke gudang dan fisiknya ada
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai FROM produksi WHERE is_deleted = 0 and status = 5 and gudang_in = 1 ORDER by id,created_at ASC";
        return $this->db->query($sql);
    }
    
    function data_produksi_sudah_publish(){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai FROM produksi WHERE is_deleted = 0 and status = 5 and gudang_in = 1 and publish = 1 ORDER by id,created_at ASC";
        return $this->db->query($sql);
    }

    function data_produksi_produk(){
        $sql = "SELECT 
*,DATE_FORMAT(a.tgl_mulai, '%d-%b-%Y') tgl_mulai,(SELECT COUNT(b.kode) AS total_produk FROM produk AS b WHERE b.kode_produksi = a.kode AND b.is_deleted = 0) totalproduk  
FROM produksi AS a WHERE a.is_deleted = 0 ORDER BY a.id,a.created_at ASC";
        return $this->db->query($sql);
    }
    
    function data_detail($kode_produksi){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai,status FROM produksi WHERE is_deleted = 0 and kode = '$kode_produksi'";
        return $this->db->query($sql);
    }
    
    function get_jumlah_akhir($kode_produksi){
        $sql = "SELECT jumlah FROM produksi_cutting WHERE is_deleted = 0 and kode_produksi = '$kode_produksi'";
        return $this->db->query($sql);
    }

    function created_label($img_qrcode,$harga_jual,$kode_produksi,$kode_produksi_produk){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO produk (kode_produksi,
                                    kode,
                                    harga,
                                    stok,
                                    img_qrcode,
                                    created_by,
                                    created_at) 
                            VALUES ('$kode_produksi',
                                    '$kode_produksi_produk',
                                    '$harga_jual',
                                    '1',
                                    '$img_qrcode',
                                    '$user_nik',
                                    NOW())";
        return $this->db->query($sql);
    }
    
    function update_harga($harga_jual,$harga_modal,$kode_produksi){
        
            $user_nik = $this->user_nik();
        
            $sql = "UPDATE produksi SET publish = 1, harga_modal = '$harga_modal', harga_jual = '$harga_jual' , updated_by = '$user_nik', updated_at = NOW() WHERE kode = '$kode_produksi' and is_deleted = 0";
            
            $sql1 = "UPDATE produk SET publish = 1, harga = '$harga_jual', updated_by = '$user_nik', updated_at = NOW() WHERE kode_produksi = '$kode_produksi'";
            $this->db->query($sql1);
            
            return $this->db->query($sql);
    }
    
    function update_stok($kode_produksi,$jumlah){
        $sql = "UPDATE produksi SET stok = $jumlah WHERE kode = $kode_produksi and is_deleted = 0";
            return $this->db->query($sql);
    }
            
    function data_produksi_detail_by_id($id_produksi_detail){
        $sql = "SELECT *,DATE_FORMAT(cutting_tgl_mulai, '%d-%b-%Y') cutting_tgl_mulai,
                DATE_FORMAT(sablon_tgl_mulai, '%d-%b-%Y') sablon_tgl_mulai,
                DATE_FORMAT(sablon_tgl_ambil, '%d-%b-%Y') sablon_tgl_ambil
                 FROM produksi_detail WHERE is_deleted = 0 and id = '$id_produksi_detail'";
        return $this->db->query($sql);
    }
    
    function simpan($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO produksi (kode,
                                    nama,
                                    tgl_mulai,
                                    qrcode,
                                    gambar,
                                    gambar_kode,
                                    jumlah_estimasi_produk,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[nama]',
                                    DATE_FORMAT(STR_TO_DATE('$data[tanggal_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),
                                    '$data[img_qrcode]',
                                    '$data[path_gambar]',
                                    '$data[id_gambar]',
                                    '$data[estimasi_produk]',
                                    '$user_nik',
                                    NOW())";
        
        
        //ini update gambar jika set approve = 4 maka akan hilang di tambah produksi (bisa dibilang sudah dipakai)
            $sql_bbbb = "UPDATE produksi_gambar SET approve = '4' WHERE id = '$data[id_gambar]' and gambar = '$data[path_gambar]'";
            $this->db->query($sql_bbbb);
        
        /* Aksesoris */
        for($i = 0;$i < count($data['rows_aksesoris']); $i++)
        {

            $aksesoris_id    	= $data['aksesoris_id'][$i];
            $aksesoris_jumlah   = $data['jumlah_aksesoris'][$i];
            $aksesoris_harga    = $data['harga_aksesoris'][$i];
            
            $hargaakss = str_replace(",","",$aksesoris_harga);
            
            //select stok akhir aksesoris
            $sql_ccc = "SELECT stok_akhir FROM aksesoris WHERE id = $aksesoris_id and is_deleted = 0";
            $c = $this->db->query($sql_ccc)->row_array();
            
            $hasil_stok_akhir = $c['stok_akhir'] - $aksesoris_jumlah;
            
            //kurangin jumlah aksesoris
            $sql_cccc = "UPDATE aksesoris SET stok_akhir = $hasil_stok_akhir WHERE id = $aksesoris_id and is_deleted = 0";
            $this->db->query($sql_cccc);
            
            
            $sql_acc = "INSERT INTO produksi_trans_aksesoris (kode_produksi,
                                                            id_aksesoris,
                                                            jumlah,
                                                            harga,
                                                            created_by,
                                                            created_at) 
                                                    VALUES ('$data[kode]',
                                                            $aksesoris_id,
                                                            $aksesoris_jumlah,
                                                            '$hargaakss',
                                                            '$user_nik',
                                                            NOW())";
            $this->db->query($sql_acc);
            
        }
        
        
        /* Bahan Baku */
        for($i = 0;$i < count($data['rows_bahanbaku']); $i++)
        {

            $bahanbaku_kode          = $data['bahan_baku_id'][$i];
            $bahanbaku_jumlah_rol    = $data['jumlah_rol_bahan_baku'][$i];
            $bahanbaku_jumlah_kilo   = $data['jumlah_kilo_bahan_baku'][$i];
            $bahanbaku_harga         = $data['harga_bahan_baku'][$i];
            
            $hargaakbb = str_replace(",","",$bahanbaku_harga);
            
            //select stok akhir bahan baku
            $sql_bbb = "SELECT stok_rol_akhir,stok_kilo_akhir FROM bahan_baku_detail WHERE kode = $bahanbaku_kode and is_deleted = 0";
            $r = $this->db->query($sql_bbb)->row_array();
            
            $hasil_stok_rol_akhir = $r['stok_rol_akhir'] - $bahanbaku_jumlah_rol;
            $hasil_stok_kilo_akhir = $r['stok_kilo_akhir'] - $bahanbaku_jumlah_kilo;
            
            //kurangin jumlah bahan baku
            $sql_bbbb = "UPDATE bahan_baku_detail SET stok_rol_akhir = $hasil_stok_rol_akhir, stok_kilo_akhir = $hasil_stok_kilo_akhir WHERE kode = $bahanbaku_kode and is_deleted = 0";
            $this->db->query($sql_bbbb);
            
            
            $sql_bb = "INSERT INTO produksi_trans_bahan_baku (kode_produksi,
                                                            kode_bahan_baku,
                                                            jumlah_rol,
                                                            jumlah_kilo,
                                                            harga,
                                                            created_by,
                                                            created_at) 
                                                    VALUES ('$data[kode]',
                                                            $bahanbaku_kode,
                                                            $bahanbaku_jumlah_rol,
                                                            $bahanbaku_jumlah_kilo,
                                                            '$hargaakbb',
                                                            '$user_nik',
                                                            NOW())";
            $this->db->query($sql_bb);
            
            
        }
        
        //produksi_cutting
        $biaya_cutting = str_replace(",","",$data['biaya_cutting']);
        
// ---------------- START BIAYA UNTUK HISTORY KAS CUTTING ------------------- //        
        
        //select ke kas cutting
        $sql_cutt_1 = "SELECT saldo_akhir FROM kas_kategori WHERE id = 1"; 
        $c1 = $this->db->query($sql_cutt_1)->row_array();
        $update_biaya_cutting = $c1['saldo_akhir'] - $biaya_cutting;
        
        //update ke kas cutting
        $sql_cutt_2 = "UPDATE kas_kategori SET saldo_akhir = '$update_biaya_cutting' WHERE id = 1"; 
        $this->db->query($sql_cutt_2);
        
        //insert ke kas transaksi
        $sql_cutt_3 = "INSERT INTO kas_transaksi (kode_produksi,id_kas_kategori,tgl_transaksi,jumlah,catatan) VALUES ('$data[kode]','1',NOW(),'$biaya_cutting','Ini biaya cutting untuk produksi ".$data['kode']."')";
        $this->db->query($sql_cutt_3);

// ---------------- END BIAYA UNTUK HISTORY KAS CUTTING ------------------- //
        
        $sql_1 = "INSERT INTO produksi_cutting (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$biaya_cutting',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_1);
        
        
        //produksi_sablon
        $biaya_sablon = str_replace(",","",$data['biaya_sablon']);
        
// ---------------- START BIAYA UNTUK HISTORY KAS SABLON ------------------- //        
        
        //select ke kas sablon
        $sql_sabb_1 = "SELECT saldo_akhir FROM kas_kategori WHERE id = 1"; 
        $s1 = $this->db->query($sql_sabb_1)->row_array();
        $update_biaya_sablon = $s1['saldo_akhir'] - $biaya_sablon;
        
        //update ke kas cutting
        $sql_sabb_2 = "UPDATE kas_kategori SET saldo_akhir = '$update_biaya_sablon' WHERE id = 1"; 
        $this->db->query($sql_sabb_2);
        
        //insert ke kas transaksi
        $sql_sabb_3 = "INSERT INTO kas_transaksi (kode_produksi,id_kas_kategori,tgl_transaksi,jumlah,catatan) VALUES ('$data[kode]','1',NOW(),'$biaya_sablon','Ini biaya sablon untuk produksi ".$data['kode']."')";
        $this->db->query($sql_sabb_3);

// ---------------- END BIAYA UNTUK HISTORY KAS SABLON ------------------- //
        
        $sql_2 = "INSERT INTO produksi_sablon (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$biaya_sablon',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_2);
        
        //produksi_aksesoris
        $sql_3 = "INSERT INTO produksi_aksesoris (kode_produksi,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_3);
        
        
        //produksi_sewing
        $biaya_sewing = str_replace(",","",$data['biaya_sewing']);
        
// ---------------- START BIAYA UNTUK HISTORY KAS SEWING ------------------- //        
        
        //select ke kas sablon
        $sql_seww_1 = "SELECT saldo_akhir FROM kas_kategori WHERE id = 1"; 
        $sw1 = $this->db->query($sql_seww_1)->row_array();
        $update_biaya_sewing = $sw1['saldo_akhir'] - $biaya_sablon;
        
        //update ke kas cutting
        $sql_seww_2 = "UPDATE kas_kategori SET saldo_akhir = '$update_biaya_sewing' WHERE id = 1"; 
        $this->db->query($sql_seww_2);
        
        //insert ke kas transaksi
        $sql_seww_3 = "INSERT INTO kas_transaksi (kode_produksi,id_kas_kategori,tgl_transaksi,jumlah,catatan) VALUES ('$data[kode]','1',NOW(),'$biaya_sewing','Ini biaya sewing untuk produksi ".$data['kode']."')";
        $this->db->query($sql_seww_3);

// ---------------- END BIAYA UNTUK HISTORY KAS SEWING ------------------- //
        
        $sql_4 = "INSERT INTO produksi_sewing (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$biaya_sewing',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_4);
        
        
        //produksi_aksesoris
        $sql_5 = "INSERT INTO produksi_finishing (kode_produksi,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_5);
        
        
        
        return $this->db->query($sql);
    }
    
    
    function simpan_manual($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO produksi (kode,
                                    nama,
                                    tgl_mulai,
                                    qrcode,
                                    harga_modal,
                                    harga_jual,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[nama]',
                                    DATE_FORMAT(STR_TO_DATE('$data[tanggal_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),
                                    '$data[img_qrcode]',
                                    '$data[harga_modal]',
                                    '$data[harga_jual]',
                                    '$user_nik',
                                    NOW())";
        
        //produksi_cutting
        $sql_1 = "INSERT INTO produksi_cutting (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$data[biaya_cutting]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_1);
        
        
        //produksi_sablon
        $sql_2 = "INSERT INTO produksi_sablon (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$data[biaya_sablon]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_2);
        
        //produksi_aksesoris
        $sql_3 = "INSERT INTO produksi_aksesoris (kode_produksi,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_3);
        
        
        //produksi_sewing
        $sql_4 = "INSERT INTO produksi_sewing (kode_produksi,
                                                biaya,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$data[biaya_sewing]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_4);
        
        
        //produksi_aksesoris
        $sql_5 = "INSERT INTO produksi_finishing (kode_produksi,
                                                created_by,
                                                created_at) 
                                            VALUES ('$data[kode]',
                                                '$user_nik',
                                                NOW())";
        $this->db->query($sql_5);
        
        
        
        return $this->db->query($sql);
    }
    
    
    function data_produksi_detail($data){
        $sql = "SELECT * FROM produksi_detail WHERE kode_produksi = '$data[kode_produksi]' and is_deleted = 0 ORDER by id DESC";
        return $this->db->query($sql);
    }
    
    function proses_upload_media($data){

        $sql = "INSERT INTO produksi_detail (kode_produksi,
                                        kode_produksi_detail,
                                        path,
                                        gambar,qrcode)
                                VALUES ('$data[kode_produksi]',
                                        '$data[kode_produksi_detail]',
                                        '$data[path]',
                                        '$data[nama_file]','$data[nama_qrcode]')";
        
        return $this->db->query($sql);
        
    }
    
    function publish($data){
        $user_nik = $this->user_nik();
        $sql = "UPDATE produksi SET publish = 1,updated_by = '$user_nik',updated_at = NOW() WHERE kode = '$data[kode_produksi]'";
        
        $sql2 = "UPDATE produksi_detail SET cutting_status = 1,cutting_status_created_by = '$user_nik',cutting_status_created_at = NOW() WHERE kode_produksi = '$data[kode_produksi]' and is_deleted = 0";
        $this->db->query($sql2);
        
        return $this->db->query($sql);
    }
    
    function update_status($kode_produksi,$status){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi SET status = $status , updated_by = '$user_nik', updated_at = NOW() WHERE kode = '$kode_produksi'";
        
        return $this->db->query($sql);
        
    }
    
    function hapus($kode_produksi){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi SET is_deleted = 1 , updated_by = '$user_nik', updated_at = NOW() WHERE kode = '$kode_produksi'";
        
        return $this->db->query($sql);
    }
    
    function data_gambar_produksi_produksi(){
        
        $sql = "SELECT * FROM produksi_gambar where is_deleted = 0 AND approve = 3 ORDER BY id_seq DESC";
        return $this->db->query($sql);
        
    }
    
    function gambar_detail($data){
        $sql = "SELECT gambar,nama FROM produksi_gambar where id = '$data[id]'";
        return $this->db->query($sql);
    }
    
    function get_all_biaya($kode_produksi){
        $sql = "SELECT b.biaya as biaya_cutting,
                        c.biaya as biaya_sewing,	
                        d.biaya as biaya_sablon,
                        e.harga as harga_aksesoris,
                        f.harga as harga_bahan_baku,
                        a.jumlah_estimasi_produk,
                        g.jumlah as jumlah_finishing
                 FROM produksi as a
                 INNER JOIN produksi_cutting as b ON a.kode = b.kode_produksi and b.is_deleted = 0
                 INNER JOIN produksi_sewing as c ON a.kode = c.kode_produksi and c.is_deleted = 0
                 INNER JOIN produksi_sablon as d ON a.kode = d.kode_produksi and d.is_deleted = 0
                 INNER JOIN produksi_finishing as g ON a.kode = g.kode_produksi and g.is_deleted = 0
                 INNER JOIN produksi_trans_aksesoris as e ON a.kode = e.kode_produksi and e.is_deleted = 0
                 INNER JOIN produksi_trans_bahan_baku as f ON a.kode = f.kode_produksi and f.is_deleted = 0
                 WHERE a.kode = '$kode_produksi' and a.is_deleted = 0";
        return $this->db->query($sql);
    }
    
    
    
    //preview detail produksi 
    public function rinci_cutting($data){
        $sql="  SELECT pc.*,
                    v.nama as nm_vendor
                FROM produksi_cutting as pc
                LEFT JOIN vendor as v ON pc.id_vendor =v.id
                WHERE kode_produksi='$data[kode_produksi]'";
             return $this->db->query($sql);
    }
    public function rinci_sablon($data){
        $sql="  SELECT ps.*,
                    v.nama as nm_vendor
                FROM produksi_sablon as ps
                LEFT JOIN vendor as v ON ps.id_vendor =v.id
                WHERE kode_produksi='$data[kode_produksi]'";
             return $this->db->query($sql);
    }
    public function rinci_aksesoris($data){
        $sql="  SELECT pa.*,
                    v.nama as nm_vendor
                FROM produksi_aksesoris as pa
                LEFT JOIN vendor as v ON pa.id_vendor =v.id
                WHERE kode_produksi='$data[kode_produksi]'";
             return $this->db->query($sql);
    }
    public function rinci_sewing($data){
        $sql="  SELECT ps.*,
                    v.nama as nm_vendor
                FROM produksi_sewing as ps
                LEFT JOIN vendor as v ON ps.id_vendor =v.id
                WHERE kode_produksi='$data[kode_produksi]'";
             return $this->db->query($sql);
    }
    public function rinci_finishing($data){
        $sql="  SELECT *
                FROM produksi_finishing 
                WHERE kode_produksi='$data[kode_produksi]'";
             return $this->db->query($sql);
    }
    
    
}
?>