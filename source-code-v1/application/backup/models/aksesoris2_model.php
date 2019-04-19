<?php 
class Aksesoris2_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT * FROM produksi_detail WHERE (aksesoris_status = 1 OR aksesoris_status = 2) AND is_deleted = 0 ORDER by id ASC";
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
                                    VALUES ('$data[kas]',NOW(),'$data[biaya]','Biaya Jasa Aksesoris','$user_nik',NOW())";
        $this->db->query($sql4);
        
         //update kas
        
        $sql = "UPDATE produksi_detail SET aksesoris_tgl_mulai         = DATE_FORMAT(STR_TO_DATE('$data[tgl_mulai]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                aksesoris_tgl_ambil         = DATE_FORMAT(STR_TO_DATE('$data[tgl_diambil]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                aksesoris_id_vendor         = '$data[vendor]',
                                                aksesoris_id_kas            = '$data[kas]',
                                                aksesoris_biaya             = '$data[biaya]',
                                                aksesoris_status            = 2,
                                                updated_by               = '$user_nik',
                                                updated_at               = NOW() WHERE id = '$data[id_produksi_detail]'";

        return $this->db->query($sql);
    }
    
    function simpan_aksesoris_produksi($data){
        $user_nik = $this->user_nik();
        
        $sql2 = "SELECT jumlah FROM aksesoris WHERE is_deleted = 0 and id = $data[aksesoris] ORDER by id ASC";
        $kk = $this->db->query($sql2)->row_array();
        
        $hasil = $kk['jumlah'] - $data['jumlah_pakai'];
        $sql3 = "UPDATE aksesoris SET jumlah  = '$hasil',
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$data[aksesoris]'";

        $this->db->query($sql3);
        
        $sql = "INSERT INTO aksesoris_produksi (id_aksesoris,id_produksi_detail,qty,created_by,created_at) VALUES ('$data[aksesoris]','$data[id_produksi_detail]','$data[jumlah_pakai]',$user_id,NOW())";
        return $this->db->query($sql);
    }
    
    function data_aksesoris_produksi_by_id($id_produksi_detail){
        
        $sql = "SELECT a.*,b.*
                    FROM aksesoris_produksi AS a 
                    INNER JOIN aksesoris AS b ON a.id_aksesoris = b.id AND b.is_deleted = 0
                    WHERE a.is_deleted = 0 and a.id_produksi_detail = $id_produksi_detail ORDER by a.id ASC";
        
        return $this->db->query($sql);
    }
    
    function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_detail SET aksesoris_berat             = '$data[berat]',
                                                aksesoris_qty               = '$data[qty]',
                                                aksesoris_gambar            = '$nama_file',
                                                aksesoris_status            = 3,
                                                aksesoris_status_updated_by = '$user_nik',
                                                aksesoris_status_updated_at = NOW(),
                                                sewing_status            = 1,
                                                sewing_status_created_by = '$user_nik',
                                                sewing_status_created_at = NOW(),
                                                updated_by               = '$user_nik',
                                                updated_at               = NOW() WHERE id = '$data[id_produksi_detail]'";

        return $this->db->query($sql);
    }
    
    
}
?>