<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_album    = '<?php echo $id_row;?>';
    
    $.ajax({
        type: 'POST',
        url: base_url + 'media/album_detail',
        data: {id_album:id_album},
        dataType  : 'json',
        success: function (data) {
            
            $('#idalbum').val(data.id);
            $("#namaalbum").val(data.nama);
        }
    });


    $("#btn_update").click(function(){
        
        
        if($("#namaalbum").val() == ''){
                Command: toastr["warning"]("Nama Album tidak boleh kosong!", "Info");
            $("#namaalbum").focus();
        }else{
            swal({
                title: "Update Album ?",
                text: "Silahkan periksa kembali harga yang ingin disimpan.",
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
                url       : base_url + 'media/album_update',
                type      : "post",
                dataType  : 'json',
                data      : {id_album:id_album,nama_album : $("#namaalbum").val(), <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response){
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Album berhasil diupdate", "Berhasil");
                        getcontents('media/album','<?php echo $tokens;?>');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });

            });
        }
        
    });

});    

</script>

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Album</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Album</label>
                <input type="text" id="namaalbum" name="namaalbum" class="form-control">
                <input type="hidden" id="idalbum" name="idalbum" class="form-control">
                </div>
          
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_update"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



