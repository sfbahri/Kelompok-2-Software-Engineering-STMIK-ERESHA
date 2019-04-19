<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('role_model');
        $this->load->model('module_model');
        
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('role/role_view',$data);
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
                $this->load->view('module/module_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    public function permission(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens']     = $tokens;
            $data['id_modal']   = $id_modal;
            $data['id_row']     = $id_row;
            
            $data['modules'] = $this->module_model->get_module_permission_users($id_row)->result_array();
            
            if($result == '1'){
                $this->load->view('role/role_permission_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function data(){
        $result = $this->role_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function simpan(){
        $data['nama']    = $this->input->post('nama',TRUE);
        $result = $this->role_model->simpan($data);
        echo json_encode($result);
    }
    
    public function detail(){
        
        $data['id_role']    = $this->input->post('id_role',TRUE);
        $result = $this->role_model->detail($data)->row_array();
        echo json_encode($result);
    }
    
    public function role_akses_update(){
       
        $data['idrole']    = $this->input->post('idrole',TRUE);
        $data['cbx_module'] = $this->input->post('cbx_module',TRUE);
        
        $result = $this->role_model->role_akses_update($data);
        echo json_encode($result);
    }
    
    
    //module sub
    public function module_sub_simpan(){
        
        $data['nama']               = $this->input->post('nama',TRUE);
        $data['nama_controller']    = $this->input->post('nama_controller',TRUE);
        $data['id_module']          = $this->input->post('id_module',TRUE);
        
        $result = $this->module_model->module_sub_simpan($data);
        echo json_encode($result);
        
    }
    
    function data_module_sub(){
        
        $data['id_module']          = $this->input->post('id_module',TRUE);
        
        $result = $this->module_model->data_module_sub($data)->result_array();
        echo json_encode($result);
    }
    
    function module_sub_update(){
        
        
        $data['nama']               = $this->input->post('nama',TRUE);
        $data['nama_controller']    = $this->input->post('nama_controller',TRUE);
        $data['id_module_sub']          = $this->input->post('id_module_sub',TRUE);
        
        $result = $this->module_model->module_sub_update($data);
        echo json_encode($result);
        
    }
    
    
    function module_sub_hapus(){
        
        $data['id_module_sub']      = $this->input->post('id_module_sub',TRUE);
        
        $result = $this->module_model->module_sub_hapus($data);
        echo json_encode($result);
        
    }
    
    public function update_users_akses(){
       
        $data['idusers']    = $this->input->post('idusers',TRUE);
        $data['cbx_module'] = $this->input->post('cbx_module',TRUE);
        
        $result = $this->module_model->update_users_akses($data);
        echo json_encode($result);
    }
    
    
}
