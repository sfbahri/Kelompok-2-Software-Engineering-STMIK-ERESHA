<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webmain extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('login_model');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('cipasswordhash');
        $this->load->model('webmain_model');
        $this->load->helper('captcha');
    }

    public function index()
    {
        $data['webkonten']      = 'home';
        $this->load->view('web/webmain_view',$data);
    }
    
    public function posisi(){
        $data['webkonten']       = 'posisi';
        $data['w_posisi_list'] = $this->webmain_model->posisi()->result_array();
        $this->load->view('web/webmain_view',$data);
    }

    public function apply($id_posisi){
        $data['webkonten']       = 'apply';
        $data['w_posisi_detail'] = $this->webmain_model->posisi_detail($id_posisi)->row_array();
        $this->load->view('web/webmain_view',$data);
    }


    public function simpan(){
  
        //ini kode random untuk token
        $token = "";
        $codeAlphabet = "04994845240019919";
        $codeAlphabet = "23762357263572653";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 
        //ini kode random untuk token
        
        $path = './uploads/files/';    
        
        $data['id_posisi']              = $this->input->post('id_posisi',TRUE);
        $data['nomor_ktp']              = $this->input->post('nomor_ktp',TRUE);
        $data['tempat_lahir']           = $this->input->post('tempat_lahir');
        $data['tgl_lahir']              = $this->input->post('tgl_lahir',TRUE);
        $data['jenis_kelamin']          = $this->input->post('jenis_kelamin',TRUE);
        $data['nomor_hp']               = $this->input->post('nomor_hp',TRUE);
        $data['nama_lengkap']           = $this->input->post('nama_lengkap',TRUE);
        $data['nama_ibu']               = $this->input->post('nama_ibu',TRUE);
        $data['email']                  = $this->input->post('email',TRUE);
        $data['alamat_lengkap']         = $this->input->post('alamat_lengkap',TRUE);


        //PENDIDIKAN
        $data['jenjang_pendidikan']     = $this->input->post('jenjang_pendidikan',TRUE);
        $data['nama_sekolah']           = $this->input->post('nama_sekolah',TRUE);
        $data['fakultas']               = $this->input->post('fakultas',TRUE);
        $data['akreditasi']             = $this->input->post('akreditasi',TRUE);
        $data['ipk']                    = $this->input->post('ipk',TRUE);
        $data['jurusan']                = $this->input->post('jurusan',TRUE);
        $data['tahun_masuk']            = $this->input->post('tahun_masuk',TRUE);
        $data['tahun_keluar']           = $this->input->post('tahun_keluar',TRUE);


        //PERUSAHAAN 1
        $data['nama_perusahaan_1']      = $this->input->post('nama_perusahaan_1',TRUE);
        $data['alamat_perusahaan_1']    = $this->input->post('alamat_perusahaan_1',TRUE);
        $data['posisi_terakhir_1']      = $this->input->post('posisi_terakhir_1',TRUE);
        $data['tahun_masuk_kerja_1']    = $this->input->post('tahun_masuk_kerja_1',TRUE);
        $data['tahun_keluar_kerja_1']   = $this->input->post('tahun_keluar_kerja_1',TRUE);
        $data['gaji_terakhir_kerja_1']  = $this->input->post('gaji_terakhir_kerja_1',TRUE);
        $data['job_pekerjaan_1']        = $this->input->post('job_pekerjaan_1',TRUE);

        //PERUSAHAAN 1
        $data['nama_perusahaan_2']      = $this->input->post('nama_perusahaan_2',TRUE);
        $data['alamat_perusahaan_2']    = $this->input->post('alamat_perusahaan_2',TRUE);
        $data['posisi_terakhir_2']      = $this->input->post('posisi_terakhir_2',TRUE);
        $data['tahun_masuk_kerja_2']    = $this->input->post('tahun_masuk_kerja_2',TRUE);
        $data['tahun_keluar_kerja_2']   = $this->input->post('tahun_keluar_kerja_2',TRUE);
        $data['gaji_terakhir_kerja_2']  = $this->input->post('gaji_terakhir_kerja_2',TRUE);
        $data['job_pekerjaan_2']        = $this->input->post('job_pekerjaan_2',TRUE);

        $data['gambar']      = $this->input->post('file_cv',TRUE);
        $date                = date('dmY');
        $file_name           = 'files_'.$date.time().$token;
        $data['kode']        = $date.$token;
        $nama_file;

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('file_cv');
        $result_files  = $this->upload->data();
        $nama_file = $result_files['file_name']; 

        //$this->load->library('image_lib');

         /* ini ukuran 300x300 */
         /*$configSize1['image_library']   = 'gd2';
         $configSize1['source_image']    = './uploads/files/'.$result_images['file_name'];
         $configSize1['create_thumb']    = FALSE;
         $configSize1['maintain_ratio']  = TRUE;
         $configSize1['width']           = 300;
         $configSize1['height']          = 300;
         $configSize1['new_image']       = './uploads/files/rz_'.$result_images['file_name'];

         $this->image_lib->initialize($configSize1);
         $this->image_lib->resize();
         $this->image_lib->clear();*/
         
         
        $result = $this->webmain_model->simpan($data,$nama_file);
        echo json_encode($result);
        
    }

}
