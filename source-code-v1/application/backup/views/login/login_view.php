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
    <meta name="description" content="Login CMS PT.Shailendra Tshai Indonesia">
    <meta name="author" content="PT.Shailendra Tshai Indonesia">

    <title>Login CMS</title>

    <!-- vendor css -->
    <link href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/lib/Ionicons/css/ionicons.css');?>" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bracket.css');?>">
  </head>

  <body>

    <div class="row no-gutters flex-row-reverse ht-100v">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
            <form class="form-horizontal" action="<?php echo base_url('login/authlogin'); ?>" method="post">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
            
            <h4 class="tx-inverse tx-center">Sign In</h4>
          <p class="tx-center mg-b-60">Login dengan NIK dan password yang aktif.</p>
          <span style="font-size:11px"><?php echo $login_failed;?></span>
          <div class="form-group">
              <input type="text" class="form-control" placeholder="NIK" id="c_user" name="c_user" required=>
          </div><!-- form-group -->
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" id="c_pass" name="c_pass" required=>
            <a href="" class="tx-info tx-12 d-block mg-t-10">Lupa Password ?</a>
          </div><!-- form-group -->
          <button type="submit" class="btn btn-info btn-block">Sign In</button>
          </form>
          <div class="mg-t-60 tx-center">Copyright © 2018  <a href="" class="tx-info">PT. Shailendra Tshai Indonesia</a></div>
        </div><!-- login-wrapper -->
      </div><!-- col -->
      <div class="col-md-6 bg-br-primary d-flex align-items-center justify-content-center">
        <div class="wd-250 wd-xl-450 mg-y-30">
          <div class="signin-logo tx-28 tx-bold tx-white"><span class="tx-normal">[</span> PT. Shailendra Tshai <span class="tx-info">Indonesia</span> <span class="tx-normal">]</span></div>
          <div class="tx-white mg-b-60">Content Management System</div>
          
          <p><img src="<?php echo base_url('assets/img/logins.png');?>" style="width: 150px"></p>
          <h5 class="tx-white">Selamat Datang ,</h5>
          <p class="tx-white-6">Content Management System ini digunakan sebagai aplikasi sistem utama PT. Shailendra Tshai Indonesia, yang mana didalamnya dapat membantu pekerjaan di dalam operasional setiap divisi atau karyawan.</p>
        <p></p>    
        <p><a href="" class="btn btn-outline-light bd bd-white bd-2 tx-white pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium"><i class="fa fa-calendar"></i> <?php echo date('l, d-m-Y');?></a></p>
        </div><!-- wd-500 -->
      </div>
    </div><!-- row -->

    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/popper.js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.js');?>"></script>
    
    <script>
                    
            $('#c_user').keypress(function(event){
                if(event.which ==13){
                    event.preventDefault();
                    $('#c_pass').focus();
                }
                
                $('#c_user').css({
                        'border':'1px solid #ccc'
                    });
            })
            .blur(function(){
                var txt = $('#c_user').val();
                var len = $(this).val().length;
                switch (len) {
                    case 1:
                        txt = '0000000'+ txt;
                        break;
                    case 2:
                        txt = '000000'+ txt;
                        break;
                    case 3:
                        txt = '00000'+ txt;
                        break;
                    case 4:
                        txt = '0000'+ txt;
                        break;
                    case 5:
                        txt = '000'+ txt;
                        break;
                    case 6:
                        txt = '00'+ txt;
                        break;
                    case 7:
                        txt = '0'+ txt;
                        break;       
                } 
                $('#c_user').val(txt);
            });
        </script>
    
  </body>
</html>



