<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $login_failed = $this->session->flashdata('usersnotfound');
?>
<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>eMonitoring | Reset Password Info</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <link href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/logins/assets/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/logins/assets/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/logins/assets/global/plugins/uniform/css/uniform.default.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/logins/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
       
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url('assets/logins/assets/global/css/components-md.min.css');?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url('assets/logins/assets/global/css/plugins-md.min.css');?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/logins/assets/pages/css/login-2.min.css');?>" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="login">
   
    <div style="text-align: center;">
        <img src="<?php echo base_url('assets/images/logo.png');?>" style="width: 80px;margin-top:20px">
        <div style="text-align: center;font-weight: bold;font-size: 16px;color: white;font-family:'Open Sans','Lucida Grande','Segoe UI', 'Arial', 'Verdana','Lucida Sans Unicode', 'Tahoma', 'Sans Serif';">Kementrian Lingkungan Hidup dan Kehutanan</div>
        <div style="text-align: center;font-weight: bold;font-size: 20px;margin-bottom: 5px;color: white;font-family:'Open Sans','Lucida Grande','Segoe UI', 'Arial', 'Verdana','Lucida Sans Unicode', 'Tahoma', 'Sans Serif'">Sistem Informasi Pengawasan Lingkungan Hidup</div>
    </div>
       
        <div class="content">
            
            <div class="note note-warning">
                <h4 class="block"><i class="fa fa-check fa-2x" style="color:green"></i> Reset Password Berhasil</h4>
                <p>Silahkan cek email masuk atau email spam.</p>
            </div>
            <div class="form-actions">
                <a href="<?php echo base_url('login');?>"><button type="submit" class="btn red btn-block uppercase"><i class="fa fa-home"></i> Ke Halaman Login</button></a>
            </div>
        </div>
        <div class="copyright"> 2017 © Direktorat Pemanfaatan Jasa Lingkungan Hutan Konservasi. </div>
       
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/js.cookie.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/logins/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <script src="<?php echo base_url('assets/logins/assets/global/scripts/app.min.js');?>" type="text/javascript"></script>

    </body>

</html>