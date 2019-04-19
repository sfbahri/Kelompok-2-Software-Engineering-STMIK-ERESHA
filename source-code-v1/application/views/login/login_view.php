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

    <!-- Meta -->
    <meta name="description" content="web - Motekar Cemerlang">
    <meta name="author" content="web - Motekar Cemerlang">

    <title>Admin - E-Rekrutment</title>

    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>

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
        <div class="login-wrapper wd-300 wd-xs-350 pd-30 pd-xs-20 bg-white rounded shadow-base">
            <br>
            <div class="text-center card-profile-img"><img src="<?php echo base_url('assets/web/images/logo.png');?>" style="width:80px"></div>
            <br>
          <div class="tx-center mg-b-20">Login E-Recrutment</div>
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
          
          <div class="mg-t-10 tx-center">Copyright &copy; <?php echo date('Y');?> E-Recrutment</div>
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











