<?php 
class Markom_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function design_gambar_simpan_so($data){
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO produksi_gambar_header (noso,
                                    nama,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[noso]',
                                    '$data[tema]',
                                    '$user_nik',
                                    NOW())";
                                    
        return $this->db->query($sql);
    }
    
    function cek_no_so($data){
        $sql = "SELECT * FROM produksi_gambar_header WHERE noso = '$data[noso]'";
        return $this->db->query($sql);
    }
    
    function design_gambar_produksi_detail($data){
        $sql = "SELECT * FROM produksi_gambar_header WHERE noso = '$data[noso]'";
        return $this->db->query($sql);
    }
    
    function design_gambar_update_so($data){
        
        $sql = "UPDATE produksi_gambar_header SET noso = '$data[noso]', nama = '$data[tema]' WHERE id = '$data[id]'";
        return $this->db->query($sql);
    }
    
    function design_gambar_data_so(){
        $sql = "SELECT  a.nama,
                        a.noso,
                (SELECT tgl_terima_produksi
                FROM bahan_baku_detail
                WHERE noso = a.noso and is_deleted = 0
                GROUP BY noso) as tanggal_terima_produksi
                FROM produksi_gambar_header as a
                WHERE a.is_deleted = 0 ORDER by id asc";
        //$sql = "SELECT * FROM produksi_gambar_header WHERE is_deleted = 0 ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function design_gambar_data_so_detail($data){
        $sql = "SELECT * FROM produksi_gambar_header WHERE is_deleted = 0 and noso = '$data[noso]' ORDER by id ASC";
        return $this->db->query($sql);
    }
    
    function proses_upload_media2($data){
        $user_nik = $this->user_nik();
        $sql = "INSERT INTO produksi_gambar (id,gambar,
                                        path,
                                        noso,
                                        created_by,
                                        created_at)
                                VALUES ('$data[img_kode]',
                                        '$data[gambar]',
                                        '$data[path]',
                                        '$data[noso]',
                                        '$user_nik',
                                        NOW())";
        
        return $this->db->query($sql);
        
    }
    
    function gambar_hapus($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_gambar SET is_deleted = 1 , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    function gambar_approve($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_gambar SET approve = 1 , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    function gambar_approve_kp($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_gambar SET approve = 2 , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    function gambar_approve_stf($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_gambar SET approve = 3 , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    function data_gambar_produksi_admin($data){
        
        $sql = "SELECT *,CASE
                WHEN approve = 0 THEN 'Pengajuan Gambar Produksi'
                WHEN approve = 1 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 2 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 3 THEN 'Gambar Siap Produksi'
                WHEN approve = 4 THEN 'Gambar Sudah Digunakan Produksi'
                ELSE 'Tidak Ada Status'
                END as status_gambar_produksi 
FROM produksi_gambar where is_deleted = 0 and noso = '$data[noso]' ORDER BY id_seq DESC"; //AND approve = 0
        return $this->db->query($sql);
        
    }
    
    function data_gambar_produksi_owner($data){
        
        $sql = "SELECT *,CASE
                WHEN approve = 0 THEN 'Pengajuan Gambar Produksi'
                WHEN approve = 1 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 2 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 3 THEN 'Gambar Siap Produksi'
                WHEN approve = 4 THEN 'Gambar Sudah Digunakan Produksi'
                ELSE 'Tidak Ada Status'
                END as status_gambar_produksi FROM produksi_gambar where is_deleted = 0 and noso = '$data[noso]' ORDER BY id_seq DESC"; //AND approve = 0
        return $this->db->query($sql);
        
    }
    
    function data_gambar_produksi_kp($data){
        
        $sql = "SELECT *,CASE
                WHEN approve = 0 THEN 'Pengajuan Gambar Produksi'
                WHEN approve = 1 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 2 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 3 THEN 'Gambar Siap Produksi'
                WHEN approve = 4 THEN 'Gambar Sudah Digunakan Produksi'
                ELSE 'Tidak Ada Status'
                END as status_gambar_produksi FROM produksi_gambar where is_deleted = 0 and noso = '$data[noso]' AND approve = 1 ORDER BY id_seq DESC";
        return $this->db->query($sql);

    }
    
    function data_gambar_produksi_stf($data){
        
        $sql = "SELECT *,CASE
                WHEN approve = 0 THEN 'Pengajuan Gambar Produksi'
                WHEN approve = 1 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 2 THEN 'Sedang Direview Bag.Produksi'
                WHEN approve = 3 THEN 'Gambar Siap Produksi'
                WHEN approve = 4 THEN 'Gambar Sudah Digunakan Produksi'
                ELSE 'Tidak Ada Status'
                END as status_gambar_produksi FROM produksi_gambar where is_deleted = 0 and noso = '$data[noso]' AND approve = 2 ORDER BY id_seq DESC";
        return $this->db->query($sql);

    }
    
    function gambar_nama($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE produksi_gambar SET nama = '$data[nama_gambar]' , updated_by = '$user_nik', updated_at = NOW() WHERE id = '$data[id]'";
        
        return $this->db->query($sql);
    }
    
    
    function gambar_catatan($data){
        $user_nik = $this->user_nik();
        $sql = "INSERT INTO produksi_gambar_catatan (kode_gambar,
                                        catatan,
                                        created_by,
                                        created_at)
                                VALUES ('$data[id]',
                                        '$data[img_catatan]',
                                        '$user_nik',
                                        NOW())";
        
        return $this->db->query($sql);
    }
    
    function gambar_details($data){
        $sql = "SELECT * FROM produksi_gambar where is_deleted = 0 and id = '$data[kodegambar]' ";
        return $this->db->query($sql);
    }
    
    function gambar_catatan_list($data){
        $sql = "SELECT 	a.catatan,
                        b.nama as nama_karyawan
                FROM produksi_gambar_catatan as a
                INNER JOIN karyawan as b ON a.created_by = b.nik and b.is_deleted = 0
                WHERE a.is_deleted = 0 and a.kode_gambar = '$data[idgambar]'";
        //$sql = "SELECT * FROM produksi_gambar_catatan where is_deleted = 0 and id = '$data[idgambar]' ";
        return $this->db->query($sql);
    }
    
    function gambar_design_update($data,$nama_file){
        
        $user_nik = $this->user_nik();
        //status dibalikan ke kepala roduksi untuk direview
        $sql = "UPDATE produksi_gambar SET gambar  = '$nama_file',
                                        path = 'uploads/produksi/".$nama_file."',
                                        approve = 1,
                                        updated_by = '$user_nik',
                                        updated_at = NOW() WHERE id = '$data[idgambar]'";
        
        return $this->db->query($sql);
    }
    
    function select_noso_gambar(){
        $sql = "SELECT  noso
                        FROM bahan_baku_detail
                        WHERE is_deleted = 0
                    GROUP BY noso";
        return $this->db->query($sql);
    }
}
?>