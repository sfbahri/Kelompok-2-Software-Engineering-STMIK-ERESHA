<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $login_failed = $this->session->flashdata('usersnotfound');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="CMS - Umroh Tiket Murah">
    <meta name="twitter:creator" content="CMS - Umroh Tiket Murah">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="<?php echo base_url('assets/img/logo_meta.jpg');?>">

    <!-- Facebook -->
    <meta property="og:url" content="http://cms.umrohtiketmurah.com/">
    <meta property="og:title" content="CMS - Umroh Tiket Murah">
    <meta property="og:description" content="Content Management System">

    <meta property="og:image" content="<?php echo base_url('assets/img/logo_meta.jpg');?>">
    <meta property="og:image:secure_url" content="<?php echo base_url('assets/img/logo_meta.jpg');?>">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="CMS - Umroh Tiket Murah">
    <meta name="author" content="CMS - Umroh Tiket Murah">

    <title>Login - Umroh Tiket Murah</title>

    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <link href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/Ionicons/css/ionicons.css');?>" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bracket.css');?>">
    <style>
        .type3 {
            width: 100px;
            height: 100px;
            background: aqua;
            border: 30px solid blue;
        }
    </style>
  </head>
  
  
  <body>

      <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
        <form class="form-horizontal" action="<?php echo base_url('login/authlogin'); ?>" method="post">
          <input type="hidden" style="display:none" name="nama_tanggal" name="nama_tanggal" value="<?php echo $num;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-20 bg-white rounded shadow-base">
            <div class="text-center card-profile-img"><img src="<?php echo base_url('assets/img/logo.gif');?>" style="width:100px"></div>
            <div class="signin-logo tx-center tx-28 tx-bold tx-black"><span class="tx-normal"></span> UMROHTIKETMURAH </span></div>
          <div class="tx-center mg-b-30">Content Management System</div>
          <span style="font-size:11px"><?php echo $login_failed;?></span>
          <div class="form-group">
              <input type="text" class="form-control" placeholder="Username" id="c_user" name="c_user" required="">
            </div><!-- form-group -->
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="c_pass" name="c_pass" required="">
                <a href="#" class="tx-info tx-12 d-block mg-t-10"><input type="checkbox" onclick="myFunction_show_password()">  Tampilkan Password </a> 
              <!--<a href="" class="tx-info tx-12 d-block mg-t-10">Lupa Password ?</a>-->
            </div><!-- form-group -->
            <div class="form-group">
                <p id="captImg"><?php echo $captchaImg; ?></p>
                <input type="text" class="form-control" placeholder="Input Kode Captcha" id="kodecpt" name="kodecpt" required="" style="width:150px">
            </div>
          <button type="submit" class="btn btn-info btn-block">Sign In</button>
          
            <img src="<?php echo base_url('assets/img/comod_secure.png');?>" style="width:60px;margin-top:10px">
          
          <div class="mg-t-10 tx-center">Copyright &copy; UTM 2018</div>
        </div><!-- login-wrapper -->
        </form>
    </div>
      
      
      
      

    
    <script src="<?php echo base_url('assets/lib/popper.js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.js');?>"></script>
    
    <script>
        
                function myFunction_show_password() {
                    var x = document.getElementById("c_pass");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
        
    </script>
    
    
  </body>
</html>











