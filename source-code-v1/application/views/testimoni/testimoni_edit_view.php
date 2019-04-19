<script type="text/javascript">
$(document).ready(function(){
    var id_modal        = '<?php echo $id_modal;?>';
    var tokens          = '<?php echo $tokens;?>';
    var id_testimoni       = '<?php echo $id_row;?>';
   
    tinyMCE.remove();
    getMCE();
    loading();
   
   
    $("#id_testimoni").val(id_testimoni);
   
    $.ajax({
        url       : base_url + 'testimoni/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_testimoni : id_testimoni,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            
            $("#nama").val(response.nama);
            $("#perusahaan").val(response.perusahaan);
            $("#jabatan").val(response.jabatan);
            var gambar = '<div style="width:100%;text-align:left"><img src="./uploads/img_testimoni/rz_'+response.foto+'" style="width:100px;height:100px"></div>';
            $("#gambar_asli_view").append(gambar);
            $("#gambar_asli").val(response.foto);
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
            title: "Update Testimoni ?",
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
                url             : base_url + 'testimoni/update', 
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
                        Command: toastr["success"]("Testimoni berhasil diupdate", "Berhasil");
                        getcontents('testimoni','<?php echo $tokens;?>');
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
            title: "Hapus Testimoni ?",
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
                url       : base_url + 'testimoni/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_testimoni:id_testimoni,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Testimoni berhasil dihapus", "Berhasil");
                            getcontents('testimoni','<?php echo $tokens;?>');
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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Testimoni</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_testimoni" name="id_testimoni" class="form-control">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Perusahaan</label>
                    <input type="text" id="perusahaan" name="perusahaan" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Gambar Saat Ini</label>
                    <div id="gambar_asli_view"></div>
                    <input type="hidden" id="gambar_asli" name="gambar_asli">

                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Ganti Foto/Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                    <p>
                    <span style="font-size: 12px">* Gambar yang disarankan : 285x285</span>
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

