<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_produksi_detail = '<?php echo $id_row;?>';
    var publish       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    $(".id_produksi_detail").val(id_produksi_detail);
    
    $('#tanggal').datepicker();
    
    
    $("#btn_selesai").click(function(){
        
         var form_data = new FormData($('#form_input2')[0]);
        
        swal({
            title: "Finishing Produksi ?",
            text: "Silahkan periksa kembali inputan hasil pengerjaan sablon.",
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
                url             : base_url + 'finishing/update', 
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
                        Command: toastr["success"]("Proses Produksi Selesai", "Berhasil");
                        getcontents('finishing','<?php echo $tokens;?>');
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
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  
</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detail Finishing</h4>
        </div>
        <div class="modal-body">
        
            <form id="form_input2"  method=POST enctype='multipart/form-data'>
                      
                      <input type="hidden" id="id_produksi_detail" name="id_produksi_detail" class="form-control id_produksi_detail">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
                    
                    <div class="form-group">
                        <label for="timesheetinput3">Tanggal Serah Terima</label>
                        <div class="position-relative has-icon-left">
                            <input type="text" class="form-control" id="tanggal" name="tanggal">
                            <div class="form-control-position">
                                  <i class="ft-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Jenis Barang</label>
                        <input type="text" id="jenis_barang" name="jenis_barang" class="form-control">
                    </div>  
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Qty</label>
                        <input type="text" id="qty" name="qty" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Upload Gambar Selesai</label>
                        <input type="file" id="c_gambar" name="c_gambar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Catatan</label>
                        <textarea type="text" id="catatan" name="catatan" class="form-control"></textarea>
                    </div>
                </form> 
            
        </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-info" id="btn_selesai"><i class="la la-check-square-o"></i> Produksi Selesai (Finishing)</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="la la-refresh"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


