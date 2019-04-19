<script>
    
    var tokens = '<?php echo $tokens;?>';
   
    //aksi simpan transaksi
    $("#btn_simpan_password").click(function(){
        
        if($("#password_baru").val() == ''){
            Command: toastr["error"]("Password tidak boleh kosong", "Error");
            $("#password_baru").focus();
        }else{
            
            swal({
            title: "Simpan Password Baru ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Simpan",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'login/ubah_password_simpan',
                type      : "post",
                dataType  : 'json',
                data      : {password_baru  : $("#password_baru").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Password Baru Berhasil Disimpan", "Berhasil");
                        $("#password_baru").val('');
                        window.location = '<?php echo base_url('main/logout');?>'; 
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
            
        }
        
    });
    
    
</script>

<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
      <span class="breadcrumb-item active">Ubah Password</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-pagetitle">
    <i class="icon icon ion-ios-lock"></i>
    <div>
      <h4>Ubah Password</h4>
      <p class="mg-b-0">Halo <?php echo $this->session->userdata('sess_nama');?>,  anda berada Halaman ubah password.</p>
    </div>
</div><!-- d-flex -->

<div class="card col-md-6" style="margin:20px;" id="form_input_no_nota">
<div class="card-body">
    <label>Masukan Password Baru :</label>
    <div class="d-md-flex pd-y-20 pd-md-y-0">
        <input type="text" class="form-control" name="password_baru" id="password_baru" placeholder="Masukan Password Baru" >
        <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_simpan_password" style="cursor:pointer" title="Mulai Transaksi Baru"><i class="fa fa-refresh"></i> Simpan Password Baru</button>
    </div>
    <small style="color:red">Harap diingat / dicatatat password baru ini !</small>
    <br>
    <br>
    * Info : <br>
    <small>Untuk menjaga keamanan sistem, setelah melakukan perubahan password dan berhasil , maka sistem akan secara otomatis logout. Setelah itu bapak/ibu bisa login kembali dengan password yang baru.</small>
</div>
</div>
