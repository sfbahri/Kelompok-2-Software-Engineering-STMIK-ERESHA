<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aksesoris extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('aksesoris_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('aksesoris/aksesoris_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function aksesoris_produksi_view(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('aksesoris/aksesoris_produksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('aksesoris/aksesoris_tambah_view',$data);
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
                $this->load->view('aksesoris/aksesoris_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->aksesoris_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_by_kode_produksi(){
        $kode_produksi        = $this->input->post('kode_produksi',TRUE);
        $result = $this->aksesoris_model->data_by_kode_produksi($kode_produksi)->result_array();
        echo json_encode($result);
    }
    
    public function data_by_kode_produksi2(){
        $kode_produksi        = $this->input->post('kode_produksi',TRUE);
        $result = $this->aksesoris_model->data_by_kode_produksi2($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->aksesoris_model->data_select()->result_array();
        echo json_encode($result);
    }

    public function detail(){
        $id_aksesoris   = $this->input->post('id_aksesoris',TRUE);
        $result = $this->aksesoris_model->detail($id_aksesoris)->row_array();
        echo json_encode($result);
    }

    public function simpan(){
  
        //ini kode random untuk token
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 
        //ini kode random untuk token
        
        $path = './uploads/aksesoris/';    
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['jumlah']      = $this->input->post('jumlah',TRUE);
        $data['harga']       = $this->input->post('harga',TRUE);
        $data['satuan']      = $this->input->post('satuan',TRUE);
        $data['tanggal']     = $this->input->post('tanggal',TRUE);
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = 'img_'.$date.time().$token;
        $data['kode']        = $date.time().$token;
        $nama_file;

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images  = $this->upload->data();
        $nama_file = $result_images['file_name']; 

        $this->load->library('image_lib');

         /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/aksesoris/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/aksesoris/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();
         
         
         //qrcpode 
         //qrcode
         $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './uploads/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        //->setLogo("logo.png")
        $this->ciqrcode->initialize($config);
 
        $image_name = $date.time().$token.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $date.time().$token; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        
        $data['nama_qrcode'] = $image_name;
         
       
        $result = $this->aksesoris_model->simpan($data,$nama_file);
        echo json_encode($result);
        
    }
    
    
    public function update(){
        $path = './uploads/aksesoris/';

        //ini kode random untuk token
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 
            //ini kode random untuk token
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['jumlah']      = $this->input->post('jumlah',TRUE);
        $data['satuan']      = $this->input->post('satuan',TRUE);
        $data['harga']       = $this->input->post('harga',TRUE);
        $data['tanggal']     = $this->input->post('tanggal',TRUE);
        $data['id_aksesoris']     = $this->input->post('id_aksesoris',TRUE);
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = 'img_'.$date.time().$token;
        $nama_file;

        
        
        if($_FILES["gambar"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');
        
       // var_dump($this->upload->data());exit();

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/aksesoris/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/aksesoris/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('gambar_asli',TRUE);
        }

        $result = $this->aksesoris_model->update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    public function hapus(){
        $id_aksesoris   = $this->input->post('id_aksesoris',TRUE);
        $result = $this->aksesoris_model->hapus($id_aksesoris);
        echo json_encode($result);
    }
    
    
    
    
    
    
    /*PRODUKSI AKSESORIS*/
    
    public function data_detail(){
        $kode_produksi = $this->input->post('kode_produksi',TRUE);
        $result = $this->aksesoris_model->data_detail($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    
    public function data_update(){
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
        
        $data['tgl_mulai']                  = $this->input->post('tgl_mulai_aksesoris',TRUE);
        $data['tgl_diambil']                = $this->input->post('tgl_diambil_aksesoris',TRUE);
        $data['vendor']                     = $this->input->post('vendor_aksesoris',TRUE);
        $data['biaya']                      = $this->input->post('biaya_aksesoris',TRUE);
        $data['jenis_barang']               = $this->input->post('jenis_barang_aksesoris',TRUE);
        $data['pic']                        = $this->input->post('pic_aksesoris',TRUE);
        $data['berat']                      = $this->input->post('berat_aksesoris',TRUE);
        $data['jumlah']                     = $this->input->post('jumlah_akhir_aksesoris',TRUE);
        $data['kode_produksi']              = $this->input->post('kode_produksi_aksesoris',TRUE);
        
        
        $data['c_gambar']                   = $this->input->post('c_gambar_aksesoris',TRUE);
        $date                               = date('dmY');
        $file_name                          = 'img_'.$date.time().$token;
        $nama_file;

        if($_FILES["c_gambar_aksesoris"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('c_gambar_aksesoris');
        $result_images           = $this->upload->data();
        $nama_file               = $result_images['file_name']; 

        $this->load->library('image_lib');

        /* ini ukuran 300x300 */
         $configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/produk/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/produk/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();

        }else{
            $nama_file = $this->input->post('c_gambar_aksesoris_asli',TRUE);
        }

        $result = $this->aksesoris_model->data_update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    // ================== FINANCE =========================== //
    public function finance_index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('aksesoris/aksesoris_finance_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function finance_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('aksesoris/aksesoris_edit_finance_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function finance_update(){
        
        $data['harga']       = $this->input->post('harga',TRUE);
        $data['id_aksesoris']     = $this->input->post('id_aksesoris',TRUE);
        $result = $this->aksesoris_model->finance_update($data);
        echo json_encode($result);
    }
    
}
