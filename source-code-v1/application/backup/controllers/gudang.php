<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('gudang_model');
    }

    public function cek_barang_masuk(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('gudang/gudang_cek_barang_masuk_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function kelola_stok(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('gudang/gudang_kelola_stok_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function order_transaksi(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('gudang/gudang_order_transaksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function input_transaksi(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens']  = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('gudang/gudang_input_transaksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function cek_barang_masuk_detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('gudang/gudang_cek_barang_masuk_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->gudang_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function cek_produksi(){

        $data['kodeproduksi'] = $this->input->post('kodeproduksi',TRUE);
        $result = $this->gudang_model->cek_produksi($data);
        echo json_encode($result);
         
    }
    
    public function update_kelola_stok(){

        $data['kode_produk'] = $this->input->post('kode_produk',TRUE);
        $data['id_outlet'] = $this->input->post('id_outlet',TRUE);
        $result = $this->gudang_model->update_kelola_stok($data);
        echo json_encode($result);
         
    }
    

    public function cek_produk(){
        $data['kode_produk']   = $this->input->post('kode_produk',TRUE);
        $result = $this->gudang_model->cek_produk($data);
        echo json_encode($result);
    }
    

    public function cutting_simpan_bahan_baku(){
        $data['id_produksi_detail'] = $this->input->post('id_produksi_detail',TRUE);
        $data['id_bahan_baku']      = $this->input->post('id_bahan_baku',TRUE);
        $result = $this->cutting_model->cutting_simpan_bahan_baku($data);
        echo json_encode($result);
    }
    
    public function detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('gudang/gudang_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function simpan(){
        
           
        $data['tgl_mulai']       = $this->input->post('tgl_mulai',TRUE);
        $data['tgl_diambil']     = $this->input->post('tgl_diambil',TRUE);
        $data['vendor']          = $this->input->post('vendor',TRUE);
        $data['kas']             = $this->input->post('kas',TRUE);
        $data['biaya']           = $this->input->post('biaya',TRUE);
        $data['pic']           = $this->input->post('pic',TRUE);
        $data['id_produksi_detail']       = $this->input->post('id_produksi_detail',TRUE);
        $result = $this->sewing_model->simpan($data);
        echo json_encode($result);    
        
    }


    public function update(){
       
        $data['catatan']                = $this->input->post('catatan',TRUE);
        $data['jumlah_barang']                = $this->input->post('jumlah_barang',TRUE);
        $data['id_produksi_detail']     = $this->input->post('id_produksi_detail',TRUE);
        
        $result = $this->gudang_model->update($data);
        echo json_encode($result);
    }
    
    
    //Cetak resi Pengiriman//
    public function cetak_resi(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('gudang/cetak_resi_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function cetak_resi_pdf($kode){
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $resi = $this->gudang_model->data_resi($kode)->row_array();
        
        $resi_detail = $this->gudang_model->data_resi_detail($kode)->result_array();
        
        $itemlist;
        foreach($resi_detail as $items){
            $itemlist .= $items['nama_produk'].''.'('.$items['count_qty'].')'.', ';
        }
        
        
            //$result = $this->order_model->data_laporan($data)->result_array();
        $mpdf = new mPDF('utf-8', array(95,140), 8, '', '', '', '', '', '', '');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        //ini jika COD , id_jenis_pembayaran = 7
        echo"
        <style>
            table{
                border:1px solid black;
                width:100%;
                margin:10px;
                font-size:10px;
                border-collapse:collapse;
                font-family: 'Arial, Helvetica, sans-serif';
            }
            table tr td, table tr th{
                border:1px solid black;
                
            }
            .logo{
                margin-top:10px;
                margin:5px;
                width:150px;
            }
            .qr{
                width:550px;
                height:550px;
            }
            .kode{
                font-size:100px;
                font:bold;
                text-align:center;
            }
 
            #container {
                width:100%;
                text-align:center;
            }

            #left {
                float:left;
                width:150px;
            }

            #center {
                display: inline-block;
                margin-top:10px;
                width:200px;
                font-size:18px;
            }

            #right {
                float:right;
                width:auto;
            }
            .tbl{
            border: 1px solid red;
            border-collapse:collapse;
            }
            .fontss{
            font-family: 'Arial, Helvetica, sans-serif';
                }
            </style>";
        
        
        if($resi['id_jenis_pembayaran'] == 7){
            
            echo "<!DOCTYPE html>
            <html>
            <head></head>
            <body>  
                <br>
                <div id='container'>
                    <div id='left'><img class='logo' src='".base_url()."/assets/img/logo_babyneeds.png'/></div>
                    <div id='center'><div style='margin-top:0px'><b>BABYNEEDS.CO.ID</b></div></div>
                    <div id='right'>Ruko Allogio Barat No.9, Medang, Pagedangan, Tangerang, Banten 15334 , No Telp . (021) 22224730 , www.babyneeds.co.id</div>
                </div>
                <hr>
                <div class='fontss' style='font-size:13px;margin:10px;font-family: 'Arial, Helvetica, sans-serif';font-weight:bold'><b>NO. NOTA : ".$resi[no_nota]."<b> <br> <div style='font-size:10px'>ADM-KSR : <b>".strtoupper($resi[kasir])."</b> / TGL-ORD : ".$resi[tgl_kirim]." / <br> CTK : ".date("Y-m-d h:i")." / Kontak Admin : 0813-1657-7229</div></div>
                <hr>
                <div style='align:center;'>";
                echo "  <div class='fontss' style='font-size:11px;margin:9px;font-family: 'Tahoma, Geneva, sans-serif';font-weight:bold'><b>INFORMASI PEMESAN :</b></div>
                        <table class='tbl'>
                        <tr><td>Nama</td><td>&nbsp;: $resi[nama]</td></tr>
                        <tr><td>Alamat</td><td>&nbsp;: $resi[alamat]</td></tr>
                        <tr><td>No. HP</td><td>&nbsp;: $resi[nohp]</td></tr>
                        <tr><td>Kurir</td><td>&nbsp;: $resi[nmjk]</td></tr>
                        <tr><td>Pembayaran</td><td>&nbsp;: COD </td></tr>
                        <tr><td>Total</td><td>&nbsp;: Rp. $resi[hargas] </td></tr>
                        <tr><td>Kode</td><td>&nbsp;: <b>$resi[kjp] - $resi[no_nota]</b></td></tr>
                       <tr><td>Item</td><td>&nbsp;: $itemlist</b></td></tr>     
                        <tr><td colspan='2' align='left'><img class='qr' src='". base_url()."uploads/qrcode/$resi[img_qrcode]' style='width:80px;height:80px'/></td></tr>
                        </table>";   
            echo "
            </div>
            </body>
            </html>";
            
        }else{
            
            
            echo "<!DOCTYPE html>
            <html>
            <head></head>
            <body>  
                <br>
                <div id='container'>
                    <div id='left'><img class='logo' src='".base_url()."/assets/img/logo_babyneeds.png'/></div>
                    <div id='center'><div style='margin-top:0px'><b>BABYNEEDS.CO.ID</b></div></div>
                    <div id='right'>Ruko Allogio Barat No.9, Medang, Pagedangan, Tangerang, Banten 15334 , No Telp . (021) 22224730 , www.babyneeds.co.id</div>
                </div>
                <hr>
                <div class='fontss' style='font-size:15px;margin:10px;font-family: 'Tahoma, Geneva, sans-serif';font-weight:bold'><b>NO. NOTA : ".$resi[no_nota]."<b> <br> <div style='font-size:10px'>ADM-KSR : <b>".strtoupper($resi[kasir])."</b> / TGL-ORD : ".$resi[tgl_kirim]." / <br> CTK : ".date("Y-m-d h:i")." / Kontak Admin : 0811-9458-583 / 0811-9458-582</div></div>
                <hr>
                <div style='align:center;'>";
                 
                echo "  <div class='fontss' style='font-size:11px;margin:10px;font-family: 'Tahoma, Geneva, sans-serif';font-weight:bold'><b>INFORMASI PEMESAN :</b></div>
                        <table class='tbl'>
                        <tr><td>Nama</td><td>&nbsp;: $resi[nama]</td></tr>
                        <tr><td>Alamat</td><td>&nbsp;: $resi[alamat]</td></tr>
                        <tr><td>No. HP</td><td>&nbsp;: $resi[nohp]</td></tr>
                        <tr><td>Kurir</td><td>&nbsp;: $resi[nmjk]</td></tr>
                        <tr><td>Kode</td><td>&nbsp;: <b>$resi[kjp] - $resi[no_nota]</b></td></tr>
                        <tr><td colspan='2' align='center'><img class='qr' src='". base_url()."uploads/qrcode/$resi[img_qrcode]' style='width:120px;height:120px'/></td></tr>
                        </table>";   
            echo "
            </div>
            </body>
            </html>";
            
        }
        
        
       
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
}
