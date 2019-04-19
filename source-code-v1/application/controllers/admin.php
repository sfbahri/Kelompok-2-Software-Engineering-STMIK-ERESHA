<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
    public function __construct(){
        parent::__construct();		
    	$this->load->model('main_model');
        $this->load->model('admin_model');
        $this->load->library('cipasswordhash');   
    }

    public function index(){

        $tokens = $this->input->post('tokens',TRUE);
        $result = $this->main_model->check_token($tokens);
        $data['tokens'] = $tokens;
        if($result == '1'){
            $this->load->view('admin/admin_view',$data);
        }else{
            echo "<script> window.location = 'main/logout' </script>";
        }

    }
    
    public function data(){
        $result = $this->admin_model->data()->result_array();
        echo json_encode($result);
    }
    
    public function tambah(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            if($result == '1'){
                $this->load->view('admin/admin_tambah_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function edit(){
            $tokens   = $this->input->post('tokens',TRUE);
            $id_modal = $this->input->post('id_modal',TRUE);
            $id_row = $this->input->post('id_row',TRUE);
            $result = $this->main_model->check_token($tokens);
            $data['tokens'] = $tokens;
            $data['id_modal'] = $id_modal;
            $data['id_row'] = $id_row;
            if($result == '1'){
                $this->load->view('admin/admin_edit_view',$data);
            }else{
                echo "<script> window.location = 'main/logout' </script>";
            }
    }
    
    public function detail(){
        $id_kloter = $this->input->post('id_kloter',TRUE);
        $result = $this->admin_model->detail($id_kloter)->row_array();
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
        
        
        //ini kode random untuk password
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
        
        $tok = 'ADMUTM'.$token.$token4;
        //ini kode random untuk token
        
        
        $data['nama']            = $this->input->post('nama',TRUE);
        $data['no_paspor']       = $this->input->post('nohp',TRUE);
        $data['email']           = $this->input->post('email',TRUE);
        $data['id_admin']        = $tok;
        $data['password']        = $this->cipasswordhash->create_hash($token2,$key);
        
        
        $result = $this->admin_model->simpan($data);
        
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
            $mail->Subject = "Pendaftaran Akun Admin UTM";

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
            $mail->Body .= 'Kode Admin UTM : <b>'.$tok.'</b><br> ';
            $mail->Body .= 'Nama Lengkap : '.$this->input->post('nama',TRUE).'<br> ';
            $mail->Body .= '<hr>';
            $mail->Body .= 'Username : '.$tok.'<br> ';
            $mail->Body .= 'Password : '.$token2.'<br> ';
            $mail->Body .= '<br><br> Silahkan login : <a href='.base_url('login').'>Login</a> <br><br></td><td width="36" id=""></td></tr>';
            $mail->Body .= '</table></td></tr></tbody></table><br> Login : https://cms.umrohtiketmurah.com/ <br>';

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
    
    public function simpan_rute(){
        
        $data['dari']      = $this->input->post('dari',TRUE);
        $data['kemana']    = $this->input->post('kemana',TRUE);
        $data['jam']       = $this->input->post('jam',TRUE);
        $data['id_kloter'] = $this->input->post('id_kloter',TRUE);
        
        $result = $this->admin_model->simpan_rute($data);
        echo json_encode($result);
        
    }
    
    public function update(){
        
        $data['id_kloter']        = $this->input->post('id_kloter',TRUE);
        $data['nama']             = $this->input->post('nama',TRUE);
        $data['tgl_berangkat']    = $this->input->post('tgl_berangkat',TRUE);
        $data['tgl_pulang']       = $this->input->post('tgl_pulang',TRUE);
        
        $result = $this->admin_model->update($data);
        echo json_encode($result);
        
    }
    
    public function hapus(){
        
        $data['id_kloter']        = $this->input->post('id_kloter',TRUE);
        $result = $this->admin_model->hapus($data);
        echo json_encode($result);
        
    }
    
    
}
