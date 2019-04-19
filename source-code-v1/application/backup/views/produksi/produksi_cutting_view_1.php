<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
    get_produksi_details = function(){
        
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        async     : false,
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            
            $("#stok_status").val(res.stok_status);
            $("#small_warna_1_inisial").val(res.small_warna_1_inisial);
            $("#small_warna_1_jumlah").val(res.small_warna_1_jumlah);
            $("#small_warna_2_inisial").val(res.small_warna_2_inisial);
            $("#small_warna_2_jumlah").val(res.small_warna_2_jumlah);
            $("#large_warna_1_inisial").val(res.large_warna_1_inisial);
            $("#large_warna_1_jumlah").val(res.large_warna_1_jumlah);
            $("#large_warna_2_inisial").val(res.large_warna_2_inisial);
            $("#large_warna_2_jumlah").val(res.large_warna_2_jumlah);
           
            if(res.stok_status == 1){
                
                $('.small_warna_1_inisial').attr('readonly', true);
                $('.small_warna_1_jumlah').attr('readonly', true);
                $('.small_warna_2_inisial').attr('readonly', true);
                $('.small_warna_2_jumlah').attr('readonly', true);
                $('.large_warna_1_inisial').attr('readonly', true);
                $('.large_warna_1_jumlah').attr('readonly', true);
                $('.large_warna_2_inisial').attr('readonly', true);
                $('.large_warna_2_jumlah').attr('readonly', true);

            }else{
                
            }
           
            
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        
    }
    get_produksi_details();
    
    
    get_cutting_detail = function(){
      
    $.ajax({
        url       : base_url + 'cutting/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#tgl_mulai_cutting').val(response.tgl_mulai);
            $('#tgl_selesai_cutting').val(response.tgl_selesai);
            $('#jumlah_bahan_terpakai_cutting').val(response.bahan_terpakai);
            $('#hasil_cutting').val(response.hasil);
            $('#sisa_bahan_cutting').val(response.sisa_bahan);
            $('#berat_cutting').val(response.berat);
            if(response.jumlah == 0){
                $('#jumlah_akhir_cutting').val('');
            }else{
                $('#jumlah_akhir_cutting').val(response.jumlah);
            }
            
            
//            $("#small_warna_1_inisial").val(response.small_warna_1_inisial);
//            $("#small_warna_1_jumlah").val(response.small_warna_1_jumlah);
//            $("#small_warna_2_inisial").val(response.small_warna_2_inisial);
//            $("#small_warna_2_jumlah").val(response.small_warna_2_jumlah);
//            $("#large_warna_1_inisial").val(response.large_warna_1_inisial);
//            $("#large_warna_1_jumlah").val(response.large_warna_1_jumlah);
//            $("#large_warna_2_inisial").val(response.large_warna_2_inisial);
//            $("#large_warna_2_jumlah").val(response.large_warna_2_jumlah);
            
            $('#biaya_cutting').val(response.biaya_cutting);
            select_vendor(response.id_vendor);
            if(response.gambar == null){
                $("#c_gambar_cutting_view").hide();
            }else{
                $("#c_gambar_cutting_view").show();
                $("#c_gambar_cutting_asli").val(response.gambar);
                $("#c_gambar_cutting_view").html('<img src="uploads/produksi/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        
    }
    get_cutting_detail();
    
    
    $("#btn_simpan_data_cutting").click(function(){
        
        if($("#small_warna_1_inisial").val() == ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial small", "Error");
            $("#small_warna_1_inisial").focus();
        }else if($("#small_warna_1_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah small", "Error");
            $("#small_warna_1_jumlah").focus();
        }else if($("#small_warna_2_inisial").val() == ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial small", "Error");
            $("#small_warna_2_inisial").focus();
        }else if($("#small_warna_2_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah small", "Error");
            $("#small_warna_2_jumlah").focus();
        }else if($("#large_warna_1_inisial").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial large", "Error");
            $("#large_warna_1_inisial").focus();
        }else if($("#large_warna_1_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah large", "Error");
            $("#large_warna_1_jumlah").focus();
        }else if($("#large_warna_2_inisial").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial large", "Error");
            $("#large_warna_2_inisial").focus();
        }else if($("#large_warna_2_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah large", "Error");
            $("#large_warna_2_jumlah").focus();
        }else if($("#jumlah_akhir_cutting").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah akhir cutting", "Error");
            $("#jumlah_akhir_cutting").focus();
        }else{
        
         var form_data = new FormData($('#form_input_cutting')[0]);
        
        swal({
            title: "Simpan Data Cutting ?",
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
                        //$('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Inputan Cutting Berhasil Disimpan", "Berhasil");
                        get_cutting_detail();
                        get_produksi_master();
                        get_produksi_details();
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
    
    
    $('#tgl_mulai_cutting,#tgl_selesai_cutting').datepicker();
    
    
    select_vendor = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                    document.getElementById("vendor_cutting").innerHTML = ""; 
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor_cutting').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor_cutting').append('<option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    select_vendor();
    
    
    
    var data_list_bahan_baku = function(){
        
        $.ajax({ 
            url: base_url + 'bahan_baku/data_by_kode_produksi',
            type: "post",
            data:{kode_produksi   :kode_produksi,
                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                 $("#list_bahan_baku").empty();
                 
                if(result.length == 0){
                    var html='';
                        html += "<tr><td colspan='4' align='center'> No data available in table </td></tr>";
                        $("#list_bahan_baku").append(html);
                }else{
                   var data = [];
                    for ( var i=0 ; i<result.length ; i++ ) {
                    
                    
                    var html='';
                        html += "<tr id='blok_non_formal"+result[i].id+"'>"
                        html += "<td>"+ result[i].nama + "</td>"
                        html += "<td>"+ result[i].jumlah_rol + " Rol</td>"
                        html += "<td>"+ result[i].jumlah_kilo + " Kg</td>"
                        html += "</tr>";
                        $("#list_bahan_baku").append(html);
                    } 
                } 
  
            },
            beforeSend: function () {
                
            },
            complete: function () {
               
            }
        });
    }
    data_list_bahan_baku();
    
    
    $("#btn_next_cutting").click(function(){
        
        if($("#small_warna_1_inisial").val() == ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial small", "Error");
            $("#small_warna_1_inisial").focus();
        }else if($("#small_warna_1_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah small", "Error");
            $("#small_warna_1_jumlah").focus();
        }else if($("#small_warna_2_inisial").val() == ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial small", "Error");
            $("#small_warna_2_inisial").focus();
        }else if($("#small_warna_2_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah small", "Error");
            $("#small_warna_2_jumlah").focus();
        }else if($("#large_warna_1_inisial").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial large", "Error");
            $("#large_warna_1_inisial").focus();
        }else if($("#large_warna_1_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah large", "Error");
            $("#large_warna_1_jumlah").focus();
        }else if($("#large_warna_2_inisial").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom inisial large", "Error");
            $("#large_warna_2_inisial").focus();
        }else if($("#large_warna_2_jumlah").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah large", "Error");
            $("#large_warna_2_jumlah").focus();
        }else if($("#jumlah_akhir_cutting").val()== ''){
            Command: toastr["error"]("Silahkan isi pada kolom jumlah akhir cutting", "Error");
            $("#jumlah_akhir_cutting").focus();
        }else{
            
            swal({
            title: "Selesai Produksi Cutting ?",
            text: "Silahkan periksa kembali hasil pengerjaan cutting.",
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
                data      : {status : 1 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Proses Produksi Cutting Selesai", "Berhasil");
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
            
        }
        
        
//        swal({
//            title: "Selesai Produksi Cutting ?",
//            text: "Silahkan periksa kembali hasil pengerjaan cutting.",
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
//                data      : {status : 1 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//                success: function (response) {
//                    if(response == true){
//                        swal.close();
//                        Command: toastr["success"]("Proses Produksi Cutting Selesai", "Berhasil");
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

    
          
        <form id="form_input_cutting"  method=POST enctype='multipart/form-data'>
        
        <input type="hidden" id="stok_status" name="stok_status" class="form-control">
        <input type="hidden" id="kode_produksi_cutting" name="kode_produksi_cutting" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
        
        <div class="row">
            <div class="col-md-12">
            <div class="card">
            <div class="card-header bg-default">Bahan Baku Yang Dipakai di Produksi Cutting</div>
            <div class="card-content table-responsive">

                <table class="table table-de mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah Rol dipakai</th>
                            <th>Jumlah Kilo dipakai (Kg)</th>
                        </tr>
                    </thead>
                    <tbody id="list_bahan_baku"></tbody>
                </table>

                </div>
            </div>
            </div>
        </div>
        <br>  
        
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName2">Tanggal Mulai Cutting :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_mulai_cutting" name="tgl_mulai_cutting">
                    <div class="form-control-position">
                        <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="lastName2">Tanggal Selesai Cutting :</label>
                <div class="position-relative has-icon-left">
                  <input type="text" class="form-control" id="tgl_selesai_cutting" name="tgl_selesai_cutting">
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
                  <label for="emailAddress3">Jumlah Bahan Terpakai :</label>
                  <input type="text" id="jumlah_bahan_terpakai_cutting" name="jumlah_bahan_terpakai_cutting" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber2">Sisa Bahan :</label>
                    <input type="text" id="sisa_bahan_cutting" name="sisa_bahan_cutting" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location2">Hasil Cutting :</label>
                    <input type="text" id="hasil_cutting" name="hasil_cutting" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">Berat :</label>
                    <input type="text" id="berat_cutting" name="berat_cutting" class="form-control">
                </div>
            </div>
        </div>
          
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber2">Vendor :</label>
                    <select name="vendor_cutting" id="vendor_cutting" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">Biaya Cutting :</label>
                    <input type="text" id="biaya_cutting" name="biaya_cutting" class="form-control maskmoney">
    <!--                <input type="date" class="form-control" id="date2">-->
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="small_warna_1_inisial" name="small_warna_1_inisial" class="form-control small_warna_1_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Small (S) Warna 1  :</label>
                        <input type="text" id="small_warna_1_jumlah" name="small_warna_1_jumlah" class="form-control small_warna_1_jumlah" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
              
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="small_warna_2_inisial" name="small_warna_2_inisial" class="form-control small_warna_2_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Small (S) Warna 2  :</label>
                        <input type="text" id="small_warna_2_jumlah" name="small_warna_2_jumlah" class="form-control small_warna_2_jumlah" placeholder="Jumlah">
                    </div>
                </div>
            </div>  
          </div>
        </div>
          
        <div class="row">
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="large_warna_1_inisial" name="large_warna_1_inisial" class="form-control large_warna_1_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Large (L) Warna 1  :</label>
                        <input type="text" id="large_warna_1_jumlah" name="large_warna_1_jumlah" class="form-control large_warna_1_jumlah" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="large_warna_2_inisial" name="large_warna_2_inisial" class="form-control large_warna_2_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Large (L) Warna 2  :</label>
                        <input type="text" id="large_warna_2_jumlah" name="large_warna_2_jumlah" class="form-control large_warna_2_jumlah" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
        </div>  
          
          
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="phoneNumber2">Jumlah Akhir :</label>
                <input type="text" id="jumlah_akhir_cutting" name="jumlah_akhir_cutting" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="date2">Gambar Selesai Cutting :</label>
                <input type="file" id="c_gambar_cutting" name="c_gambar_cutting" class="form-control">
                <input type="hidden" id="c_gambar_cutting_asli" name="c_gambar_cutting_asli" class="form-control">
                <div id="c_gambar_cutting_view" style="display:none"></div>
            </div>
          </div>
        </div>
          
        </form>
        
        <button type="button" id="btn_simpan_data_cutting" class="btn btn-primary btn-left pull-left"><i class="ft-save"></i> Update Data Cutting</button>
        <button type="button" id="btn_next_cutting" class="btn btn-info pull-right"> Selanjutnya <i class="icon-arrow-right"></i></button>
        
     

        
