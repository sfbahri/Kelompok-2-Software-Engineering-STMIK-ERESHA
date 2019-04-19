<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Warna ?",
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
                url       : base_url + 'warna/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama       : $("#nama").val(),
                            inisial     : $("#inisial").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Warna berhasil disimpan", "Berhasil");
                        getcontents('warna','<?php echo $tokens;?>');
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
    
    
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Warna</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Inisial</label>
                <input type="text" id="inisial" name="inisial" class="form-control" placeholder="Maksimal 3 huruf" maxlength="3">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Warna</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
            </div> 
            </div>
        </div>
        <div class="modal-footer">
             <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

