<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produk = '<?php echo $id_row;?>';
    var publish       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    alert('sss')
    
    $('#tanggal').datepicker();
    
    $("#btn_simpan").click(function(){
        
         var form_data = new FormData($('#form_input2')[0]);
        
        swal({
            title: "Update Harga?",
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
                url             : base_url + 'finance/simpan', 
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
                        Command: toastr["success"]("Update Harga Berhasil", "Berhasil");
                        getcontents('finance/input_harga_dasar','<?php echo $tokens;?>');
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
            <h4 class="modal-title">Input Harga Dasar</h4>
        </div>
        <div class="modal-body">
        
            <form id="form_input2"  method=POST enctype='multipart/form-data'>
                      
                      <input type="hidden" id="id_produksi_detail" name="id_produksi_detail" class="form-control id_produksi_detail">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
                  
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Kode Produk</label>
                        <input type="text" id="kode_produk" name="kode_produk" class="form-control" value="<?php echo $id_row;?>" readonly="">
                    </div>  
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Harga Modal</label>
                        <input type="text" id="harga_modal" name="harga_modal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Harga Jual</label>
                        <input type="text" id="harga_jual" name="harga_jual" class="form-control">
                    </div>
                </form> 
            
        </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-info" id="btn_simpan"><i class="la la-check-square-o"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="la la-refresh"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


