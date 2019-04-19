<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('finishing_model');
        $this->load->model('aksesoris_model');
        $this->load->model('bahan_baku_model');
        $this->load->model('produk_model');
    }

    public function cetak_produksi_finishing($kode){
        
        $nama_dokumen = 'Produksi_Finishing_'.$kode;
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $data = $this->finishing_model->data_detail($kode)->row_array();
        $data['no_produksi'] = $kode;
            //$result = $this->order_model->data_laporan($data)->result_array();
        $mpdf = new mPDF('utf-8', array(95,140), 8, '', '', '', '', '', '', '');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_produksi_finishing_view',$data);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    
    public function cetak_aksesoris_label($kode){
        
        $nama_dokumen = 'Aksesoris_'.$kode;
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $data = $this->aksesoris_model->detail_cetak($kode)->row_array();
        $data['no_produksi'] = $kode;
            //$result = $this->order_model->data_laporan($data)->result_array();
        $mpdf = new mPDF('utf-8', array(95,140), 8, '', '', '', '', '', '', '');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_aksesoris_label_view',$data);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    
    public function cetak_bahanbaku_label($kode){
        
        $nama_dokumen = 'Aksesoris_'.$kode;
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $data = $this->bahan_baku_model->data_detail_cetak($kode)->row_array();
        $data['no_produksi'] = $kode;
            //$result = $this->order_model->data_laporan($data)->result_array();
        $mpdf = new mPDF('utf-8', array(95,140), 8, '', '', '', '', '', '', '');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_bahan_baku_label_view',$data);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    
    public function cetak_produk_label($kode){
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $labels = $this->produk_model->data_list($kode)->result_array();
            //$result = $this->order_model->data_laporan($data)->result_array();

            $i = 0;
            $base_url = base_url();
            $html = '<div style="text-align:center;width:100% !important"><center><table border="0" style="width: 100% !important;margin-left:40px;margin-right:20px" cellspacing="6" cellpadding="6"><tr style="border: 1px solid white;height: 130px;">';
                        foreach($labels as $item){
                            $i++;
                            $html .='<td> 
                                    <img src="'.$base_url.'uploads/qrcode/'.$item['img_qrcode'].'" style="width:110px;height:110px;margin-bottom:0;"><br>
                                        <b><center><span style="font-size:8px">'.$item['nama_all'].'</span></center></b><b><center><span style="font-size:8px">'.$item['kode_produk'].'</span></center></b><center><span style="font-size:10px">'.$item['nama_produk'].'</span></center>
                                    </td>';
                            if($i == 2) { // three items in a row. Edit this to get more or less items on a row
                                $html .='</tr><tr>';
                                $i = 0;
                            }
                        }
                     $html .='</tr></table><center></div>';


            //$html = $this->load->view('produksi/produksi_print_label_view',$data);
            //$mpdf = new mPDF('utf-8', array(95,122.27),'0');         
            $mpdf = new mPDF('utf-8', array(95,48), 8, '', '', '', '', '', '', '');
            $mpdf->WriteHTML($html,2);
            $mpdf->Output();
    }
    
}
