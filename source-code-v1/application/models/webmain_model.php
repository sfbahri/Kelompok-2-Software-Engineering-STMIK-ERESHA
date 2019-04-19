<?php 
class Webmain_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function simpan($data,$nama_file){
       
        $sql = "INSERT INTO pelamar (kode,
                                    id_posisi,
                                    nama,
                                    tempat_lahir,
                                    tgl_lahir,
                                    nohp,
                                    email,
                                    no_ktp,
                                    alamat,
                                    file_cv,
                                    nama_ibu,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[id_posisi]',
                                    '$data[nama_lengkap]',
                                    '$data[tempat_lahir]',
                                    '$data[tgl_lahir]',
                                    '$data[nomor_hp]',
                                    '$data[email]',
                                    '$data[nomor_ktp]',
                                    '$data[alamat_lengkap]',
                                    '$nama_file',
                                    '$data[nama_ibu]',
                                    '$data[kode]',
                                    NOW())";

        $sql_pendidikan = "INSERT INTO pelamar_pendidikan (kode_pelamar,
                                    nama_sekolah,
                                    jenjang_pendidikan,
                                    jurusan,
                                    fakultas,
                                    tahun_masuk,
                                    tahun_keluar,
                                    nilai_ipk,
                                    akreditasi_kampus,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[nama_sekolah]',
                                    '$data[jenjang_pendidikan]',
                                    '$data[jurusan]',
                                    '$data[fakultas]',
                                    '$data[tahun_masuk]',
                                    '$data[tahun_keluar]',
                                    '$data[ipk]',
                                    '$data[akreditasi]',
                                    '$data[kode]',
                                    NOW())";

        $this->db->query($sql_pendidikan);


        $sql_pekerjaan_1 = "INSERT INTO pelamar_riwayat_pekerjaan (kode_pelamar,
                                    nama_perusahaan,
                                    alamat_kantor,
                                    tahun_masuk,
                                    tahun_keluar,
                                    gaji,
                                    posisi_terakhir,
                                    deskripsi_pekerjaan,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[nama_perusahaan_1]',
                                    '$data[alamat_perusahaan_1]',
                                    '$data[tahun_masuk_kerja_1]',
                                    '$data[tahun_keluar_kerja_1]',
                                    '$data[gaji_terakhir_kerja_1]',
                                    '$data[posisi_terakhir_1]',
                                    '$data[job_pekerjaan_1]',
                                    '$data[kode]',
                                    NOW())";

        $this->db->query($sql_pekerjaan_1);


        $sql_pekerjaan_2 = "INSERT INTO pelamar_riwayat_pekerjaan (kode_pelamar,
                                    nama_perusahaan,
                                    alamat_kantor,
                                    tahun_masuk,
                                    tahun_keluar,
                                    gaji,
                                    posisi_terakhir,
                                    deskripsi_pekerjaan,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[kode]',
                                    '$data[nama_perusahaan_2]',
                                    '$data[alamat_perusahaan_2]',
                                    '$data[tahun_masuk_kerja_2]',
                                    '$data[tahun_keluar_kerja_2]',
                                    '$data[gaji_terakhir_kerja_2]',
                                    '$data[posisi_terakhir_2]',
                                    '$data[job_pekerjaan_2]',
                                    '$data[kode]',
                                    NOW())";

        $this->db->query($sql_pekerjaan_2);

        return $this->db->query($sql);
    }

    function posisi(){

        $sql = "SELECT * FROM posisi";

        return $this->db->query($sql);

    }

    function posisi_detail($id_posisi){
        $sql = "SELECT * FROM posisi where id = '$id_posisi'";

        return $this->db->query($sql);
    }

}
?>