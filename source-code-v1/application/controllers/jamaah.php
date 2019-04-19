<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jamaah extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('jamaah_model');
        $this->load->model('kloter_model');
        $this->load->library('cipasswordhash');
        
    }

    public function by_kloter(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('jamaah/jamaah_by_kloter_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data_by_kloter(){
        $id_kloter   = $this->input->post('id_kloter',TRUE);
        $result = $this->jamaah_model->data_by_kloter($id_kloter)->result_array();
        echo json_encode($result);
    }
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('jamaah/jamaah_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function edit(){
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
                $this->load->view('jamaah/jamaah_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function dokumen(){
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
                $this->load->view('jamaah/jamaah_dokumen_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    
    
    public function detail(){
        $id_jamaah = $this->input->post('id_jamaah',TRUE);
        $result = $this->jamaah_model->detail($id_jamaah)->row_array();
        echo json_encode($result);
    }
    
    public function simpan(){
        
        $today = date("ymd");
        $key = $this->config->item('encryption_key');
        
        //ini kode random untuk token
        $token = "";
        $codeAlphabet    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet   .= "NVZXCMAMNBZMNBKJASMNBXMVNB";
        $codeAlphabet   .= "MNBXKJHSGASDFDGGHFLKJHGRET";
        $codeAlphabet   .= "NVZXCMAMNBZMNBKJASMNBXMVNB";
        $codeAlphabet   .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 2; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 
        
        
        //ini kode random untuk token
        $token4 = "";
        $codeAlphabet4    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet4   .= "UYTQWEKJHWEMNBMNQWUEIUQWEL";
        $codeAlphabet4   .= "0123456789";
        $max4 = strlen($codeAlphabet4) - 1;
        for ($i=0; $i < 1; $i++) {
            $token4 .= $codeAlphabet4[mt_rand(0, $max4)];
        } 
        
        
        //ini kode random untuk paspor
        $token2 = "";
        $codeAlphabet1    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet1   .= "HSDJHGJHDGFJTIUYDFXMCNVKWM";
        $codeAlphabet1   .= "IWENNBHGJHIUYYJDFKJHSDFKJH";
        $codeAlphabet1   .= "KJSDHFUEWIRMNBWERWETRIUIUY";
        $codeAlphabet1   .= "UYTWERQPOUWEIUYQMNBWQEITQU";
        $codeAlphabet1   .= "NVZXCMAMNBZMNBKJASMNBXMVNB";
        $codeAlphabet1   .= "0123456789";
        $max1 = strlen($codeAlphabet1) - 1;
        for ($i=0; $i < 5; $i++) {
            $token2 .= $codeAlphabet1[mt_rand(0, $max1)];
        } 
        
        $tok = $today.$this->input->post('id_kloter',TRUE).$token.$token4;
        //ini kode random untuk token
        
        
        $data['nama']            = $this->input->post('nama',TRUE);
        $data['no_paspor']       = $this->input->post('no_paspor',TRUE);
        $data['email']           = $this->input->post('email',TRUE);
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $tok;
        $data['password']        = $this->cipasswordhash->create_hash($token2,$key);
        
        
        $result = $this->jamaah_model->simpan($data);
        
        if($result == true){
            $this->load->library('MY_PHPMailer');
            $mail = new PHPMailer();
            $mail->IsSMTP();                       // set mailer to use SMTP
            $mail->Host     = "sgx4.cloudhost.id";  // specify main and backup server
            $mail->SMTPAuth = TRUE;     // turn off SMTP authentication
            $mail->Username = "hello@codelabasia.com";  // SMTP username
            $mail->Password = "@password2017"; // SMTP password

            $mail->From = "noreply@umrohtiketmurah.com";
            $mail->FromName = 'UTM - UMROHTIKETMURAH.COM';
            $mail->AddAddress($this->input->post('email',TRUE));
            $mail->IsHTML(true);  
            $mail->Subject = "Pendaftaran Akun UTM";

            $mail->Body = '<table cellpadding="0" cellspacing="0" style="border:1px #dceaf5 solid;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr><td colspan="3" height="52"></td></tr>';
            $mail->Body .= '<tr style="line-height:0px;" id="">';
            $mail->Body .= '<td width="100%" style="font-size:0px;" align="center" height="1" id="">';
            $mail->Body .= '</td></tr>';
            $mail->Body .= '<tr id=""><td id="">';
            $mail->Body .= '<table cellpadding="0" cellspacing="0" style="line-height:25px;" border="0" align="center" id="">';
           $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr id=""><td width="36"></td>';
            $mail->Body .= '<td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:\'Open Sans\', \'Lucida Grande\', \'Segoe UI\', Arial, Verdana, \'Lucida Sans Unicode\', Tahoma, \'Sans Serif\';max-width:454px;" valign="top" id="">Yth Bpk/Ibu , <strong>'.$this->input->post('nama',TRUE).'</strong><br><br>';
            $mail->Body .= 'Berikut adalah akun CMS UTM : <br> ';
            $mail->Body .= 'Kode Jamaah : <b>'.$tok.'</b><br> ';
            $mail->Body .= 'Nama Lengkap : '.$this->input->post('nama',TRUE).'<br> ';
            $mail->Body .= 'Tanggal Lahir : '.$this->input->post('tgl_lahir',TRUE).'<br> ';
            $mail->Body .= '<hr>';
           $mail->Body .= 'Username : '.$tok.'<br> ';
            $mail->Body .= 'Password : '.$token2.'<br> ';
            $mail->Body .= '<br><br> Silahkan login : <a href='.base_url('login').'>Login</a> <br><br></td><td width="36" id=""></td></tr>';
            $mail->Body .= '</table></td></tr></tbody></table><br> "Informasi Penting :

Kepada seluruh jamaah UTM , Agar tetap berhati-hati terhadap penelpon,pesan whatsapp,atau email yang mengatasnamakan UTM / UMROHTIKETMURAH.COM,yang memanfaatkan untuk kepentingan pribadi.
Jika ada merasa keraguan, harap hubungi admin UTM untuk memastikan kebenaran informasi yang di terima.
Terima Kasih" <br>';

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $mail->send();
                //echo "Message sent!";
            }
        }
        
        
        echo json_encode($result);
        
    }
    
    public function update(){
        
        $klt = $this->input->post('idkloter',TRUE);
        $directory_name = 'kloter_'.$klt;
        $namakloter     = 'kloter_'.$klt;
        if (!is_dir('uploads/files/'.$directory_name)) {
            mkdir('./uploads/files/' . $namakloter, 0777, TRUE);
        }
        
        $path = './uploads/files/'.$namakloter.'/';
        

        $data['kode_jamaah']            = $this->input->post('kode_jamaah',TRUE);
        $data['nama']                   = $this->input->post('nama',TRUE);
        $data['nama_paspor']            = $this->input->post('nama_paspor',TRUE);
        $data['tgl_lahir']              = $this->input->post('tgl_lahir',TRUE);
        $data['no_ktp']                 = $this->input->post('no_ktp',TRUE);
        $data['agama']                  = $this->input->post('agama',TRUE);
        $data['email']                  = $this->input->post('email',TRUE);
        $data['pendidikan']             = $this->input->post('pendidikan',TRUE);
        $data['warga_negara']           = $this->input->post('warga_negara',TRUE);
        $data['tgl_exp_paspor']         = $this->input->post('tgl_exp_paspor',TRUE);
        $data['nama_ayah']              = $this->input->post('nama_ayah',TRUE);
        $data['nama_kakek']             = $this->input->post('nama_kakek',TRUE);
        $data['no_paspor']              = $this->input->post('no_paspor',TRUE);
        $data['tempat_lahir']           = $this->input->post('tempat_lahir',TRUE);
        $data['jenis_kelamin']          = $this->input->post('jenis_kelamin',TRUE);
        $data['no_kk']                  = $this->input->post('no_kk',TRUE);
        $data['status']                 = $this->input->post('status',TRUE);
        $data['no_hp']                  = $this->input->post('no_hp',TRUE);
        $data['pekerjaan']              = $this->input->post('pekerjaan',TRUE);
        $data['tgl_keluar_paspor']      = $this->input->post('tgl_keluar_paspor',TRUE);
        $data['kota_penerbit_paspor']   = $this->input->post('kota_penerbit_paspor',TRUE);
        $data['nama_ibu']               = $this->input->post('nama_ibu',TRUE);
        $data['berangkat_dengan_siapa'] = $this->input->post('berangkat_dengan_siapa',TRUE);
        $data['kota_asal']              = $this->input->post('kota_asal',TRUE);
        $data['alamat']                 = $this->input->post('alamat',TRUE);
        $data['alamat_koper']           = $this->input->post('alamat_koper',TRUE);
        $data['kamar']                  = $this->input->post('kamar',TRUE);
        $data['ambil_koper']            = $this->input->post('ambil_koper',TRUE);
        
        
        $data['gambar']      = $this->input->post('gambar',TRUE);
        $date                = date('dmY');
        $file_name           = $date.time().'_'.$this->input->post('kode_jamaah',TRUE);
        //data['img_foto']    = $nama_file;  
        
        
        if($_FILES["gambar"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name;
        $this->load->library('upload',$config);
        $this->upload->do_upload('gambar');
        $result_images1           = $this->upload->data();
        $data['img_foto']        = $result_images1['file_name']; 

        
//        $this->load->library('image_lib');
//        
//        /* ini ukuran 300x300 */
//         $configSize1['image_library']   = 'gd2';
//         $configSize1['source_image']    = $path.$result_images['file_name'];
//         $configSize1['create_thumb']    = FALSE;
//         $configSize1['maintain_ratio']  = TRUE;
//         $configSize1['width']           = 300;
//         $configSize1['height']          = 300;
//         $configSize1['new_image']       = $path.'rz_'.$result_images['file_name'];
//
//         $this->image_lib->initialize($configSize1);
//         $this->image_lib->resize();
//         $this->image_lib->clear();

        }else{
            $data['img_foto'] = $this->input->post('foto_asli',TRUE);
        }

        
        /*
         * START
         * UPLOAD PERNYATAAN SIPATUH
         */
        
        $data['dok_surat_pernyataan']      = $this->input->post('dok_surat_pernyataan',TRUE);
        $date2                = date('dmY');
        $file_name2           = $date2.time().'_surat_pernyataan_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_surat_pernyataan"]['name'] !=''){

        $config2['upload_path']   = $path;
        $config2['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config2['max_size']      = '6048';
        $config2['file_name']     = $file_name2;
        $this->load->library('upload',$config2);
        $this->upload->do_upload('dok_surat_pernyataan');
        $result_images2                  = $this->upload->data();
        $data['dok_surat_pernyataan']   = $result_images2['file_name']; 

        }else{
            $data['dok_surat_pernyataan'] = $this->input->post('dok_surat_pernyataan_asli',TRUE);
        }
        
        /*
         * END
         * UPLOAD PERNYATAAN SIPATUH
         */
        
        
        /*
         * START
         * UPLOAD PASPOR
         */
        
        $data['dok_paspor']   = $this->input->post('dok_paspor',TRUE);
        $date3                = date('dmY');
        $file_name3           = $date3.time().'_paspor_'.$this->input->post('kode_jamaah',TRUE);
         
        if($_FILES["dok_paspor"]['name'] !=''){

        $config3['upload_path']   = $path;
        $config3['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config3['max_size']      = '6048';
        $config3['file_name']     = $file_name3;
        $this->load->library('upload',$config3);
        $this->upload->do_upload('dok_paspor');
        $result_images3            = $this->upload->data();
        $data['dok_paspor']       = $result_images3['file_name']; 

        }else{
            $data['dok_paspor'] = $this->input->post('dok_paspor_asli',TRUE);
        }
        
        /*
         * END
         * UPLOAD PASPOR
         */
        
        
        /*
         * START
         * UPLOAD KTP
         */
        
        $data['dok_ktp']   = $this->input->post('dok_ktp',TRUE);
        $date4                = date('dmY');
        $file_name4           = $date4.time().'_ktp_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_ktp"]['name'] !=''){

        $config4['upload_path']   = $path;
        $config4['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config4['max_size']      = '6048';
        $config4['file_name']     = $file_name4;
        $this->load->library('upload',$config3);
        $this->upload->do_upload('dok_ktp');
        $result_images4    = $this->upload->data();
        $data['dok_ktp']  = $result_images4['file_name']; 

        }else{
            $data['dok_ktp'] = $this->input->post('dok_ktp_asli',TRUE);
        }
        
        /*
         * END
         * UPLOAD KTP
         */
        
        
        
        /*
         * START
         * UPLOAD KK
         */
        
        $data['dok_kk']       = $this->input->post('dok_kk',TRUE);
        $date5                = date('dmY');
        $file_name5           = $date5.time().'_kk_'.$this->input->post('kode_jamaah',TRUE);
             
        if($_FILES["dok_kk"]['name'] !=''){

        $config5['upload_path']   = $path;
        $config5['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config5['max_size']      = '6048';
        $config5['file_name']     = $file_name5;
        $this->load->library('upload',$config5);
        $this->upload->do_upload('dok_kk');
        $result_images5           = $this->upload->data();
        $data['dok_kk']           = $result_images5['file_name']; 

        }else{
            $data['dok_kk'] = $this->input->post('dok_kk_asli',TRUE);
        }
        
        /*
         * END
         * UPLOAD KK
         */
        
        
        $result = $this->jamaah_model->update($data);
        echo json_encode($result);
    }
    
    
    public function biodata(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('jamaah/jamaah_biodata_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function dokumen_list(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('jamaah/jamaah_dokumen_list_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function biodata_pdf($kode_jamaah){
        
        
        $data['detail'] = $this->jamaah_model->detail($kode_jamaah)->row_array();
        
        $nama_dokumen = 'Jamaah_UTM_'.$data['nama'].'_'.$kode_jamaah;
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        //$result['datapiutang'] = $this->piutang_model->data()->result_array();
      
        $mpdf=new mPDF('utf-8', 'A4-P');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('jamaah/jamaah_biodata_pdf_view',$data);
        
        
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        
        $mpdf->SetWatermarkImage('./assets/img/logo_meta_2.jpg');
        $mpdf->showWatermarkImage = true;
        
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    public function biodata_detail(){
        $result = $this->jamaah_model->biodata_detail()->row_array();
        echo json_encode($result);
    }
    
    
    public function reset(){
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
                $this->load->view('jamaah/jamaah_reset_emailpass_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    function jambu(){
        
        $key = $this->config->item('encryption_key');
        
        echo $this->cipasswordhash->create_hash('YXKWB',$key);
        
    }
    
    public function reset_aksi(){
        
        $key = $this->config->item('encryption_key');
        
        //ini kode random untuk paspor
        $token2 = "";
        $codeAlphabet1    = "ABCDEF";
        $codeAlphabet1   .= "0123456789";
        $max1 = strlen($codeAlphabet1) - 1;
        for ($i=0; $i < 5; $i++) {
            $token2 .= $codeAlphabet1[mt_rand(0, $max1)];
        } 
        
        $data['kode_jamaah']            = $this->input->post('kode_jamaah',TRUE);
        $data['email']                  = $this->input->post('email',TRUE);
        $data['id_kloter']              = $this->input->post('id_klter',TRUE);
        $data['no_paspor']              = $this->input->post('no_paspor',TRUE);
        $data['password']               = $this->cipasswordhash->create_hash($token2,$key);
        
        
        
        $result = $this->jamaah_model->reset_aksi($data);
        
        if($result == true){
            $this->load->library('MY_PHPMailer');
            $mail = new PHPMailer();
            $mail->IsSMTP();                       // set mailer to use SMTP
            $mail->Host     = "sgx4.cloudhost.id";  // specify main and backup server
            $mail->SMTPAuth = TRUE;     // turn off SMTP authentication
            $mail->Username = "hello@codelabasia.com";  // SMTP username
            $mail->Password = "@password2017"; // SMTP password

            $mail->From = "noreply@umrohtiketmurah.com";
            $mail->FromName = 'UTM - UMROHTIKETMURAH.COM';
            $mail->AddAddress($this->input->post('email',TRUE));
            $mail->IsHTML(true);  
            $mail->Subject = "Reset Email dan Password Akun UTM";

            $mail->Body = '<table cellpadding="0" cellspacing="0" style="border:1px #dceaf5 solid;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr><td colspan="3" height="52"></td></tr>';
            $mail->Body .= '<tr style="line-height:0px;" id="">';
            $mail->Body .= '<td width="100%" style="font-size:0px;" align="center" height="1" id="">';
            $mail->Body .= '</td></tr>';
            $mail->Body .= '<tr id=""><td id="">';
            $mail->Body .= '<table cellpadding="0" cellspacing="0" style="line-height:25px;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr id=""><td width="36"></td>';
            $mail->Body .= '<td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:\'Open Sans\', \'Lucida Grande\', \'Segoe UI\', Arial, Verdana, \'Lucida Sans Unicode\', Tahoma, \'Sans Serif\';max-width:454px;" valign="top" id="">Yth Bpk/Ibu , <strong>'.$this->input->post('nama',TRUE).'</strong><br><br>';
            $mail->Body .= 'Berikut adalah akun terbaru CMS UTM : <br> ';
            $mail->Body .= 'Kode Jamaah : <b>'.$this->input->post('kode_jamaah',TRUE).'</b><br> ';
            $mail->Body .= 'Nama Lengkap : '.$this->input->post('nama',TRUE).'<br> ';
            $mail->Body .= '<hr>';
            $mail->Body .= 'Username : '.$this->input->post('kode_jamaah',TRUE).'<br> ';
            $mail->Body .= 'Password : '.$token2.'<br> ';
            $mail->Body .= '<br><br> Silahkan login : <a href='.base_url('login').'>Login</a> <br><br></td><td width="36" id=""></td></tr>';
            $mail->Body .= '</table></td></tr></tbody></table><br> "Informasi Penting :

Kepada seluruh jamaah UTM , Agar tetap berhati-hati terhadap penelpon,pesan whatsapp,atau email yang mengatasnamakan UTM / UMROHTIKETMURAH.COM,yang memanfaatkan untuk kepentingan pribadi.
Jika ada merasa keraguan, harap hubungi admin UTM untuk memastikan kebenaran informasi yang di terima.
Terima Kasih" <br>';

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $mail->send();
                //echo "Message sent!";
            }
        }
        
        
        
        echo json_encode($result);
    }
    
    public function hapus(){
        
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $this->input->post('id_jamaah',TRUE);
        
        $result = $this->jamaah_model->hapus($data);
        echo json_encode($result);
    }
    
    
    public function jamaah_list_pdf($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_dokumen = 'List_Jamaah_Kloter_'.$a['nama'];
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        
        
        $result['datajamaah'] = $this->jamaah_model->data_by_kloter($id_kloter)->result_array();
        
        $mpdf=new mPDF('utf-8', 'A4-L');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_data_list_jamaah_by_kloter_view.php',$result);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    
    public function verif_dok_upload(){
        $id_jamaah = $this->input->post('id_jamaah',TRUE);
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $kategori = $this->input->post('kategori',TRUE);
        
        $nama_kategori;
        if($kategori == 'sipatuh'){
            $nama_kategori = 'SiPatuh';
        }else if($kategori == 'paspor'){
            $nama_kategori = 'Paspor';
        }else if($kategori == 'ktp'){
            $nama_kategori = 'KTP';
        }else if($kategori == 'kk'){
            $nama_kategori = 'Kartu Keluarga';
        }else{
            $nama_kategori = '';
        }
        
        
        $result = $this->jamaah_model->verif_dok_upload($id_jamaah,$id_kloter,$kategori);
        
        $v = $this->jamaah_model->detail($id_jamaah)->row_array();
        
        $em = $v['email'];
        if($result == true){
            $this->load->library('MY_PHPMailer');
            $mail = new PHPMailer();
            $mail->IsSMTP();                       // set mailer to use SMTP
            $mail->Host     = "sgx4.cloudhost.id";  // specify main and backup server
            $mail->SMTPAuth = TRUE;     // turn off SMTP authentication
            $mail->Username = "hello@codelabasia.com";  // SMTP username
            $mail->Password = "@password2017"; // SMTP password

            $mail->From = "noreply@umrohtiketmurah.com";
            $mail->FromName = 'UTM - UMROHTIKETMURAH.COM';
            $mail->AddAddress($em);
            $mail->IsHTML(true);  
            $mail->Subject = "Verifikasi Dokumen Upload - $nama_kategori";

            $mail->Body = '<table cellpadding="0" cellspacing="0" style="border:1px #dceaf5 solid;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr><td colspan="3" height="52"></td></tr>';
            $mail->Body .= '<tr style="line-height:0px;" id="">';
            $mail->Body .= '<td width="100%" style="font-size:0px;" align="center" height="1" id="">';
            $mail->Body .= '</td></tr>';
            $mail->Body .= '<tr id=""><td id="">';
            $mail->Body .= '<table cellpadding="0" cellspacing="0" style="line-height:25px;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr id=""><td width="36"></td>';
            $mail->Body .= '<td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:\'Open Sans\', \'Lucida Grande\', \'Segoe UI\', Arial, Verdana, \'Lucida Sans Unicode\', Tahoma, \'Sans Serif\';max-width:454px;" valign="top" id="">Yth Bpk/Ibu , <strong>'.$v['nama'].'</strong><br><br>';
            $mail->Body .= 'Informasi Verifikasi Untuk Dokumen Upload : <br> ';
            $mail->Body .= 'Kode Jamaah : <b>'.$id_jamaah.'</b><br> ';
            $mail->Body .= 'Nama Lengkap : '.$v['nama'].'<br> ';
            $mail->Body .= '<hr>';
            $mail->Body .= 'Informasi Verifikasi : <b>Dokumen Upload <span style="color:green">'.$nama_kategori.'</span> berhasil di <span style="color:green">Verifikasi</span> </b> <br><br> ';
            $mail->Body .= '</table></td></tr></tbody></table><p><br> "Informasi Penting :

Kepada seluruh jamaah UTM , Agar tetap berhati-hati terhadap penelpon,pesan whatsapp,atau email yang mengatasnamakan UTM / UMROHTIKETMURAH.COM,yang memanfaatkan untuk kepentingan pribadi.
Jika ada merasa keraguan, harap hubungi admin UTM untuk memastikan kebenaran informasi yang di terima.
Terima Kasih" <br>';

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $mail->send();
                //echo "Message sent!";
            }
        }
        
        echo json_encode($result);
    }
    
    public function un_verif_dok_upload(){
        $id_jamaah = $this->input->post('id_jamaah',TRUE);
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $kategori = $this->input->post('kategori',TRUE);
        $result = $this->jamaah_model->un_verif_dok_upload($id_jamaah,$id_kloter,$kategori);
        echo json_encode($result);
    }
    
    function verif_dok_kirim_upload(){
        $id_jamaah = $this->input->post('id_jamaah',TRUE);
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $kategori = $this->input->post('kategori',TRUE);
        $result = $this->jamaah_model->verif_dok_kirim_upload($id_jamaah,$id_kloter,$kategori);
        
        $nama_kategori;
        if($kategori == 'foto'){
            $nama_kategori = 'Foto 4X6 Background Putih';
        }else if($kategori == 'vaksin'){
            $nama_kategori = 'Buku Vaksin';
        }else if($kategori == 'paspor'){
            $nama_kategori = 'Buku Paspor';
        }else if($kategori == 'buku_nikah'){
            $nama_kategori = 'Buku Nikah';
        }else if($kategori == 'akte_kelahiran'){
            $nama_kategori = 'Akte Kelahiran';
        }else if($kategori == 'tiket_pp'){
            $nama_kategori = 'Tiket Ke Meeting Point & Tiket PP Jeddah';
        }else if($kategori == 'ktp'){
            $nama_kategori = 'FC KTP';
        }else if($kategori == 'kk'){
            $nama_kategori = 'FC Kartu Keluarga';
        }else if($kategori == 'sipatuh'){
            $nama_kategori = 'Sipatuh';
        }else{
            $nama_kategori = '';
        }
        
        
        $v = $this->jamaah_model->detail($id_jamaah)->row_array();
        
        $em = $v['email'];
        if($result == true){
            $this->load->library('MY_PHPMailer');
            $mail = new PHPMailer();
            $mail->IsSMTP();                       // set mailer to use SMTP
            $mail->Host     = "sgx4.cloudhost.id";  // specify main and backup server
            $mail->SMTPAuth = TRUE;     // turn off SMTP authentication
            $mail->Username = "hello@codelabasia.com";  // SMTP username
            $mail->Password = "@password2017"; // SMTP password

            $mail->From = "noreply@umrohtiketmurah.com";
            $mail->FromName = 'UTM - UMROHTIKETMURAH.COM';
            $mail->AddAddress($em);
            $mail->IsHTML(true);  
            $mail->Subject = "Verifikasi Dokumen Upload - $nama_kategori";

            $mail->Body = '<table cellpadding="0" cellspacing="0" style="border:1px #dceaf5 solid;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr><td colspan="3" height="52"></td></tr>';
            $mail->Body .= '<tr style="line-height:0px;" id="">';
            $mail->Body .= '<td width="100%" style="font-size:0px;" align="center" height="1" id="">';
            $mail->Body .= '</td></tr>';
            $mail->Body .= '<tr id=""><td id="">';
            $mail->Body .= '<table cellpadding="0" cellspacing="0" style="line-height:25px;" border="0" align="center" id="">';
            $mail->Body .= '<tbody id="">';
            $mail->Body .= '<tr id=""><td width="36"></td>';
            $mail->Body .= '<td width="454" align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:\'Open Sans\', \'Lucida Grande\', \'Segoe UI\', Arial, Verdana, \'Lucida Sans Unicode\', Tahoma, \'Sans Serif\';max-width:454px;" valign="top" id="">Yth Bpk/Ibu , <strong>'.$v['nama'].'</strong><br><br>';
            $mail->Body .= 'Informasi Verifikasi Untuk Dokumen Upload : <br> ';
            $mail->Body .= 'Kode Jamaah : <b>'.$id_jamaah.'</b><br> ';
            $mail->Body .= 'Nama Lengkap : '.$v['nama'].'<br> ';
            $mail->Body .= '<hr>';
            $mail->Body .= 'Informasi Verifikasi : <b>Dokumen Upload <span style="color:green">'.$nama_kategori.'</span> berhasil di <span style="color:green">Verifikasi</span> </b> <br><br> ';
            $mail->Body .= '</table></td></tr></tbody></table><p><br> "Informasi Penting :

Kepada seluruh jamaah UTM , Agar tetap berhati-hati terhadap penelpon,pesan whatsapp,atau email yang mengatasnamakan UTM / UMROHTIKETMURAH.COM,yang memanfaatkan untuk kepentingan pribadi.
Jika ada merasa keraguan, harap hubungi admin UTM untuk memastikan kebenaran informasi yang di terima.
Terima Kasih" <br>';

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                $mail->send();
                //echo "Message sent!";
            }
        }
         
        
        echo json_encode($result);
    }
    
    function verif_dok_kirim_upload_cancel(){
        $id_jamaah = $this->input->post('id_jamaah',TRUE);
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $kategori = $this->input->post('kategori',TRUE);
        $result = $this->jamaah_model->verif_dok_kirim_upload_cancel($id_jamaah,$id_kloter,$kategori);
        echo json_encode($result);
    }
    
    
    public function dok_terima(){
        
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $this->input->post('id_jamaah',TRUE);
        $data['id_value']       = $this->input->post('id_value',TRUE);
        
        $result = $this->jamaah_model->dok_terima($data);
        echo json_encode($result);
    }
    
    public function dok_lengkap(){
        
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $this->input->post('id_jamaah',TRUE);
        $data['id_value']       = $this->input->post('id_value',TRUE);
        
        $result = $this->jamaah_model->dok_lengkap($data);
        echo json_encode($result);
    }
    
    
    public function pembayaran(){
        
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $this->input->post('id_jamaah',TRUE);
        $data['id_value']       = $this->input->post('id_value',TRUE);
        $data['kategori']       = $this->input->post('kategori',TRUE);
        
        $result = $this->jamaah_model->pembayaran($data);
        echo json_encode($result);
    }
    
    public function upload_ktp(){
        
        $kloter = $this->input->post('id_kloter',TRUE);
        $data['kode_jamaah'] = $this->input->post('kode_jamaah',TRUE);
        $directory_name = 'kloter_'.$kloter;
        $namakloter     = 'kloter_'.$kloter;
        if (!is_dir('uploads/files/'.$directory_name)) {
            mkdir('./uploads/files/' . $namakloter, 0777, TRUE);
        }
        
        $path = './uploads/files/'.$namakloter.'/';
        
        $data['dok_ktp']   = $this->input->post('dok_ktp',TRUE);
        $date4                = date('dmY');
        $file_name4           = $date4.time().'_ktp_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_ktp"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name4;
        $this->load->library('upload',$config);
        $this->upload->do_upload('dok_ktp');
        $result_images    = $this->upload->data();
        $data['dok_ktp']  = $result_images['file_name']; 
            
        }else{
           
            $data['dok_ktp'] = $this->input->post('dok_ktp_asli',TRUE);
        }
        $data['kategori'] = 'ktp';
        $result = $this->jamaah_model->update_file_upload($data);
        echo json_encode($result);
        //echo json_encode($result);

    }

    
    public function upload_sipatuh(){
        
        $kloter = $this->input->post('id_kloter',TRUE);
        $data['kode_jamaah'] = $this->input->post('kode_jamaah',TRUE);
        $directory_name = 'kloter_'.$kloter;
        $namakloter     = 'kloter_'.$kloter;
        if (!is_dir('uploads/files/'.$directory_name)) {
            mkdir('./uploads/files/' . $namakloter, 0777, TRUE);
        }
        
        $path = './uploads/files/'.$namakloter.'/';
        
        $data['dok_sipatuh']  = $this->input->post('dok_sipatuh',TRUE);
        $date4                = date('dmY');
        $file_name4           = $date4.time().'_surat_pernyataan_sipatuh_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_sipatuh"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name4;
        $this->load->library('upload',$config);
        $this->upload->do_upload('dok_sipatuh');
        $result_images    = $this->upload->data();
        $data['dok_sipatuh']  = $result_images['file_name']; 
            
        }else{
           
            $data['dok_sipatuh'] = $this->input->post('dok_sipatuh_asli',TRUE);
        }
        $data['kategori'] = 'sipatuh';
        $result = $this->jamaah_model->update_file_upload($data);
        echo json_encode($result);
        //echo json_encode($result);

    }
    
    public function upload_paspor(){
        
        $kloter = $this->input->post('id_kloter',TRUE);
        $data['kode_jamaah'] = $this->input->post('kode_jamaah',TRUE);
        $directory_name = 'kloter_'.$kloter;
        $namakloter     = 'kloter_'.$kloter;
        if (!is_dir('uploads/files/'.$directory_name)) {
            mkdir('./uploads/files/' . $namakloter, 0777, TRUE);
        }
        
        $path = './uploads/files/'.$namakloter.'/';
        
        $data['dok_paspor']  = $this->input->post('dok_paspor',TRUE);
        $date4                = date('dmY');
        $file_name4           = $date4.time().'_paspor_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_paspor"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name4;
        $this->load->library('upload',$config);
        $this->upload->do_upload('dok_paspor');
        $result_images    = $this->upload->data();
        $data['dok_paspor']  = $result_images['file_name']; 
            
        }else{
           
            $data['dok_paspor'] = $this->input->post('dok_paspor_asli',TRUE);
        }
        $data['kategori'] = 'paspor';
        $result = $this->jamaah_model->update_file_upload($data);
        echo json_encode($result);
        //echo json_encode($result);

    }
    
    
    public function upload_kk(){
        
        $kloter = $this->input->post('id_kloter',TRUE);
        $data['kode_jamaah'] = $this->input->post('kode_jamaah',TRUE);
        $directory_name = 'kloter_'.$kloter;
        $namakloter     = 'kloter_'.$kloter;
        if (!is_dir('uploads/files/'.$directory_name)) {
            mkdir('./uploads/files/' . $namakloter, 0777, TRUE);
        }
        
        $path = './uploads/files/'.$namakloter.'/';
        
        $data['dok_kk']  = $this->input->post('dok_kk',TRUE);
        $date4                = date('dmY');
        $file_name4           = $date4.time().'_kartu_keluarg_'.$this->input->post('kode_jamaah',TRUE);
          
        if($_FILES["dok_kk"]['name'] !=''){

        $config['upload_path']   = $path;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size']      = '6048';
        $config['file_name']     = $file_name4;
        $this->load->library('upload',$config);
        $this->upload->do_upload('dok_kk');
        $result_images    = $this->upload->data();
        $data['dok_kk']  = $result_images['file_name']; 
            
        }else{
           
            $data['dok_kk'] = $this->input->post('dok_kk_asli',TRUE);
        }
        $data['kategori'] = 'kk';
        $result = $this->jamaah_model->update_file_upload($data);
        echo json_encode($result);
        //echo json_encode($result);

    }
    
    public function koper_status(){
        
        $data['id_kloter']       = $this->input->post('id_kloter',TRUE);
        $data['id_jamaah']       = $this->input->post('id_jamaah',TRUE);
        $data['id_value']       = $this->input->post('id_value',TRUE);
        
        $result = $this->jamaah_model->koper_status($data);
        echo json_encode($result);
    }
    
    public function jamaah_list_pembayaran_pdf($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_dokumen = 'List_Pembayaran_Jamaah_Kloter_'.$a['nama'];
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        
        
        $result['datajamaah'] = $this->jamaah_model->data_by_kloter($id_kloter)->result_array();
        
        $mpdf=new mPDF('utf-8', 'A4-L');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_data_list_pembayaran_view.php',$result);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    public function jamaah_list_pengiriman_koper_pdf($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_dokumen = 'List_Pengiriman_Koper_Jamaah_Kloter_'.$a['nama'];
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        
        
        $result['datajamaah'] = $this->jamaah_model->data_by_kloter($id_kloter)->result_array();
        
        $mpdf=new mPDF('utf-8', 'A4-L');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_data_list_pengiriman_koper_view.php',$result);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    public function jamaah_list_pengiriman_koper_dikirim_pdf($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_dokumen = 'List_Pengiriman_Koper_Dikirim_Jamaah_Kloter_'.$a['nama'];
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        
        
        $result['datajamaah'] = $this->jamaah_model->data_by_kloter_koper_dikirim($id_kloter)->result_array();
        
        $mpdf=new mPDF('utf-8', 'A4-L');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('cetak/cetak_data_list_pengiriman_koper_dikirim_view.php',$result);
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
    }
    
    
     public function jamaah_list_pengiriman_koper_dikirim_excel($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_dokumen = 'List_Pengiriman_Koper_Dikirim_Jamaah_Kloter_'.$a['nama'];
        
        $result['datajamaah'] = $this->jamaah_model->data_by_kloter_koper_dikirim($id_kloter)->result_array();
   
        // Fungsi header dengan mengirimkan raw data excel
        header("Content-type: application/vnd-ms-excel");
 
        // Mendefinisikan nama file ekspor "hasil-export.xls"
        header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
 
        
        
        $this->load->view('cetak/cetak_data_list_pengiriman_koper_dikirim_view.php',$result);
 
    }
    
    /* Download */

    public function lembar_download(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('jamaah/jamaah_lembar_download_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }

    function lembar_checklist_dokumen(){
        
        $data['detail'] = $this->jamaah_model->detail($this->session->userdata('sess_id_jamaah'))->row_array();
        $data['kloter'] = $this->jamaah_model->get_kloter($this->session->userdata('sess_id_jamaah'))->row_array();
        $data['url']    = array("oke"=>1);
        
        
        $nama_dokumen = 'Lembar_Checklist_Dokumen_'.$data['nama'].'_'.$this->session->userdata('sess_id_jamaah');
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        //$result['datapiutang'] = $this->piutang_model->data()->result_array();
      
        $mpdf=new mPDF('utf-8', 'A4-P');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('jamaah/jamaah_lembar_checklist_dokumen_pdf_view',$data);
        
        
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        
        //$mpdf->SetWatermarkImage('./assets/img/logo_meta_2.jpg');
        //$mpdf->showWatermarkImage = true;
        
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
        
    }
    
    function lembar_dokumen_kop_map(){
        
        $data['detail'] = $this->jamaah_model->detail($this->session->userdata('sess_id_jamaah'))->row_array();
        $data['kloter'] = $this->jamaah_model->get_kloter($this->session->userdata('sess_id_jamaah'))->row_array();
        $data['url']    = array("oke"=>1);
        
        
        $nama_dokumen = 'Lembar_Map_Dokumen_'.$data['nama'].'_'.$this->session->userdata('sess_id_jamaah');
        
        // Tentukan path yang tepat ke mPDF
        $this->load->library('mpdf/mpdf');
        //$result['datapiutang'] = $this->piutang_model->data()->result_array();
      
        $mpdf=new mPDF('utf-8', 'A4-P');
         
        //Memulai proses untuk menyimpan variabel php dan html
        ob_start();
        
        $this->load->view('jamaah/jamaah_lembar_surat_pengiriman_pdf_view',$data);
        
        
        
        //$mpdf->setFooter('{PAGENO}');
        //penulisan output selesai, sekarang menutup mpdf dan generate kedalam format pdf
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        //Disini dimulai proses convert UTF-8, kalau ingin ISO-8859-1 cukup dengan mengganti $mpdf->WriteHTML($html);
        
        //$mpdf->SetWatermarkImage('./assets/img/logo_meta_2.jpg');
        //$mpdf->showWatermarkImage = true;
        
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output($nama_dokumen.".pdf" ,'I');
        exit;
        
    }
    
    /* Download */
    
    
    
    public function jamaah_rekap_sipatuh($id_kloter){
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_files = str_replace(' ', '_', $a['nama']);
        $nama_dokumen = 'Rekap_Sipatuh_Kloter_'.$nama_files.'.xls';
        
        $data_jamaah = $this->jamaah_model->data_rekap_sipatuh($id_kloter)->result_array();
   
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=".$nama_dokumen."");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        echo "<b>INFORMASI AKUN PENDAFTARAN (*)</b>";
        echo "<br>";
        echo "<br>";
        echo " <table border='1' width='100%'>
                <thead>
                <tr>
                    <th>NOMOR AKUN (*)</th>
                    <th>NIK (*)</th>
                    <th>TANGGAL LAHIR (*)</th>
                    <th>NAMA AKUN (*)</th>
                    <th>TELP (*)</th>
                    <th>EMAIL (*)</th>
                    <th>**</th>
                    <th>NOMOR AKUN (*)</th>
                    <th>NOMOR JAMAAH (*)</th>
                    <th>NIK (*)</th>
                    <th>JENIS IDENTITAS (*)</th>
                    <th>NAMA JAMAAH (*)</th>
                    <th>JENIS KELAMIN </th>
                    <th>TEMPAT LAHIR </th>
                    <th>TGL LAHIR </th>
                    <th>STATUS MENIKAH </th>
                    <th>NO HP/TELP</th>
                    <th>EMAIL</th>
                    <th>PENDIDIKAN TERAKHIR </th>
                    <th>NOMOR PASPOR </th>
                    <th>NAMA PASPOR </th>
                    <th>TGL DIKELUARKAN </th>
                    <th>TGL HABIS </th>
                    <th>KOTA PASPOR </th>
                    <th>PILIHAN KAMAR </th>
                    <th>KATEGORI USIA </th>
                </tr>
                </thead>
                <tbody>";
                foreach($data_jamaah as $a){
                //$nomorktp = join('', $a['no_ktp']);
                //$tanggals = str_replace('/', '-', $a['no_ktp']); 
                //$ktps = '~'.$a['no_ktp']
                echo "<tr>
                    <td></td>
                    <td>".$a['noktp']."</td>
                    <td align='center'>".$a['tgl_lahir']."</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>username</td>
                    <td>password</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>username</td>
                    <td>password</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>username</td>
                    <td>password</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>username</td>
                    <td>password</td>
                    <td>nama</td>
                    <td>nama</td>
                    <td>nama</td>
                </tr>";
                }
                echo "</tbody>
                </table>";
        
        //$this->load->view('cetak/cetak_data_list_pengiriman_koper_dikirim_view.php',$result);
 
    }
    
    
    public function jamaah_rekap_sipatuh2($id_kloter){
        
        $this->load->library('PHPExcel');
        
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_files = str_replace(' ', '_', $a['nama']);
        $nama_dokumen = 'Rekap_Sipatuh_Kloter_'.$nama_files.'.xls';
        
                      
        $objPHPExcel = new PHPExcel();
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => '82CAFF',
                ),
            ),
        );

        $styleDetail = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        
        $styleFooter = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'F5DEB3',
                ),
            ),
        );        

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'NOMOR AKUN (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'NIK (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'TANGGAL LAHIR (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'NAMA AKUN (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'TELP (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'EMAIL (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'NOMOR AKUN (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'NOMOR JAMAAH (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'NIK (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'JENIS IDENTITAS (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'NAMA JAMAAH (*)');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'JENIS KELAMIN');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'TGL LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'STATUS MENIKAH');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'NO HP/TELP');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'EMAIL');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'PENDIDIKAN TERAKHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', 'NOMOR PASPOR');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', 'NAMA PASPOR');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', 'TGL DIKELUARKAN');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', 'TGL HABIS');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', 'KOTA PASPOR');
        $objPHPExcel->getActiveSheet()->setCellValue('Y1', 'PILIHAN KAMAR');
        $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'KATEGORI USIA');

        $objPHPExcel->getActiveSheet()->getStyle("A1:Z1")->applyFromArray($styleHeader);
        
        $data_jamaah = $this->jamaah_model->data_rekap_sipatuh($id_kloter)->result_array();
        $y       = 2;
        foreach($data_jamaah as $row)
        {
            
            $objPHPExcel->getActiveSheet()->setCellValue("A".$y, null);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("B".$y, $row['no_ktp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("C".$y, $row['tgl_lahir']);//$row->SIANG
            $objPHPExcel->getActiveSheet()->setCellValue("D".$y, $row['nama']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("E".$y, $row['no_telp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("F".$y, $row['email']);
            $objPHPExcel->getActiveSheet()->setCellValue("G".$y, null);
            $objPHPExcel->getActiveSheet()->setCellValue("H".$y, null);
            $objPHPExcel->getActiveSheet()->setCellValue("I".$y, $row['id']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("J".$y, $row['no_ktp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("K".$y, 'KTP');
            $objPHPExcel->getActiveSheet()->setCellValue("L".$y, $row['nama']);
            $objPHPExcel->getActiveSheet()->setCellValue("M".$y, $row['JENKEL']);
            $objPHPExcel->getActiveSheet()->setCellValue("N".$y, $row['tempat_lahir']);
            $objPHPExcel->getActiveSheet()->setCellValue("O".$y, $row['tgl_lahir']);
            $objPHPExcel->getActiveSheet()->setCellValue("P".$y, $row['STATUS_MENIKAH']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit("Q".$y, $row['no_ktp'], PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue("R".$y, $row['email']);
            $objPHPExcel->getActiveSheet()->setCellValue("S".$y, $row['STATUS_PENDIDIKAN']);
            $objPHPExcel->getActiveSheet()->setCellValue("T".$y, $row['paspor_no']);
            $objPHPExcel->getActiveSheet()->setCellValue("U".$y, $row['nama_paspor']);
            $objPHPExcel->getActiveSheet()->setCellValue("V".$y, $row['tgl_keluar_paspor']);
            $objPHPExcel->getActiveSheet()->setCellValue("W".$y, $row['tgl_exp_paspor']);
            $objPHPExcel->getActiveSheet()->setCellValue("X".$y, $row['paspor_kota_penerbit']);
            $objPHPExcel->getActiveSheet()->setCellValue("Y".$y, $row['id_kamar']);
            $objPHPExcel->getActiveSheet()->setCellValue("Z".$y, null);
            
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$y.":Z".$y)->applyFromArray($styleDetail);
            $y++;
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('Data Jamaah ');
        $objPHPExcel->setActiveSheetIndex(0);
                
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$nama_dokumen");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
 
    }
    
    
    function jamaah_rekap_manifest($id_kloter){
        
        $this->load->library('PHPExcel');
        
        
        $a     = $this->kloter_model->detail($id_kloter)->row_array();
        $result['kloter']     = $this->kloter_model->detail($id_kloter)->row_array();
        
        $nama_files = str_replace(' ', '_', $a['nama']);
        $nama_dokumen = 'Rekap_Manifest_Kloter_'.$nama_files.'.xls';
        
                      
        $objPHPExcel = new PHPExcel();
        $styleHeader = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'argb' => '82CAFF',
                ),
            ),
        );

        $styleDetail = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        
        $styleFooter = array(
            'font' => array(
                'bold' => true,
                'color' => array(
                    'rgb' => '000000'
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => 'F5DEB3',
                ),
            ),
        );        

        $objPHPExcel->createSheet();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'NOMOR');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'NAMA ASLI (KTP)');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'NAME 1');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'NAME 2');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'NAME 3');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'GENDER');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'TEMPAT LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'TGL LAHIR');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'NOMOR PASPOR');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'KOTA PASPOR');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TGL DIKELUARKAN');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TGL HABIS');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'KETERANGAN');

        $objPHPExcel->getActiveSheet()->getStyle("A1:Z1")->applyFromArray($styleHeader);
        
        $data_jamaah = $this->jamaah_model->data_rekap_sipatuh($id_kloter)->result_array();
        $y       = 2;
        foreach($data_jamaah as $row)
        {
            
            $arr_kalimat = explode (" ",$row['nama_paspor'], 3);
            
            $objPHPExcel->getActiveSheet()->setCellValue("A".$y, null);
            $objPHPExcel->getActiveSheet()->setCellValue("B".$y, $row['nama']);
            $objPHPExcel->getActiveSheet()->setCellValue("C".$y, $arr_kalimat[0]);
            $objPHPExcel->getActiveSheet()->setCellValue("D".$y, $arr_kalimat[1]);
            $objPHPExcel->getActiveSheet()->setCellValue("E".$y, $arr_kalimat[2]);
            $objPHPExcel->getActiveSheet()->setCellValue("F".$y, $row['JENKEL_MANIFEST']);
            $objPHPExcel->getActiveSheet()->setCellValue("G".$y, $row['tempat_lahir']);
            $objPHPExcel->getActiveSheet()->setCellValue("H".$y, $row['tgl_lahir_manifest']);
            $objPHPExcel->getActiveSheet()->setCellValue("I".$y, $row['paspor_no']);
            $objPHPExcel->getActiveSheet()->setCellValue("J".$y, $row['paspor_kota_penerbit']);
            $objPHPExcel->getActiveSheet()->setCellValue("K".$y, $row['tgl_keluar_paspor']);
            $objPHPExcel->getActiveSheet()->setCellValue("L".$y, $row['tgl_exp_paspor']);
            $objPHPExcel->getActiveSheet()->setCellValue("M".$y, null);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$y.":M".$y)->applyFromArray($styleDetail);
            $objPHPExcel->getActiveSheet()->getStyle("A".$y.":M".$y)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $y++;
        }
        
        $objPHPExcel->getActiveSheet()->setTitle('Manifest Jamaah');
        $objPHPExcel->setActiveSheetIndex(0);
                
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$nama_dokumen");
        header("Cache-Control: max-age=0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        
    }
    
    
    public function jadwal_penerbangan(){

        $tokens  = $this->input->post('tokens',TRUE);
        $id_rows = $this->input->post('id_rows',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        $data['id_rows'] = $id_rows;
        if($result == '1'){
            $this->load->view('jamaah/jamaah_pnr_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    
}
