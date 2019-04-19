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
        <title>eMonitoring | Reset Password</title>
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

    <body class="login" style="background-image: url('<?php echo base_url('assets/images/bg_login.jpg');?>'); height: 100%;background-position: center;
    background-repeat: no-repeat;
    background-size: cover;overflow: hidden;">
   
    <div style="text-align: center;">
        <img src="<?php echo base_url('assets/images/logo.png');?>" style="width: 80px;margin-top:20px">
        <div style="text-align: center;font-weight: bold;font-size: 16px;color: white;font-family:'Open Sans','Lucida Grande','Segoe UI', 'Arial', 'Verdana','Lucida Sans Unicode', 'Tahoma', 'Sans Serif';">Kementrian Lingkungan Hidup dan Kehutanan</div>
        <div style="text-align: center;font-weight: bold;font-size: 20px;margin-bottom: 5px;color: white;font-family:'Open Sans','Lucida Grande','Segoe UI', 'Arial', 'Verdana','Lucida Sans Unicode', 'Tahoma', 'Sans Serif'">Sistem Informasi Pengawasan Lingkungan Hidup</div>
    </div>
       
        <div class="content">
            
            <form class="login-form" action="<?php echo base_url('act-reset-password'); ?>" method="post">
                
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
                
                <div class="form-title">
                    <span class="form-title"><i class="fa fa-lock"></i> Lupa Password.</span>
                </div>
                
                <?php 
                    //echo '<div class="alert alert-danger"><button class="close" data-close="alert"></button><span>'.$login_failed.'</span></div>';
                    echo ! empty($login_failed) ? '<div class="alert alert-danger"><button class="close" data-close="alert"></button><span>'.$login_failed.'</span></div>' : '';
                ?>
                
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input required="" class="form-control form-control-solid placeholder-no-fix" style="background:black;border-color:orangered" type="email" autocomplete="off" placeholder="Masukan Email yang terdaftar" name="c_email" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn green btn-block uppercase" style="background:orangered">Reset <i class="fa fa-refresh"></i></button>
                </div>
                <div class="form-actions">
                    <div class="pull-left">
                        
                    </div>
                    <div class="pull-right forget-password-block">
                        <a href="<?php echo base_url('login');?>" id="forget-password" class="forget-password"><i class="fa fa-home"></i> Halaman Login</a>
                    </div>
                </div>
            </form>
          
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