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
$sess_email         = $this->session->userdata('sess_email');
$sess_nik           = $this->session->userdata('sess_nik');
$sess_token         = $this->session->userdata('sess_token');
$sess_aktif         = $this->session->userdata('sess_aktif');
$sess_login         = $this->session->userdata('sess_login');
$sess_outlet        = $this->session->userdata('sess_outlet');


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
if (empty($sess_email) AND empty($sess_nik) AND empty($sess_token) AND $login ==0 && $sess_aktif == 1 && $sess_outlet == 0){
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
    <meta name="description" content="Login CMS PT.Shailendra Tshai Indonesia">
    <meta name="author" content="PT.Shailendra Tshai Indonesia">

    <title>CMS Shailendra Tshai Indonesia </title>
    <link rel="SHORTCUT ICON" href="<?php echo base_url('assets/img/favicon.ico');?>" />
    <link rel="icon" href="<?php echo base_url('assets/img/favicon.ico');?>" type="image/ico" />
    
    <?php include "main_css.php";?>
    <script src="<?php echo base_url('assets/lib/jquery/jquery.js');?>"></script>
  </head>

  <body>

    
    <div class="br-logo"><a href=""><span>[</span>CMS <i>DASHBOARD</i><span>]</span></a></div>
    
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
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-email-outline tx-24"></i>
              <!-- start: if statement -->
              <span class="square-8 bg-danger pos-absolute t-15 r-0 rounded-circle"></span>
              <!-- end: if statement -->
            </a>
            <div class="dropdown-menu dropdown-menu-header">
              <div class="dropdown-menu-label">
                <label>Messages</label>
                <a href="">+ Add New Message</a>
              </div><!-- d-flex -->

              <div class="media-list">
                <!-- loop starts here -->
                <a href="" class="media-list-link">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <div>
                        <p>Donna Seay</p>
                        <span>2 minutes ago</span>
                      </div><!-- d-flex -->
                      <p>A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring.</p>
                    </div>
                  </div><!-- media -->
                </a>
                <!-- loop ends here -->
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <div>
                        <p>Samantha Francis</p>
                        <span>3 hours ago</span>
                      </div><!-- d-flex -->
                      <p>My entire soul, like these sweet mornings of spring.</p>
                    </div>
                  </div><!-- media -->
                </a>
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <div>
                        <p>Robert Walker</p>
                        <span>5 hours ago</span>
                      </div><!-- d-flex -->
                      <p>I should be incapable of drawing a single stroke at the present moment...</p>
                    </div>
                  </div><!-- media -->
                </a>
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <div>
                        <p>Larry Smith</p>
                        <span>Yesterday</span>
                      </div><!-- d-flex -->
                      <p>When, while the lovely valley teems with vapour around me, and the meridian sun strikes...</p>
                    </div>
                  </div><!-- media -->
                </a>
                <div class="dropdown-footer">
                  <a href=""><i class="fa fa-angle-down"></i> Show All Messages</a>
                </div>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
          <div class="dropdown">
            <a href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-bell-outline tx-24"></i>
              <!-- start: if statement -->
              <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
              <!-- end: if statement -->
            </a>
            <div class="dropdown-menu dropdown-menu-header">
              <div class="dropdown-menu-label">
                <label>Notifications</label>
                <a href="">Mark All as Read</a>
              </div><!-- d-flex -->

              <div class="media-list">
                <!-- loop starts here -->
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <p class="noti-text"><strong>Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
                      <span>October 03, 2017 8:45am</span>
                    </div>
                  </div><!-- media -->
                </a>
                <!-- loop ends here -->
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <p class="noti-text"><strong>Mellisa Brown</strong> appreciated your work <strong>The Social Network</strong></p>
                      <span>October 02, 2017 12:44am</span>
                    </div>
                  </div><!-- media -->
                </a>
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <p class="noti-text">20+ new items added are for sale in your <strong>Sale Group</strong></p>
                      <span>October 01, 2017 10:20pm</span>
                    </div>
                  </div><!-- media -->
                </a>
                <a href="" class="media-list-link read">
                  <div class="media">
                    <img src="http://via.placeholder.com/280x280" alt="">
                    <div class="media-body">
                      <p class="noti-text"><strong>Julius Erving</strong> wants to connect with you on your conversation with <strong>Ronnie Mara</strong></p>
                      <span>October 01, 2017 6:08pm</span>
                    </div>
                  </div><!-- media -->
                </a>
                <div class="dropdown-footer">
                  <a href=""><i class="fa fa-angle-down"></i> Show All Notifications</a>
                </div>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
          <div class="dropdown">
            <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $this->session->userdata('sess_full_name');?></span>
              <img src="http://via.placeholder.com/500x500" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href=""><img src="http://via.placeholder.com/500x500" class="wd-80 rounded-circle" alt=""></a>
                <h6 class="logged-fullname"><?php echo $this->session->userdata('sess_full_name');?></h6>
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
      
        
        <div id="content-container"></div>
        
        <div id="content-popup"></div>
        <br>
        <br>

        
        <footer class="br-footer">
            <div class="footer-left">
              <div class="mg-b-2">Copyright &copy; 2018. PT. Shailendra Tshai Indonesia. All Rights Reserved.</div>
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