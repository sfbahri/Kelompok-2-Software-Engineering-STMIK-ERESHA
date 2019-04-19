<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
   
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Aksesoris ?",
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
                url             : base_url + 'aksesoris/simpan', 
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
                        Command: toastr["success"]("Aksesoris berhasil disimpan", "Berhasil");
                        getcontents('aksesoris','<?php echo $tokens;?>');
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
   
    $('#tanggal').datepicker();
    
    
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Aksesoris</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Aksesoris</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlah / Stok</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control maskmoney" onkeypress="return isNumber(event)">
                </div>
                
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <label class="radio-inline">
                        <input type="radio" name="satuan" value="1"> Pcs
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="satuan" value="2"> Kg
                      </label>
                </div>
            
            
                <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control maskmoney">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Sampai</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tanggal" name="tanggal">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

