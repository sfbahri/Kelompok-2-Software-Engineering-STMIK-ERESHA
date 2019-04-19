<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('penjualan_model');
        $this->load->model('outlet_model');
    }
    

    public function kasir(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('penjualan/penjualan_kasir_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function kasir_transaksi($kode_transaksi){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens']         = $tokens;
        $data['kode_transaksi'] = $kode_transaksi;
        if($result == '1'){
            $this->load->view('penjualan/penjualan_kasir_transaksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function invoice($no_faktur){
        
        $data['trans_header'] = $this->penjualan_model->transaksi_header($no_faktur)->row_array();
        $data['trans_detail'] = $this->penjualan_model->transaksi_detail($no_faktur)->result_array();
        $data['nofaktur']     = $no_faktur;
        $this->load->view('penjualan/invoice_view',$data);
    }
    
    public function simpan_transaksi_baru(){
        
           
        $data['kode_transaksi']     = $this->input->post('kode_transaksi',TRUE);
        $data['nama']               = $this->input->post('nama',TRUE);
        $data['no_hp']              = $this->input->post('no_hp',TRUE);
        $data['customer']           = $this->input->post('customer',TRUE);
        $data['list_member']        = $this->input->post('list_member',TRUE);
        $result = $this->penjualan_model->simpan_transaksi_baru($data);
        echo json_encode($result);    
        
    }
    
    public function simpan(){
        
        $data['kode_transaksi']     = $this->input->post('kode_transaksi',TRUE);
        $data['kodeproduk']         = $this->input->post('kodeproduk',TRUE);
        $result = $this->penjualan_model->simpan($data);
        echo json_encode($result);
    }
    
    public function data(){
       
        $data['kode_transaksi']     = $this->input->post('kode_transaksi',TRUE);
        $result = $this->penjualan_model->data($data)->result_array();
        echo json_encode($result);    
        
    }
    
    public function data_detail(){
       
        $data['kode_transaksi']     = $this->input->post('kode_transaksi',TRUE);
        $result = $this->penjualan_model->data_detail($data)->row_array();
        echo json_encode($result);    
        
    }
    
    
    //------------------------- TRANSAKSI ------------------------------------//
    
    public function mulai(){
       
        $data['no_nota']            = $this->input->post('no_nota',TRUE);
        $data['nama_dummy']         = $this->input->post('nama_dummy',TRUE);
        $data['id_pelanggan']       = $this->input->post('id_pelanggan',TRUE);
        $data['nama_pelanggan']     = $this->input->post('nama_pelanggan',TRUE);
        $data['nohp_pelanggan']     = $this->input->post('nohp_pelanggan',TRUE);
        $data['email_pelanggan']    = $this->input->post('email_pelanggan',TRUE);
        $data['alamat_pelanggan']   = $this->input->post('alamat_pelanggan',TRUE);
        
        /*Start Qr Code*/
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './uploads/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name = $this->input->post('no_nota',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('no_nota',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data['img_qrcode'] = $image_name;
        /*End Qr Code*/
        
        $result = $this->penjualan_model->mulai($data);
        echo json_encode($result);    
        
    }
    
    function detailtransaksi(){
        $no_nota = $this->input->post('no_nota',TRUE);
        $result = $this->penjualan_model->detailtransaksi($no_nota)->row_array();
        echo json_encode($result);
    }
    
    function input_order_detail(){
        
        $data['kode_produk_header']  = $this->input->post('kode_produk_header',TRUE);
        $data['kode_produk']    = $this->input->post('kode_produk',TRUE);
        $data['harga']          = $this->input->post('harga',TRUE);
        $data['qty']            = $this->input->post('qty',TRUE);
        $data['no_nota']        = $this->input->post('no_nota',TRUE);
        
        $result = $this->penjualan_model->input_order_detail($data);
        echo json_encode($result);
    }
    
    function cek_produk_order_detail(){
        $data['kode_produk']    = $this->input->post('kode_produk',TRUE);
        $result = $this->penjualan_model->cek_produk_order_detail($data)->num_rows();
        echo json_encode($result);
    }
    
    function data_order_detail(){
        $no_nota    = $this->input->post('nonota',TRUE);
        $result = $this->penjualan_model->data_order_detail($no_nota)->result_array();
        echo json_encode($result);
    }
    
    function data_total_order_detail(){
        $no_nota    = $this->input->post('no_nota',TRUE);
        $result = $this->penjualan_model->data_total_order_detail($no_nota)->row_array();
        echo json_encode($result);
    }
    
    public function simpan_trans(){
        
        $data['no_nota']          = $this->input->post('no_nota',TRUE);
        $data['jenis_pembayaran'] = $this->input->post('jenis_pembayaran',TRUE);
        $data['jenis_wilayah']    = $this->input->post('jenis_wilayah',TRUE);
        $data['jenis_pengiriman'] = $this->input->post('jenis_pengiriman',TRUE);
        $data['jenis_kurir']      = $this->input->post('jenis_kurir',TRUE);
        $data['alamat_pengiriman']= $this->input->post('alamat_pengiriman',TRUE);
        $data['uang_bayar']       = $this->input->post('uang_bayar',TRUE);
        $data['uang_kembali']     = $this->input->post('uang_kembali',TRUE);
        $data['uang_ongkir']     = $this->input->post('uang_ongkir',TRUE);
        $data['catatan']          = $this->input->post('catatan',TRUE);
        $data['id_pelanggan']     = $this->input->post('id_pelanggan',TRUE);
        $data['nama_pelanggan']   = $this->input->post('nama_pelanggan',TRUE);
        $data['nohp_pelanggan']   = $this->input->post('nohp_pelanggan',TRUE);
        $data['email_pelanggan']  = $this->input->post('email_pelanggan',TRUE);
        $data['total']  = $this->input->post('total',TRUE);
        
        $result = $this->penjualan_model->simpan_trans($data);
        echo json_encode($result);
    }
    
    public function cetak_struk($no_nota){
            $this->load->library('mpdf/mpdf');
            
            $res = $this->penjualan_model->data_order_detail($no_nota)->result_array();
            $rest = $this->penjualan_model->data_total_order_detail_cetak($no_nota)->row_array();
            $d = $this->penjualan_model->data_order_header_cetak($no_nota)->row_array();
            
            
            $session_id_outlet = $this->session->userdata('sess_outlet');
            $o = $this->outlet_model->get_alamat($session_id_outlet)->row_array();
            
            $c = $this->penjualan_model->data_order_header_cetak2($no_nota)->row_array();
            $imgqrcode = $c['img_qrcode'];
            
            $i = 0;
            $base_url = base_url();
            $html = '<table width="100" border="0" style="margin-right:20px;margin-left:20px">
                    <tr>
                      <td height="53" colspan="3" align="center"><strong>STRUK BELANJA BABYNEED.CO.ID</strong> <br> <img src="'.base_url('/uploads/qrcode/'.$imgqrcode.'').'" width="80px" height="80px"></td>
                    </tr>
                    <tr>
                    <td colspan="3" align="left">No Nota : <b>'.$no_nota.'</b> / ADM : '.$d['kasir'].' / CTK : '.date("Y-m-d h:i").'</td>
                  </tr>
                  <tr>
                      <td colspan="3">-------------------------------------------------------------------</td>
                    </tr>';
                        foreach($res as $r){
                            $html .='<tr>
                                <td  align="left">'.$r['kode_produk'].' - '.$r['nama_produks'].'</td>
                                <td  align="center">'.$r['count_qty'].'</td>
                                <td  align="right">'.$r['count_harga'].'</td>
                            </tr>';
                        }
                    $html .='<tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right">TOTAL</td>
                      <td align="center">:</td>
                      <td align="right">'.$rest['total'].'</td>
                    </tr>
                    <tr>
                      <td colspan="3">-------------------------------------------------------------------</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center">Terima Kasih. Selamat Belanja Kembali</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center">'.$o['alamat'].'</td>
                    </tr>
                    <tr>
                      <td colspan="3" align="center">www.babyneeds.co.id</td>
                    </tr>
                    </table>';


            //$html = $this->load->view('produksi/produksi_print_label_view',$data);
            //$mpdf = new mPDF('utf-8', array(95,122.27),'0');         
            $mpdf = new mPDF('utf-8', array(58,3275), 8, '', '', '', '', '', '', '');
            
            
            
            $mpdf->WriteHTML($html);
            $mpdf->Output();

    }
    
    
    
    public function cetak_struk_dotmetrik($no_nota){
            $this->load->library('mpdf/mpdf');
            
            $res = $this->penjualan_model->data_order_detail_cetak($no_nota)->result_array();
            $rest = $this->penjualan_model->data_total_order_detail_cetak($no_nota)->row_array();
            
            $d = $this->penjualan_model->data_order_header_cetak($no_nota)->row_array();
            $c = $this->penjualan_model->data_order_header_cetak2($no_nota)->row_array();
            $imgqrcode = $c['img_qrcode'];
            
            
            $session_id_outlet = $this->session->userdata('sess_outlet');
            $o = $this->outlet_model->get_alamat($session_id_outlet)->row_array();
            
            $rek_bca;
            $rek_mandiri;
            //1 Allogio, 2 Tanah Abang
            if($session_id_outlet == 1){
              $rek_bca = 'Bank BCA : 3366772999 </b> a/n Desy Tanzil / Willy Septian Alexander'; 
              $rek_mandiri = 'Bank Mandiri : 1210 04 09 1988 </b> a/n Willy Septian Alexander';
            }else{
              $rek_bca = '<b>Bank BCA : 336 999 7 999</b> a/n PT. Shailendra Tshai Indonesia'; 
              $rek_mandiri = '<b>Bank Mandiri : 121 00 9997999</b> a/n PT. Shailendra Tshai Indonesia';
            }
            
            
            $i = 0;
            $base_url = base_url();
            $html = '<table width="100%" border="0" style="margin-right:20px;margin-left:20px;">
                    <tr>
                      <td height="53" colspan="5"><strong>STRUK PEMBELIAN - BABYNEEDS.CO.ID</strong> <br> '.$o['alamat'].' <br> <img src="'.base_url('/uploads/qrcode/'.$imgqrcode.'').'" width="50px" height="50px"></td>
                    </tr>
                    <tr>
                      <td height="53" colspan="5" align="left"><strong>INFORMASI PEMBELI</strong> <br> '.$d['nama'].' / '.$d['nama_dummy'].' / '.$d['nohp'].' / '.$d['alamat'].'</td>
                    </tr>
                    <tr>
                    <td colspan="5" align="left">No Nota : <b>'.$no_nota.' / ADM : '.$d['kasir'].' / CTK : '.date("Y-m-d h:i").'</b></td>
                  </tr>
                    
                  <tr>
                      <td colspan="5"><hr></td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>Nama Barang</td>
                            <td>Jumlah / Qty</td>
                            <td>Harga</td>
                            <td width="100px" align="right">TOTAL</td>
                        </tr>
                        ';
                        $no = 0;
                        foreach($res as $r){
                            $nos = $no+1;
                            $html .='<tr>
                                <td  align="left">'.$nos.'</td>
                                <td  align="left">'.$r['nama_produks'].' - <span style="font-size:9px">'.$r['kode_produk_header'].'</span></td>
                                <td  align="left">'.$r['count_qty'].' Pcs</td>
                                <td  align="center">'.$r['hargas'].'</td>
                                <td  align="right">'.$r['count_harga'].'</td>
                            </tr>';
                            $no++;
                        }
                    $html .='<tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><b>Ongkos Kirim</b></td>
                      <td align="center"><b>:</b></td>
                      <td align="right"><b>'.$d['uang_ongkir'].'</b></td>
                    </tr>
                   <tr>
                      <td colspan="5"><hr></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><b>TOTAL</b></td>
                      <td align="center"><b>:</b></td>
                      <td align="right"><b>'.$d['jumlah_tot'].'</b></td>
                    </tr>
                    <tr>
                      <td colspan="5"></td>
                    </tr>
                    <tr>
                      <td colspan="5">* Catatan : '.$d['catatan'].' / Metode Pembayaran : '.$d['jenis_pembayaran'].'</td>
                    </tr>
                    <tr>
                      <td colspan="5"><hr> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left"><b>'.$rek_bca.'</b> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left"><b>'.$rek_mandiri.'</b> </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center">-----====----- </td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center">Terima Kasih. Selamat Belanja Kembali</td>
                    </tr>
                    <tr>
                      <td colspan="5" align="center">www.babyneeds.co.id</td>
                    </tr>
                    </table>';

            //$html = $this->load->view('produksi/produksi_print_label_view',$data);
            //$mpdf = new mPDF('utf-8', array(95,122.27),'0');         
            $mpdf = new mPDF('utf-8', array(160,240), 8, '', '', '', '', '', '', '');
            
            
            
            $mpdf->WriteHTML($html);
            $mpdf->Output();

    }
    
    
    //------------------------- RIWAYAT TRANSAKSI ------------------------------------//
    
    public function transaksi(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('penjualan/penjualan_transaksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function transaksi_edit(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens']  = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('penjualan/penjualan_transaksi_edit_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    function transaksi_data(){
        $result = $this->penjualan_model->transaksi_data()->result_array();
        echo json_encode($result);
    }
    
    
    public function order_produk(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_rows = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_rows;
            if($result == '1'){
                $this->load->view('penjualan/penjualan_order_produk_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function simpan_order(){
        
        $data['kode_produk_header']     = $this->input->post('kode_produk_header',TRUE);
        $data['id_gambar']            = $this->input->post('id_gambar',TRUE);
        $data['rows']                   = $this->input->post('rows',TRUE);
        $data['ukuran_s']           = $this->input->post('ukuran_s',TRUE);
        $data['ukuran_m']           = $this->input->post('ukuran_m',TRUE);
        $data['ukuran_l']           = $this->input->post('ukuran_l',TRUE);
        $data['nonota']    = $this->input->post('nonota',TRUE);
        
        $result = $this->penjualan_model->simpan_order($data);
        echo json_encode($result);
        
    }
    
    
    public function data_order_request_barang(){
        $data['nonota']    = $this->input->post('nonota',TRUE);
        
        $result = $this->penjualan_model->data_order_request_barang($data)->result_array();
        echo json_encode($result);
    }
    
    public function update_status_penjualan(){
        $data['nonota']    = $this->input->post('nonota',TRUE);
        $data['status']    = $this->input->post('status',TRUE);
        $result = $this->penjualan_model->update_status_penjualan($data);
        echo json_encode($result);
    }
    
    
    function input_order_detail_gudang(){
        
        $data['kode_produk_header']  = $this->input->post('kode_produk_header',TRUE);
        $data['kode_produk']    = $this->input->post('kode_produk',TRUE);
        $data['harga']          = $this->input->post('harga',TRUE);
        $data['qty']            = $this->input->post('qty',TRUE);
        $data['no_nota']        = $this->input->post('no_nota',TRUE);
        
        $result = $this->penjualan_model->input_order_detail_gudang($data);
        echo json_encode($result);
    }
    
    
    public function update_trans(){
        
        $data['no_nota']          = $this->input->post('no_nota',TRUE);
        $data['jenis_pembayaran'] = $this->input->post('jenis_pembayaran',TRUE);
        $data['jenis_wilayah']    = $this->input->post('jenis_wilayah',TRUE);
        $data['jenis_pengiriman'] = $this->input->post('jenis_pengiriman',TRUE);
        $data['jenis_kurir']      = $this->input->post('jenis_kurir',TRUE);
        $data['alamat_pengiriman']= $this->input->post('alamat_pengiriman',TRUE);
        $data['uang_bayar']       = $this->input->post('uang_bayar',TRUE);
        $data['uang_kembali']     = $this->input->post('uang_kembali',TRUE);
        $data['uang_ongkir']     = $this->input->post('uang_ongkir',TRUE);
        $data['catatan']          = $this->input->post('catatan',TRUE);
        $data['id_pelanggan']     = $this->input->post('id_pelanggan',TRUE);
        $data['nama_pelanggan']   = $this->input->post('nama_pelanggan',TRUE);
        $data['nohp_pelanggan']   = $this->input->post('nohp_pelanggan',TRUE);
        $data['email_pelanggan']  = $this->input->post('email_pelanggan',TRUE);
        $data['alamat_pelanggan']   = $this->input->post('alamat_pelanggan',TRUE);
        $data['nama_pelanggan_dummy']   = $this->input->post('nama_pelanggan_dummy',TRUE);
        $data['total']            = $this->input->post('total',TRUE);
        $data['no_order_sales']   = $this->input->post('no_order_sales',TRUE);
        
        $result = $this->penjualan_model->update_trans($data);
        echo json_encode($result);
    }
    
    function update_status_selesai(){
        $data['no_nota']          = $this->input->post('no_nota',TRUE);
        $result = $this->penjualan_model->update_status_selesai($data);
        echo json_encode($result);
    }
    
    
    function update_order_sales(){
        $data['no_nota']          = $this->input->post('no_nota',TRUE);
        $data['no_order_sales']          = $this->input->post('no_order_sales',TRUE);
        $result = $this->penjualan_model->update_order_sales($data);
        echo json_encode($result);
    }
    
    
    /* RETUR */
    public function transaksi_retur(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens']  = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('penjualan/penjualan_transaksi_retur_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    function retur_order_detail(){
        
        $data['kode_produk_header']  = $this->input->post('kode_produk_header',TRUE);
        $data['kode_produk']         = $this->input->post('kode_produk',TRUE);
        $data['harga']               = $this->input->post('harga',TRUE);
        $data['qty']                 = $this->input->post('qty',TRUE);
        $data['no_nota']             = $this->input->post('no_nota',TRUE);
        
        $result = $this->penjualan_model->retur_order_detail($data);
        echo json_encode($result);
    }
    
}
