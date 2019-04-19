<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_produksi_detail = '<?php echo $id_row;?>';
    var publish       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    $(".id_produksi_detail").val(id_produksi_detail);
    
    get_produksi_detail = function(){
        
    $.ajax({
        url       : base_url + 'produksi/data_produksi_detail_by_id',
        type      : "post",
        dataType  : 'json',
        data      : {id_produksi_detail  : id_produksi_detail,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
           
            $('#id_sablon').val(response.id);
            $('#tgl_mulai').val(response.sablon_tgl_mulai);
            $('#tgl_diambil').val(response.sablon_tgl_ambil);
            $('#biaya').val(response.sablon_biaya);
            
            kas_sablon(response.sablon_id_kas);
            select_vendor(response.sablon_id_vendor);
            
            if(response.sablon_status == 2){
                $("#btn_simpan").hide();
                $("#btn_selesai_sablon").show();
                $("#base-tab2").show();
            }else if(response.sablon_status == 3){
                $("#btn_simpan").hide();
                $("#btn_selesai_sablon").show();
                $("#base-tab2").show();
            }else{
                $("#btn_simpan").show();
                $("#btn_selesai_sablon").hide();
                $("#base-tab2").hide();
            }
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_detail();
    
    
    kas_sablon = function(id){
        $.ajax({
            type: 'POST',
            url: base_url + 'kas/kas_sablon',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#kas').empty();
                var $kategori = $('#kas');
                $kategori.append('<option value=0>- Pilih Kas Sablon -</option>');
                for (var i = 0; i < data.length; i++) {
                    
                    if(id == data[i].id){
                        $kategori.append('<option value=' + data[i].id + ' selected>' + data[i].nama + ' / Sisa Saldo : ' + data[i].jum_sisa_saldo +'</option>');
                    }else{
                        $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + ' / Sisa Saldo : ' + data[i].jum_sisa_saldo +'</option>');
                    }
                    
                    
                }
            }
        });
    }
    //kas_sablon();
   
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Detail Sablon ?",
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
                url       : base_url + 'sablon/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {tgl_mulai : $('#tgl_mulai').val(),
                            tgl_diambil : $('#tgl_diambil').val(),
                            vendor : $('#vendor').val(),
                            kas : $('#kas').val(),
                            biaya : $('#biaya').val(),
                            id_produksi_detail:id_produksi_detail,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            swal.close();
                            Command: toastr["success"]("Bahan Baku Berhasil Disimpan", "Berhasil");
                            $("#btn_simpan").hide();
                            $("#base-tab2").show();
                            get_produksi_detail();
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
   
   
    /*vendor*/
    select_vendor = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor').append('<option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    //select_vendor();
    
    $('#tgl_mulai,#tgl_diambil').datepicker();
    
    
    $("#btn_selesai_sablon").click(function(){
        
         var form_data = new FormData($('#form_input2')[0]);
        
        swal({
            title: "Sablon Selesai ?",
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
                url             : base_url + 'sablon/update', 
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
                        Command: toastr["success"]("Proses Sablon Selesai", "Berhasil");
                        getcontents('sablon','<?php echo $tokens;?>');
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
            <h4 class="modal-title">Detail Sablon</h4>
        </div>
        <div class="modal-body">
        
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                  href="#tab1" aria-expanded="true">Input Tanggal & Biaya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="base-tab2" style="display:none" data-toggle="tab" aria-controls="tab2" href="#tab2"
                  aria-expanded="false">Input Pengerjaan Selesai</a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
              <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                <form id="form_input"  method=POST enctype='multipart/form-data'>
                
                    <input type="hidden" id="id_sablon" name="id_sablon" class="form-control">
                    <input type="hidden" id="id_produksi_detail" name="id_produksi_detail" class="form-control id_produksi_detail">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
                    
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Mulai</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                    
                </div>
                    
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Diambil</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tgl_diambil" name="tgl_diambil">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                </div> 
                    
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Vendor</label>
                    <select name="vendor" id="vendor" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
                </div>
                    
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Kas Sablon</label>
                    <select name="kas" id="kas" class="form-control"></select>
                </div>    
                    
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Biaya</label>
                    <input type="text" id="biaya" name="biaya" class="form-control">
                </div>
                     
                </form>
              </div>
              <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                  <form id="form_input2"  method=POST enctype='multipart/form-data'>
                      
                      <input type="hidden" id="id_produksi_detail" name="id_produksi_detail" class="form-control id_produksi_detail">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
                      
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Jenis Barang</label>
                        <input type="text" id="jenis_barang" name="jenis_barang" class="form-control">
                    </div> 
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Jumlah Barang</label>
                        <input type="text" id="jumlah" name="jumlah" class="form-control">
                    </div>   
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Berat</label>
                        <input type="text" id="berat" name="berat" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Qty</label>
                        <input type="text" id="qty" name="qty" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Upload Gambar Selesai</label>
                        <input type="file" id="c_gambar" name="c_gambar" class="form-control">
                    </div>
                </form>   
              </div>
            </div>
            
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_simpan"><i class="la la-check-square-o"></i> Simpan Tanggal & Biaya</button>
        <button type="button" class="btn btn-info" id="btn_selesai_sablon" style="display:none"><i class="la la-check-square-o"></i> Selesai & Kirim data Ke Aksesoris</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="la la-refresh"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


