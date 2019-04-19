<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('users_model');
        $this->load->model('module_model');
        $this->load->library('cipasswordhash');
    }

    public function index(){
       
        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('users/users_view',$data);
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
                $this->load->view('users/users_tambah_view',$data);
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
                $this->load->view('users/users_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function module_permission(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            //$data['modules'] = $this->module_model->get_module_all()->result_array();
            //$data['modules_sub'] = $this->module_model->get_module_all()->result_array();
            $data['modules'] = $this->module_model->get_module_permission_users($id_row)->result_array();
            
            if($result == '1'){
                $this->load->view('users/users_module_permission_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->users_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function data_select(){
        $result = $this->aksesoris_model->data_select()->result_array();
        echo json_encode($result);
    }

    public function detail(){
        $nik   = $this->input->post('nik',TRUE);
        $result = $this->users_model->detail($nik)->row_array();
        echo json_encode($result);
    }

    public function simpan(){

        $key = $this->config->item('encryption_key');

        $data['nama']        = $this->input->post('nama',TRUE);
        $data['username']    = $this->input->post('username',TRUE);
        $data['password']    = $this->cipasswordhash->create_hash($this->input->post('password',TRUE),'$key');
        $data['nohp']        = $this->input->post('nohp',TRUE);
        $data['email']       = $this->input->post('email',TRUE);

        $result = $this->users_model->simpan($data);
        echo json_encode($result);
        
    }
    
    
    public function update(){
       
        $data['nama']       = $this->input->post('nama',TRUE);
        $data['nohp']       = $this->input->post('nohp',TRUE);
        $data['email']      = $this->input->post('email',TRUE);
        $data['id_users']   = $this->input->post('id_users',TRUE);
       
        $result = $this->users_model->update($data);
        echo json_encode($result);
    }
    
    
    public function hapus(){
        $nik   = $this->input->post('nik',TRUE);
        $result = $this->users_model->hapus($id_users);
        echo json_encode($result);
    }

    public function actives(){
        $nik   = $this->input->post('nik',TRUE);
        $id_status   = $this->input->post('id_status',TRUE);
        
        $result = $this->users_model->actives($nik,$id_status);
        echo json_encode($result);
    }
    
    
    
    
    
    
    
    
}
