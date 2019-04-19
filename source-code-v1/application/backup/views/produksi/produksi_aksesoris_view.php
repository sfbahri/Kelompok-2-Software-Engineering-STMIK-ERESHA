<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
    get_aksesoris_detail = function(){
        
    $.ajax({
        url       : base_url + 'aksesoris/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#tgl_mulai_aksesoris').val(response.tgl_mulai);
            $('#tgl_diambil_aksesoris').val(response.tgl_ambil);
            $('#jenis_barang_aksesoris').val(response.jenis_barang);
            $('#berat_aksesoris').val(response.berat);
            $('#pic_aksesoris').val(response.pic);
            $('#biaya_aksesoris').val(response.biaya_aksesoris);

            
            if(response.jumlah == 0){
                $('#jumlah_akhir_aksesoris').val('');
            }else{
                $('#jumlah_akhir_aksesoris').val(response.jumlah);
            }
            
            select_vendor_aksesoris(response.id_vendor);
            if(response.gambar == ''|| response.gambar == null){
                $("#c_gambar_aksesoris_view").hide();
            }else{
                $("#c_gambar_aksesoris_view").show();
                $("#c_gambar_aksesoris_asli").val(response.gambar);
                $("#c_gambar_aksesoris_view").html('<img src="uploads/produksi/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_aksesoris_detail();
    
    
    $("#btn_simpan_data_aksesoris").click(function(){
        
         var form_data = new FormData($('#form_input_aksesoris')[0]);
        
        swal({
            title: "Simpan Data Aksesoris ?",
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
                url             : base_url + 'aksesoris/data_update', 
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
                        Command: toastr["success"]("Data Inputan Aksesoris Berhasil Disimpan", "Berhasil");
                        get_aksesoris_detail();
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

    $('#tgl_mulai_aksesoris,#tgl_diambil_aksesoris').datepicker();
    
    
    select_vendor_aksesoris = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                    document.getElementById("vendor_aksesoris").innerHTML = ""; 
                    $('#vendor_aksesoris').append('<option value="0">- Pilih Vendor -</option>');
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor_aksesoris').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor_aksesoris').append('<option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
                    
                    $("#vendor_aksesoris").chosen({width: "100%"});
                    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    select_vendor_aksesoris();
    
    
    
    var data_list_aksesoris = function(){
        
        $.ajax({ 
            url: base_url + 'aksesoris/data_by_kode_produksi',
            type: "post",
            data:{kode_produksi   :kode_produksi,
                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                 $("#list_aksesoris").empty();
                 
                if(result.length == 0){
                    var html='';
                        html += "<tr><td colspan='4' align='center'> No data available in table </td></tr>";
                        $("#list_aksesoris").append(html);
                }else{
                   var data = [];
                    for ( var i=0 ; i<result.length ; i++ ) {
                    
                    var satuans;
                    if(result[i].satuan == 1){
                        satuans = 'Pcs';
                    }else if(result[i].satuan == 2){
                        satuans = 'Kg';
                    }else if(result[i].satuan == 3){
                        satuans = 'Cm';
                    }else{
                        satuans = '-';
                    }
                    
                    var html='';
                        html += "<tr id='blok_non_formal"+result[i].id+"'>"
                        html += "<td>"+ result[i].nama + "</td>"
                        html += "<td>"+ result[i].jumlah + "</td>"
                        html += "<td>"+ satuans + "</td>"
                        html += "</tr>";
                        $("#list_aksesoris").append(html);
                    } 
                } 
  
            },
            beforeSend: function () {
                
            },
            complete: function () {
               
            }
        });
    }
    data_list_aksesoris();
    
    
    
    $("#btn_next_aksesoris").click(function(){
        
        swal({
            title: "Selesai Produksi Aksesoris ?",
            text: "Silahkan periksa kembali hasil pengerjaan Aksesoris.",
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
                data      : {status : 3 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Proses Produksi Aksesoris Selesai", "Berhasil");
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
//            title: "Selesai Produksi Aksesoris ?",
//            text: "Silahkan periksa kembali hasil pengerjaan Aksesoris.",
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
//                data      : {status : 3 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//                success: function (response) {
//                    if(response == true){
//                        swal.close();
//                        Command: toastr["success"]("Proses Produksi Aksesoris Selesai", "Berhasil");
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



    
          
        <form id="form_input_aksesoris"  method=POST enctype='multipart/form-data'>
        
        <input type="hidden" id="kode_produksi_aksesoris" name="kode_produksi_aksesoris" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
        
        <div class="row">
            <div class="col-md-12">
            <div class="card">
            <div class="card-header bg-default">Aksesoris Yang Dipakai di Produksi Aksesoris</div>
            <div class="card-content table-responsive">

                <table class="table table-de mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah dipakai</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody id="list_aksesoris"></tbody>
                </table>

                </div>
            </div>
            </div>
        </div>
        <br>  
        
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName2">Tanggal Mulai Aksesoris :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_mulai_aksesoris" name="tgl_mulai_aksesoris">
                    <div class="form-control-position">
                        <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="lastName2">Tanggal Kirim Aksesoris :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_diambil_aksesoris" name="tgl_diambil_aksesoris">
                    <div class="form-control-position">
                          <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
        </div>
        
<!--        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="phoneNumber2">PIC / Penanggung Jawab :</label>
                    <input type="text" id="pic_aksesorisx" name="pic_aksesoris" class="form-control">
                </div>
            </div>
        </div>-->
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber2">Vendor :</label>
                    <select name="vendor_aksesoris" id="vendor_aksesoris" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">PIC / Penanggung Jawab:</label>
                    <input type="text" id="pic_aksesoris" name="pic_aksesoris" class="form-control maskmoney">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location2">Jenis Barang :</label>
                    <input type="text" id="jenis_barang_aksesoris" name="jenis_barang_aksesoris" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date2">Berat:</label>
                        <input type="text" id="berat_aksesoris" name="berat_aksesoris" class="form-control">
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
<!--          <div class="col-md-6">
            <div class="form-group">
                <label for="phoneNumber2">Jumlah Akhir :</label>
                <input type="text" id="jumlah_akhir_aksesoris" name="jumlah_akhir_aksesoris" class="form-control">
            </div>
          </div>-->
          <div class="col-md-12">
            <div class="form-group">
                <label for="date2">Gambar Selesai Sablon :</label>
                <input type="file" id="c_gambar_aksesoris" name="c_gambar_aksesoris" class="form-control">
                <input type="hidden" id="c_gambar_aksesoris_asli" name="c_gambar_aksesoris_asli" class="form-control">
                <div id="c_gambar_aksesoris_view" style="display:none"></div>
            </div>
          </div>
        </div>
          
        </form>
            <button type="button" id="btn_simpan_data_aksesoris" class="btn btn-primary pull-left"><i class="ft-save"></i> Update Data Aksesoris</button>
            <button type="button" id="btn_next_aksesoris" class="btn btn-info pull-right"> Selanjutnya <i class="icon-arrow-right"></i></button>
    