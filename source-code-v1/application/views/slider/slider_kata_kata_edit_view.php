<script type="text/javascript">
$(document).ready(function(){
    var id_modal        = '<?php echo $id_modal;?>';
    var tokens          = '<?php echo $tokens;?>';
    var id_slider       = '<?php echo $id_row;?>';
   
    loading();
   
   
    $("#id_slider").val(id_slider);
   
    $.ajax({
        url       : base_url + 'slider/detail_kata',
        type      : "post",
        dataType  : 'json',
        data      : {id_slider : id_slider,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            
            $("#kata_1").val(response.kata_1);
            $("#kata_2").val(response.kata_2);
            $("#kata_3").val(response.kata_3);

            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Kata Kata Slider ini ?",
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
                url             : base_url + 'slider/update', 
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
                        Command: toastr["success"]("Kata Kata Slider berhasil diupdate", "Berhasil");
                        getcontents('slider','<?php echo $tokens;?>');
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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Kata-Kata Slider</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_slider" name="id_slider" class="form-control">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Kata 1</label>
                    <input type="text" id="kata_1" name="kata_1" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Kata 2</label>
                    <input type="text" id="kata_2" name="kata_2" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Kata 3</label>
                    <input type="text" id="kata_3" name="kata_3" class="form-control">
                </div>
            
            
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

