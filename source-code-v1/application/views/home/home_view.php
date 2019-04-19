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
          <h4 class="tx-normal tx-roboto tx-white"> Hi, <?php echo ucwords($this->session->userdata('sess_nama'));?></h4>

          <p class="wd-md-500 mg-md-l-auto mg-md-r-auto mg-b-25">Selamat Datang di Website Administrator</p>

          <p class="mg-b-0 tx-24 mg-md-l-auto">
<!--            <nav class="nav text-center" style="text-align: center">
                <a href="" class="nav-link" title="Pengaturan">
                    <span class="iconwrap bg-gray-200 icon-32" style="border-radius: 5px"><i class="fa fa-cog"></i></span>
                    <p style="color:white">Pengaturan</p>
                </a>
                <a href="javascript:void(0)" onclick="getcontents('login/ubah_password','<?php echo $this->session->userdata('sess_token');?>')" class="nav-link" title="Ubah Kata Sandi">
                    <span class="iconwrap bg-gray-200 icon-32" style="border-radius: 5px"><i class="fa fa-lock"></i></span>
                    <p style="color:white">Password</p>
                </a>
            </nav>    -->
          </p>
        </div><!-- card-body -->
        
      </div><!-- card -->
    </div>