<?php 
class Sewing_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM produksi_detail WHERE (sewing_status = 1 OR sewing_status = 2) AND is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function data_detail($kode_produksi){
        $sql = "SELECT *,DATE_FORMAT(tgl_mulai, '%d-%b-%Y') tgl_mulai,
                DATE_FORMAT(tgl_ambil, '%d-%b-%Y') tgl_ambil,format(biaya, 0) as biaya_sewing FROM produksi_sewing WHERE kode_produksi = $kode_produksi AND is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->user_nik();
        
        //update kas
        $sql2 = "SELECT saldo_sisa FROM kas_data WHERE is_deleted = 0 and id = $data[kas]";
        $bb =  $this->db->query($sql2)->row_array();
        
        $hasil = $bb['saldo_sisa'] - $data['biaya'];
        $sql3 = "UPDATE kas_data SET saldo_sisa = '$hasil' WHERE id = '$data[kas]'";
        $this->db->query($sql3);
        
        $sql4 = "INSERT INTO kas_transaksi (id_kas_data,
                                            tgl_transaksi,
                                            jumlah,
                                            deskripsi,
                                            created_by,
                                            created_at)
                                    VALUES ('$data[kas]',NOW(),'$data[biaya]','Biaya Jasa Sewing','$user_nik',NOW())";
        $this->db->query($sql4);
        
        //update kas
        $sql = "UPDATE produksi_detail SET sewing_tgl_mulai         = DATE_FORMAT(STR_TO_DATE('$data[tgl_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                sewing_tgl_ambil         = DATE_FORMAT(STR_TO_DATE('$data[tgl_kirim]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                sewing_id_vendor         = '$data[vendor]',
                                                sewing_id_kas            = '$data[kas]',
                                                sewing_biaya             = '$data[biaya]',
                                                sewing_pic               = '$data[pic]',
                                                sewing_status            = 2,
                                                updated_by               = '$user_nik',
                                                updated_at               = NOW() WHERE id = '$data[id_produksi_detail]'";

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
        
        $tgl_diambil;
        if($data['tgl_diambil'] == ''){
            $tgl_diambil = 'NULL,';
        }else{
            $tgl_diambil = "DATE_FORMAT(STR_TO_DATE('$data[tgl_kirim]', '%d-%b-%Y'),'%Y-%m-%d'),";
        }
        
        $biaya_sewing = str_replace(",","",$data['biaya']);
        
        $sql = "UPDATE  produksi_sewing SET     tgl_mulai        = $tgl_mulai
                                                tgl_ambil        = $tgl_diambil
                                                id_vendor        = '$data[vendor]',
                                                biaya            = '$biaya_sewing',
                                                pic                 = '$data[pic]',
                                                jenis_barang     = '$data[jenis_barang]',
                                                berat            = '$data[berat]',
                                                jumlah           = '$data[qty_awal]',
                                                gambar           = '$nama_file',
                                                updated_by       = '$user_nik',
                                                updated_at       = NOW() WHERE kode_produksi = '$data[kode_produksi]'";

        return $this->db->query($sql);
    }
    
}
?>