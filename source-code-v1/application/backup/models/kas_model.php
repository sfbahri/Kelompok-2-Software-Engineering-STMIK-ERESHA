<?php 
class Kas_model extends CI_Model{	
    
    function __construct() {
        parent::__construct();
    }
    
    function user_nik(){
        return $this->session->userdata('sess_nik');
    }
    
    function kas_sablon(){
        $sql = "SELECT *,concat('Rp ', format(saldo_sisa, 0)) as jum_sisa_saldo FROM {PRE}kas_data WHERE is_deleted = 0 and id_kas_kategori = 3";
        return $this->db->query($sql);
    }
    
    function kas_aksesoris(){
        $sql = "SELECT *,concat('Rp ', format(saldo_sisa, 0)) as jum_sisa_saldo FROM {PRE}kas_data WHERE is_deleted = 0 and id_kas_kategori = 4";
        return $this->db->query($sql);
    }
    
    function kas_sewing(){
        $sql = "SELECT *,concat('Rp ', format(saldo_sisa, 0)) as jum_sisa_saldo FROM {PRE}kas_data WHERE is_deleted = 0 and id_kas_kategori = 5";
        return $this->db->query($sql);
    }
    
    function kas_data_kategori(){
        $sql = "SELECT *,DATE_FORMAT(tgl_transfer_saldo, '%d-%b-%Y') tgl_transfer_saldo,concat('Rp. ', format(saldo_awal, 0)) as saldoawal,CONCAT('Rp. ', FORMAT(saldo_akhir, 0)) AS saldoakhir FROM kas_kategori WHERE is_deleted = 0";
        return $this->db->query($sql);
    }
    
    function kas_kategori_simpan($data){
        
        $user_nik = $this->user_nik();
        $saldo = str_replace(",","",$data['saldo_awal']);
        
        $sql = "INSERT INTO kas_kategori (id,nama,tgl_transfer_saldo,saldo_awal,saldo_akhir,catatan,created_by,created_at) VALUES ('$data[id]','$data[nama]',DATE_FORMAT(STR_TO_DATE('$data[tgl_transfer]', '%d-%b-%Y'),'%Y-%m-%d'),'$saldo','$saldo','$data[catatan]',$user_nik,NOW())";
        return $this->db->query($sql);
    
    }
    
    function get_data_kas_transaksi($tgl_start,$tgl_end){
        
        $sql = "SELECT * FROM kas_transaksi WHERE tgl_transaksi BETWEEN DATE_FORMAT(STR_TO_DATE('$tgl_start', '%d-%b-%Y'),'%Y-%m-%d') AND DATE_FORMAT(STR_TO_DATE('$tgl_end', '%d-%b-%Y'),'%Y-%m-%d')";
    
        return $this->db->query($sql);
    }
    
    function kas_kategori_tambah_saldo($data){
        $user_nik = $this->user_nik();

        $isi_saldo  = str_replace(",","",$data['isi_saldo']);
        $sisa_saldo = $data['sisa_saldo'];
        
        $saldo_awal = $isi_saldo+$sisa_saldo;
        
        $sql = "UPDATE kas_kategori SET saldo_awal          = '$saldo_awal',
                                        saldo_akhir         = '$saldo_awal',
                                        tgl_transfer_saldo  = DATE_FORMAT(STR_TO_DATE('$data[tgl_transfer]', '%d-%b-%Y'),'%Y-%m-%d'),
                                        catatan             = '$data[catatan]',
                                        updated_by          = '$user_nik',
                                        updated_at          = NOW() WHERE id = '$data[id]'";

        //insert ke hostory isi saldo
        $sql2 = "INSERT INTO kas_kategori_isi_saldo_history (id_kas_kategori,saldo_awal,saldo_akhir,saldo_isi,saldo_terupdate,tgl_transfer,created_by,created_at) VALUES ('$data[id]','$data[saldo_awal]','$sisa_saldo','$isi_saldo','$saldo_awal',DATE_FORMAT(STR_TO_DATE('$data[tgl_transfer]', '%d-%b-%Y'),'%Y-%m-%d'),'$user_nik',NOW())";
        $this->db->query($sql2);
        
        
        return $this->db->query($sql);
        
        
    }
    
    function max_id(){
        $sql = "SELECT MAX(id) as max_id FROM kas_kategori";
        return $this->db->query($sql);
    }
    
    function kas_kategori_detail($id_kas_kategori){
        $sql = "SELECT *,concat('Rp ', format(saldo_akhir, 0)) as saldo_akhir_temp FROM kas_kategori WHERE id = $id_kas_kategori";
        return $this->db->query($sql);
    }
    
    
    //START KAS KANTOR
    
    function kas_kantor_simpan($data){
        
        $user_nik = $this->user_nik();
        $nominal = str_replace(",","",$data['nominal']);
        
        //select dulu
        $sqlq = "SELECT * FROM kas_kategori where id = 2";
        $d = $this->db->query($sqlq)->row_array();
        $hasil_hitung = $d['saldo_akhir']-$nominal;
        
        //update di kas kecil 
        $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                        updated_by          = '$user_nik',
                                        updated_at          = NOW() WHERE id = '2'";
        $this->db->query($sqlxx);
        
        
        $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('2','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
        return $this->db->query($sql);
    }
    
    function get_data_kas_kantor($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 2 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 2 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
    }
    
    //END KAS KANTOR
    
    
    
    
    
    
    
    
        //START KAS DINAS
        
        function kas_dinas_simpan($data){
        
            $user_nik = $this->user_nik();
            $nominal = str_replace(",","",$data['nominal']);

            //select dulu
            $sqlq = "SELECT * FROM kas_kategori where id = 4";
            $d = $this->db->query($sqlq)->row_array();
            $hasil_hitung = $d['saldo_akhir']-$nominal;

            //update di kas kecil 
            $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                            updated_by          = '$user_nik',
                                            updated_at          = NOW() WHERE id = '4'";
            $this->db->query($sqlxx);


            $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('4','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
            return $this->db->query($sql);
        }
        
        
        function get_data_kas_dinas($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 4 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 4 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
        }
        
        
        
        
        //START KAS it
        
        function kas_it_simpan($data){
        
            $user_nik = $this->user_nik();
            $nominal = str_replace(",","",$data['nominal']);

            //select dulu
            $sqlq = "SELECT * FROM kas_kategori where id = 7";
            $d = $this->db->query($sqlq)->row_array();
            $hasil_hitung = $d['saldo_akhir']-$nominal;

            //update di kas kecil 
            $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                            updated_by          = '$user_nik',
                                            updated_at          = NOW() WHERE id = '7'";
            $this->db->query($sqlxx);


            $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('7','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
            return $this->db->query($sql);
        }
        
        
        function get_data_kas_it($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 7 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 7 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
        }
        
        
        
        
        // KAS PICKUP
        //START KAS BESAR
        
        function kas_pengiriman_simpan($data){
        
            $user_nik = $this->user_nik();
            $nominal = str_replace(",","",$data['nominal']);

            //select dulu
            $sqlq = "SELECT * FROM kas_kategori where id = 6";
            $d = $this->db->query($sqlq)->row_array();
            $hasil_hitung = $d['saldo_akhir']-$nominal;

            //update di kas kecil 
            $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                            updated_by          = '$user_nik',
                                            updated_at          = NOW() WHERE id = '6'";
            $this->db->query($sqlxx);


            $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('6','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
            return $this->db->query($sql);
        }
        
        
        function get_data_kas_pengiriman($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 6 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 6 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
        }
        
        
        
        
        //START KAS PROMOSI
        
        function kas_promosi_simpan($data){
        
            $user_nik = $this->user_nik();
            $nominal = str_replace(",","",$data['nominal']);

            //select dulu
            $sqlq = "SELECT * FROM kas_kategori where id = 5";
            $d = $this->db->query($sqlq)->row_array();
            $hasil_hitung = $d['saldo_akhir']-$nominal;

            //update di kas kecil 
            $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                            updated_by          = '$user_nik',
                                            updated_at          = NOW() WHERE id = '5'";
            $this->db->query($sqlxx);


            $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('5','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
            return $this->db->query($sql);
        }
        
        
        function get_data_kas_promosi($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 5 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 5 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
        }
        
        
        
        //START KAS PROMOSI
        
        function kas_marketing_simpan($data){
        
            $user_nik = $this->user_nik();
            $nominal = str_replace(",","",$data['nominal']);

            //select dulu
            $sqlq = "SELECT * FROM kas_kategori where id = 8";
            $d = $this->db->query($sqlq)->row_array();
            $hasil_hitung = $d['saldo_akhir']-$nominal;

            //update di kas kecil 
            $sqlxx = "UPDATE kas_kategori SET saldo_akhir         = '$hasil_hitung',
                                            updated_by          = '$user_nik',
                                            updated_at          = NOW() WHERE id = '8'";
            $this->db->query($sqlxx);


            $sql = "INSERT INTO kas_transaksi (id_kas_kategori,jumlah,tgl_transaksi,catatan,created_by,created_at) VALUES ('8','$nominal',DATE_FORMAT(STR_TO_DATE('$data[tanggal]', '%d-%b-%Y'),'%Y-%m-%d'),'$data[catatan]','$user_nik',NOW())";
            return $this->db->query($sql);
        }
        
        
        function get_data_kas_marketing($data){
        
        $user_nik = $this->user_nik();
        
        if($user_nik == '00000001'){
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 8 AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }else{
            
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = 8 and a.created_by = '$user_nik' AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
            
        }
        
        }
        
        
        
        
        function get_data_kas_hari_ini($data){
            //update di kas kecil 
            $sqlxx = "SELECT  a.*,
                                b.`nama`,
                                b.`nik`,
                                concat('Rp ', format(jumlah, 0)) as saldo,
                                DATE_FORMAT(tgl_transaksi, '%d-%b-%Y') as tgl_transaksi
                        FROM kas_transaksi AS a
                        INNER JOIN karyawan AS b ON a.`created_by` = b.`nik` AND b.`is_deleted` =0
                        WHERE a.id_kas_kategori = '$data[id_kas_kategori]' AND DATE(a.`created_at`) = DATE(NOW()) AND a.is_deleted = 0";

            return $this->db->query($sqlxx);
        }
        
        
        
       
}
?>