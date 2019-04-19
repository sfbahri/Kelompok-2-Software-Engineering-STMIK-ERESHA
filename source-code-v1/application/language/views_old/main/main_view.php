<?php 
if(!isset($_SESSION)){ 
    session_start(); 
}

$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
$this->output->set_header('Pragma: no-cache');

//LOGIN SESSION
$sess_nama          = $this->session->userdata('sess_nama');
$sess_username      = $this->session->userdata('sess_username');
$sess_token         = $this->session->userdata('sess_token');
$sess_aktif         = $this->session->userdata('sess_aktif');
$sess_login         = $this->session->userdata('sess_login');
$sess_id_jamaah     = $this->session->userdata('sess_id_jamaah');
$sess_id_admin      = $this->session->userdata('sess_id_admin');


/* session kcfinder */
$_SESSION['KCFINDER']=array();
$_SESSION['KCFINDER']['disabled'] = false;
$_SESSION['KCFINDER']['uploadURL'] = base_url('assets/plugins/editor/files/');
$_SESSION['KCFINDER']['uploadDir'] = "";
/* session kcfinder */

//$this->session->sess_expiration = '14400'; // expires in 4 hours

if($sess_login==0){
    redirect(base_url("main/logout"));
}
else{
if (empty($sess_username) AND empty($sess_token) AND $login ==0 && $sess_aktif == 1){
    redirect(base_url("main/logout"));
}
else{
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Login CMS.UTM">
    <meta name="author" content="Umroh Tiket Murah">

    <title>CMS.UTM </title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url('assets/img/favicon.ico');?>" />
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico');?>" type="image/ico" />
    
    <?php include "main_css.php";?>
    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>
  </head>

  <body>

    
    <div class="br-logo"><a href=""><span></span>UTM <i>DASHBOARD</i><span></span></a></div>
    
    <!-- start menu sidebar -->
    <div class="br-sideleft overflow-y-auto">
        <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
        <?php include "menu_view.php";?>
    </div>
    <!-- end menu sidebar -->


    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
          <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-ios-menu"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-ios-menu" ></i></a></div>
        <div class="input-group hidden-xs-down wd-170 transition">
          <input id="searchbox" type="text" class="form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div><!-- input-group -->
      </div><!-- br-header-left -->
      <div class="br-header-right">
        <nav class="nav">
        
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $this->session->userdata('nama');?></span>
              <img src="<?php echo base_url('assets/img/jamaah.png');?>" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href=""><img src="<?php echo base_url('assets/img/jamaah.png');?>" class="wd-80 rounded-circle" alt=""></a>
                <h6 class="logged-fullname"><?php echo $this->session->userdata('nama');?></h6>
                <p><?php echo $this->session->userdata('sess_nama');?></p>
              </div>
              
<!--            <hr>  <div class="tx-center">
                <span class="profile-earning-label">Earnings After Taxes</span>
                <h3 class="profile-earning-amount">$13,230 <i class="icon ion-ios-arrow-thin-up tx-success"></i></h3>
                <span class="profile-earning-text">Based on list price.</span>
              </div>-->
              <hr>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="javascript:void(0)" onclick="getcontents('login/ubah_password','<?php echo $this->session->userdata('sess_token');?>')"><i class="icon ion-ios-lock"></i> Ubah Password </a></li>
<!--                <li><a href=""><i class="icon ion-ios-gear"></i> Settings</a></li>-->
                <li><a href="<?php echo base_url('main/logout');?>"><i class="icon ion-ios-log-out"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
        <div class="navicon-right">
          <a id="btnRightMenu" href="" class="pos-relative">
            <i class="icon ion-md-chatboxes"></i>
            <!-- start: if statement -->
            <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span>
            <!-- end: if statement -->
          </a>
        </div><!-- navicon-right -->
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

 
    <!-- sidebar kanan -->
    <?php include "main_sidebar_kanan.php";?>
    
    

    
    <div class="br-mainpanel">
        
        <?php
        $this->session->userdata('sess_id_jamaah');
        ?>
        <div id="content-container"></div>
        
        <div id="content-popup"></div>
        <br>
        <br>

        
        <footer class="br-footer">
            <div class="footer-left">
              <div class="mg-b-2">Copyright &copy; 2018. UMROHTIKETMURAH.COM . All Rights Reserved.</div>
            </div>
            <div class="footer-right d-flex align-items-center">
              <span class="tx-uppercase mg-r-10">CMS.V.01</span>
<!--              <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracketplus/intro"><i class="fa fa-facebook tx-20"></i></a>
              <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Bracket%20Plus,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracketplus/intro"><i class="fa fa-twitter tx-20"></i></a>-->
            </div>
          </footer>
        
    </div>

    
    
    
    <?php include "main_js.php";?>
    
  </body>
</html>

<?php 
}
}
?>