<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>e-recruitment</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('assets/web/vendor/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url('assets/web/css/shop-homepage.css');?>" rel="stylesheet">

  <link href="<?php echo base_url('assets/lib/toastr/toastr.css');?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url('assets/lib/sweetalert/sweetalert.css');?>" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<style>
body {
    font-family: 'Exo 2';
}
</style>

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #0a0a4d;color: white">
    <div class="container">
      <a class="navbar-brand" href="#" style="font-size: 28px"><b>e-</b>recruitment</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url();?>"><i class="fa fa-home"></i> Halaman Depan</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">
        <br>
        <div class="list-group">
          <a href="<?php echo base_url();?>" class="list-group-item list-group-item-primary"><i class="fa fa-home"></i> Home</a>
          <a href="<?php echo base_url('posisi');?>" class="list-group-item list-group-item-info"><i class="fa fa-edit"></i> Lihat Posisi</a>
          <a href="#" class="list-group-item list-group-item-primary"><i class="fa fa-info-circle"></i> Informasi</a>
        </div>

      </div>
      <!-- /.col-lg-3 -->

    <div class="col-lg-9">

      <?php include "webmain_konten_view.php";?>
        
        <br>
        <br>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->
</div>
  <!-- Footer -->

  <style type="text/css">
    .footer-fixed {
    position: fixed;
    height: 30px;
    bottom: 0px;
    width: 100%;
    background-color: #040425;
}
  </style>

  <footer class="footer-fixed navbar-dark">

      <p class="m-0 text-center text-white" style="font-size: 12px;padding-top: 5px">Copyright &copy; e-recruitment PT.ABC 2019</p>

  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url('assets/web/vendor/jquery/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
  <script src="<?php echo base_url('assets/lib/toastr/toastr.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/sweetalert/sweetalert.min.js');?>" type="text/javascript"></script>

  <script type="text/javascript">
      
        function validate(evt) {
          var theEvent = evt || window.event;

          // Handle paste
          if (theEvent.type === 'paste') {
              key = event.clipboardData.getData('text/plain');
          } else {
          // Handle key press
              var key = theEvent.keyCode || theEvent.which;
              key = String.fromCharCode(key);
          }
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }


        $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Kirim Aplikasi Lamaran ini ?",
            text: "Jika ingin dikirim, silahkan klik button kirim",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Kirim",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){
            
            var base_url = '<?php echo base_url();?>';

            $.ajax({
                url             : base_url + 'webmain/simpan', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(response){

                    if(response == true){ 
                        Command: toastr["success"]("Terima Kasih, Aplikasi Lamaran Berhasil disimpan", "Ok Berhasil");

                        setTimeout(function(){ 
                          window.location.href = '<?php echo base_url('posisi');?>';
                        }, 3000);

                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
        
    });
   
    </script>

</body>

</html>
