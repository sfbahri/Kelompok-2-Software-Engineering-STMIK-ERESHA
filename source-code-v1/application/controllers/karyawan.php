<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('karyawan_model');
        $this->load->model('module_model');
        $this->load->library('cipasswordhash');
    }

    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('karyawan/karyawan_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function karyawan_data(){
        $result = $this->karyawan_model->karyawan_data()->result_array();
        echo json_encode($result);
    }
    
    public function karyawan_detail(){
        $nik   = $this->input->post('nik',TRUE);
        $result = $this->karyawan_model->karyawan_detail($nik)->row_array();
        echo json_encode($result);
    }

    public function karyawan_tambah(){
        
            $resultx = $this->karyawan_model->karyawan_get_nik()->row_array();
            $nik_urut = (int) substr($resultx['nik'], 1, 7);
            $nikfix = $nik_urut+1;
            $nikx = sprintf("%08s", $nikfix);
        
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['nik']      = $nikx;
            if($result == '1'){
                $this->load->view('karyawan/karyawan_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function karyawan_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('karyawan/karyawan_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function karyawan_simpan(){
        
        $key = $this->config->item('encryption_key');

        $data['nik']            = $this->input->post('nik',TRUE);
        $data['nama']           = $this->input->post('nama',TRUE);
        $data['inisial']        = $this->input->post('inisial',TRUE);
        $data['tempat_lahir']   = $this->input->post('tempat_lahir',TRUE);
        $data['tgl_lahir']      = $this->input->post('tgl_lahir',TRUE);
        $data['tgl_masuk']      = $this->input->post('tgl_masuk',TRUE);
        $data['email']          = $this->input->post('email',TRUE);
        $data['alamat']         = $this->input->post('alamat',TRUE);
        $data['username']       = $this->input->post('username',TRUE);
        $data['no_hp']          = $this->input->post('no_hp',TRUE);
        $data['no_ktp']         = $this->input->post('no_ktp',TRUE);
        $data['agama']          = $this->input->post('agama',TRUE);
        $data['id_divisi']      = $this->input->post('id_divisi',TRUE);
        $data['id_jabatan']     = $this->input->post('id_jabatan',TRUE);
        $data['id_outlet']      = $this->input->post('id_outlet',TRUE);
        
        $data['id_divisi_sub']  = $this->input->post('id_divisi_sub',TRUE);
        $data['id_jabatan']     = $this->input->post('id_jabatan',TRUE);
        
        
        
        $data['password']    = $this->cipasswordhash->create_hash($this->input->post('password',TRUE),$key);
        
        $result = $this->karyawan_model->karyawan_simpan($data);
        echo json_encode($result);
        
    }

    
    public function karyawan_update(){
        
        $key = $this->config->item('encryption_key');

        $data['nik']         = $this->input->post('nik',TRUE);
        $data['nama']        = $this->input->post('nama',TRUE);
        $data['inisial']     = $this->input->post('inisial',TRUE);
        $data['tempat_lahir']= $this->input->post('tempat_lahir',TRUE);
        $data['tgl_lahir']   = $this->input->post('tgl_lahir',TRUE);
        $data['tgl_masuk']   = $this->input->post('tgl_masuk',TRUE);
        $data['email']       = $this->input->post('email',TRUE);
        $data['alamat']      = $this->input->post('alamat',TRUE);
        $data['username']    = $this->input->post('username',TRUE);
        $data['no_hp']       = $this->input->post('no_hp',TRUE);
        $data['no_ktp']      = $this->input->post('no_ktp',TRUE);
        $data['agama']      = $this->input->post('agama',TRUE);
       
        $data['id_divisi']      = $this->input->post('id_divisi',TRUE);
        $data['id_jabatan']      = $this->input->post('id_jabatan',TRUE);
        $data['id_outlet']      = $this->input->post('id_outlet',TRUE);
        
        
        $result = $this->karyawan_model->karyawan_update($data);
        echo json_encode($result);
        
    }

    
    
}
