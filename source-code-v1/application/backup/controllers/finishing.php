<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finishing extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('finishing_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('finishing/finishing_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->finishing_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->finishing_model->data_detail($kode_produksi)->row_array();
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
                $this->load->view('finishing/finishing_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function update(){
        $path = './uploads/produksi/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['tgl_serah_terima']           = $this->input->post('tgl_serah_terima',TRUE);
        $data['jenis_barang']               = $this->input->post('jenis_barang_finishing',TRUE);
        $data['berat']                      = $this->input->post('berat_finishing',TRUE);
        $data['jumlah_akhir']               = $this->input->post('jumlah_akhir_finishing',TRUE);
        $data['catatan']                    = $this->input->post('catatan_finishing',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_finishing',TRUE);
        $kd_produksi                        = $this->input->post('kode_produksi_finishing',TRUE);
        
        
        
        //stok terakhir
        $data['small_warna_1_jumlah_akhir']              = $this->input->post('small_warna_1_jumlah_akhir',TRUE);
        $data['small_warna_2_jumlah_akhir']              = $this->input->post('small_warna_2_jumlah_akhir',TRUE);
        $data['large_warna_1_jumlah_akhir']              = $this->input->post('large_warna_1_jumlah_akhir',TRUE);
        $data['large_warna_2_jumlah_akhir']              = $this->input->post('large_warna_2_jumlah_akhir',TRUE);
        
        //stok warna 
        $data['small_warna_1_inisial_akhir']              = $this->input->post('small_warna_1_inisial_akhir',TRUE);
        $data['small_warna_2_inisial_akhir']              = $this->input->post('small_warna_2_inisial_akhir',TRUE);
        $data['large_warna_1_inisial_akhir']              = $this->input->post('large_warna_1_inisial_akhir',TRUE);
        $data['large_warna_2_inisial_akhir']              = $this->input->post('large_warna_2_inisial_akhir',TRUE);
        
        
        $data['c_gambar']                   = $this->input->post('c_gambar_finishing',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_finishing"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_finishing');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/produksi/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/produksi/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('c_gambar_finishing_asli',TRUE);
        }
        
        
        $s = $this->finishing_model->get_kode_produk_header($kd_produksi)->row_array();
        $kd_produkheader = $s['kode'];
        
        
        //Start : INISIAL S1
        //ini kode random untuk token
        $token_small_1 = "";
        $codeAlphabeta = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta.= "0123456789";
        $maxa = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_1 .= $codeAlphabeta[mt_rand(0, $maxa)];
        } 
        //ini kode random untuk token
        
        $token_small_12 = "";
        $codeAlphabeta12 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta12.= "HSDJHGJHDGFJTIUYDFXMCNVKW";
        $codeAlphabeta12.= "IWENNBHGJHIUYYJDFKJHSDFKJH";
        $maxa12 = strlen($codeAlphabeta12) - 1;
        for ($i=0; $i < 3; $i++) {
            $token_small_12 .= $codeAlphabeta12[mt_rand(0, $maxa12)];
        } 
        
        $small_inisial_1   = $this->input->post('small_warna_1_inisial_akhir',TRUE);
        $small_jumlah_1    = $this->input->post('small_warna_1_jumlah_akhir',TRUE);
        for ($x = 0; $x < $small_jumlah_1; $x++) {
            
            $no = $x + 1;

            $kode_produk = 'BNS1'.$kd_produksi.$small_inisial_1.$token_small_12.$no;
            //$kode_produksi_produk = 'BNS1'.$kd_produksi.$small_inisial_1.$no;
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
            
            $data['size']      = 'S';
            $data['id_warna']  = $this->input->post('small_warna_1_inisial_akhir',TRUE);
            $data['berat']     = '0.15';
            $inisial = 'BNS1'.$token_small_1.$kd_produkheader;
            
            $this->finishing_model->created_label($img_qrcode,$kd_produksi,$kode_produk,$inisial,$data);
 
        }
         //End : INISIAL S1
        
        
        
        
         //Start : INISIAL S2
        //ini kode random untuk token
        $token_small_2 = "";
        $codeAlphabetb = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetb.= "0123456789";
        $maxb = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_2 .= $codeAlphabetb[mt_rand(0, $maxb)];
        } 
        //ini kode random untuk token
        
        
        $token_small_13 = "";
        $codeAlphabeta13 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta13.= "HSDJHGJHDGFJTIUYDFXMCNVKW";
        $codeAlphabeta13.= "IWENNBHGJHIUYYJDFKJHSDFKJH";
        $maxa13 = strlen($codeAlphabeta13) - 1;
        for ($i=0; $i < 3; $i++) {
            $token_small_13 .= $codeAlphabeta13[mt_rand(0, $maxa13)];
        }
        
        
        $small_inisial_2   = $this->input->post('small_warna_2_inisial_akhir',TRUE);
        $small_jumlah_2    = $this->input->post('small_warna_2_jumlah_akhir',TRUE);
        for ($x = 0; $x < $small_jumlah_2; $x++) {
            
            $no = $x + 1;
           
            $kode_produk = 'BNS2'.$kd_produksi.$small_inisial_2.$token_small_13.$no;
            
            //$kode_produksi_produk = 'BNS2'.$kd_produksi.$small_inisial_2.$no;
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
            
            $data['size']      = 'S';
            $data['id_warna']  = $this->input->post('small_warna_2_inisial_akhir',TRUE);
            $data['berat']     = '0.15';
            $inisial = 'BNS2'.$token_small_2.$kd_produkheader;
            
            $this->finishing_model->created_label($img_qrcode,$kd_produksi,$kode_produk,$inisial,$data);
 
        }
         //End : INISIAL S2
        
        
         //Start : INISIAL L1
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
        
        $token_small_14 = "";
        $codeAlphabeta14 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta14.= "HSDJHGJHDGFJTIUYDFXMCNVKW";
        $codeAlphabeta14.= "IWENNBHGJHIUYYJDFKJHSDFKJH";
        $maxa14 = strlen($codeAlphabeta14) - 1;
        for ($i=0; $i < 3; $i++) {
            $token_small_14 .= $codeAlphabeta14[mt_rand(0, $maxa14)];
        }
        
        $large_inisial_1   = $this->input->post('large_warna_1_inisial_akhir',TRUE);
        $large_jumlah_1    = $this->input->post('large_warna_1_jumlah_akhir',TRUE);
        for ($x = 0; $x < $large_jumlah_1; $x++) {
            
            $no = $x + 1;
            
            $kode_produksi_produk = 'BNL1'.$kd_produksi.$large_inisial_1.$token_small_14.$no;
         
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
            
            $data['size']      = 'L';
            $data['id_warna']  = $this->input->post('large_warna_1_inisial_akhir',TRUE);
            $data['berat']     = '0.15';
            $inisial = 'BNL1'.$token_large_1.$kd_produkheader;
            
            $this->finishing_model->created_label($img_qrcode,$kd_produksi,$kode_produksi_produk,$inisial);
 
        }
         //eND : INISIAL L1
        
        
         //Start : INISIAL L2
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
        
        $token_small_19 = "";
        $codeAlphabeta19 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta19.= "HSDJHGJHDGFJT8IUYDFXMCNVKW";
        $codeAlphabeta19.= "IWENNBHGJHIUYYJDFKJHSDFKJH";
        $maxa19 = strlen($codeAlphabeta19) - 1;
        for ($i=0; $i < 3; $i++) {
            $token_small_19 .= $codeAlphabeta19[mt_rand(0, $maxa19)];
        }
        
        $large_inisial_2   = $this->input->post('large_warna_2_inisial_akhir',TRUE);
        $large_jumlah_2    = $this->input->post('large_warna_2_jumlah_akhir',TRUE);
        for ($x = 0; $x < $large_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'L'.$kd_produksi.$large_inisial_2.$no;
           $kode_produksi_produk = 'BNL2'.$kd_produksi.$large_inisial_2.$token_small_19.$no;
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
            
            $inisial = 'BNL2'.$token_large_2.$kd_produkheader;
            $data['size']      = 'L';
            $data['id_warna']  = $this->input->post('large_warna_2_inisial_akhir',TRUE);
            $data['berat']     = '0.15';
            
            $this->finishing_model->created_label($img_qrcode,$kd_produksi,$kode_produksi_produk,$inisial);
 
        }
        
         //Start : INISIAL L2
        
        

        $result = $this->finishing_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
}
