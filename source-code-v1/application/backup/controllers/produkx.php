<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('produk_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('produk/produk_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    public function tambah_manual(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('produk/produk_tambah_manual_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }

    public function detail_list(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('produk/produk_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->produk_model->data()->result_array();
        echo json_encode($result);
    }

    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->produk_model->data_detail($kode_produksi)->result_array();
        echo json_encode($result);
    }
    
    public function cari(){
        $data['kode_produk'] = $this->input->post('kodeproduk',TRUE);
        $result = $this->produk_model->cari($data)->row_array();
        echo json_encode($result);
    }
    
    public function cek_produk(){
        $kodeproduk = $this->input->post('kodeproduk',TRUE);
        $result = $this->produk_model->cek_produk($kodeproduk)->num_rows();
        echo json_encode($result);
    }
    
    public function cek_gudang(){
        $kodeproduk = $this->input->post('kodeproduk',TRUE);
        $result = $this->produk_model->cek_gudang($kodeproduk);
        echo json_encode($result);
    }
    

    public function simpan_manual(){


        $data['kode_produksi']             = $this->input->post('kode_produksi',TRUE);
        $data['kode_utama']                = $this->input->post('kode_utama',TRUE);
        $data['jumlah_label']              = $this->input->post('jumlah_label',TRUE);
        


        //looping label
        $kd_utama = $this->input->post('kode_utama',TRUE);
        for ($x = 0; $x < $this->input->post('jumlah_label',TRUE); $x++) {
            
            $no = $x + 1;
            $fzeropadded = sprintf("%04d", $no);
            $kode_produksi_produk = $fzeropadded.$kd_utama;
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

            $image_name = $kode_produksi_produk.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $kode_produksi_produk; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $img_qrcode = $image_name;
            /*End Qr Code*/
            $this->produk_model->created_label($img_qrcode,$kode_produksi_produk,$data);
 
        }

        $result = true;
        //$result = $this->cutting_model->update($data,$nama_file);
        echo json_encode($result);
    }

    
}
