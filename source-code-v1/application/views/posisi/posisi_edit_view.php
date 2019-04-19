<script type="text/javascript">
$(document).ready(function(){
    var tokens      = '<?php echo $tokens;?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var id_posisi   = '<?php echo $id_row;?>';
    
    $("#idposisi").val(id_posisi);
    
    $.ajax({
        url       : base_url + 'posisi/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_posisi  : id_posisi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
                $("#nama_posisi").val(res.nama_posisi);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan_role").click(function(){
        swal({
            title: "Update Nama Posisi ?",
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
            
            var form_data = new FormData($('#form_input')[0]);
            
            $.ajax({
                url       : base_url + 'posisi/update', 
                type      : "POST",
                dataType  : 'json',
                mimeType  : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(data)
                {

                    if(data == true){
                        $('#'+id_modal).modal('hide');
                        swal.close(); 
                        Command: toastr["success"]("Nama Posisi  Berhasil Di Update", "Berhasil");
                        getcontents('posisi','<?php echo $tokens;?>');   
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    }
                }
            });

        });
        
    });





    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Nama Posisi  ?",
            text: "Jika ingin dihapus, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
            //confirmButtonColor: "#286090"
        },
        function(){
            
            var form_data = new FormData($('#form_input')[0]);
            
            $.ajax({
                url       : base_url + 'posisi/hapus', 
                type      : "POST",
                dataType  : 'json',
                mimeType  : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(data)
                {

                    if(data == true){
                        $('#'+id_modal).modal('hide');
                        swal.close(); 
                        Command: toastr["success"]("Nama Posisi  Berhasil Di Hapus", "Berhasil");
                        getcontents('posisi','<?php echo $tokens;?>');   
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    }
                }
            });

        });
        
    });

});    

</script>




<div id="<?php echo $id_modal;?>" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content bd-0">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Posisi</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  
                  <form id="form_input" method=POST enctype='multipart/form-data'>
        <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" class="form-control" name="idposisi" id="idposisi">
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Posisi</label>
                <input type="text" id="nama_posisi" name="nama_posisi" class="form-control">
                </div>
                
            
      </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btn_simpan_role"><i class="fa fa-save"></i> Update</button>
                  <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
                <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->

