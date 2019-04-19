<?php 
class Penjualan_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function get_outlet(){
        return $this->session->userdata('sess_outlet');
    }
    
    function data($data){
        $sql = "SELECT *,format(harga, 0) as hargas FROM order_detail WHERE kode_transaksi = '$data[kode_transaksi]'";
        return $this->db->query($sql);
    }
    
    function data_detail($data){
        
        $sql = "SELECT FORMAT(SUM(harga), 0) AS tot_harga,SUM(harga) harga_asli FROM order_detail WHERE kode_transaksi = '$data[kode_transaksi]'";
        return $this->db->query($sql);
    }
    
    function simpan_transaksi_baru($data){
        $user_nik = $this->user_nik();
            
            // 1. Member
            // 2. Non Member
        
            if($data['customer'] == 1){
                
                $sql1 = "SELECT nama,nohp FROM users WHERE id = '$data[list_member]'";
                $r =  $this->db->query($sql1)->row_array();
                
                $sql2 = "INSERT INTO order_header (kode_transaksi,
                                    tgl_order,
                                    id_users,
                                    nama,
                                    nohp,
                                    status,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode_transaksi]',
                                    NOW(),
                                    '$data[list_member]',
                                    '$r[nama]',
                                    '$r[nohp]',
                                    '1',
                                    '$user_nik',
                                    NOW())";
        
                return $this->db->query($sql2);
                
            }else{
                
                $sql = "INSERT INTO order_header (kode_transaksi,
                                    tgl_order,
                                    nama,
                                    nohp,
                                    status,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode_transaksi]',
                                    NOW(),
                                    '$data[nama]',
                                    '$data[no_hp]',
                                    '1',
                                    '$user_nik',
                                    NOW())";
        
                return $this->db->query($sql);
                
            }
        
            
    }
    
    
    function simpan($data){
        $user_nik = $this->user_nik();
        
            $sqla = "SELECT * FROM produk where kode = '$data[kodeproduk]'";
            $s = $this->db->query($sqla)->row_array();
            
            
            $sql = "INSERT INTO order_detail (kode_transaksi,
                                    kode_produk,
                                    qty,
                                    harga,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode_transaksi]',
                                    '$data[kodeproduk]',
                                    '1',
                                    '$s[harga]',
                                    '$user_nik',
                                    NOW())";
        
            $sqlc = "UPDATE produk SET beli = 1 WHERE kode = '$data[kodeproduk]' and is_deleted = 0";
            $this->db->query($sqlc);
            
        
        return $this->db->query($sql);
    }
    
    function transaksi_detail($kode_transaksi){
        $sql = "SELECT *,format(harga, 0) as hargas FROM order_detail WHERE kode_transaksi = '$kode_transaksi'";
        return $this->db->query($sql);
    }
    
    function transaksi_header($kode_transaksi){
        $sql = "SELECT *,format(total_pembelian, 0) as total_pembelian,format(uang_bayar, 0) as uang_bayar,format(uang_kembalian, 0) as uang_kembalian FROM order_header WHERE kode_transaksi = '$kode_transaksi'";
        return $this->db->query($sql);
    }
    
    
    // --------------------------- TRANSAKSI -------------------------------- //
    
    function mulai($data){
        
        $outlet = $this->get_outlet();
        
        //cari kasir 
        $user_nik = $this->user_nik();
        $ksr = "SELECT nama FROM karyawan WHERE nik = $user_nik";
        $d = $this->db->query($ksr)->row_array();
        
        $sql2 = "INSERT INTO order_header (no_nota,
                                    nama_dummy,
                                    tgl_order,
                                    kasir,
                                    status,
                                    id_outlet,
                                    id_pelanggan,
                                    nama,
                                    nohp,
                                    email,
                                    created_by,
                                    created_at,
                                    img_qrcode) 
                            VALUES ('$data[no_nota]',
                                    '$data[nama_dummy]',
                                    NOW(),
                                    '$d[nama]',
                                    '1',
                                    '$outlet',
                                    '$data[id_pelanggan]',
                                    '$data[nama_pelanggan]',
                                    '$data[nohp_pelanggan]',
                                    '$data[email_pelanggan]',
                                    '$user_nik',
                                    NOW(),'$data[img_qrcode]')";
        
        return $this->db->query($sql2);
    }
    
    function detailtransaksi($no_nota){
        $sql = "SELECT a.*,
                    b.nama as nama_outlet,
                    format(a.uang_bayar, 0) as uangbayar,
                    format(a.uang_kembali, 0) as uangkembali
                FROM order_header as a 
                INNER JOIN outlet as b ON a.id_outlet = b.id and b.is_deleted = 0
                where a.is_deleted = 0 and a.no_nota = '$no_nota' ORDER by a.id_order DESC";
        //$sql = "SELECT * FROM order_header WHERE no_nota = '$no_nota'";
        return $this->db->query($sql);
    }
    
    function input_order_detail($data){
        
        $user_nik = $this->user_nik();
        
        //ambil data stok dari produksi ini by kode produksi
        $ss = "SELECT stok FROM produk_header where kode = '$data[kode_produk_header]'";
        $d = $this->db->query($ss)->row_array();
        $stok_sekarang = $d['stok'];
        //ini stok sekarang dikurang satu, ( jumlah qty yang discan)
        $stok_akhir = $stok_sekarang - 1;
        
        
        $sql = "INSERT INTO order_detail (no_nota,
                                    kode_produk_header,
                                    kode_produk,
                                    harga,
                                    qty,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[no_nota]',
                                    '$data[kode_produk_header]',
                                    '$data[kode_produk]',
                                    '$data[harga]',
                                    '$data[qty]',
                                    '$user_nik',
                                    NOW())";
        
        $sqlc = "UPDATE produk SET beli = 1 WHERE kode = '$data[kode_produk]' and is_deleted = 0";
        $this->db->query($sqlc);
        
        $sqlcs = "UPDATE produk_header SET stok = '$stok_akhir' WHERE kode = '$data[kode_produk_header]' and is_deleted = 0";
        $this->db->query($sqlcs);
        
        
        return $this->db->query($sql);
        
    }
    
    function input_order_detail_gudang($data){
        
        $user_nik = $this->user_nik();
        
        //ambil data stok dari produksi ini by kode produksi
        $ss = "SELECT stok FROM produk_header where kode = '$data[kode_produk_header]'";
        $d = $this->db->query($ss)->row_array();
        $stok_sekarang = $d['stok'];
        //ini stok sekarang dikurang satu, ( jumlah qty yang discan)
        $stok_akhir = $stok_sekarang - 1;
        
        $sql = "INSERT INTO order_detail (no_nota,
                                    kode_produk_header,
                                    kode_produk,
                                    harga,
                                    qty,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[no_nota]',
                                    '$data[kode_produk_header]',
                                    '$data[kode_produk]',
                                    '$data[harga]',
                                    '$data[qty]',
                                    '$user_nik',
                                    NOW())";
        
        $sqlc = "UPDATE produk SET beli = 1 WHERE kode = '$data[kode_produk]' and is_deleted = 0";
        $this->db->query($sqlc);
        
        $sqlcs = "UPDATE produk_header SET stok = '$stok_akhir' WHERE kode = '$data[kode_produk_header]'";
        $this->db->query($sqlcs);
        
        
        return $this->db->query($sql);
        
    }
    
    function cek_produk_order_detail($data){
        $sql = "SELECT * FROM order_detail where kode_produk = '$data[kode_produk]'";
        return $this->db->query($sql);
    }
    
    function data_order_detail($no_nota){
        //$sql = "SELECT *,format(harga, 0) as hargas FROM order_detail where no_nota = '$no_nota' and is_deleted = 0";
        $sql = "SELECT a.*,format(a.harga, 0) as hargas,b.nama as nama_produk ,c.nama as nama_produks
                    FROM order_detail as a
                    INNER JOIN produk as b ON a.kode_produk = b.kode and b.is_deleted = 0
                    INNER JOIN produk_header as c ON b.kode_produk_header = c.kode and c.is_deleted = 0
                    where a.no_nota = '$no_nota' and a.is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_order_detail_cetak($no_nota){
        //$sql = "SELECT *,format(harga, 0) as hargas FROM order_detail where no_nota = '$no_nota' and is_deleted = 0";
        $sql = "SELECT a.*,format(a.harga, 0) as hargas,b.nama as nama_produk ,c.nama as nama_produks,COUNT(a.qty) as count_qty,format(SUM(a.harga), 0) as count_harga
                    FROM order_detail as a
                    INNER JOIN produk as b ON a.kode_produk = b.kode and b.is_deleted = 0
                    INNER JOIN produk_header as c ON b.kode_produk_header = c.kode and c.is_deleted = 0
                    where a.no_nota = '$no_nota' and a.is_deleted = 0 GROUP BY b.kode_produk_header";
        return $this->db->query($sql);
    }
    
    function data_total_order_detail($no_nota){
        $sql = "SELECT concat('Rp.', format( sum(harga), 0)) as total,sum(harga) as total_asli FROM order_detail where no_nota = '$no_nota' and is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_order_header_cetak($no_nota){
        $sql = "SELECT a.*,
                        format(a.total, 0) as totalbayar,
                        format(a.uang_bayar, 0) as uangbayar, 
                        b.nama as jenis_pembayaran,
                        a.img_qrcode as qrcodes
                FROM order_header as a
                INNER JOIN jenis_pembayaran as b ON a.id_jenis_pembayaran = b.id and b.is_deleted = 0 
                where a.no_nota = '$no_nota' and a.is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_order_header_cetak2($no_nota){
        $sql = "SELECT img_qrcode FROM order_header where no_nota = '$no_nota' and is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function data_total_order_detail_cetak($no_nota){
        $sql = "SELECT concat('Rp.', format( sum(harga), 0)) as total,sum(harga) as total_asli FROM order_detail where no_nota = '$no_nota' and is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function simpan_trans($data){
        $user_nik = $this->user_nik();
        
        $uang_bayar = str_replace(",","",$data['uang_bayar']);
        
        $sql = "UPDATE order_header SET     id_jenis_pembayaran         = '$data[jenis_pembayaran]',
                                            id_jenis_wilayah_pengiriman = '$data[jenis_wilayah]',
                                            id_jenis_pengiriman         = '$data[jenis_pengiriman]',
                                            id_jenis_kurir              = '$data[jenis_kurir]',
                                            alamat                      = '$data[alamat_pengiriman]',
                                            uang_bayar                  = '$uang_bayar',
                                            uang_kembali                = '$data[uang_kembali]',
                                            total                       = '$data[total]',
                                            catatan                     = '$data[catatan]',
                                            id_pelanggan                = '$data[id_pelanggan]',
                                            nama                        = '$data[nama_pelanggan]',
                                            nohp                        = '$data[nohp_pelanggan]',
                                            email                       = '$data[email_pelanggan]',
                                            status                      = 2,
                                            updated_by                  = '$user_nik',
                                            updated_at                  = NOW() WHERE no_nota = '$data[no_nota]'";
        
        return $this->db->query($sql);
    }
    
    function update_trans($data){
        $user_nik = $this->user_nik();
        
        $uang_bayar = str_replace(",","",$data['uang_bayar']);
        
        $sql = "UPDATE order_header SET     id_jenis_pembayaran         = '$data[jenis_pembayaran]',
                                            id_jenis_wilayah_pengiriman = '$data[jenis_wilayah]',
                                            id_jenis_pengiriman         = '$data[jenis_pengiriman]',
                                            id_jenis_kurir              = '$data[jenis_kurir]',
                                            alamat                      = '$data[alamat_pengiriman]',
                                            uang_bayar                  = '$uang_bayar',
                                            uang_kembali                = '$data[uang_kembali]',
                                            catatan                     = '$data[catatan]',
                                            id_pelanggan                = '$data[id_pelanggan]',
                                            nama                        = '$data[nama_pelanggan]',
                                            nohp                        = '$data[nohp_pelanggan]',
                                            email                       = '$data[email_pelanggan]',
                                            nama_dummy                  = '$data[nama_pelanggan_dummy]',
                                            total                       = '$data[total]',
                                            updated_by                  = '$user_nik',
                                            updated_at                  = NOW() WHERE no_nota = '$data[no_nota]'";
        
        return $this->db->query($sql);
    }
    
    
    function update_warehouse_trans($data){
        $user_nik = $this->user_nik();
        
        $uang_bayar = str_replace(",","",$data['uang_bayar']);
        
        $sql = "UPDATE order_header SET     status_order         = '3',
                                            updated_by                  = '$user_nik',
                                            updated_at                  = NOW() WHERE no_nota = '$data[no_nota]'";
        
        return $this->db->query($sql);
    }
    
    function update_status_selesai($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE order_header SET     status         = '6',
                                            updated_by     = '$user_nik',
                                            updated_at     = NOW() WHERE no_nota = '$data[no_nota]'";
        
        return $this->db->query($sql);
    }
    
    function transaksi_data(){
        
        $outlet = $this->get_outlet();
        
        $sql = "SELECT a.*,
                    DATE_FORMAT(a.tgl_order, '%d-%b-%Y') tgl_order,
                    b.nama as nama_outlet,
                    c.nama as nama_jenis_pembayaran
                FROM order_header as a 
                LEFT JOIN outlet as b ON a.id_outlet = b.id and b.is_deleted = 0
                LEFT JOIN jenis_pembayaran as c ON a.id_jenis_pembayaran = c.id and c.is_deleted = 0
                where a.is_deleted = 0 and a.id_outlet = '$outlet' ORDER by a.id_order DESC";
        return $this->db->query($sql);
    }
    
    function simpan_order($data){
        
        $user_nik = $this->user_nik();
        
        for($i = 0;$i < count($data['rows']); $i++)
        {

            $kode_produk_header   = $data['kode_produk_header'][$i];
            $id_gambar   = $data['id_gambar'][$i];
            $ukuran_s    = $data['ukuran_s'][$i];
            $ukuran_m    = $data['ukuran_m'][$i];
            $ukuran_l    = $data['ukuran_l'][$i];
            
            $sql_acc = "INSERT INTO order_request (no_nota,
                                                    kode_produk_header,
                                                    id_gambar,
                                                    qty_s,
                                                    qty_m,
                                                    qty_l,
                                                    created_by,
                                                    created_at) 
                                            VALUES ('$data[nonota]',
                                                    '$kode_produk_header',
                                                    '$id_gambar',
                                                    '$ukuran_s',
                                                    '$ukuran_m',
                                                    '$ukuran_l',
                                                    '$user_nik',
                                                    NOW())";
            $this->db->query($sql_acc);
            
        }
        
        $sql = "UPDATE order_header SET     status         = '2',
                                            updated_by           = '$user_nik',
                                            updated_at           = NOW() WHERE no_nota = '$data[nonota]'";
        
        return $this->db->query($sql);
        
        
    }
    
    function data_order_request_barang($data){
        
        $sql = "SELECT  a.nama,
                        a.kode_produksi,
                        a.qty,
                        b.gambar
                FROM order_request as a
                INNER JOIN produksi as b ON a.kode_produksi = b.kode and b.is_deleted = 0
                WHERE a.is_deleted = 0 and a.no_nota = '$data[nonota]'";
        
        return $this->db->query($sql);
        
    }
    
    function update_status_penjualan($data){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE order_header SET     status         = '$data[status]',
                                            updated_by           = '$user_nik',
                                            updated_at           = NOW() WHERE no_nota = '$data[nonota]'";
        
        return $this->db->query($sql);
    }
}
?>