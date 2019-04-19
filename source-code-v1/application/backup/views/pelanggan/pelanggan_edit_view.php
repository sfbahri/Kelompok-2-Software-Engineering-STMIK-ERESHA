<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id         = '<?php echo $id_row;?>';
    $.ajax({
        type: 'POST',
        url: base_url + 'pelanggan/pelanggan_detail',
        data: {id:id,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        dataType  : 'json',
        success: function (data) {
            $("#id").val(data.id);
            $("#nama").val(data.nama);
            $("#email").val(data.email);
            $("#alamat").val(data.alamat);
            $("#no_hp").val(data.nohp);
            $("#limit").val(data.saldo_limit);

        }
    });
    
    //agama
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Data pelanggan Baru ?",
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
                url       : base_url + 'pelanggan/pelanggan_update',
                type      : "post",
                dataType  : 'json',
                data      : {id           : $("#id").val(),
                            nama          : $("#nama").val(),
                            email         : $("#email").val(),
                            alamat        : $("#alamat").val(),
                            no_hp         : $("#no_hp").val(),
                            limit         : $("#limit").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data pelanggan berhasil disimpan", "Berhasil");
                        getcontents('pelanggan','<?php echo $tokens;?>');
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
   
    //$('#biaya_asuransi').maskMoney();
    
    myFunction = function() {
        var x = document.getElementById("nama");
        x.value = x.value.toUpperCase();
    }
    
    $("#tgl_masuk,#tgl_lahir").datepicker();
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit pelanggan</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">
             <div class="col-md-12">
                <div class="form-group">
                <input type="hidden" id="id" name="">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Email <span style="color:red">*</span></label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control">
                </div>
                <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Limit</label>
                        <input type="text" id="limit" name="limit" class="form-control maskmoney">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control"></textarea>
                </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



