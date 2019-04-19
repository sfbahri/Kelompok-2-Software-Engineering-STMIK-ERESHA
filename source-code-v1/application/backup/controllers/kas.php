<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kas extends CI_Controller {
	
    public function __construct(){
        parent::__construct();
        $this->load->model('main_model');
        $this->load->model('kas_model');
    }

    public function kas_sablon(){
        $result = $this->kas_model->kas_sablon()->result_array();
        echo json_encode($result);
    }
    
    public function kas_aksesoris(){
        $result = $this->kas_model->kas_aksesoris()->result_array();
        echo json_encode($result);
    }
    
    public function kas_sewing(){
        $result = $this->kas_model->kas_sewing()->result_array();
        echo json_encode($result);
    }
    
    public function kas_kategori(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_kategori_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
     public function kas_transaksi(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_transaksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function kas_kategori_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('kas/kas_kategori_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function kas_kategori_update_saldo(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']   = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row']   = $id_row;
            if($result == '1'){
                $this->load->view('kas/kas_kategori_update_saldo_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function get_data_kas_transaksi(){
        $tgl_start   = $this->input->post('tgl_start',TRUE);
        $tgl_end     = $this->input->post('tgl_end',TRUE);
        $result = $this->kas_model->get_data_kas_transaksi($tgl_start,$tgl_end)->result_array();
        echo json_encode($result);
    }


    public function kas_data_kategori(){
        $result = $this->kas_model->kas_data_kategori()->result_array();
        echo json_encode($result);
    }
    
    public function kas_kategori_detail(){
        $id_kas_kategori   = $this->input->post('id_kas_kategori',TRUE);
        $result = $this->kas_model->kas_kategori_detail($id_kas_kategori)->row_array();
        echo json_encode($result);
    }
    
    
    public function kas_kategori_simpan(){
        
        $data['id']           = $this->input->post('id',TRUE);
        $data['nama']         = $this->input->post('nama',TRUE);
        $data['saldo_awal']   = $this->input->post('saldo_awal',TRUE);
        $data['tgl_transfer'] = $this->input->post('tgl_transfer',TRUE);
        $data['catatan']      = $this->input->post('catatan',TRUE);

        $result = $this->kas_model->kas_kategori_simpan($data);
        echo json_encode($result);
    }
    
    public function kas_kategori_tambah_saldo(){
        
        $data['id']           = $this->input->post('id',TRUE);
        $data['sisa_saldo']   = $this->input->post('sisa_saldo',TRUE);
        $data['saldo_awal']   = $this->input->post('saldo_awal',TRUE);
        $data['isi_saldo']    = $this->input->post('isi_saldo',TRUE);
        $data['tgl_transfer'] = $this->input->post('tgl_transfer',TRUE);
        $data['catatan']      = $this->input->post('catatan',TRUE);

        $result = $this->kas_model->kas_kategori_tambah_saldo($data);
        echo json_encode($result);
        
    }


    public function max_id(){
        $result = $this->kas_model->max_id()->row_array();
        echo json_encode($result);
    }
    
    
    
    // ================= START KAS KANTOR ============//
    
    public function kas_kantor(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_kantor_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_kantor_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_kantor_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_kantor($data){
        $result = $this->kas_model->get_data_kas_kantor($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS KANTOR ========//
    
    
    
    
    // ================= START KAS DINAS ============//
    
    public function kas_dinas(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_dinas_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_dinas_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_dinas_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_dinas($data){
        $result = $this->kas_model->get_data_kas_dinas($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS DINAS ========//
    
    
    
    
    // ================= START KAS IT ============//
    
    public function kas_it(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_it_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_it_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_it_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_it($data){
        $result = $this->kas_model->get_data_kas_it($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS IT ========//
    
    
    
    
    // ================= START KAS PENGIRIMAN ============//
    
    public function kas_pengiriman(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_pengiriman_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_pengiriman_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_pengiriman_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_pengiriman($data){
        $result = $this->kas_model->get_data_kas_pengiriman($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS PENGIRIMAN ========//
    
    
    
    
    // ================= START KAS PROMOSI ============//
    
    public function kas_promosi(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_promosi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_promosi_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_promosi_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_promosi($data){
        $result = $this->kas_model->get_data_kas_promosi($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS BESAR ========//
    
    
    
    // ================= START KAS MARKETING ============//
    
    public function kas_marketing(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('kas/kas_marketing_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function kas_marketing_simpan(){
        $data['nominal']   = $this->input->post('nominal',TRUE);
        $data['tanggal']   = $this->input->post('tanggal',TRUE);
        $data['catatan']   = $this->input->post('catatan',TRUE);
        $result = $this->kas_model->kas_marketing_simpan($data);
        echo json_encode($result);
    }
    
    
    public function get_data_kas_marketing($data){
        $result = $this->kas_model->get_data_kas_marketing($data)->result_array();
        echo json_encode($result);
    }


    // ================= END KAS MARKETING ========//
    
    
    
    
    public function kas_transaksi_hari_ini(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']   = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row']   = $id_row;
            if($result == '1'){
                $this->load->view('kas/kas_transaksi_hari_ini_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function get_data_kas_hari_ini(){
        $data['id_kas_kategori']   = $this->input->post('id_kas_kategori',TRUE);
        $result = $this->kas_model->get_data_kas_hari_ini($data)->result_array();
        echo json_encode($result);
    }
    
}
