<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    
    $.ajax({
        url       : base_url + 'kas/max_id',
        type      : "post",
        dataType  : 'json',
        data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (response) {
            var ids = parseInt(response.max_id) + parseInt(1);
            $("#id").val(ids);
        },
    error: function(jqXHR, textStatus, errorThrown) {
        Command: toastr["error"]("Ajax Error !!", "Error");
    }

    });
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Kas Kategori Baru ?",
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
                url       : base_url + 'kas/kas_kategori_simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama       : $("#nama").val(),
                            saldo_awal  : $("#saldo_awal").val(),
                            tgl_transfer: $("#tgl_transfer").val(),
                            catatan     : $("#catatan").val(),
                            id          : $("#id").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Kas kategori berhasil disimpan", "Berhasil");
                        getcontents('kas/kas_kategori','<?php echo $tokens;?>');
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
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#tgl_transfer').datepicker();
    
    
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Kas Kategori</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">  
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">ID Kas</label>
                    <input type="text" id="id" name="id" class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Kas</label>
                        <input type="text" id="nama" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Saldo Awal</label>
                        <input type="text" id="saldo_awal" name="saldo_awal" class="form-control maskmoney">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Tanggal Transfer Saldo</label>
                        <input type="text" id="tgl_transfer" name="tgl_transfer" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Catatan</label>
                        <input type="text" id="catatan" name="catatan" class="form-control">
                    </div>
                </div> 
            </div> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

