<?php 
class Cutting_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM produksi_detail WHERE (cutting_status = 1 OR cutting_status = 2) AND is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function cutting_simpan_bahan_baku($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_detail SET  cutting_id_bahan_baku    = '$data[id_bahan_baku]',
                                                 cutting_status           = 2,
                                                cutting_status_created_by = '$user_id',     
                                                cutting_status_created_at = NOW(),
                                                updated_by  = '$user_id',
                                                updated_at  = NOW() WHERE id = '$data[id_produksi_detail]'";
        
        return $this->db->query($sql);
    }
    
    function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $tgl_mulai;
        if($data['tgl_mulai'] == ''){
            $tgl_mulai = 'NULL,';
        }else{
            $tgl_mulai = "DATE_FORMAT(STR_TO_DATE('$data[tgl_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        $tgl_selesai;
        if($data['tgl_selesai'] == ''){
            $tgl_selesai = 'NULL,';
        }else{
            $tgl_selesai = "DATE_FORMAT(STR_TO_DATE('$data[tgl_selesai]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        $biaya_cutting = str_replace(",","",$data['biaya_cutting']);
        
        $sql = "UPDATE  produksi_cutting SET    tgl_mulai        = $tgl_mulai
                                                tgl_selesai      = $tgl_selesai
                                                bahan_terpakai   = '$data[bahan_terpakai]',
                                                hasil            = '$data[hasil]',
                                                sisa_bahan       = '$data[sisa_bahan]',
                                                berat            = '$data[berat]',
                                                id_vendor        = '$data[vendor]',
                                                jumlah           = '$data[qty]',
                                                gambar           = '$nama_file',
                                                biaya            = '$biaya_cutting',
                                                updated_by       = '$user_nik',
                                                updated_at       = NOW() WHERE kode_produksi = '$data[kode_produksi]'";

        
        $total_stok = $data['small_warna_1_jumlah']+$data['small_warna_2_jumlah']+$data['large_warna_1_jumlah']+$data['large_warna_2_jumlah'];
        
        $sql2 = "UPDATE  produksi SET   small_warna_1_inisial = '$data[small_warna_1_inisial]',
                                        small_warna_1_jumlah  = '$data[small_warna_1_jumlah]',
                                        small_warna_2_inisial = '$data[small_warna_2_inisial]',
                                        small_warna_2_jumlah  = '$data[small_warna_2_jumlah]',
                                        large_warna_1_inisial = '$data[large_warna_1_inisial]',
                                        large_warna_1_jumlah  = '$data[large_warna_1_jumlah]',
                                        large_warna_2_inisial = '$data[large_warna_2_inisial]',
                                        large_warna_2_jumlah  = '$data[large_warna_2_jumlah]',
                                        stok_status           = '1',
                                        updated_by            = '$user_nik',
                                        updated_at            = NOW() WHERE kode = '$data[kode_produksi]'";
        $this->db->query($sql2);
        
        return $this->db->query($sql);
    }
    
    function data_detail($kode_produksi){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai,
                DATE_FORMAT(tgl_selesai, '%d-%b-%Y') tgl_selesai,format(biaya, 0) as biaya_cutting FROM produksi_cutting WHERE kode_produksi = $kode_produksi AND is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function created_label($img_qrcode,$harga_jual,$kode_produksi,$kode_produksi_produk,$inisial){
        
        $user_nik = $this->user_nik();
        
        $sql1 = "SELECT stok_status FROM produksi WHERE kode = '$kode_produksi'";
        $r = $this->db->query($sql1)->row_array();
        
        if($r['stok_status'] == 1){
            
        }else{
            
            $sql = "INSERT INTO produk (kode_produksi,
                                    inisial,
                                    kode,
                                    harga,
                                    stok,
                                    img_qrcode,
                                    created_by,
                                    created_at) 
                            VALUES ('$kode_produksi',
                                    '$inisial',
                                    '$kode_produksi_produk',
                                    '$harga_jual',
                                    '1',
                                    '$img_qrcode',
                                    '$user_nik',
                                    NOW())";
            return $this->db->query($sql);
            
        }
        
        
    }
    
    function cek_harga_jual($kode_produksi){
        $sql = "SELECT harga_jual FROM produksi WHERE kode = $kode_produksi";
        return $this->db->query($sql);
    }
    
}
?>