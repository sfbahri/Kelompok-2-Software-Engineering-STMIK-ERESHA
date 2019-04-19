<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_produksi_detail = '<?php echo $id_row;?>';
    var publish       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    $("#id_produksi_detail").val(id_produksi_detail);
    
    get_produksi_detail = function(){
        
    $.ajax({
        url       : base_url + 'produksi/data_produksi_detail_by_id',
        type      : "post",
        dataType  : 'json',
        data      : {id_produksi_detail  : id_produksi_detail,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#bahan_baku').val(response.cutting_id_bahan_baku);
            $("#idbahan_baku").val(response.cutting_id_bahan_baku);
            
            
            if(response.cutting_id_bahan_baku == null){
                
            }else{
                get_detail_bahan_baku(response.cutting_id_bahan_baku);
                
                $.ajax({
                    type: 'POST',
                    url: base_url + 'bahan_baku/data_select',
                    data: {},
                    dataType  : 'json',
                    success: function (data) {
                        $('#bahan_baku').empty();
                        var $kategori = $('#bahan_baku');
                        //$kategori.append('<option value=0>- Pilih Bahan Baku -</option>');
                        for (var i = 0; i < data.length; i++) {
                            if(response.cutting_id_bahan_baku == data[i].id){
                                $kategori.append('<option value=' + data[i].id + ' selected>' + data[i].nama + '</option>');
                            }else{
                                $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                            }
                            
                        }
                    }
                });
                
            }
            
            
            if(response.cutting_status == 2){
                $("#btn_simpan_bahan_baku").hide();
                $("#btn_selesai_cutting").show();
                $("#base-tab2").show();
            }else if(response.cutting_status == 3){
                $("#btn_simpan_bahan_baku").hide();
                $("#btn_selesai_cutting").show();
                $("#base-tab2").show();
            }else{
                $("#btn_simpan_bahan_baku").show();
                $("#btn_selesai_cutting").hide();
            }
           
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_detail();
    
    
    
/*================================= TAB 1 ==================================== */    
    
    bahan_baku = function(){
        $.ajax({
            type: 'POST',
            url: base_url + 'bahan_baku/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#bahan_baku').empty();
                var $kategori = $('#bahan_baku');
                $kategori.append('<option value=0>- Pilih Bahan Baku -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                }
            }
        });
    }
    bahan_baku();
    
    $('#bahan_baku').change(function(){
        var id_bahan_baku = $(this).val();
        get_detail_bahan_baku(id_bahan_baku);
    });
    
    get_detail_bahan_baku = function(id_bahan_baku){
        document.getElementById("radio_satuan").innerHTML = "";
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
    }
    
    
    
    $("#btn_simpan_bahan_baku").click(function(){
        
        if($("#bahan_baku").val() == 0){
            Command: toastr["info"]("Silahkan Pilih Bahan Baku Terlebih Dahulu", "Info");
        }else{
           
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
                url       : base_url + 'cutting/cutting_simpan_bahan_baku',
                type      : "post",
                dataType  : 'json',
                data      : {id_produksi_detail : id_produksi_detail,
                             id_bahan_baku : $("#bahan_baku").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            swal.close();
                            Command: toastr["success"]("Bahan Baku Berhasil Disimpan", "Berhasil");
                            $("#btn_selesai_cutting").show();
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
           
        }
        
    });
    
/*================================= TAB 1 ==================================== */    
   
   
   
   
   
   
   
   
   
/*================================= TAB 2 ==================================== */

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
    select_vendor();
    
    
    $("#btn_selesai_cutting").click(function(){
        
         var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Selesai Cutting ?",
            text: "Silahkan periksa kembali inputan hasil pengerjaan cutting.",
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
                url             : base_url + 'cutting/update', 
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
                        Command: toastr["success"]("Proses Cutting Selesai", "Berhasil");
                        getcontents('cutting','<?php echo $tokens;?>');
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


/*================================= TAB 2 ==================================== */
   
    $('#tgl_mulai,#tgl_selesai').datepicker();
    
    
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
            <h4 class="modal-title">Detail Cutting</h4>
        </div>
        <div class="modal-body">
        
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">Input Bahan Baku</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="display:none" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Input Pengerjaan Selesai</a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
               <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Bahan Baku</label>
                    <select class="form-control" id="bahan_baku"></select>
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jenis Bahan Baku</label>
                    <input type="text" id="jenis" name="jenis" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Warna</label>
                    <input type="text" id="warna" name="warna" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlah</label>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" readonly="">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Satuan </label><br>
                    <div id="radio_satuan"></div>
                </div>  
                
                <button type="button" class="btn btn-info btn-sm" id="btn_simpan_bahan_baku"><i class="la la-check-square-o"></i> Simpan Bahan Baku</button>
                   
            </div>
            <div class="tab-pane" id="tab2" aria-labelledby="base-tab2">
                
                <form id="form_input"  method=POST enctype='multipart/form-data'>
                
                    <input type="hidden" id="idbahan_baku" name="idbahan_baku" class="form-control">
                    <input type="hidden" id="id_produksi_detail" name="id_produksi_detail" class="form-control">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
                    
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Mulai Cutting</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Selesai Cutting</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                </div>    
                    
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Jumlah Bahan Terpakai</label>
                    <input type="text" id="bahan_terpakai" name="bahan_terpakai" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Hasil Cutting</label>
                    <input type="text" id="hasil" name="hasil" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Sisa Bahan</label>
                    <input type="text" id="sisa_bahan" name="sisa_bahan" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Vendor</label>
                    <select name="vendor" id="vendor" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
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
        <button type="button" class="btn btn-info" id="btn_selesai_cutting" style="display:none"><i class="la la-check-square-o"></i> Selesai & Kirim data Ke Sablon</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


