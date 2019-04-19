<?php 
class Finance_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function data(){
        $sql = "SELECT a.*,b.*,concat('Rp ', format( a.harga_jual, 0)) as harga_jual,concat('Rp ', format( a.harga_modal, 0)) as harga_modal
                    FROM goft_produk AS a
                    INNER JOIN goft_produksi_detail AS b ON a.`kode_produk` = b.`kode_produksi_detail` 
                    WHERE a.status = 1 ORDER by a.id ASC";
        return $this->db->query($sql);
    }
    
    function update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE {PRE}produksi_detail SET finishing_jenis_barang      = '$data[jenis_barang]',
                                                finishing_tgl_serah_terima  = DATE_FORMAT(STR_TO_DATE('$data[tgl_kembali]', '%d-%b-%Y'),'%Y-%m-%d'),
                                                finishing_qty               = '$data[qty]',
                                                finishing_catatan           = '$data[catatan]',
                                                finishing_gambar            = '$nama_file',
                                                finishing_status            = 2,
                                                finishing_status_updated_by = '$user_nik',
                                                finishing_status_updated_at = NOW(),
                                                updated_by               = '$user_nik',
                                                updated_at               = NOW() WHERE id = '$data[id_produksi_detail]'";

        return $this->db->query($sql);
    }
    
    function simpan($data){
        
        $user_nik = $this->user_nik();
        
            $sql = "UPDATE  produk SET harga_modal      = '$data[harga_modal]',
                                                harga_jual  = '$data[harga_jual]',
                                                status      = '2',
                                                updated_by  = '$user_nik',
                                                updated_at  = NOW() WHERE kode_produk = '$data[kode_produk]'";

        return $this->db->query($sql);
    }
    
    
}
?>