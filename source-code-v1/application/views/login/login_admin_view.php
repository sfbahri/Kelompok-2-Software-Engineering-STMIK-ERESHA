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

      <div class="d-flex align-items-center justify-content-center ht-100v">
      <img src="<?php echo base_url('assets/img/bg.jpeg');?>" class="wd-100p ht-100p object-fit-cover" alt="">
      <div class="overlay-body bg-black-6 d-flex align-items-center justify-content-center" style="border-color: red">
        <div class="login-wrapper wd-320 wd-xs-350 pd-25 pd-xs-40 rounded bd bg-black-7" style="border-color: yellow">
            <div class="text-center card-profile-img"><img src="<?php echo base_url('assets/img/logo.gif');?>" style="width:100px;" ></div>
          <div class="signin-logo tx-center tx-28 tx-bold tx-white"><span class="tx-normal"></span> UMROHTIKETMURAH </span></div>
          <div class="tx-white-5 tx-center mg-b-60">Content Management System</div>
          <span style="font-size:11px"><?php echo $login_failed;?></span>
           <form class="form-horizontal" action="<?php echo base_url('admin/authlogin'); ?>" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
          <div class="form-group">
            <input type="text" class="form-control fc-outline-dark" placeholder="Username" id="c_user" name="c_user" required="">
          </div><!-- form-group -->
          <div class="form-group">
              <input type="password" class="form-control fc-outline-dark" placeholder="Password" id="c_pass" name="c_pass" required="">
            <a href="" class="tx-info tx-12 d-block mg-t-10">Lupa Password ?</a>
          </div><!-- form-group -->
          <button type="submit" class="btn btn-info btn-block">Masuk</button>
           </form>
        </div><!-- login-wrapper -->
      </div><!-- overlay-body -->
    </div><!-- d-flex -->

    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/popper.js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.js');?>"></script>
    
    
  </body>
</html>











