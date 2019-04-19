<?php 
class Laporan_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function penjualan_data($data){
        
        $tanggal = $data['tanggal'];
        $outlet  = $data['outlet'];
        
        $sql = "SELECT a.*,
                    DATE_FORMAT(a.tgl_order, '%d-%b-%Y') tgl_order,
                    b.nama as nama_outlet,
                    c.nama as nama_jenis_pembayaran,
                    format(a.total, 0) as total,
                    d.nama as nama_karyawan
                FROM order_header as a 
                LEFT JOIN outlet as b ON a.id_outlet = b.id and b.is_deleted = 0
                LEFT JOIN jenis_pembayaran as c ON a.id_jenis_pembayaran = c.id and c.is_deleted = 0
                LEFT JOIN karyawan as d ON a.created_by = d.nik and d.is_deleted = 0
                where a.is_deleted = 0 and DATE_FORMAT(a.tgl_order, '%d-%b-%Y') = '$tanggal' and a.id_outlet = '$outlet' ORDER by a.id_order DESC";
        //and a.status = 6
        return $this->db->query($sql);
        
        
    }
    
    
    function penjualan_data_total($data){
        
        $tanggal = $data['tanggal'];
        $outlet  = $data['outlet'];
        
        $sql = "SELECT format(SUM(a.total), 0) as total
                FROM order_header as a 
                LEFT JOIN outlet as b ON a.id_outlet = b.id and b.is_deleted = 0
                LEFT JOIN jenis_pembayaran as c ON a.id_jenis_pembayaran = c.id and c.is_deleted = 0
                where a.is_deleted = 0 and DATE_FORMAT(a.tgl_order, '%d-%b-%Y') = '$tanggal' and a.id_outlet = '$outlet'";
        //and a.status = 6
        return $this->db->query($sql);
        
        
    }
    
    
    
}
?>