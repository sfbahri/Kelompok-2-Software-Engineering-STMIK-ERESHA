<?php 
class Jamaah_model extends CI_Model{	
    
    //var $dps;
    
    function __construct() {
        parent::__construct();
        //$this->dps = $this->load->database('dps', TRUE);
    }
    
    function username(){
        return $this->session->userdata('sess_username');
    }
    
    function id_jamaah(){
        return $this->session->userdata('sess_id_jamaah');
    }
    
    function simpan($data){
        
        $user_nik = $this->username();
        //DATE_FORMAT(STR_TO_DATE('$data[tgl_lahir]', '%d-%b-%Y'),'%Y-%m-%d'),
        
        $sql ="INSERT INTO jamaah (id,
                                    nama,
                                    paspor_no,
                                    id_kloter,
                                    email,
                                    created_by,
                                    created_at) 
                                    VALUES ('$data[id_jamaah]',
                                            '$data[nama]',
                                            '$data[no_paspor]',
                                            '$data[id_kloter]',
                                            '$data[email]',
                                            '$user_nik',
                                            NOW())";     
        
        //insert ke user login
        $sql1 = "INSERT INTO accs (username,
                                    password,
                                    id_module_role,
                                    created_by,
                                    created_at) 
                            VALUES ('$data[id_jamaah]',
                                    '$data[password]',
                                    '3',
                                    '$user_nik',
                                    NOW())";
        
        $this->db->query($sql1);
        
        
        return $this->db->query($sql);
        
    }
    
    function data_by_kloter($id_kloter){
        
        $sql = "SELECT *,DATE_FORMAT(tanggal_lahir, '%d-%b-%Y') tgl_lahir FROM jamaah where id_kloter = '$id_kloter' and is_deleted = 0 ORDER BY nama ASC";
        return $this->db->query($sql);
        
    }
    
    function hapus($data){
        $sql = "DELETE FROM jamaah WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
        
        $sql2 = "DELETE FROM accs WHERE username = '$data[id_jamaah]'";
        $this->db->query($sql2);
        
        return $this->db->query($sql);
    }
    
    function detail($id_jamaah){
        
        
        
        /*$sql = "SELECT *,DATE_FORMAT(tanggal_lahir, '%d-%b-%Y') tgl_lahir,
                DATE_FORMAT(paspor_tgl_keluar, '%d-%b-%Y') paspor_tgl_keluar,
                DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') tgl_daftar,
                DATE_FORMAT(paspor_tgl_exp, '%d-%b-%Y'),
                DATE_FORMAT(terima_tgl_foto, '%d-%b-%Y %H:%i:%s') terima_tgl_foto,
                DATE_FORMAT(terima_tgl_buku_vaksin, '%d-%b-%Y %H:%i:%s') terima_tgl_buku_vaksin,
                DATE_FORMAT(terima_tgl_paspor, '%d-%b-%Y %H:%i:%s') terima_tgl_paspor,
                DATE_FORMAT(terima_tgl_buku_nikah, '%d-%b-%Y %H:%i:%s') terima_tgl_buku_nikah,
                DATE_FORMAT(terima_tgl_akte_kelahiran, '%d-%b-%Y %H:%i:%s') terima_tgl_akte_kelahiran,
                DATE_FORMAT(terima_tgl_tiket_pp, '%d-%b-%Y %H:%i:%s') terima_tgl_tiket_pp,
                DATE_FORMAT(terima_tgl_ktp, '%d-%b-%Y %H:%i:%s') terima_tgl_ktp,
                DATE_FORMAT(terima_tgl_kk, '%d-%b-%Y %H:%i:%s') terima_tgl_kk,
                DATE_FORMAT(terima_tgl_surat_pernyataan_sipatuh, '%d-%b-%Y %H:%i:%s') terima_tgl_surat_pernyataan_sipatuh
                paspor_tgl_exp FROM jamaah where id = '$id_jamaah' and is_deleted = 0";*/
                
        $sql = "SELECT *,DATE_FORMAT(tanggal_lahir, '%d-%b-%Y') tgl_lahir,
                DATE_FORMAT(paspor_tgl_keluar, '%d-%b-%Y') paspor_tgl_keluar,
                DATE_FORMAT(created_at, '%d-%b-%Y %H:%i:%s') tgl_daftar,
                DATE_FORMAT(paspor_tgl_exp, '%d-%b-%Y') paspor_tgl_exp,
                DATE_FORMAT(terima_tgl_foto, '%d-%b-%Y %H:%i:%s') terima_tgl_foto,
                DATE_FORMAT(terima_tgl_buku_vaksin, '%d-%b-%Y %H:%i:%s') terima_tgl_buku_vaksin,
                DATE_FORMAT(terima_tgl_paspor, '%d-%b-%Y %H:%i:%s') terima_tgl_paspor,
                DATE_FORMAT(terima_tgl_buku_nikah, '%d-%b-%Y %H:%i:%s') terima_tgl_buku_nikah,
                DATE_FORMAT(terima_tgl_akte_kelahiran, '%d-%b-%Y %H:%i:%s') terima_tgl_akte_kelahiran,
                DATE_FORMAT(terima_tgl_tiket_pp, '%d-%b-%Y %H:%i:%s') terima_tgl_tiket_pp,
                DATE_FORMAT(terima_tgl_ktp, '%d-%b-%Y %H:%i:%s') terima_tgl_ktp,
                DATE_FORMAT(terima_tgl_kk, '%d-%b-%Y %H:%i:%s') terima_tgl_kk,
                DATE_FORMAT(terima_tgl_surat_pernyataan_sipatuh, '%d-%b-%Y %H:%i:%s') terima_tgl_surat_pernyataan_sipatuh
                FROM jamaah
                where id = '$id_jamaah' and is_deleted = 0";            
                
        return $this->db->query($sql);
        
    }
    
    function update($data){
        
        $username = $this->username(); 
        
        $sql = "UPDATE jamaah SET nama              = '$data[nama]',
                                nama_paspor         = '$data[nama_paspor]',
                                tempat_lahir        = '$data[tempat_lahir]',
                                tanggal_lahir       = DATE_FORMAT(STR_TO_DATE('$data[tgl_lahir]', '%d-%b-%Y'),'%Y-%m-%d'),
                                alamat              = '$data[alamat]',
                                alamat_pengiriman_koper = '$data[alamat_koper]',
                                jenis_kelamin       = '$data[jenis_kelamin]',
                                status              = '$data[status]',
                                email               = '$data[email]',
                                no_telp             = '$data[no_hp]',
                                pekerjaan           = '$data[pekerjaan]',
                                pendidikan_terakhir = '$data[pendidikan]',
                                paspor_no           = '$data[no_paspor]',
                                paspor_tgl_keluar   = DATE_FORMAT(STR_TO_DATE('$data[tgl_keluar_paspor]', '%d-%b-%Y'),'%Y-%m-%d'),
                                paspor_tgl_exp      = DATE_FORMAT(STR_TO_DATE('$data[tgl_exp_paspor]', '%d-%b-%Y'),'%Y-%m-%d'),
                                paspor_kota_penerbit= '$data[kota_penerbit_paspor]',
                                nama_ibu            = '$data[nama_ibu]',
                                nama_ayah           = '$data[nama_ayah]',
                                nama_kakek          = '$data[nama_kakek]',
                                no_ktp              = '$data[no_ktp]',
                                no_kk               = '$data[no_kk]',
                                img_foto            = '$data[img_foto]',
                                berangkat_sama_siapa= '$data[berangkat_dengan_siapa]',
                                warga_negara        = '$data[warga_negara]',
                                agama               = '$data[agama]',
                                kota_asal           = '$data[kota_asal]',
                                koper               = '$data[ambil_koper]',
                                id_kamar            = '$data[kamar]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]'";
        
        return $this->db->query($sql);
        
//        upload_dok_surat_pernyataan_sipatuh     = '$data[dok_surat_pernyataan]',
//        upload_tgl_dok_surat_pernyataan_sipatuh = NOW(),
//        upload_usr_dok_surat_pernyataan_sipatuh = '$username',
//        upload_dok_paspor     = '$data[dok_paspor]',
//        upload_tgl_dok_paspor = NOW(),
//        upload_usr_dok_paspor = '$username',
//        upload_dok_ktp        = '$data[dok_ktp]',
//        upload_tgl_dok_ktp    = NOW(),
//        upload_usr_dok_ktp   = '$username',
//        upload_dok_kk        = '$data[dok_kk]',
//        upload_tgl_dok_kk    = NOW(),
//        upload_usr_dok_kk   = '$username',
        
        
    }
    
    function biodata_detail(){
        
        $id_jamaah = $this->id_jamaah(); 
        
        
        
        
        $sql = "SELECT *,DATE_FORMAT(tanggal_lahir, '%d-%b-%Y') tgl_lahir,
                        DATE_FORMAT(paspor_tgl_keluar, '%d-%b-%Y') paspor_tgl_keluar
                FROM jamaah where id = '$id_jamaah' and is_deleted = 0";
        return $this->db->query($sql);
        
//        
//                DATE_FORMAT(paspor_tgl_exp, '%d-%b-%Y') paspor_tgl_exp,
//                DATE_FORMAT(upload_tgl_dok_surat_pernyataan_sipatuh, '%d-%b-%Y %H:%i:%s') tgl_dok_surat_pernyataan_sipatuh,
//                DATE_FORMAT(upload_tgl_dok_paspor, '%d-%b-%Y %H:%i:%s') tgl_dok_paspor,
//                DATE_FORMAT(upload_tgl_dok_ktp, '%d-%b-%Y %H:%i:%s') tgl_dok_ktp,
//                DATE_FORMAT(upload_tgl_dok_kk, '%d-%b-%Y %H:%i:%s') tgl_dok_kk
        
        
    }
    
    function reset_aksi($data){
        
        $username = $this->username(); 
        
        $sql = "UPDATE jamaah SET email             = '$data[email]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]' and id_kloter = '$data[id_kloter]' and paspor_no = '$data[no_paspor]'";
        
        //insert ke user login
        $sql1 = "UPDATE accs SET password = '$data[password]',updated_by = '$username', updated_at = NOW() WHERE username = '$data[kode_jamaah]'";
        $this->db->query($sql1);
        
        return $this->db->query($sql);
    }
    
    function verif_dok_upload($id_jamaah,$id_kloter,$kategori){
        
        if($kategori == 'sipatuh'){
            $sql = "UPDATE jamaah SET upload_verif_sipatuh = 1  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'paspor'){
            $sql = "UPDATE jamaah SET upload_verif_paspor = 1  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'ktp'){
            $sql = "UPDATE jamaah SET upload_verif_ktp = 1  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'kk'){
            $sql = "UPDATE jamaah SET upload_verif_kk = 1  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else{
            
        }
        
        
    }
    
    
    function un_verif_dok_upload($id_jamaah,$id_kloter,$kategori){
        
        if($kategori == 'sipatuh'){
            $sql = "UPDATE jamaah SET upload_verif_sipatuh = 0 WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'paspor'){
            $sql = "UPDATE jamaah SET upload_verif_paspor = 0 WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'ktp'){
            $sql = "UPDATE jamaah SET upload_verif_ktp = 0 WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'kk'){
            $sql = "UPDATE jamaah SET upload_verif_kk = 0 WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else{
            
        }
        
        
    }
    
    
     function verif_dok_kirim_upload($id_jamaah,$id_kloter,$kategori){
        
        $user_name = $this->username();
        $admin_nama = $this->session->userdata('sess_nama_admin');
        
        if($kategori == 'foto'){
            $sql = "UPDATE jamaah SET kirim_foto = 1,terima_tgl_foto = NOW(),terima_usr_foto = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'vaksin'){
            $sql = "UPDATE jamaah SET kirim_buku_vaksin = 1,terima_tgl_buku_vaksin = NOW(),terima_usr_buku_vaksin = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'paspor'){
            $sql = "UPDATE jamaah SET kirim_paspor = 1,terima_tgl_paspor = NOW(),terima_usr_paspor = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'buku_nikah'){
            $sql = "UPDATE jamaah SET kirim_buku_nikah = 1,terima_tgl_buku_nikah = NOW(),terima_usr_buku_nikah = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'akte_kelahiran'){
            $sql = "UPDATE jamaah SET kirim_akte_kelahiran = 1,terima_tgl_akte_kelahiran = NOW(),terima_usr_akte_kelahiran = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'tiket_pp'){
            $sql = "UPDATE jamaah SET kirim_tiket_pp = 1,terima_tgl_tiket_pp = NOW(),terima_usr_tiket_pp = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'ktp'){
            $sql = "UPDATE jamaah SET kirim_ktp = 1,terima_tgl_ktp = NOW(),terima_usr_ktp = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'kk'){
            $sql = "UPDATE jamaah SET kirim_kk = 1,terima_tgl_kk = NOW(),terima_usr_kk = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'sipatuh'){
            $sql = "UPDATE jamaah SET kirim_surat_pernyataan_sipatuh = 1,terima_tgl_surat_pernyataan_sipatuh = NOW(),terima_usr_surat_pernyataan_sipatuh = '$admin_nama'  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else{
            
        }
        
        
    }


    function verif_dok_kirim_upload_cancel($id_jamaah,$id_kloter,$kategori){
        
        $user_name = $this->username();
        $admin_nama = $this->session->userdata('sess_nama_admin');
        
        if($kategori == 'foto'){
            $sql = "UPDATE jamaah SET kirim_foto = 0,terima_tgl_foto = NULL,terima_usr_foto = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'vaksin'){
            $sql = "UPDATE jamaah SET kirim_buku_vaksin = 0,terima_tgl_buku_vaksin = NULL,terima_usr_buku_vaksin = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'paspor'){
            $sql = "UPDATE jamaah SET kirim_paspor = 0,terima_tgl_paspor = NULL,terima_usr_paspor = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'buku_nikah'){
            $sql = "UPDATE jamaah SET kirim_buku_nikah = 0,terima_tgl_buku_nikah = NULL,terima_usr_buku_nikah = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'akte_kelahiran'){
            $sql = "UPDATE jamaah SET kirim_akte_kelahiran = 0,terima_tgl_akte_kelahiran = NULL,terima_usr_akte_kelahiran = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'tiket_pp'){
            $sql = "UPDATE jamaah SET kirim_tiket_pp = 0,terima_tgl_tiket_pp = NULL,terima_usr_tiket_pp = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'ktp'){
            $sql = "UPDATE jamaah SET kirim_ktp = 0,terima_tgl_ktp = NULL,terima_usr_ktp = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'kk'){
            $sql = "UPDATE jamaah SET kirim_kk = 0,terima_tgl_kk = NULL,terima_usr_kk = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else if($kategori == 'sipatuh'){
            $sql = "UPDATE jamaah SET kirim_surat_pernyataan_sipatuh = 0,terima_tgl_surat_pernyataan_sipatuh = NULL,terima_usr_surat_pernyataan_sipatuh = NULL  WHERE id = '$id_jamaah' and id_kloter = '$id_kloter'";
            return $this->db->query($sql);
        }else{
            
        }


    }
    
    function dok_terima($data){
        $sql = "UPDATE jamaah SET dokumen_terima = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
        return $this->db->query($sql);
    }
    
    function dok_lengkap($data){
        $sql = "UPDATE jamaah SET dokumen_lengkap = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
        return $this->db->query($sql);
    }
    
    
    function pembayaran($data){
        
        if($data['kategori'] == 'PERNAK'){
            $sql = "UPDATE jamaah SET bayar_pernakpernik = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'ADM'){
            $sql = "UPDATE jamaah SET bayar_adm = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'LA'){
            $sql = "UPDATE jamaah SET bayar_la = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'VISA'){
            $sql = "UPDATE jamaah SET bayar_visa = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'BATIK'){
            $sql = "UPDATE jamaah SET bayar_batik = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'MANASIK'){
            $sql = "UPDATE jamaah SET bayar_manasik = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'MAHROM'){
            $sql = "UPDATE jamaah SET bayar_mahrom = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else if($data['kategori'] == 'LUNAS'){
            $sql = "UPDATE jamaah SET bayar_lunas = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
            return $this->db->query($sql);
        }else{
            
        }
        
        
        
    }
    
    
    function update_file_upload($data){
        
        $username = $this->username(); 
        
        if($data['kategori'] == 'ktp'){
            $sql = "UPDATE jamaah SET upload_dok_ktp        = '$data[dok_ktp]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]'";
        
        return $this->db->query($sql);
        }else if($data['kategori'] == 'sipatuh'){
            
            $sql = "UPDATE jamaah SET upload_dok_surat_pernyataan_sipatuh        = '$data[dok_sipatuh]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]'";
        
            return $this->db->query($sql);
        }else if($data['kategori'] == 'paspor'){
            
            $sql = "UPDATE jamaah SET upload_dok_paspor        = '$data[dok_paspor]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]'";
        
            return $this->db->query($sql);
        }else if($data['kategori'] == 'kk'){
            
            $sql = "UPDATE jamaah SET upload_dok_kk        = '$data[dok_kk]',
                                updated_by          = '$username',
                                updated_at          = NOW() WHERE id = '$data[kode_jamaah]'";
        
            return $this->db->query($sql);
        }
        
        
        
        
//        upload_dok_surat_pernyataan_sipatuh     = '$data[dok_surat_pernyataan]',
//        upload_tgl_dok_surat_pernyataan_sipatuh = NOW(),
//        upload_usr_dok_surat_pernyataan_sipatuh = '$username',
//        upload_dok_paspor     = '$data[dok_paspor]',
//        upload_tgl_dok_paspor = NOW(),
//        upload_usr_dok_paspor = '$username',
//        upload_dok_ktp        = '$data[dok_ktp]',
//        upload_tgl_dok_ktp    = NOW(),
//        upload_usr_dok_ktp   = '$username',
//        upload_dok_kk        = '$data[dok_kk]',
//        upload_tgl_dok_kk    = NOW(),
//        upload_usr_dok_kk   = '$username',
        
        
    }
    
    function koper_status($data){
        
        $sql = "UPDATE jamaah SET koper = $data[id_value]  WHERE id = '$data[id_jamaah]' and id_kloter = '$data[id_kloter]'";
        
        return $this->db->query($sql);
        
    }
    
}
?>