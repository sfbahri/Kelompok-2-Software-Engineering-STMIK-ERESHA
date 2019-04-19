<?php 
class Karyawan_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function karyawan_data(){
        //$sql = "SELECT *,DATE_FORMAT(tanggal_lahir, '%d-%b-%Y') tgl_lahir FROM karyawan WHERE is_deleted = 0 ";
        
        $sql = "SELECT 	a.nik,
                        a.nama as nama_karyawan,
                        b.nama as nama_divisi,
                        d.nama as nama_outlet,
                        c.nama as nama_jabatan
                FROM karyawan AS a
                INNER JOIN karyawan_divisi as b ON a.id_divisi = b.id and b.is_deleted = 0
                INNER JOIN karyawan_jabatan as c ON a.id_jabatan = c.id and c.is_deleted = 0
                INNER JOIN outlet as d ON a.id_outlet = d.id and d.is_deleted = 0
                WHERE a.is_deleted = 0";
        
//        $sql = "SELECT 
//                  k.*,
//                  k.id_jabatan AS kij,
//                  k.id_divisi_sub AS kisb,
//                  j.id AS jid,
//                  j.nama AS nm_j,
//                  sd.id AS sdid,
//                  sd.nama AS nm_sd,
//                  sd.id_divisi AS sdid,
//                  d.id AS did,d.nama AS nm_d,
//                  DATE_FORMAT(k.tanggal_lahir, '%d-%b-%Y') tgl_lahir,
//                  e.nama as nama_outlet,
//                  j.nama as nama_jabatan,
//                  d.nama as nama_divisi
//                FROM karyawan AS k
//                LEFT JOIN karyawan_jabatan AS j      ON k.id_jabatan = j.id and j.is_deleted = 0
//                LEFT JOIN karyawan_divisi_sub AS sd  ON sd.id = k.id_divisi_sub and sd.is_deleted = 0
//                LEFT JOIN karyawan_divisi AS d       ON d.id = sd.id_divisi and d.is_deleted = 0
//                LEFT JOIN outlet AS e ON k.id_outlet = e.id and e.is_deleted = 0
//                WHERE k.is_deleted = 0 ";
        return $this->db->query($sql);
    }
    
    function karyawan_get_nik(){
        $sql = "SELECT MAX(nik) as nik FROM karyawan WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function karyawan_simpan($data){
        //
        $user_nik = $this->user_nik();
        
        $sql = "INSERT INTO karyawan (nik,nama,
                               inisial,
                               tempat_lahir,
                               tanggal_lahir,
                               alamat,
                               email,
                               agama,
                               id_divisi,
                               id_jabatan,
                               id_outlet,
                               no_hp,
                               no_ktp,
                               tgl_in,
                               created_by,
                               created_at) 
                            VALUES ('$data[nik]',
                                    '$data[nama]',
                                    '$data[inisial]',
                                    '$data[tempat_lahir]',
                                    DATE_FORMAT(STR_TO_DATE('$data[tgl_lahir]', '%d-%b-%Y'),'%Y-%m-%d'),
                                    '$data[alamat]',
                                    '$data[email]',
                                    '$data[agama]',
                                    '$data[id_divisi]',
                                    '$data[id_jabatan]',
                                    '$data[id_outlet]',
                                    '$data[no_hp]',
                                    '$data[no_ktp]',
                                    DATE_FORMAT(STR_TO_DATE('$data[tgl_masuk]', '%d-%b-%Y'),'%Y-%m-%d'),
                                    $user_nik,NOW())";
        
        //insert ke user login
        $sql1 = "INSERT INTO users (nik,
                                    password,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[nik]',
                                    '$data[password]',
                                    $user_nik,
                                    NOW())";
        
        $this->db->query($sql1);
        
        return $this->db->query($sql);
        
    }
    
    function karyawan_update($data){
        $user_nik = $this->user_nik();
        
        $sql = "UPDATE karyawan SET nik         = '$data[nik]',
                               nama             = '$data[nama]',
                               inisial          = '$data[inisial]',
                               tempat_lahir     = '$data[tempat_lahir]',
                               tanggal_lahir    = DATE_FORMAT(STR_TO_DATE('$data[tgl_lahir]', '%d-%b-%Y'),'%Y-%m-%d'),
                               alamat           = '$data[alamat]',
                               email            = '$data[email]',
                               agama            = '$data[agama]',
                               no_hp            = '$data[no_hp]',
                               no_ktp           = '$data[no_ktp]',
                               id_divisi    = '$data[id_divisi]',
                               id_jabatan       = '$data[id_jabatan]',
                               id_outlet       = '$data[id_outlet]',
                               tgl_in           = DATE_FORMAT(STR_TO_DATE('$data[tgl_masuk]', '%d-%b-%Y'),'%Y-%m-%d'),
                               updated_by       = '$user_nik',
                               updated_at       = NOW() WHERE nik = '$data[nik]' ";
                    
        return $this->db->query($sql);
        
    }
            
    function karyawan_detail($nik){
        
        $sql = "SELECT 	a.nik,
                        a.nama as nama_karyawan,
                        b.nama as nama_divisi,
                        b.id as id_divisi,
                        d.nama as nama_outlet,
                        c.nama as nama_jabatan,
                        a.*,
                        DATE_FORMAT(a.tanggal_lahir, '%d-%b-%Y') tgl_lahir, 
                        DATE_FORMAT(a.tgl_in, '%d-%b-%Y') tglin
                FROM karyawan AS a
                INNER JOIN karyawan_divisi as b ON a.id_divisi = b.id and b.is_deleted = 0
                INNER JOIN karyawan_jabatan as c ON a.id_jabatan = c.id and c.is_deleted = 0
                INNER JOIN outlet as d ON a.id_outlet = d.id and d.is_deleted = 0
                WHERE a.is_deleted = 0 and a.nik = '$nik'";
        
//        $sql = "SELECT 
//                  k.*,
//                  k.id_jabatan AS kij,
//                  k.id_divisi_sub AS kisb,
//                  j.id AS jid,
//                  j.nama AS nm_j,
//                  sd.id AS sdid,
//                  sd.nama AS nm_sd,sd.id_divisi AS sdid,
//                  d.id AS did,d.nama AS nm_d,
//                  DATE_FORMAT(k.tanggal_lahir, '%d-%b-%Y') tgl_lahir, 
//                  DATE_FORMAT(k.tgl_in, '%d-%b-%Y') tglin
//                FROM karyawan AS k
//                LEFT JOIN karyawan_jabatan AS j      ON j.id = k.id_jabatan
//                LEFT JOIN karyawan_divisi_sub AS sd  ON sd.id = k.id_divisi_sub
//                LEFT JOIN karyawan_divisi AS d       ON d.id = sd.id_divisi
//                WHERE k.is_deleted = 0 and nik = '$nik'";
        
        return $this->db->query($sql);
    }
    
}
?>