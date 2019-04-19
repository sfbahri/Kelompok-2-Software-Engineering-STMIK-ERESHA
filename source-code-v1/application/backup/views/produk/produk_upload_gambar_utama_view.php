<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
   
    var kode_produk     = '<?php echo $id_row;?>';

    $.ajax({
            url       : base_url + 'produk/details',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk : kode_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#nama_produk").val(response.nama);
                $("#gambar_asli").val(response.img);
                var gambar;
                if(response.img == null){
                    gambar = '<span style="color:red"><img src="assets/img/noimages.jpg"></span>';
                }else{
                    gambar = '<div style="width:100%;text-align:left"><img src="uploads/produk/rz_'+response.img+'" style="width:200px;height:200px"></div>';
                }
                 
                $("#gambar_asli_view").append(gambar);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
   
   
    $("#btn_simpan_produksi").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Gambar Utama Produk ?",
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
                url             : base_url + 'produk/upload_gambar_utama_media', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success         : function(response){
          
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Produk berhasil disimpan", "Berhasil");
                        getcontents('produk','<?php echo $tokens;?>');
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

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
      
    <!-- Modal content-->
    <div class="modal-content ">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Gambar Produk</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Produk</label>
                <input type="text" id="kode_produk" name="kode_produk" class="form-control" value="<?php echo $id_row;?>" readonly>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Gambar Saat Ini</label>
                    <div id="gambar_asli_view"></div>
                    <input type="hidden" id="gambar_asli" name="gambar_asli">
                </div>
                
                <div class="form-group">
                    <label>Ganti Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>
                
            </div>  
        </form>   
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_simpan_produksi"><i class="ft-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
    </div>
    </div>

  </div>
</div>



