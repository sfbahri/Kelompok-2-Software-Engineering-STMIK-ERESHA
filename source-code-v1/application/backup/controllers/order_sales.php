<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_sales extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('order_sales_model');
        $this->load->model('outlet_model');
    }
    

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('order_sales/order_sales_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function tambah_baru(){
        $noos   = $this->input->post('noos',TRUE);
        $result = $this->order_sales_model->tambah_baru($noos);
        echo json_encode($result);
    }
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('order_sales/order_sales_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('order_sales/order_sales_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->order_sales_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_produk(){
        $result = $this->order_sales_model->data_produk()->result_array();
        echo json_encode($result);
    }
    
    public function simpan(){
        
        $data['qty']   = $this->input->post('qty',TRUE);
        $data['kd_produk_header']   = $this->input->post('kd_produk_header',TRUE);
        $data['no_order_sales']   = $this->input->post('no_order_sales',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $data['harga']   = $this->input->post('harga',TRUE);
        $result = $this->order_sales_model->simpan($data);
        echo json_encode($result);
        
    }
    
    public function hapus(){
        $data['kd_produk_header']   = $this->input->post('kd_produk_header',TRUE);
        $data['no_order_sales']     = $this->input->post('no_order_sales',TRUE);
        $result = $this->order_sales_model->hapus($data);
        echo json_encode($result);
        
    }
    
    public function hapus_order_sales(){
        $data['no_order_sales']     = $this->input->post('no_order_sales',TRUE);
        $result = $this->order_sales_model->hapus_order_sales($data);
        echo json_encode($result);
    }
    
    public function bayar_order_sales(){
        $data['no_order_sales']     = $this->input->post('id_order_sales',TRUE);
        $result = $this->order_sales_model->bayar_order_sales($data);
        echo json_encode($result);
    }
    
    public function data_produk_order(){
        $data['id_order_sales']   = $this->input->post('id_order_sales',TRUE);
        $result = $this->order_sales_model->data_produk_order($data)->result_array();
        echo json_encode($result);
    }
    
    public function update(){

        $data['list_member']   = $this->input->post('list_member',TRUE);
        $data['kategori_pemesanan']   = $this->input->post('kategori_pemesanan',TRUE);
        $data['id_order_sales']     = $this->input->post('id_order_sales',TRUE);
        $data['ongkos_kirim']     = $this->input->post('ongkos_kirim',TRUE);
        $result = $this->order_sales_model->update($data);
        echo json_encode($result);
    }
    
    public function detail(){
        $data['id_order_sales']     = $this->input->post('id_order_sales',TRUE);
        $result = $this->order_sales_model->detail($data)->row_array();
        echo json_encode($result);
    }
    
    
    public function cetak_struk_dotmetrik_unpaid($no_order_sales){
            $this->load->library('mpdf/mpdf');
            
            function rupiah($angka){
	
                    $hasil_rupiah = number_format($angka,0,',',',');
                    return $hasil_rupiah;

            }
            
            $res = $this->order_sales_model->cetak_data_produk_order($no_order_sales)->result_array();
            $d = $this->order_sales_model->cetak_data_produk_order_header($no_order_sales)->row_array();
            $f = $this->order_sales_model->cetak_data_produk_order_header_all($no_order_sales)->row_array();
            $g = $this->order_sales_model->detailss($no_order_sales)->row_array();
            
            $session_id_outlet = $this->session->userdata('sess_outlet');
            $o = $this->outlet_model->get_alamat($session_id_outlet)->row_array();
            
            $i = 0;
            $base_url = base_url();
            if($g['bayar'] == 1){
                $status_bayar = base_url('/assets/img/paid.jpg');
            }else{
                $status_bayar = base_url('/assets/img/unpaid.jpg');
            }
            $html = '<table width="100%" border="0" style="margin-right:20px;margin-left:20px;">
                    <tr>
                      <td height="53" colspan="6"><strong>ORDER SALES - BABYNEEDS.CO.ID</strong> <br> '.$o['alamat'].' <br> <img src="'.$status_bayar.'" width="100px" height="30px"></td>
                    </tr>
                    <tr>
                      <td height="53" colspan="6" align="left"><strong>INFORMASI PEMBELI</strong> <br> '.$d['nama_pelanggan'].' / '.$d['nohp'].' / '.$d['alamat'].'</td>
                    </tr>
                    <tr>
                    <td colspan="5" align="left">No. Order Sales : <b>'.$no_order_sales.' / ADM : '.$this->session->userdata('sess_nama').' / CTK : '.date("Y-m-d h:i").'</b></td>
                  </tr>
                    
                  <tr>
                      <td colspan="6"><hr></td>
                        </tr>
                        <tr>
                            <td>No</td>
                            <td>Nama Barang</td>
                            <td>Jumlah / Qty</td>
                            <td>Berat</td>
                            <td>Harga</td>
                            <td width="100px" align="right">TOTAL</td>
                        </tr>
                        ';
                        $no = 0;
                        foreach($res as $r){
                            $nos = $no+1;
                            $html .='<tr>
                                <td  align="left">'.$nos.'</td>
                                <td  align="left">'.$r['nama_produk'].'</span></td>
                                <td  align="left">'.$r['count_qty'].' Pcs</td>
                                <td  align="center">'.$r['count_berat'].'</td>
                                <td  align="center">'.$r['harga'].'</td>
                                <td  align="right">'.$r['count_harga'].'</td>
                            </tr>';
                            $no++;
                        }
                    $html .='<tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>Total Berat : '.number_format($f['tot_berat'],2).' Kg</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><b>TOTAL</b></td>
                      <td align="center"><b>:</b></td>
                      <td align="right"><b>'.$f['tot_harga'].'</b></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><b>Ongkos Kirim</b></td>
                      <td align="center"><b>:</b></td>
                      <td align="right"><b>'.$d['ongkos_kirims'].'</b></td>
                    </tr>
                   <tr>
                      <td colspan="6"><hr></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right"><b>SUB TOTAL</b></td>
                      <td align="center"><b>:</b></td>
                      <td align="right"><b>'.rupiah($f['total_hrg']+$d['ongkos_kirim']).'</b></td>
                    </tr>
                    <tr>
                      <td colspan="6"></td>
                    </tr>
                    <tr>
                      <td colspan="6"><hr></td>
                    </tr>
                    <tr>
                      <td colspan="6"><span style="color:black;font-weight:bold;">Batas Akhir Pembayaran :</span> <span style="color:red;font-weight:bold;font-size:16px">'.$d['expired_at'].' WIB</span> <br> <span style="color:red;font-weight:bold;">Informasi Penting</span> : Untuk keep barang dan transaksi Pembayaran batas waktunya hanya 12 jam terhitung dari pembuatan Order Sales ini, jika melawati batas akhir pembayaran yang telah ditentukan silahkan konfirmasi terlebih dahulu kepada admin kami, untuk kami cek ketersediaan stok, mengingat dalam transaksi ini tidak ada keterikatan stok. Terima Kasih</td>
                    </tr>
                    <tr>
                      <td colspan="6"><hr></td>
                    </tr>
                    <tr>
                      <td colspan="5" align="left"><b>BCA : 3366772999 </b> a/n Desy Tanzil / Willy Septian Alexander </td>
                    </tr>
                    <tr>
                      <td colspan="6" align="left"><b>Mandiri : 1210 04 09 1988 </b> a/n Willy Septian Alexander </td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center">-----====----- </td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center">Terima Kasih. Selamat Belanja Kembali</td>
                    </tr>
                    <tr>
                      <td colspan="6" align="center">www.babyneeds.co.id</td>
                    </tr>
                    </table>';

            //$html = $this->load->view('produksi/produksi_print_label_view',$data);
            //$mpdf = new mPDF('utf-8', array(95,122.27),'0');         
            $mpdf = new mPDF('utf-8', array(160,240), 8, '', '', '', '', '', '', '');
            
            
            
            $mpdf->WriteHTML($html);
            $mpdf->Output('ORDER-SALES-'.$d['nama_pelanggan'].'.pdf', 'I');
    }
    
     public function data_select(){
        $result = $this->order_sales_model->data_select()->result_array();
        echo json_encode($result);
    }
    
}
