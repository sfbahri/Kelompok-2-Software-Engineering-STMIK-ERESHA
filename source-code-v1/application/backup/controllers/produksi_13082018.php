<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('produksi_model');
        $this->load->model('produk_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('produksi/produksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    public function print_label($kode){
            $this->load->library('mpdf/mpdf');

            $labels = $this->produk_model->data_produk($kode)->result_array();
            //$result = $this->order_model->data_laporan($data)->result_array();

            $i = 0;
            $base_url = base_url();
            $html = '<table border="0" style="border: 1px solid black;border-collapse: collapse;" ><tr style="border: 1px solid black;">';
                        foreach($labels as $item){
                            $i++;
                            $html .='<td style="border: 1px solid black;"><img src="'.$base_url.'uploads/qrcode/'.$item['img_qrcode'].'" style="width:150px;height:150px"><br><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:13px">'.$item['kode'].'</span></b></td>';
                            if($i == 4) { // three items in a row. Edit this to get more or less items on a row
                                $html .='</tr><tr>';
                                $i = 0;
                            }
                        }
                     $html .='</tr></table>';


            //$html = $this->load->view('produksi/produksi_print_label_view',$data);
            //$mpdf = new mPDF('utf-8', array(95,122.27),'0');         
            $mpdf = new mPDF('utf-8', array(95,140), 8, '', '', '', '', '', '', '');
            $mpdf->WriteHTML($html,2);
            $mpdf->Output();

    }
    
    public function produksi_finance(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('produksi/produksi_finance_view',$data);
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
                $this->load->view('produksi/produksi_tambah_view',$data);
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
                $this->load->view('produksi/produksi_tambah_manual_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $id_row2 = $this->input->post('id_row2',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            $data['id_row2'] = $id_row2;
            if($result == '1'){
                $this->load->view('produksi/produksi_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function input_harga(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $id_row2 = $this->input->post('id_row2',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            $data['id_row2'] = $id_row2;
            if($result == '1'){
                $this->load->view('produksi/produksi_input_harga_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function data(){
        $result = $this->produksi_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_produksi_finance(){
        $result = $this->produksi_model->data_produksi_finance()->result_array();
        echo json_encode($result);
    }
    
    public function data_produksi_sudah_publish(){
        $result = $this->produksi_model->data_produksi_sudah_publish()->result_array();
        echo json_encode($result);
    }

    public function data_produksi_produk(){
        $result = $this->produksi_model->data_produksi_produk()->result_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_produksi     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->data_detail($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    public function get_jumlah_akhir(){
        $kode_produksi     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->get_jumlah_akhir($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    public function update_harga(){
        $harga_jual      = $this->input->post('harga_jual',TRUE);
        $harga_modal     = $this->input->post('harga_modal',TRUE);
        $kode_produksi   = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->update_harga($harga_jual,$harga_modal,$kode_produksi);
        echo json_encode($result);
    }
    
    public function created_label(){
        $jumlah             = $this->input->post('jum_label',TRUE);
        $kode_produksi      = $this->input->post('kode_produksi',TRUE);
        $harga_jual         = $this->input->post('harga_jual',TRUE);
        
        for ($x = 0; $x <= $jumlah; $x++) {
            
            $no = $x + 1;
            $kode_produksi_produk = $kode_produksi.$no;
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
            $this->produksi_model->created_label($img_qrcode,$harga_jual,$kode_produksi,$kode_produksi_produk);
 
        } 
        
        $result = $this->produksi_model->update_stok($kode_produksi,$jumlah);
        echo json_encode($result);
        
    }
    
    public function hapus(){
        $kode_produksi     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->hapus($kode_produksi);
        echo json_encode($result);
    }
    
    public function update_status(){
        $kode_produksi      = $this->input->post('kode_produksi',TRUE);
        $status             = $this->input->post('status',TRUE);
        $result = $this->produksi_model->update_status($kode_produksi,$status);
        echo json_encode($result);
    }

    public function data_produksi_detail(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
       
        $result = $this->produksi_model->data_produksi_detail($data)->result_array();
        echo json_encode($result);
    }
    
    public function simpan(){
  
        //ini kode random untuk token
            $tokensss = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $tokensss .= $codeAlphabet[mt_rand(0, $max)];
            } 
        //ini kode random untuk token
        
        
        $data['kode']              = $this->input->post('kode',TRUE);
        $data['nama']              = $this->input->post('nama',TRUE);
        $data['gambar']            = $this->input->post('gambar',TRUE);
        $data['estimasi_produk']   = $this->input->post('estimasi_produk',TRUE);
        $data['tanggal_mulai']     = $this->input->post('tanggal_mulai',TRUE);
        /*bahanbaku*/
        $data['bahan_baku_id']          = $this->input->post('bahan_baku_id',TRUE);
        $data['jumlah_rol_bahan_baku']  = $this->input->post('jumlah_rol_bahan_baku',TRUE);
        $data['jumlah_kilo_bahan_baku'] = $this->input->post('jumlah_kilo_bahan_baku',TRUE);
        $data['rows_bahanbaku']         = $this->input->post('rows_bahanbaku',TRUE);
        $data['harga_bahan_baku']       = $this->input->post('harga_bahan_baku',TRUE);
        /*aksesoris*/
        $data['aksesoris_id']      = $this->input->post('aksesoris_id',TRUE);
        $data['jumlah_aksesoris']  = $this->input->post('jumlah_aksesoris',TRUE);
        $data['rows_aksesoris']    = $this->input->post('rows_aksesoris',TRUE);
        $data['harga_aksesoris']   = $this->input->post('harga_aksesoris',TRUE);
        /*Estimasi Biaya*/
        $data['biaya_cutting']     = $this->input->post('biaya_cutting',TRUE);
        $data['biaya_sewing']      = $this->input->post('biaya_sewing',TRUE);
        $data['biaya_sablon']      = $this->input->post('biaya_sablon',TRUE);
        
        //gambar produksi 
        $data['id_gambar']         = $this->input->post('id_gambar',TRUE);
        $data['path_gambar']       = $this->input->post('path_gambar',TRUE);

        
        /* Start : Gambar */
//        $date                = date('dmY');
//        $file_name           = 'img_'.$date.time().$tokensss;
//        $nama_file;
//
//        $config['upload_path']   = './uploads/produk/';
//        $config['allowed_types'] = 'jpg|jpeg|png';
//        $config['max_size']      = '6048';
//        $config['file_name']     = $file_name;
//        $this->load->library('upload',$config);
//        $this->upload->do_upload('gambar');
//        $result_images  = $this->upload->data();
//        $nama_file = $result_images['file_name']; 
//
//        $this->load->library('image_lib');
//
//         /* ini ukuran 300x300 */
//         $configSize1['image_library']   = 'gd2';
//         $configSize1['source_image']    = './uploads/produk/'.$result_images['file_name'];
//         $configSize1['create_thumb']    = FALSE;
//         $configSize1['maintain_ratio']  = TRUE;
//         $configSize1['width']           = 300;
//         $configSize1['height']          = 300;
//         $configSize1['new_image']       = './uploads/produk/rz_'.$result_images['file_name'];
//
//         $this->image_lib->initialize($configSize1);
//         $this->image_lib->resize();
//         $this->image_lib->clear();
//        
        /* End Gambar */
        
        
        
        
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
 
        $image_name = $this->input->post('kode',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data['img_qrcode'] = $image_name;
        /*End Qr Code*/
        
        
        
        $result = $this->produksi_model->simpan($data);
        echo json_encode($result);
        
    }
    
    
    public function simpan_manual(){
  
        //ini kode random untuk token
            $tokensss = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $tokensss .= $codeAlphabet[mt_rand(0, $max)];
            } 
        //ini kode random untuk token
        
        
        $data['kode']               = $this->input->post('kode',TRUE);
        $data['nama']               = $this->input->post('nama',TRUE);
        $data['tanggal_mulai']      = $this->input->post('tanggal_mulai',TRUE);
        $data['harga_modal']        = $this->input->post('harga_modal',TRUE);
        $data['harga_jual']         = $this->input->post('harga_jual',TRUE);
       
        
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
 
        $image_name = $this->input->post('kode',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        $data['img_qrcode'] = $image_name;
        /*End Qr Code*/
        
        
        
        $result = $this->produksi_model->simpan_manual($data);
        echo json_encode($result);
        
    }
    
    //Untuk proses upload gambar
    public function proses_upload_media(){
        
        
        $token = "";
        $codeAlphabet = "33434343556789934343434567812345667980909";
        $codeAlphabet.= "54979319491320389885589989898989867733333";
        $codeAlphabet.= "0123456789";

        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 

        $today = date("Ymd");
        $kode_produksi_detail = $token.$today;
        
        
        $nama_file      = $this->input->post('nama_file',TRUE);
        $kode_produksi  = $this->input->post('kode_produksi',TRUE);
        
        
        
        $config['upload_path']   = "./uploads/produk/";
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name']     = $nama_file;
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
            
            //qr_code
            $this->load->library('ciqrcode'); //pemanggilan library QR CODE
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './uploads/'; //string, the default is application/cache/
            $config['errorlog']     = './uploads/'; //string, the default is application/logs/
            $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(70,130,180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name             = $kode_produksi_detail.'.png'; //buat name dari qr code sesuai dengan nim

            $params['data']         = $kode_produksi_detail; //data yang akan di jadikan QR CODE
            $params['level']        = 'H'; //H=High
            $params['size']         = 10;
            $params['savename']     = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            //qr_code
            
            
            $d = $this->upload->data('file_name');
            $data['nama_file']              = $nama_file;
            $data['path']  = "uploads/produk/".$nama_file."";
            $data['kode_produksi']          = $kode_produksi;
            $data['kode_produksi_detail']   = $kode_produksi_detail;
            $data['nama_qrcode']            = $image_name;
            $res = $this->produksi_model->proses_upload_media($data);
            echo json_encode($res);
        }
    }
    
    public function data_produksi_detail_by_id(){
        $id_produksi_detail          = $this->input->post('id_produksi_detail',TRUE);
        
        $res = $this->produksi_model->data_produksi_detail_by_id($id_produksi_detail)->row_array();
        echo json_encode($res);
    }
    
    public function publish(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->publish($data);
        echo json_encode($result);
    }
    
    
    //UPLOAD GAMBAR DROPZONE
    
    public function gambar_table(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('produksi/produksi_gambar_table_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    function data_gambar_produksi_produksi(){
        $result = $this->produksi_model->data_gambar_produksi_produksi()->result_array();
        echo json_encode($result);
    }
    
    
    
    public function gambar_detail(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->produksi_model->gambar_detail($data)->row_array();
        echo json_encode($result);
    }
    
    
    
    function get_all_biaya(){
        $kode_produksi     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->get_all_biaya($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    
    
    
    //detail preview produksi
    //rinci produksi yang sedang berjalan//
    public function rinci(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $id_row2 = $this->input->post('id_row2',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            $data['id_row2'] = $id_row2;
            if($result == '1'){
                $this->load->view('produksi/produksi_rinci_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    public function data_rinci_cutting(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->rinci_cutting($data)->row_array();
        echo json_encode($result);
    }
    public function data_rinci_sablon(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->rinci_sablon($data)->row_array();
        echo json_encode($result);
    }
    public function data_rinci_aksesoris(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->rinci_aksesoris($data)->row_array();
        echo json_encode($result);
    }
    public function data_rinci_sewing(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->rinci_sewing($data)->row_array();
        echo json_encode($result);
    }
    public function data_rinci_finishing(){
        $data['kode_produksi']     = $this->input->post('kode_produksi',TRUE);
        $result = $this->produksi_model->rinci_finishing($data)->row_array();
        echo json_encode($result);
    }
    
    
    
}
