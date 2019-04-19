<script type="text/javascript">
$(document).ready(function(){
    var id_modal           = '<?php echo $id_modal;?>';
    var id_kas_kategori    = '<?php echo $id_row;?>';
    
    $.ajax({
        url       : base_url + 'kas/kas_kategori_detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_kas_kategori:id_kas_kategori,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (response) {
            $("#id").val(response.id);
            $("#nama").val(response.nama);
            $("#sisa_saldo").val(response.saldo_akhir_temp);
            $("#sisa_saldo_asli").val(response.saldo_akhir);
            $("#saldo_awal_asli").val(response.saldo_awal);
        },
    error: function(jqXHR, textStatus, errorThrown) {
        Command: toastr["error"]("Ajax Error !!", "Error");
    }

    });
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Saldo Kas ?",
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
                url       : base_url + 'kas/kas_kategori_tambah_saldo',
                type      : "post",
                dataType  : 'json',
                data      : {sisa_saldo : $("#sisa_saldo_asli").val(),
                            saldo_awal  : $("#saldo_awal_asli").val(),
                            isi_saldo   : $("#isi_saldo").val(),
                            tgl_transfer: $("#tgl_transfer").val(),
                            catatan     : $("#catatan").val(),
                            id          : $("#id").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Kas kategori berhasil disimpan", "Berhasil");
                        getcontents('kas/kas_kategori','<?php echo $tokens;?>');
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
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    $('#tgl_transfer').datepicker();
    
    
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Kas Saldo</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">  
                <div class="col-md-12">
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Kas</label>
                    <input type="hidden" id="id" name="id" class="form-control" readonly="">
                    <input type="text" id="nama" name="nama" class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Sisa Saldo</label>
                        <input type="text" id="sisa_saldo" name="sisa_saldo" class="form-control" readonly="">
                        <input type="hidden" id="sisa_saldo_asli" name="sisa_saldo_asli" class="form-control" readonly="">
                        <input type="hidden" id="saldo_awal_asli" name="saldo_awal_asli" class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Masukan Jumlah Saldo yang ingin ditambah</label>
                    <input type="text" id="isi_saldo" name="isi_saldo" class="form-control maskmoney" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Tanggal Transfer Saldo</label>
                        <input type="text" id="tgl_transfer" name="tgl_transfer" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Catatan</label>
                        <input type="text" id="catatan" name="catatan" class="form-control">
                    </div>
                </div> 
            </div> 
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

