<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_kloter   = '<?php echo $id_row;?>';
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Tambahkan Kloter Baru ?",
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
                url       : base_url + 'jamaah/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama        : $("#nama").val(),
                            no_paspor    : $("#no_paspor").val(),
                            tgl_lahir    : $("#tgl_lahir").val(),
                            kota_asal    : $("#kota_asal").val(),
                            email        : $("#email").val(),
                            id_kloter    : id_kloter,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Jamaah berhasil disimpan", "Berhasil");
                        getcontents('jamaah/by_kloter','<?php echo $tokens;?>','<?php echo $id_row;?>');

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
   
    myFunction = function() {
        var x = document.getElementById("nama");
        x.value = x.value.toUpperCase();
    }
    
    myFunction2 = function() {
        var x = document.getElementById("kota_asal");
        x.value = x.value.toUpperCase();
    }
    
    myFunction3 = function() {
        var x = document.getElementById("no_paspor");
        x.value = x.value.toUpperCase();
    }
    
    $("#tgl_lahir").datepicker();
    
    
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Jamaah</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">  
            <div class="col-md-6">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">No. PASPOR</label>
                    <input type="text" id="no_paspor" name="no_paspor" class="form-control" onkeyup="myFunction3()">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" onkeyup="myFunction()">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kota Asal</label>
                    <input type="text" id="kota_asal" name="kota_asal" class="form-control" onkeyup="myFunction2()">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Email</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email Aktif wajib isi disini..">
                </div>
            </div> 
        </div>
          
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



