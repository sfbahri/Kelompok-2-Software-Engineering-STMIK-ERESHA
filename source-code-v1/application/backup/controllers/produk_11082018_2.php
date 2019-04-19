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
    
    public function tambah_manual_by_vendor(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('produk/produk_tambah_manual_by_vendor_view',$data);
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
    
    
    public function detail_list_produk(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('produk/produk_detail_list_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function data_list(){
        $kode_produk = $this->input->post('kode_produk',TRUE);
        $result = $this->produk_model->data_list($kode_produk)->result_array();
        echo json_encode($result);
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
    

    public function simpan_manualx(){


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

    
    public function simpan_manual(){
        $path = './uploads/produk/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['kode_produksi']               = $this->input->post('kode_produksi',TRUE);
        $data['kode_utama']                  = $this->input->post('kode_utama',TRUE);
        $data['nama']                        = $this->input->post('nama',TRUE);
        $data['harga_modal']                 = $this->input->post('harga_modal',TRUE);
        $data['harga_jual']                  = $this->input->post('harga_jual',TRUE);
        $kd_produksi                         = $this->input->post('kode_produksi',TRUE);//ini kode utama bukan kode produksi
        $kd_produk_header                    = $this->input->post('kode_utama',TRUE);
        $harga_jual                          = $this->input->post('harga_jual',TRUE);
        $nama                                = $this->input->post('nama',TRUE);
        
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

        $image_name = $this->input->post('kode_utama',TRUE).'.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $this->input->post('kode_utama',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data['img_qrcode'] = $image_name;
        /*End Qr Code*/
        
        
        
        
        //small
        $data['small_warna_1_inisial']      = $this->input->post('small_warna_1_inisial',TRUE);
        $data['small_warna_1_jumlah']       = $this->input->post('small_warna_1_jumlah',TRUE);
        $data['small_warna_2_inisial']      = $this->input->post('small_warna_2_inisial',TRUE);
        $data['small_warna_2_jumlah']       = $this->input->post('small_warna_2_jumlah',TRUE);
        $data['small_warna_3_inisial']      = $this->input->post('small_warna_3_inisial',TRUE);
        $data['small_warna_3_jumlah']       = $this->input->post('small_warna_3_jumlah',TRUE);
        //medium
        $data['medium_warna_1_inisial']      = $this->input->post('medium_warna_1_inisial',TRUE);
        $data['medium_warna_1_jumlah']       = $this->input->post('medium_warna_1_jumlah',TRUE);
        $data['medium_warna_2_inisial']      = $this->input->post('medium_warna_2_inisial',TRUE);
        $data['medium_warna_2_jumlah']       = $this->input->post('medium_warna_2_jumlah',TRUE);
        $data['medium_warna_3_inisial']      = $this->input->post('medium_warna_3_inisial',TRUE);
        $data['medium_warna_3_jumlah']       = $this->input->post('medium_warna_3_jumlah',TRUE);
        //large
        $data['large_warna_1_inisial']      = $this->input->post('large_warna_1_inisial',TRUE);
        $data['large_warna_1_jumlah']       = $this->input->post('large_warna_1_jumlah',TRUE);
        $data['large_warna_2_inisial']      = $this->input->post('large_warna_2_inisial',TRUE);
        $data['large_warna_2_jumlah']       = $this->input->post('large_warna_2_jumlah',TRUE);
        $data['large_warna_3_inisial']      = $this->input->post('large_warna_3_inisial',TRUE);
        $data['large_warna_3_jumlah']       = $this->input->post('large_warna_3_jumlah',TRUE);
        
        
        //SMALL WARNA 1
        //inisial small 1
        $token_small_1 = "";
        $codeAlphabeta = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta.= "0123456789";
        $maxa = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_1 .= $codeAlphabeta[mt_rand(0, $maxa)];
        } 
        //inisial small 1
        
        $small_inisial_1   = $this->input->post('small_warna_1_inisial',TRUE);
        $small_jumlah_1    = $this->input->post('small_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produk = 'BNS1'.$kd_produk_header.$small_inisial_1.$no;
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

            $image_name = $kode_produk.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $kode_produk; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $img_qrcode = $image_name;
            /*End Qr Code*/
            
            $inisial = 'BNS1'.$token_small_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produk,$inisial,$nama);
 
        }
        
        
        //ini kode random untuk token
        $token_small_2 = "";
        $codeAlphabetb = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetb.= "0123456789";
        $maxb = strlen($codeAlphabetb) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_2 .= $codeAlphabetb[mt_rand(0, $maxb)];
        } 
        //ini kode random untuk token
        
        $small_inisial_2   = $this->input->post('small_warna_2_inisial',TRUE);
        $small_jumlah_2    = $this->input->post('small_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_2.$no;
            $kode_produk = 'BNS2'.$kd_produk_header.$small_inisial_2.$no;
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

            $image_name = $kode_produk.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $kode_produk; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $img_qrcode = $image_name;
            /*End Qr Code*/
            
            $inisial = 'BNS2'.$token_small_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produk,$inisial,$nama);
 
        }
        
        //SMALL 3
        //ini kode random untuk token
        $token_small_3 = "";
        $codeAlphabet3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet3.= "0123456789";
        $max3 = strlen($codeAlphabet3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_3 .= $codeAlphabet3[mt_rand(0, $max3)];
        } 
        //ini kode random untuk token
        
        $small_inisial_3   = $this->input->post('small_warna_3_inisial',TRUE);
        $small_jumlah_3    = $this->input->post('small_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_2.$no;
            $kode_produksi_produk = 'BNS3'.$kd_produk_header.$small_inisial_3.$no;
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
            
            $inisial = 'BNS3'.$token_small_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        
        //MEDIUM WARNA 1
        $token_medium_1 = "";
        $codeAlphabetm1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm1.= "0123456789";
        $maxm1 = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_1 .= $codeAlphabetm1[mt_rand(0, $maxm1)];
        } 
        
        $medium_inisial_1   = $this->input->post('medium_warna_1_inisial',TRUE);
        $medium_jumlah_1    = $this->input->post('medium_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'BNM1'.$kd_produk_header.$medium_inisial_1.$no;
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
            
            $inisial = 'BNM1'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        //MEDIUM WARNA 1
        $token_medium_2 = "";
        $codeAlphabetm2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm2.= "0123456789";
        $maxm2 = strlen($codeAlphabetm2) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_2 .= $codeAlphabetm2[mt_rand(0, $maxm2)];
        } 
        
        $medium_inisial_2   = $this->input->post('medium_warna_2_inisial',TRUE);
        $medium_jumlah_2    = $this->input->post('medium_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'BNM2'.$kd_produk_header.$medium_inisial_2.$no;
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
            
            $inisial = 'BNM2'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //MEDIUM WARNA 3
        $token_medium_3 = "";
        $codeAlphabetm3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm3.= "0123456789";
        $maxm3 = strlen($codeAlphabetm3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_3 .= $codeAlphabetm3[mt_rand(0, $maxm3)];
        } 
        
        $medium_inisial_3   = $this->input->post('medium_warna_3_inisial',TRUE);
        $medium_jumlah_3    = $this->input->post('medium_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'BNM3'.$kd_produk_header.$medium_inisial_3.$no;
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
            
            $inisial = 'BNM3'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        
        
        //LARGE WARNA 1
        //ini kode random untuk token
        $token_large_1 = "";
        $codeAlphabetc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetc.= "0123456789";
        $maxc = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_1 .= $codeAlphabetc[mt_rand(0, $maxc)];
        } 
        //ini kode random untuk token
        
        $large_inisial_1   = $this->input->post('large_warna_1_inisial',TRUE);
        $large_jumlah_1    = $this->input->post('large_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_1.$no;
            $kode_produksi_produk = 'BNL1'.$kd_produk_header.$large_inisial_1.$no;
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
            
            $inisial = 'BNL1'.$token_large_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //LARGE WARNA 2
        //ini kode random untuk token
        $token_large_2 = "";
        $codeAlphabetd = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetd.= "0123456789";
        $maxd = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_2 .= $codeAlphabetd[mt_rand(0, $maxd)];
        } 
        //ini kode random untuk token
        $large_inisial_2   = $this->input->post('large_warna_2_inisial',TRUE);
        $large_jumlah_2    = $this->input->post('large_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_2.$no;
            $kode_produksi_produk = 'BNL2'.$kd_produk_header.$large_inisial_2.$no;
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
            
            $inisial = 'BNL2'.$token_large_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //LARGE WARNA 3
        //ini kode random untuk token
        $token_large_3 = "";
        $codeAlphabetL3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetL3.= "0123456789";
        $maxl3 = strlen($codeAlphabetL3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_3 .= $codeAlphabetL3[mt_rand(0, $maxl3)];
        } 
        //ini kode random untuk token
        $large_inisial_3   = $this->input->post('large_warna_3_inisial',TRUE);
        $large_jumlah_3    = $this->input->post('large_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_2.$no;
            $kode_produksi_produk = 'BNL3'.$kd_produk_header.$large_inisial_3.$no;
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
            
            $inisial = 'BNL3'.$token_large_3.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        

        $result = $this->produk_model->simpan_manual($data);
        echo json_encode($result);
        
        
        
        
        //upload gambar
//        $data['c_gambar']                   = $this->input->post('c_gambar_cutting',TRUE);
//        $date                               = date('dmY');
//        $file_name                          = 'img_'.$date.time().$token;
//        $nama_file;
//
//        if($_FILES["c_gambar_cutting"]['name'] !=''){
//
//        $config['upload_path']   = $path;
//        $config['allowed_types'] = 'jpg|jpeg|png';
//        $config['max_size']      = '6048';
//        $config['file_name']     = $file_name;
//        $this->load->library('upload',$config);
//        $this->upload->do_upload('c_gambar_cutting');
//        $result_images           = $this->upload->data();
//        $nama_file               = $result_images['file_name']; 
//
//        $this->load->library('image_lib');
//
//        /* ini ukuran 300x300 */
//         $configSize1['image_library']   = 'gd2';
//         $configSize1['source_image']    = './uploads/produksi/'.$result_images['file_name'];
//         $configSize1['create_thumb']    = FALSE;
//         $configSize1['maintain_ratio']  = TRUE;
//         $configSize1['width']           = 300;
//         $configSize1['height']          = 300;
//         $configSize1['new_image']       = './uploads/produksi/rz_'.$result_images['file_name'];
//
//         $this->image_lib->initialize($configSize1);
//         $this->image_lib->resize();
//         $this->image_lib->clear();
//
//        }else{
//            $nama_file = $this->input->post('c_gambar_cutting_asli',TRUE);
//        }
        
        
    }
    
    
    
    
    
    public function simpan_manual_by_vendor(){
        $path = './uploads/produk/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['kode_produksi']               = $this->input->post('kode_produksi',TRUE);
        $data['kode_utama']                  = $this->input->post('kode_utama',TRUE);
        $data['nama']                        = $this->input->post('nama',TRUE);
        $data['harga_modal']                 = $this->input->post('harga_modal',TRUE);
        $data['harga_jual']                  = $this->input->post('harga_jual',TRUE);
        $data['id_vendor']                   = $this->input->post('vendor',TRUE);
        $kd_produksi                         = $this->input->post('kode_produksi',TRUE);//ini kode utama bukan kode produksi
        $kd_produk_header                    = $this->input->post('kode_utama',TRUE);
        $harga_jual                          = $this->input->post('harga_jual',TRUE);
        $nama                                = $this->input->post('nama',TRUE);
        
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

        $image_name = $this->input->post('kode_utama',TRUE).'.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = $this->input->post('kode_utama',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data['img_qrcode'] = $image_name;
        /*End Qr Code*/
        
        
        
        
        //small
        $data['small_warna_1_inisial']      = $this->input->post('small_warna_1_inisial',TRUE);
        $data['small_warna_1_jumlah']       = $this->input->post('small_warna_1_jumlah',TRUE);
        $data['small_warna_2_inisial']      = $this->input->post('small_warna_2_inisial',TRUE);
        $data['small_warna_2_jumlah']       = $this->input->post('small_warna_2_jumlah',TRUE);
        $data['small_warna_3_inisial']      = $this->input->post('small_warna_3_inisial',TRUE);
        $data['small_warna_3_jumlah']       = $this->input->post('small_warna_3_jumlah',TRUE);
        //medium
        $data['medium_warna_1_inisial']      = $this->input->post('medium_warna_1_inisial',TRUE);
        $data['medium_warna_1_jumlah']       = $this->input->post('medium_warna_1_jumlah',TRUE);
        $data['medium_warna_2_inisial']      = $this->input->post('medium_warna_2_inisial',TRUE);
        $data['medium_warna_2_jumlah']       = $this->input->post('medium_warna_2_jumlah',TRUE);
        $data['medium_warna_3_inisial']      = $this->input->post('medium_warna_3_inisial',TRUE);
        $data['medium_warna_3_jumlah']       = $this->input->post('medium_warna_3_jumlah',TRUE);
        //large
        $data['large_warna_1_inisial']      = $this->input->post('large_warna_1_inisial',TRUE);
        $data['large_warna_1_jumlah']       = $this->input->post('large_warna_1_jumlah',TRUE);
        $data['large_warna_2_inisial']      = $this->input->post('large_warna_2_inisial',TRUE);
        $data['large_warna_2_jumlah']       = $this->input->post('large_warna_2_jumlah',TRUE);
        $data['large_warna_3_inisial']      = $this->input->post('large_warna_3_inisial',TRUE);
        $data['large_warna_3_jumlah']       = $this->input->post('large_warna_3_jumlah',TRUE);
        
        
        //SMALL WARNA 1
        //inisial small 1
        $token_small_1 = "";
        $codeAlphabeta = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta.= "0123456789";
        $maxa = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_1 .= $codeAlphabeta[mt_rand(0, $maxa)];
        } 
        //inisial small 1
        
        $small_inisial_1   = $this->input->post('small_warna_1_inisial',TRUE);
        $small_jumlah_1    = $this->input->post('small_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produk = 'LVS1'.$kd_produk_header.$small_inisial_1.$no;
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

            $image_name = $kode_produk.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $kode_produk; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $img_qrcode = $image_name;
            /*End Qr Code*/
            
            $inisial = 'LVS1'.$token_small_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produk,$inisial,$nama);
 
        }
        
        
        //ini kode random untuk token
        $token_small_2 = "";
        $codeAlphabetb = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetb.= "0123456789";
        $maxb = strlen($codeAlphabetb) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_2 .= $codeAlphabetb[mt_rand(0, $maxb)];
        } 
        //ini kode random untuk token
        
        $small_inisial_2   = $this->input->post('small_warna_2_inisial',TRUE);
        $small_jumlah_2    = $this->input->post('small_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_2.$no;
            $kode_produk = 'LVS2'.$kd_produk_header.$small_inisial_2.$no;
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

            $image_name = $kode_produk.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data'] = $kode_produk; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $img_qrcode = $image_name;
            /*End Qr Code*/
            
            $inisial = 'LVS2'.$token_small_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produk,$inisial,$nama);
 
        }
        
        //SMALL 3
        //ini kode random untuk token
        $token_small_3 = "";
        $codeAlphabet3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet3.= "0123456789";
        $max3 = strlen($codeAlphabet3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_3 .= $codeAlphabet3[mt_rand(0, $max3)];
        } 
        //ini kode random untuk token
        
        $small_inisial_3   = $this->input->post('small_warna_3_inisial',TRUE);
        $small_jumlah_3    = $this->input->post('small_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_2.$no;
            $kode_produksi_produk = 'LVS3'.$kd_produk_header.$small_inisial_3.$no;
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
            
            $inisial = 'LVS3'.$token_small_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        
        //MEDIUM WARNA 1
        $token_medium_1 = "";
        $codeAlphabetm1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm1.= "0123456789";
        $maxm1 = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_1 .= $codeAlphabetm1[mt_rand(0, $maxm1)];
        } 
        
        $medium_inisial_1   = $this->input->post('medium_warna_1_inisial',TRUE);
        $medium_jumlah_1    = $this->input->post('medium_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'LVM1'.$kd_produk_header.$medium_inisial_1.$no;
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
            
            $inisial = 'LVM1'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        //MEDIUM WARNA 1
        $token_medium_2 = "";
        $codeAlphabetm2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm2.= "0123456789";
        $maxm2 = strlen($codeAlphabetm2) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_2 .= $codeAlphabetm2[mt_rand(0, $maxm2)];
        } 
        
        $medium_inisial_2   = $this->input->post('medium_warna_2_inisial',TRUE);
        $medium_jumlah_2    = $this->input->post('medium_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'LVM2'.$kd_produk_header.$medium_inisial_2.$no;
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
            
            $inisial = 'LVM2'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //MEDIUM WARNA 3
        $token_medium_3 = "";
        $codeAlphabetm3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetm3.= "0123456789";
        $maxm3 = strlen($codeAlphabetm3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_medium_3 .= $codeAlphabetm3[mt_rand(0, $maxm3)];
        } 
        
        $medium_inisial_3   = $this->input->post('medium_warna_3_inisial',TRUE);
        $medium_jumlah_3    = $this->input->post('medium_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $medium_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'LVM3'.$kd_produk_header.$medium_inisial_3.$no;
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
            
            $inisial = 'LVM3'.$token_medium_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        
        
        
        //LARGE WARNA 1
        //ini kode random untuk token
        $token_large_1 = "";
        $codeAlphabetc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetc.= "0123456789";
        $maxc = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_1 .= $codeAlphabetc[mt_rand(0, $maxc)];
        } 
        //ini kode random untuk token
        
        $large_inisial_1   = $this->input->post('large_warna_1_inisial',TRUE);
        $large_jumlah_1    = $this->input->post('large_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_1.$no;
            $kode_produksi_produk = 'LVL1'.$kd_produk_header.$large_inisial_1.$no;
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
            
            $inisial = 'LVL1'.$token_large_1.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //LARGE WARNA 2
        //ini kode random untuk token
        $token_large_2 = "";
        $codeAlphabetd = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetd.= "0123456789";
        $maxd = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_2 .= $codeAlphabetd[mt_rand(0, $maxd)];
        } 
        //ini kode random untuk token
        $large_inisial_2   = $this->input->post('large_warna_2_inisial',TRUE);
        $large_jumlah_2    = $this->input->post('large_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_2.$no;
            $kode_produksi_produk = 'LVL2'.$kd_produk_header.$large_inisial_2.$no;
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
            
            $inisial = 'LVL2'.$token_large_2.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        
        //LARGE WARNA 3
        //ini kode random untuk token
        $token_large_3 = "";
        $codeAlphabetL3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetL3.= "0123456789";
        $maxl3 = strlen($codeAlphabetL3) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_large_3 .= $codeAlphabetL3[mt_rand(0, $maxl3)];
        } 
        //ini kode random untuk token
        $large_inisial_3   = $this->input->post('large_warna_3_inisial',TRUE);
        $large_jumlah_3    = $this->input->post('large_warna_3_jumlah',TRUE);
        for ($x = 0; $x < $large_jumlah_3; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_2.$no;
            $kode_produksi_produk = 'LVL3'.$kd_produk_header.$large_inisial_3.$no;
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
            
            $inisial = 'LVL3'.$token_large_3.$this->input->post('kode_utama',TRUE);
            
            $this->produk_model->created_label($img_qrcode,$harga_jual,$kd_produk_header,$kode_produksi_produk,$inisial,$nama);
 
        }
        
        

        $result = $this->produk_model->simpan_manual_by_vendor($data);
        echo json_encode($result);
        
        
        
        
        //upload gambar
//        $data['c_gambar']                   = $this->input->post('c_gambar_cutting',TRUE);
//        $date                               = date('dmY');
//        $file_name                          = 'img_'.$date.time().$token;
//        $nama_file;
//
//        if($_FILES["c_gambar_cutting"]['name'] !=''){
//
//        $config['upload_path']   = $path;
//        $config['allowed_types'] = 'jpg|jpeg|png';
//        $config['max_size']      = '6048';
//        $config['file_name']     = $file_name;
//        $this->load->library('upload',$config);
//        $this->upload->do_upload('c_gambar_cutting');
//        $result_images           = $this->upload->data();
//        $nama_file               = $result_images['file_name']; 
//
//        $this->load->library('image_lib');
//
//        /* ini ukuran 300x300 */
//         $configSize1['image_library']   = 'gd2';
//         $configSize1['source_image']    = './uploads/produksi/'.$result_images['file_name'];
//         $configSize1['create_thumb']    = FALSE;
//         $configSize1['maintain_ratio']  = TRUE;
//         $configSize1['width']           = 300;
//         $configSize1['height']          = 300;
//         $configSize1['new_image']       = './uploads/produksi/rz_'.$result_images['file_name'];
//
//         $this->image_lib->initialize($configSize1);
//         $this->image_lib->resize();
//         $this->image_lib->clear();
//
//        }else{
//            $nama_file = $this->input->post('c_gambar_cutting_asli',TRUE);
//        }
        
        
    }
    
    
    
    
    
}
