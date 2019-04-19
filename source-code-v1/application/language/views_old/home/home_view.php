<?php 
if($this->session->userdata('sess_level') == 3){
?>


<div class=" br-profile-page">

      <div class="card shadow-base bd-0 rounded-0 widget-4">
        <div class="card-header ht-75">
          <div class="hidden-xs-down">
            <a href="" class="mg-r-10"><i class="fa fa-home"></i> Home</a>
          </div>
          <div class="tx-24 hidden-xs-down">
            <a href="" class="mg-r-10"><i class="fa fa-envelope"></i></a>
            <a href=""><i class="icon ion-more"></i></a>
          </div>
        </div><!-- card-header -->
        <div class="card-body">
          <div class="card-profile-img">
            <img src="<?php echo base_url('assets/img/jamaah.png');?>" >
          </div><!-- card-profile-img -->
          <h4 class="tx-normal tx-roboto tx-white"> <?php echo ucwords($this->session->userdata('sess_nama'));?></h4>
          <p class="mg-b-25">KODE JAMAAH : <?php echo $this->session->userdata('sess_id_jamaah');;?></p>

          <p class="wd-md-500 mg-md-l-auto mg-md-r-auto mg-b-25">Selamat Datang di Content Management System UTM (Umroh Tiket Murah)</p>

          <p class="mg-b-0 tx-24">
              <a href="javascript:void(0)" onclick="getcontents('login/ubah_password','<?php echo $this->session->userdata('sess_token');?>')" class="tx-white-8 mg-r-5" title="Ubah Kata Sandi"><i class="fa fa-lock"></i></a>
<!--            <a href="" class="tx-white-8 mg-r-5"><i class="fa fa-twitter"></i></a>
            <a href="" class="tx-white-8 mg-r-5"><i class="fa fa-pinterest"></i></a>
            <a href="" class="tx-white-8"><i class="fa fa-instagram"></i></a>-->
          </p>
        </div><!-- card-body -->
      </div><!-- card -->
    </div>
<?php
}else{
?>
<div class=" br-profile-page">

      <div class="card shadow-base bd-0 rounded-0 widget-4">
        <div class="card-header ht-75">
          <div class="hidden-xs-down">
            <a href="" class="mg-r-10"><i class="fa fa-home"></i> Home</a>
          </div>
          <div class="tx-24 hidden-xs-down">
            <a href="" class="mg-r-10"><i class="fa fa-envelope"></i></a>
            <a href=""><i class="icon ion-more"></i></a>
          </div>
        </div><!-- card-header -->
        <div class="card-body">
            <div class="card-profile-img" >
            <img src="<?php echo base_url('assets/img/jamaah.png');?>" >
          </div><!-- card-profile-img -->
          <h4 class="tx-normal tx-roboto tx-white"> <?php echo ucwords($this->session->userdata('sess_nama_admin'));?></h4>
          <p class="mg-b-25">KODE ADMIN : <?php echo $this->session->userdata('sess_id_admin');;?></p>

          <p class="wd-md-500 mg-md-l-auto mg-md-r-auto mg-b-25">Selamat Datang di Content Management System UTM (Umroh Tiket Murah)</p>

          <p class="mg-b-0 tx-24">
              <a href="javascript:void(0)" onclick="getcontents('login/ubah_password','<?php echo $this->session->userdata('sess_token');?>')" class="tx-white-8 mg-r-5" title="Ubah Kata Sandi"><i class="fa fa-lock"></i></a>
<!--            <a href="" class="tx-white-8 mg-r-5"><i class="fa fa-twitter"></i></a>
            <a href="" class="tx-white-8 mg-r-5"><i class="fa fa-pinterest"></i></a>
            <a href="" class="tx-white-8"><i class="fa fa-instagram"></i></a>-->
          </p>
        </div><!-- card-body -->
      </div><!-- card -->
    </div>
<?php
}
?>