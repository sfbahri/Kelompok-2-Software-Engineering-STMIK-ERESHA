<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
 
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    get_sablon_detail = function(){
        
    $.ajax({
        url       : base_url + 'sablon/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#tgl_mulai_sablon').val(response.tgl_mulai);
            $('#tgl_kirim_sablon').val(response.tgl_ambil);
            $('#jenis_barang_sablon').val(response.jenis_barang);
            $('#berat_sablon').val(response.berat);
            $('#jumlah_akhir_sablon').val(response.jumlah_akhir);
            $('#biaya_sablon').val(response.biaya_sablon);
            select_vendor_sablon(response.id_vendor);
            if(response.gambar == null || response.gambar == ''){
                $("#c_gambar_sablon_view").hide();
            }else{
                $("#c_gambar_sablon_view").show();
                $("#c_gambar_sablon_asli").val(response.gambar);
                $("#c_gambar_sablon_view").html('<img src="uploads/produksi/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_sablon_detail();
    
    
    $("#btn_simpan_data_sablon").click(function(){
        
         var form_data = new FormData($('#form_input_sablon')[0]);
        
        swal({
            title: "Simpan Data Sablon ?",
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
                        //$('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Sablon Berhasil Disimpan", "Berhasil");
                        get_sablon_detail();
                        get_produksi_master();
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

    $('#tgl_mulai_sablon,#tgl_kirim_sablon').datepicker();
    
    
    select_vendor_sablon = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                    document.getElementById("vendor_sablon").innerHTML = "";
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor_sablon').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor_sablon').append('<option value="0">-Pilih Vendor-</option><option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
                    
                    $("#vendor_sablon").chosen({width: "100%"});
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    
    
    $("#btn_next_sablon").click(function(){
          
          swal({
            title: "Selesai Produksi Sablon ?",
            text: "Silahkan periksa kembali hasil pengerjaan sablon.",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Selesai",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){
            
            $.ajax({
                url       : base_url + 'produksi/update_status',
                type      : "post",
                dataType  : 'json',
                data      : {status : 2 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Proses Produksi Sablon Selesai", "Berhasil");
                        get_produksi_master();
                        getcontents('produksi','<?php echo $tokens;?>');
                        $('.steps-form').css('display','none');
                        $('.icons-tab-steps').hide();
                        $('#steps-loading').show();
                        setTimeout(function(){ 
                            $('.icons-tab-steps').show();
                            $('#steps-loading').hide();
                        }, 2000);
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
            
        });
            
//        swal({
//            title: "Selesai Produksi Sablon ?",
//            text: "Silahkan periksa kembali hasil pengerjaan sablon.",
//            type: "info",
//            showCancelButton: true,
//            closeOnConfirm: false,
//            showLoaderOnConfirm: true,
//            confirmButtonText: "Selesai",
//            //confirmButtonColor: "#E73D4A"
//            confirmButtonColor: "#286090"
//        },
//        function(){
//            
//            $.ajax({
//                url       : base_url + 'produksi/update_status',
//                type      : "post",
//                dataType  : 'json',
//                data      : {status : 2 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//                success: function (response) {
//                    if(response == true){
//                        swal.close();
//                        Command: toastr["success"]("Proses Produksi Sablon Selesai", "Berhasil");
//                        get_produksi_master();
//                        getcontents('produksi','<?php echo $tokens;?>');
//                    }else{
//                        Command: toastr["error"]("Response Ajax Error !!", "Error");
//                    }  
//                },
//                error: function(jqXHR, textStatus, errorThrown) {
//                    Command: toastr["error"]("Ajax Error !!", "Error");
//                }
//            });
//            
//        });
        
    });
    
    
});
</script>


    
          
        <form id="form_input_sablon"  method=POST enctype='multipart/form-data'>
        
        <input type="hidden" id="kode_produksi_sablon" name="kode_produksi_sablon" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
        
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName2">Tanggal Mulai Sablon :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_mulai_sablon" name="tgl_mulai_sablon">
                    <div class="form-control-position">
                        <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="lastName2">Tanggal Kembali Sablon :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_kirim_sablon" name="tgl_kirim_sablon">
                    <div class="form-control-position">
                          <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber2">Vendor :</label>
                    <select name="vendor_sablon" id="vendor_sablon" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">Biaya Sablon :</label>
                    <input type="text" id="biaya_sablon" name="biaya_sablon" class="form-control maskmoney">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location2">Jenis Barang :</label>
                    <input type="text" id="jenis_barang_sablon" name="jenis_barang_sablon" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date2">Berat:</label>
                        <input type="text" id="berat_sablon" name="berat_sablon" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">Satuan:</label>
                    <br>
                    <b>Kg (Kilogram)</b>
                </div>
                </div>
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="phoneNumber2">Jumlah Akhir :</label>
                <input type="text" id="jumlah_akhir_sablon" name="jumlah_akhir_sablon" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="date2">Gambar Selesai Sablon :</label>
                <input type="file" id="c_gambar_sablon" name="c_gambar_sablon" class="form-control">
                <input type="hidden" id="c_gambar_sablon_asli" name="c_gambar_sablon_asli" class="form-control">
                <div id="c_gambar_sablon_view" style="display:none"></div>
            </div>
          </div>
        </div>
          
        </form>
          <button type="button" id="btn_simpan_data_sablon" class="btn btn-primary pull-left"><i class="ft-save"></i> Update Data Sablon</button> 
          <button type="button" id="btn_next_sablon" class="btn btn-info pull-right"> Selanjutnya <i class="icon-arrow-right"></i></button>
