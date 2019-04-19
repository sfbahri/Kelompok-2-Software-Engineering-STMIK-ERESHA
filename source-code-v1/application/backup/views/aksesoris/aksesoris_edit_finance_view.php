<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var tokens    = '<?php echo $tokens;?>';
    var id_aksesoris    = '<?php echo $id_row;?>';
   
    $("#id_aksesoris").val(id_aksesoris);
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
   
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
                $("#radio_satuan").html('<label class="radio-inline"> * Pcs </label>');
            }else{
                $("#radio_satuan").html('<label class="radio-inline"> * Kg</label>');
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
                url             : base_url + 'aksesoris/finance_update', 
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
                        Command: toastr["success"]("Harga Aksesoris berhasil disimpan", "Berhasil");
                        getcontents('aksesoris/finance_index','<?php echo $tokens;?>');
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

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Aksesoris</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="form" id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_aksesoris" name="id_aksesoris" class="form-control">
            
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Aksesoris</label>
                    <input type="text" id="nama" name="nama" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlah / Stok</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <div id="radio_satuan"></div>
                </div>
                <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Harga</label>
                        <input type="text" id="harga" name="harga" class="form-control maskmoney" style="border-color:#ca706e">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Sampai</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" readonly="">
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
            
<!--                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Ganti Gambar</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>-->
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update Harga</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

