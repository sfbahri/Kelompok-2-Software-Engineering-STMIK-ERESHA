<script type="text/javascript">
$(document).ready(function(){
    var tokens      = '<?php echo $tokens;?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var id_vendor    = '<?php echo $id_row;?>';
   
    $.ajax({
        url       : base_url + 'vendor/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_vendor       : id_vendor,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
                $("#nama").val(res.nama);
                $("#no_telp").val(res.no_telp);
                $("#email").val(res.email);
                $("#alamat").val(res.alamat);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Vendor ?",
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
                url       : base_url + 'vendor/update',
                type      : "post",
                dataType  : 'json',
                data      : {nama       : $("#nama").val(),
                            no_telp     : $("#no_telp").val(),
                            email       : $("#email").val(),
                            alamat      : $("#alamat").val(),
                            id_vendor   :id_vendor,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Vendor berhasil diupdate", "Berhasil");
                            getcontents('vendor',tokens);
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
    
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Vendor ?",
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
                url       : base_url + 'vendor/update',
                type      : "post",
                dataType  : 'json',
                data      : {nama       : $("#nama").val(),
                            no_telp     : $("#no_telp").val(),
                            email       : $("#email").val(),
                            alamat      : $("#alamat").val(),
                            id_vendor   :id_vendor,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Vendor berhasil diupdate", "Berhasil");
                            getcontents('vendor',tokens);
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
    
    
    
    
    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Vendor ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'vendor/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_vendor   :id_vendor,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Vendor berhasil dihapus", "Berhasil");
                            getcontents('vendor',tokens);
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
    
   
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Vendor</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">  
            <div class="col-md-12">
                  <div class="form-group">
                  <label for="demo-vs-definput" class="control-label">Nama</label>
                      <input type="text" id="nama" name="nama" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="demo-vs-definput" class="control-label">No Telp</label>
                      <input type="text" id="no_telp" name="no_telp" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="demo-vs-definput" class="control-label">Email</label>
                      <input type="text" id="email" name="email" class="form-control">
                  </div>
                  <div class="form-group">
                      <label for="demo-vs-definput" class="control-label">Alamat</label>
                      <textarea type="text" id="alamat" name="alamat" class="form-control">

                      </textarea>
                  </div>
            </div> 
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>


