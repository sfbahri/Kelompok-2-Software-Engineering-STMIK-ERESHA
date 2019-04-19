<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_baku extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('bahan_baku_model');
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('bahan_baku/bahan_baku_view',$data);
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
                $this->load->view('bahan_baku/bahan_baku_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->bahan_baku_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->bahan_baku_model->data_select()->result_array();
        echo json_encode($result);
    }
    
    public function data_by_kode_produksi(){
        $kode_produksi        = $this->input->post('kode_produksi',TRUE);
        $result = $this->bahan_baku_model->data_by_kode_produksi($kode_produksi)->result_array();
        echo json_encode($result);
    }
    
    public function data_by_kode_produksi2(){
        $kode_produksi        = $this->input->post('kode_produksi',TRUE);
        $result = $this->bahan_baku_model->data_by_kode_produksi2($kode_produksi)->row_array();
        echo json_encode($result);
    }
    
    public function data_detail(){
        $kode_bahan_baku        = $this->input->post('kode_bahan_baku',TRUE);
        $result = $this->bahan_baku_model->data_detail($kode_bahan_baku)->row_array();
        echo json_encode($result);
    }
    
    public function simpan(){
        
        $data['kode']           = $this->input->post('kode',TRUE);
        $data['tanggal']        = $this->input->post('tanggal',TRUE);
       
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
 
        $image_name = $this->input->post('kode',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        
        $data['nama_qrcode'] = $image_name;
        
        $result = $this->bahan_baku_model->simpan($data);
        echo json_encode($result);

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
                $this->load->view('bahan_baku/bahan_baku_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('bahan_baku/bahan_baku_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function update(){
        
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['jenis']       = $this->input->post('jenis',TRUE);
        $data['warna']       = $this->input->post('warna',TRUE);
        $data['no_faktur']   = $this->input->post('no_faktur',TRUE);
        $data['tanggal']     = $this->input->post('tanggal',TRUE);
        $data['jumlah']      = $this->input->post('jumlah',TRUE);
        $data['satuan']      = $this->input->post('satuan',TRUE);
        $data['id_bahan_baku']     = $this->input->post('id_bahan_baku',TRUE);
       
        $result = $this->bahan_baku_model->update($data);
        echo json_encode($result);
        
    }
    
    public function hapus(){

        $id_bahan_baku     = $this->input->post('id_bahan_baku',TRUE);
        $result = $this->bahan_baku_model->hapus($id_bahan_baku);
        echo json_encode($result);
        
    }
    
    
    public function cek_tanggal(){

        $tanggal     = $this->input->post('tanggal',TRUE);
        $result = $this->bahan_baku_model->cek_tanggal($tanggal)->num_rows();
        echo json_encode($result);
        
    }
    
    
    /*========================= BAHAN BAKU DETAIL ==========================*/
    
    public function bahanbaku_detail(){
        $kode_bahanbaku_detail     = $this->input->post('kode_bahanbaku_detail',TRUE);
        $result = $this->bahan_baku_model->bahanbaku_detail($kode_bahanbaku_detail)->row_array();
        echo json_encode($result);
    }


    public function data_bahan_baku_detail(){
        $kode_bahan_baku     = $this->input->post('kode_bahan_baku',TRUE);
        $result = $this->bahan_baku_model->data_bahan_baku_detail($kode_bahan_baku)->result_array();
        echo json_encode($result);
    }
    
    public function simpan_bahan_baku_detail(){
        
        $data['nama']                   = $this->input->post('nama',TRUE);
        $data['jenis']                  = $this->input->post('jenis',TRUE);
        $data['warna']                  = $this->input->post('warna',TRUE);
        $data['no_faktur']              = $this->input->post('no_faktur',TRUE);
        $data['jumlah_rol']             = $this->input->post('jumlah_rol',TRUE);
        $data['jumlah_kilo']            = $this->input->post('jumlah_kilo',TRUE);
        $data['satuan']                 = $this->input->post('satuan',TRUE);
        $data['harga']                  = $this->input->post('harga',TRUE);
        $data['kode_bahan_baku']        = $this->input->post('kode_bahan_baku',TRUE);
        $data['seq']                    = $this->input->post('seq',TRUE);
        $data['kode_bahan_baku_detail'] = $this->input->post('kode_bahan_baku_detail',TRUE);
        
        
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
 
        $image_name = $this->input->post('kode_bahan_baku_detail',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode_bahan_baku_detail',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        
        $data['nama_qrcode'] = $image_name;
        
        
        
        $result = $this->bahan_baku_model->simpan_bahan_baku_detail($data);
        echo json_encode($result);
        
    }
    
    
    public function update_bahan_baku_detail(){
        
        $data['nama']                   = $this->input->post('nama',TRUE);
        $data['jenis']                  = $this->input->post('jenis',TRUE);
        $data['warna']                  = $this->input->post('warna',TRUE);
        $data['no_faktur']              = $this->input->post('no_faktur',TRUE);
        $data['jumlah_rol']             = $this->input->post('jumlah_rol',TRUE);
        $data['jumlah_kilo']            = $this->input->post('jumlah_kilo',TRUE);
        $data['satuan']                 = $this->input->post('satuan',TRUE);
        $data['harga']                  = $this->input->post('harga',TRUE);
        $data['kode']                   = $this->input->post('kode',TRUE);
        
        
        $result = $this->bahan_baku_model->update_bahan_baku_detail($data);
        echo json_encode($result);
        
    }
    
    
    
    
    // ==================================  BAHAN BAKU FINANCE ========================//
    
    public function finance_index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('bahan_baku/bahan_baku_finance_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function finance_detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('bahan_baku/bahan_baku_detail_finance_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function finance_input_harga_bahan_baku(){
        
        $data['kode_bahan_bakau_detail'] = $this->input->post('kode_bahan_bakau_detail',TRUE);
        $data['harga']                   = $this->input->post('harga',TRUE);
        
        $result = $this->bahan_baku_model->finance_input_harga_bahan_baku($data);
        echo json_encode($result);
        
    }
    
    
    
    //PO BAHAN BAKU
    public function bahan_baku_po(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('bahan_baku/bahan_baku_po_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function cek_order_po(){

        $po_bulan     = $this->input->post('po_bulan',TRUE);
        $po_tahun     = $this->input->post('po_tahun',TRUE);
        $result = $this->bahan_baku_model->cek_order_po($po_bulan,$po_tahun)->num_rows();
        echo json_encode($result);
        
    }
    
    
    public function bahan_baku_po_data(){
        $result = $this->bahan_baku_model->bahan_baku_po_data()->result_array();
        echo json_encode($result);
    }
    
    public function bahan_baku_po_simpan(){

        $data['kode']            = $this->input->post('kode',TRUE);
        $data['po_bulan']        = $this->input->post('po_bulan',TRUE);
        $data['po_tahun']        = $this->input->post('po_tahun',TRUE);
       
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
 
        $image_name = $this->input->post('po_bulan',TRUE).$this->input->post('po_tahun',TRUE).$this->input->post('kode',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        
        $data['nama_qrcode'] = $image_name;
        
        $result = $this->bahan_baku_model->bahan_baku_po_simpan($data);
        echo json_encode($result);

    }
    
    
    public function bahan_baku_po_detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('bahan_baku/bahan_baku_po_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function simpan_bahan_baku_detail_po(){
        
        
        $data['nama']                   = $this->input->post('nama',TRUE);
        $data['jenis']                  = $this->input->post('jenis',TRUE);
        $data['warna']                  = $this->input->post('warna',TRUE);
        $data['no_so']                  = $this->input->post('no_so',TRUE);
        $data['nourut']                 = $this->input->post('nourut',TRUE);
        $data['kategoribahan']          = $this->input->post('kategori_bahan',TRUE);
        $data['harga']                  = $this->input->post('harga',TRUE);
        $data['tgl_kirim']              = $this->input->post('tgl_kirim',TRUE);
        $data['jumlah_rol']             = $this->input->post('jumlah_rol',TRUE);
        $data['jumlah_kilo']            = $this->input->post('jumlah_kilo',TRUE);
        $data['satuan']                 = $this->input->post('satuan',TRUE);
        $data['kode_bahan_baku']        = $this->input->post('kode_bahan_baku',TRUE);
        $data['seq']                    = $this->input->post('seq',TRUE);
        $data['kode_bahan_baku_detail'] = $this->input->post('kode_bahan_baku_detail',TRUE);
        
        
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
 
        $image_name = $this->input->post('kode_bahan_baku_detail',TRUE).'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $this->input->post('kode_bahan_baku_detail',TRUE); //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
        
        $data['nama_qrcode'] = $image_name;
        
        
        
        $result = $this->bahan_baku_model->simpan_bahan_baku_detail_po($data);
        echo json_encode($result);
        
    }
    
    
    
    public function update_bahan_baku_detail_po(){
        
        $data['nama']                   = $this->input->post('nama',TRUE);
        $data['jenis']                  = $this->input->post('jenis',TRUE);
        $data['warna']                  = $this->input->post('warna',TRUE);
        $data['no_so']                  = $this->input->post('no_so',TRUE);
        $data['nourut']                 = $this->input->post('nourut',TRUE);
        $data['tgl_kirim']              = $this->input->post('tgl_kirim',TRUE);
        $data['kategoribahan']          = $this->input->post('kategori_bahan',TRUE);
        $data['jumlah_rol']             = $this->input->post('jumlah_rol',TRUE);
        $data['jumlah_kilo']            = $this->input->post('jumlah_kilo',TRUE);
        $data['satuan']                 = $this->input->post('satuan',TRUE);
        $data['harga']                  = $this->input->post('harga',TRUE);
        $data['kode']                   = $this->input->post('kode',TRUE);
        
        
        $result = $this->bahan_baku_model->update_bahan_baku_detail_po($data);
        echo json_encode($result);
        
    }
    
    
    
    
    //BAHAN BAKU BAG.PRODUKSI
    public function bahan_baku_produksi_view(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('bahan_baku/bahan_baku_produksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function bahan_baku_produksi_detail(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            if($result == '1'){
                $this->load->view('bahan_baku/bahan_baku_produksi_detail_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function update_status_bahan_baku_produksi(){

        $kode_bahan_baku     = $this->input->post('kode_bahan_baku_detail',TRUE);
        $result = $this->bahan_baku_model->update_status_bahan_baku_produksi($kode_bahan_baku);
        echo json_encode($result);
        
    }
    
    function update_status_bahan_baku_finance(){
        $kode_bahan_baku     = $this->input->post('kode_bahan_baku_detail',TRUE);
        $result = $this->bahan_baku_model->update_status_bahan_baku_finance($kode_bahan_baku);
        echo json_encode($result);
    }
    
    function update_status_order(){
            $kode_bahan_baku     = $this->input->post('kode_bahan_baku',TRUE);
            $result = $this->bahan_baku_model->update_status_order($kode_bahan_baku);
            echo json_encode($result);
        }
    
}
