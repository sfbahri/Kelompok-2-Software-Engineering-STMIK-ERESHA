<script type="text/javascript">
$(document).ready(function(){
    var id_modal        = '<?php echo $id_modal;?>';
    var tokens          = '<?php echo $tokens;?>';
    var id_berita       = '<?php echo $id_row;?>';
   
    tinyMCE.remove();
    getMCE();
    loading();
   
   
    $("#id_berita").val(id_berita);
   
    $.ajax({
        url       : base_url + 'berita/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_berita : id_berita,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            
            $("#judul").val(response.judul);
            var gambar = '<div style="width:100%;text-align:left"><img src="./uploads/img_berita/rz_'+response.gambar+'" style="width:100px;height:100px"></div>';
            $("#gambar_asli_view").append(gambar);
            $("#gambar_asli").val(response.gambar);
            var ed1 = tinyMCE.get('deskripsi');
            // Do you ajax call here, window.setTimeout fakes ajax call
            ed1.setProgressState(1); // Show progress
            window.setTimeout(function() {
                ed1.setProgressState(0); // Hide progress
                ed1.setContent(response.deskripsi);
            }, 1000);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan").click(function(){
        
        tinyMCE.triggerSave();
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Blog / Berita ?",
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

            //tinyMCE.triggerSave();

            $.ajax({
                url             : base_url + 'berita/update', 
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
                        Command: toastr["success"]("Blog / Berita berhasil diupdate", "Berhasil");
                        getcontents('berita','<?php echo $tokens;?>');
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
            title: "Hapus Blog / Berita ?",
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
                url       : base_url + 'berita/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_berita:id_berita,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Berita berhasil dihapus", "Berhasil");
                            getcontents('berita','<?php echo $tokens;?>');
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
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Blog / Berita</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_berita" name="id_berita" class="form-control">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Judul</label>
                    <input type="text" id="judul" name="judul" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Gambar Saat Ini</label>
                    <div id="gambar_asli_view"></div>
                    <input type="hidden" id="gambar_asli" name="gambar_asli">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Ganti Foto/Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>
                <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="9" class="form-control mceEditor"></textarea>
                </div>
            
            
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

