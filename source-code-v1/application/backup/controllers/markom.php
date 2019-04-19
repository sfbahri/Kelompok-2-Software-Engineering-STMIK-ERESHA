<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markom extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('markom_model');
    }

    public function design_gambar_produksi(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    //owner
    public function design_gambar_produksi_owner(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_owner_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function design_gambar_produksi_upload_owner(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_upload_owner_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
    public function design_gambar_produksi_upload_merah_owner(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_upload_merah_owner_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    //owner
    
    //produksi (kepala produksi)
    public function design_gambar_produksi_kp(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_kp_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function design_gambar_produksi_upload_kp(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_upload_kp_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    function data_gambar_produksi_kp(){
        $data['noso']     = $this->input->post('noso',TRUE);
        $result = $this->markom_model->data_gambar_produksi_kp($data)->result_array();
        echo json_encode($result);
    }
    //produksi (kepala produksi)
    
    
    //produksi staff
     public function design_gambar_produksi_stf(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_stf_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function design_gambar_produksi_upload_stf(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_upload_stf_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    function data_gambar_produksi_stf(){
        $data['noso']     = $this->input->post('noso',TRUE);
        $result = $this->markom_model->data_gambar_produksi_stf($data)->result_array();
        echo json_encode($result);
    }
    
    //produksi staf
    
    
    public function design_gambar_produksi_upload(){

        $tokens = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('markom/design_gambar_produksi_upload_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function design_gambar_produksi_tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('markom/design_gambar_produksi_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function design_gambar_produksi_edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_rows  = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_rows'] = $id_rows;
            if($result == '1'){
                $this->load->view('markom/design_gambar_produksi_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function design_gambar_produksi_detail(){
        $data['noso']   = $this->input->post('noso',TRUE);
        $result = $this->markom_model->design_gambar_produksi_detail($data)->row_array();
        echo json_encode($result);
    }


    public function design_gambar_simpan_so(){
        $data['noso']   = $this->input->post('noso',TRUE);
        $data['tema']   = $this->input->post('tema',TRUE);
        $result = $this->markom_model->design_gambar_simpan_so($data);
        echo json_encode($result);
    }
    
    public function design_gambar_update_so(){
        $data['noso']   = $this->input->post('noso',TRUE);
        $data['tema']   = $this->input->post('tema',TRUE);
        $data['id']   = $this->input->post('id',TRUE);
        $result = $this->markom_model->design_gambar_update_so($data);
        echo json_encode($result);
    }
    
    public function cek_no_so(){
        $data['noso']   = $this->input->post('noso',TRUE);
        $result = $this->markom_model->cek_no_so($data)->num_rows();
        echo json_encode($result);
    }
    
    public function design_gambar_data_so(){
        $result = $this->markom_model->design_gambar_data_so()->result_array();
        echo json_encode($result);
    }
    
     public function design_gambar_data_so_detail(){
         $data['noso']   = $this->input->post('noso',TRUE);
        $result = $this->markom_model->design_gambar_data_so_detail($data)->row_array();
        echo json_encode($result);
    }
    
    
    //Untuk proses upload foto
    function proses_upload_media2(){

        
        $nama_file  = $this->input->post('nama_file',TRUE);
        $noso       = $this->input->post('noso',TRUE);

        $config['upload_path']   = getcwd() .'/uploads/produksi/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name']     = $nama_file;
        $this->load->library('upload',$config);
        
        /* start : resize images */
//        $config2['image_library']    = 'gd2';
//        $config2['source_image']     = './uploads/produksi/'.$nama_file;
//        $config2['file_name']        = 'rz_'.$nama_file;
//        $config2['create_thumb']     = TRUE;
//        $config2['maintain_ratio']   = TRUE;
//        $config2['width']            = 150;
//        $config2['height']           = 150;
//        $this->image_lib->clear();
//        $this->load->library('image_lib', $config2);
//        $this->image_lib->resize();
        /* end : resize images */
        
        if($this->upload->do_upload('userfile')){
            $d = $this->upload->data('file_name');
            $data['path']       = 'uploads/produksi/'.$d['file_name'].'';
            $data['gambar']     = $d['file_name'];
            
            /* start : resize images */
            $config2['image_library']    = 'gd2';
            $config2['source_image']     = './uploads/produksi/'.$data['gambar'];
            $config2['file_name']        = 'rz_'.$data['gambar'];
            $config2['create_thumb']     = FALSE;
            $config2['maintain_ratio']   = TRUE;
            $config2['width']            = 150;
            $config2['height']           = 150;
            $config2['new_image']        = './uploads/produksi/rz_'.$data['gambar'];
            
            $this->load->library('image_lib', $config2);
            $this->image_lib->resize();
            /* end : resize images */
            
            
            /*token kode*/
            $token = "";
            $codeAlphabet = "33434343556789934343434567812345667980909";
            $codeAlphabet.= "54979319491320389885589989898989867733333";
            $codeAlphabet.= "0123456789";
            $codeAlphabet.= "4535345345345345";
            $codeAlphabet.= "748274928746974687486347354653473483764837";

            $max = strlen($codeAlphabet) - 1;
            for ($i=0; $i < 5; $i++) {
                $token .= $codeAlphabet[mt_rand(0, $max)];
            } 

            $today = date("Ymd");
            $data['img_kode'] = $today.$token;
            $data['noso'] = $noso;
            
            
            $this->markom_model->proses_upload_media2($data);
        }
    }
    
    function data_gambar_produksi_admin(){
        $data['noso']     = $this->input->post('noso',TRUE);
        $result = $this->markom_model->data_gambar_produksi_admin($data)->result_array();
        echo json_encode($result);
    }
    
    function data_gambar_produksi_owner(){
        $data['noso']     = $this->input->post('noso',TRUE);
        $result = $this->markom_model->data_gambar_produksi_owner($data)->result_array();
        echo json_encode($result);
    }
    
    function gambar_hapus(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->markom_model->gambar_hapus($data);
        echo json_encode($result);
    }
    
    function gambar_approve(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->markom_model->gambar_approve($data);
        echo json_encode($result);
    }
    
    function gambar_approve_kp(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->markom_model->gambar_approve_kp($data);
        echo json_encode($result);
    }
    
    function gambar_approve_stf(){
        $data['id']     = $this->input->post('id',TRUE);
        $result = $this->markom_model->gambar_approve_stf($data);
        echo json_encode($result);
    }
    
    function gambar_nama(){
        $data['id']             = $this->input->post('id',TRUE);
        $data['nama_gambar']    = $this->input->post('nama_gambar',TRUE);
        $result = $this->markom_model->gambar_nama($data);
        echo json_encode($result);
    }
    
    function gambar_catatan(){
        $data['id']             = $this->input->post('id',TRUE);
        $data['img_catatan']    = $this->input->post('img_catatan',TRUE);
        $result = $this->markom_model->gambar_catatan($data);
        echo json_encode($result);
    }
    
    function gambar_catatan_view(){
        $tokens   = $this->input->post('tokens',TRUE);
        $id_modal = $this->input->post('id_modal',TRUE);
        $id_row = $this->input->post('id_row',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_modal'] = $id_modal;
        $data['id_row'] = $id_row;
        if($result == '1'){
            $this->load->view('markom/design_gambar_catatan_gambar_list_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }
    }
    
    function upload_ulang_img(){
        $tokens   = $this->input->post('tokens',TRUE);
        $id_modal = $this->input->post('id_modal',TRUE);
        $id_row = $this->input->post('id_row',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_modal'] = $id_modal;
        $data['id_row'] = $id_row;
        if($result == '1'){
            $this->load->view('markom/design_gambar_upload_ulang_img_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }
    }
    
    
    function gambar_details(){
        $data['kodegambar']     = $this->input->post('kodegambar',TRUE);
        $result = $this->markom_model->gambar_details($data)->row_array();
        echo json_encode($result);
    }
    
    function gambar_catatan_list(){
        $data['idgambar']     = $this->input->post('idgambar',TRUE);
        $result = $this->markom_model->gambar_catatan_list($data)->result_array();
        echo json_encode($result);
    }
    
    
    public function gambar_design_update(){
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
        
        $data['idgambar']           = $this->input->post('idgambar',TRUE);
        $data['gambar_asli_design'] = $this->input->post('gambar_asli_design',TRUE);
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
            $nama_file = $this->input->post('gambar_asli_design',TRUE);
        }

        $result = $this->markom_model->gambar_design_update($data,$nama_file);
        echo json_encode($result);
    }
    
    
    
    function select_noso_gambar(){
        $result = $this->markom_model->select_noso_gambar()->result_array();
        echo json_encode($result);
    }
    
}
