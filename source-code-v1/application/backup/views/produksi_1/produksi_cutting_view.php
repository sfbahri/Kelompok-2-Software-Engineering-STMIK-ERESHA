<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    
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
            $('#jumlah_akhir_cutting').val(response.jumlah);
            $('#biaya_cutting').val(response.biaya);
            select_vendor(response.id_vendor);
            if(response.gambar == ''){
                $("#c_gambar_cutting_view").hide();
            }else{
                $("#c_gambar_cutting_view").show();
                $("#c_gambar_cutting_asli").val(response.gambar);
                $("#c_gambar_cutting_view").html('<img src="uploads/produk/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_cutting_detail();
    
    
    $("#btn_simpan_data_cutting").click(function(){
        
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
                    
                    var satuans;
                    if(result[i].satuan == 1){
                        satuans = 'Rol';
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
    
    
    $("#btn_selesai_cutting").click(function(){
        
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
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
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



<div class="card">
        <div class="card-header">
          <h4 class="card-title">Bahan Baku Yang Dipakai</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content table-responsive">
            
            <table class="table table-de mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah dipakai</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody id="list_bahan_baku"></tbody>
            </table>

            </div>
        </div>

    <form id="form_input_cutting"  method=POST enctype='multipart/form-data'>
                
        <input type="hidden" id="kode_produksi_cutting" name="kode_produksi_cutting" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 

        <div class="form-group">
            <label for="timesheetinput3">Tanggal Mulai Cutting</label>
            <div class="position-relative has-icon-left">
                <input type="text" class="form-control" id="tgl_mulai_cutting" name="tgl_mulai_cutting">
                <div class="form-control-position">
                    <i class="ft-calendar"></i>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="timesheetinput3">Tanggal Selesai Cutting</label>
            <div class="position-relative has-icon-left">
                <input type="text" class="form-control" id="tgl_selesai_cutting" name="tgl_selesai_cutting">
                <div class="form-control-position">
                      <i class="ft-calendar"></i>
                </div>
            </div>
        </div> 
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Jumlah Bahan Terpakai</label>
            <input type="text" id="jumlah_bahan_terpakai_cutting" name="jumlah_bahan_terpakai_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Hasil Cutting</label>
            <input type="text" id="hasil_cutting" name="hasil_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Sisa Bahan</label>
            <input type="text" id="sisa_bahan_cutting" name="sisa_bahan_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Biaya</label>
            <input type="text" id="biaya_cutting" name="biaya_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Vendor</label>
            <select name="vendor_cutting" id="vendor_cutting" class="form-control">
                <option value="0">-Pilih Vendor-</option>
            </select>
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Berat</label>
            <input type="text" id="berat_cutting" name="berat_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Qty / Jumlah Akhir</label>
            <input type="text" id="jumlah_akhir_cutting" name="jumlah_akhir_cutting" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Upload Gambar Selesai</label>
            <input type="file" id="c_gambar_cutting" name="c_gambar_cutting" class="form-control">
            <input type="hidden" id="c_gambar_cutting_asli" name="c_gambar_cutting_asli" class="form-control">
            <div id="c_gambar_cutting_view" style="display:none"></div>
        </div>

    </form>

    <button type="button" id="btn_simpan_data_cutting" class="btn btn-info"><i class="ft-save"></i> Simpan Data Cutting</button>
    <button type="button" id="btn_selesai_cutting" class="btn btn-success"><i class="ft-check"></i> Selesai Cutting</button>