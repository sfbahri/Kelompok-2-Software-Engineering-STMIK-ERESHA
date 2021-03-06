<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var tokens    = '<?php echo $tokens;?>';
    var id_aksesoris    = '<?php echo $id_row;?>';
   
    $("#id_aksesoris").val(id_aksesoris);
   
    $.ajax({
        url       : base_url + 'aksesoris/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_aksesoris : id_aksesoris,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $("#nama").val(response.nama);
            $("#gambar_asli").val(response.gambar);
            $("#jumlah").val(response.stok_awal);
            $("#no_faktur").val(response.no_faktur);
            $("#harga").val(response.harga);
            $("#tanggal").val(response.tgl);
            var gambar = '<div style="width:100%;text-align:left"><img src="uploads/aksesoris/rz_'+response.gambar+'" style="width:100px;height:100px"></div>';
            $("#gambar_asli_view").append(gambar);
            
            if(response.satuan == 1){
                $("#radio_satuan").append('<label class="radio-inline"><input type="radio" name="satuan" value="1" checked> Pcs </label> <label class="radio-inline"> <input type="radio" name="satuan" value="2"> Kg</label>');
            }else{
                $("#radio_satuan").append('<label class="radio-inline"><input type="radio" name="satuan" value="1"> Pcs </label> <label class="radio-inline"> <input type="radio" name="satuan" value="2" checked> Kg</label>');
            }
            
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Aksesoris ?",
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

            $.ajax({
                url             : base_url + 'aksesoris/update', 
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
    
    
    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Aksesoris ?",
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
                url       : base_url + 'aksesoris/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_aksesoris:id_aksesoris,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Aksesoris berhasil dihapus", "Berhasil");
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

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Aksesoris</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_aksesoris" name="id_aksesoris" class="form-control">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Aksesoris</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlah Barang</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control">
                </div>
                <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <div id="radio_satuan"></div>
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tanggal" name="tanggal">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
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
            
<!--                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Ganti Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>-->
            </form>
              
              
              
              
        </div>  
          
        </div>      
      </div>
      <div class="modal-footer">
          
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="ft-trash"></i> Hapus</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>

      </div>
    </div>

  </div>
</div>



