<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cutting extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('cutting_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('cutting/cutting_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->cutting_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->cutting_model->data_detail($kode_produksi)->row_array();
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
                $this->load->view('cutting/cutting_detail_view',$data);
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
        
        $data['tgl_mulai']                  = $this->input->post('tgl_mulai_cutting',TRUE);
        $data['tgl_selesai']                = $this->input->post('tgl_selesai_cutting',TRUE);
        $data['bahan_terpakai']             = $this->input->post('jumlah_bahan_terpakai_cutting',TRUE);
        $data['hasil']                      = $this->input->post('hasil_cutting',TRUE);
        $data['sisa_bahan']                 = $this->input->post('sisa_bahan_cutting',TRUE);
        $data['berat']                      = $this->input->post('berat_cutting',TRUE);
        $data['qty']                        = $this->input->post('jumlah_akhir_cutting',TRUE);
        $data['vendor']                     = $this->input->post('vendor_cutting',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_cutting',TRUE);
        $data['biaya_cutting']              = $this->input->post('biaya_cutting',TRUE);
        
        
        
        //small
        $data['small_warna_1_inisial']      = $this->input->post('small_warna_1_inisial',TRUE);
        $data['small_warna_1_jumlah']       = $this->input->post('small_warna_1_jumlah',TRUE);
        $data['small_warna_2_inisial']      = $this->input->post('small_warna_2_inisial',TRUE);
        $data['small_warna_2_jumlah']       = $this->input->post('small_warna_2_jumlah',TRUE);
        //large
        $data['large_warna_1_inisial']      = $this->input->post('large_warna_1_inisial',TRUE);
        $data['large_warna_1_jumlah']       = $this->input->post('large_warna_1_jumlah',TRUE);
        $data['large_warna_2_inisial']      = $this->input->post('large_warna_2_inisial',TRUE);
        $data['large_warna_2_jumlah']       = $this->input->post('large_warna_2_jumlah',TRUE);
        
        
        
        $data['c_gambar']                   = $this->input->post('c_gambar_cutting',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_cutting"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_cutting');
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
            $nama_file = $this->input->post('c_gambar_cutting_asli',TRUE);
        }
        
        $kd_produksi = $this->input->post('kode_produksi_cutting',TRUE);
        $ress  = $this->cutting_model->cek_harga_jual($this->input->post('kode_produksi_cutting',TRUE))->row_array();
        $harga_jual = $ress['harga_jual'];
        //Label Qrcode Small Warna 1
        
        //SMALL WARNA 1
        
        //ini kode random untuk token
        $token_small_1 = "";
        $codeAlphabeta = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabeta.= "0123456789";
        $maxa = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_1 .= $codeAlphabeta[mt_rand(0, $maxa)];
        } 
        //ini kode random untuk token
        
        $small_inisial_1   = $this->input->post('small_warna_1_inisial',TRUE);
        $small_jumlah_1    = $this->input->post('small_warna_1_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_1; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_1.$no;
            $kode_produksi_produk = 'S1'.$kd_produksi.$small_inisial_1.$no;
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
            
            $inisial = 'S1'.$token_small_1.$this->input->post('kode_produksi_cutting',TRUE);
            
            $this->cutting_model->created_label($img_qrcode,$harga_jual,$kd_produksi,$kode_produksi_produk,$inisial);
 
        }
        
        
        //ini kode random untuk token
        $token_small_2 = "";
        $codeAlphabetb = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabetb.= "0123456789";
        $maxb = strlen($codeAlphabeta) - 1;
        for ($i=0; $i < 5; $i++) {
            $token_small_2 .= $codeAlphabetb[mt_rand(0, $maxb)];
        } 
        //ini kode random untuk token
        
        $small_inisial_2   = $this->input->post('small_warna_2_inisial',TRUE);
        $small_jumlah_2    = $this->input->post('small_warna_2_jumlah',TRUE);
        for ($x = 0; $x < $small_jumlah_2; $x++) {
            
            $no = $x + 1;
            //$kode_produksi_produk = 'S'.$kd_produksi.$small_inisial_2.$no;
            $kode_produksi_produk = 'S2'.$kd_produksi.$small_inisial_2.$no;
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
            
            $inisial = 'S2'.$token_small_2.$this->input->post('kode_produksi_cutting',TRUE);
            
            $this->cutting_model->created_label($img_qrcode,$harga_jual,$kd_produksi,$kode_produksi_produk,$inisial);
 
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
            $kode_produksi_produk = 'L1'.$kd_produksi.$large_inisial_1.$no;
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
            
            $inisial = 'L1'.$token_large_1.$this->input->post('kode_produksi_cutting',TRUE);
            
            $this->cutting_model->created_label($img_qrcode,$harga_jual,$kd_produksi,$kode_produksi_produk,$inisial);
 
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
            $kode_produksi_produk = 'L2'.$kd_produksi.$large_inisial_2.$no;
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
            
            $inisial = 'L2'.$token_large_2.$this->input->post('kode_produksi_cutting',TRUE);
            
            $this->cutting_model->created_label($img_qrcode,$harga_jual,$kd_produksi,$kode_produksi_produk,$inisial);
 
        }
        
        

        $result = $this->cutting_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
}
