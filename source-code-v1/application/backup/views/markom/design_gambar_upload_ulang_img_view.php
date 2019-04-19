<script type="text/javascript">
$(document).ready(function(){
    var id_modal         = '<?php echo $id_modal;?>';
    var tokens           = '<?php echo $tokens;?>';
    var idgambar         = '<?php echo $id_row;?>';
    
    $("#idgambar").val(idgambar);
    
    var get_seq = function(){
        
        $.ajax({
            url       : base_url + 'markom/gambar_details',
            type      : "post",
            dataType  : 'json',
            data      : {kodegambar : idgambar,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#gambarbro").html('<img src="./uploads/produksi/'+response.gambar+'" style="width:200px;heigth:200px">'); 
                $("#gambar_asli_design").val(response.gambar);
                $("#noso").val(response.noso);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    get_seq();
   
   
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Gambar ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Update",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url             : base_url + 'markom/gambar_design_update', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(response){
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        var nosos = $("#noso").val();
                        Command: toastr["success"]("Harga Aksesoris berhasil disimpan", "Berhasil");
                        getcontents('markom/design_gambar_produksi_upload_stf','<?php echo $tokens;?>',''+nosos+'');
                        //getcontents('aksesoris/finance_index','<?php echo $tokens;?>');
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
    <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Kode Gambar : <a href="javascript:void(0)" style="font-weight:bold"><?php echo $id_row;?></a></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="idgambar" name="idgambar" class="form-control">
            <input type="hidden" id="gambar_asli_design" name="gambar_asli_design" class="form-control">
            <input type="hidden" id="noso" name="noso" class="form-control">
            
            
            <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Gambar Saat Ini</label>
                    <div id="gambarbro" style="align:center"></div>
                </div>
            <hr>
            <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Update Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update Gambar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

