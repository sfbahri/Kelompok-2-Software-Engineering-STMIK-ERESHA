<script type="text/javascript">
$(document).ready(function(){
    var id_modal         = '<?php echo $id_modal;?>';
    var tokens           = '<?php echo $tokens;?>';
    var id_bahan_baku    = '<?php echo $id_row;?>';
   
    $.ajax({
        url       : base_url + 'bahan_baku/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_bahan_baku      : id_bahan_baku,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $("#nama").val(response.nama);
            $("#jenis").val(response.jenis);
            $("#warna").val(response.warna);
            $("#no_faktur").val(response.no_faktur);
            $("#tanggal").val(response.tgl_sampai);
            $("#jumlah").val(response.jumlah);
            
            if(response.satuan == 1){
                $("#radio_satuan").append('<label class="radio-inline"><input type="radio" name="satuan" value="1" checked> Rol </label> <label class="radio-inline"> <input type="radio" name="satuan" value="2"> Kg</label>');
            }else{
                $("#radio_satuan").append('<label class="radio-inline"><input type="radio" name="satuan" value="1"> Rol </label> <label class="radio-inline"> <input type="radio" name="satuan" value="2" checked> Kg</label>');
            }
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Bahan Baku ?",
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
                url       : base_url + 'bahan_baku/update',
                type      : "post",
                dataType  : 'json',
                data      : {nama        : $("#nama").val(),
                            jenis        : $("#jenis").val(),
                            warna        : $("#warna").val(),
                            no_faktur    : $("#no_faktur").val(),
                            tanggal      : $("#tanggal").val(),
                            id_bahan_baku:id_bahan_baku,
                            jumlah       : $("#jumlah").val(),
                            satuan       : $('input[name="satuan"]:checked').val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Bahan Baku berhasil diupdate", "Berhasil");
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
    
    
    
    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Bahan Baku ?",
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
                url       : base_url + 'bahan_baku/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_bahan_baku:id_bahan_baku,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Bahan Baku berhasil dihapus", "Berhasil");
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
            <h4 class="modal-title">Edit Bahan Baku</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
                
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
                    <label for="demo-vs-definput" class="control-label">Jumlah</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <div id="radio_satuan"></div>
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
        </div>  
          
        </div>      
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="ft-trash"></i> Hapus</button>
            <button type="button" class="btn btn-success" data-dismiss="modal"><i class="ft-refresh-ccw"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>



