<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct(){
        parent::__construct();      
        $this->load->model('main_model');
        $this->load->model('laporan_model');
        $this->load->model('outlet_model');
    }

    public function penjualan(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('laporan/penjualan/laporan_penjualan_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    function penjualan_data(){
        $data['outlet'] = $this->input->post('outlet',TRUE);
        $data['tanggal'] = $this->input->post('tanggal',TRUE);
        $result = $this->laporan_model->penjualan_data($data)->result_array();
        echo json_encode($result);
    }
    
    function penjualan_data_total(){
        $data['outlet'] = $this->input->post('outlet',TRUE);
        $data['tanggal'] = $this->input->post('tanggal',TRUE);
        $result = $this->laporan_model->penjualan_data_total($data)->row_array();
        echo json_encode($result);
    }
    
    public function penjualan_data_pdf($outlet,$tanggal){
        
        $r = $this->outlet_model->get_alamat($outlet)->row_array();
        $data['outlet'] = $outlet;
        $data['tanggal'] = $tanggal;
        
        $nama_dokumen = 'Laporan_Data_Penjualan_'.$r['nama'].'_'.$tanggal;
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        $result['detail_penjualan'] = $this->laporan_model->penjualan_data($data)->result_array();
        $result['total_penjualan'] = $this->laporan_model->penjualan_data_total($data)->row_array();
        $result['nama_outlet'] = $r['nama'];
        $result['tanggals'] = $tanggal;
        
            //$result = $this->order_model->data_laporan($data)->result_array();
        $mpdf=new mPDF('utf-8', 'A4-L');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('laporan/penjualan/laporan_penjualan_pdf_view',$result);
        
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
