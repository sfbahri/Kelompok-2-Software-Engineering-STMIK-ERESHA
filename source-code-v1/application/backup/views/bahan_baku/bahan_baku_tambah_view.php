<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Bahan Baku ?",
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
                url       : base_url + 'bahan_baku/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama        : $("#nama").val(),
                            jenis        : $("#jenis").val(),
                            warna        : $("#warna").val(),
                            no_faktur    : $("#no_faktur").val(),
                            tanggal      : $("#tanggal").val(),
                            jumlah       : $("#jumlah").val(),
                            satuan       : $('input[name="satuan"]:checked').val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Bahan Baku berhasil disimpan", "Berhasil");
                        getcontents('bahan_baku','<?php echo $tokens;?>');
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
   
    $('#tanggal').datepicker({todayHighlight: true});
   
});    

</script>

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Bahan Baku</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
              <section id="basic-form-layouts">  
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Bahan Baku</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jenis Bahan Baku</label>
                    <input type="text" id="jenis" name="jenis" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Warna</label>
                    <input type="text" id="warna" name="warna" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlahx</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" onkeypress="return isNumber(event)">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <label class="radio-inline">
                        <input type="radio" name="satuan" value="1"> Rol
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="satuan" value="2"> Kg
                      </label>
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">No Faktur</label>
                    <input type="text" id="no_faktur" name="no_faktur" class="form-control">
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
            </section>  
        </div>  
          
        </div>      
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>



