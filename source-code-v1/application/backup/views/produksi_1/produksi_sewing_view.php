<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    get_sewing_detail = function(){
        
    $.ajax({
        url       : base_url + 'sewing/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#tgl_mulai_sewing').val(response.tgl_mulai);
            $('#tgl_diambil_sewing').val(response.tgl_ambil);
            $('#tgl_kembali_sewing').val(response.tgl_kembali);
            $('#jenis_barang_sewing').val(response.jenis_barang);
            $('#berat_sewing').val(response.berat);
            $('#jumlah_sewing').val(response.jumlah);
            $('#biaya_sewing').val(response.biaya);
            select_vendor_sewing(response.id_vendor);
            if(response.gambar == ''){
                $("#c_gambar_sewing_view").hide();
            }else{
                $("#c_gambar_sewing_view").show();
                $("#c_gambar_sewing_asli").val(response.gambar);
                $("#c_gambar_sewing_view").html('<img src="uploads/produk/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_sewing_detail();
    
    
    $("#btn_simpan_data_sewing").click(function(){
        
         var form_data = new FormData($('#form_input_sewing')[0]);
        
        swal({
            title: "Simpan Data Sewing ?",
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
                url             : base_url + 'sewing/update', 
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
                        Command: toastr["success"]("Data Inputan Sewing Berhasil Disimpan", "Berhasil");
                        get_sewing_detail();
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

    
    
    
    select_vendor_sewing = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                    document.getElementById("vendor_sewing").innerHTML = "";
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor_sewing').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor_sewing').append('<option value="0">-Pilih Vendor-</option><option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    
    $('#tgl_mulai_sewing,#tgl_diambil_sewing,#tgl_kembali_sewing').datepicker();
    
    
    $("#btn_selesai_sewing").click(function(){
        
        swal({
            title: "Selesai Produksi Sewing ?",
            text: "Silahkan periksa kembali hasil pengerjaan Sewing.",
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
                data      : {status : 4 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Proses Produksi Sewing Selesai", "Berhasil");
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


    <form id="form_input_sewing"  method=POST enctype='multipart/form-data'>
                
        <input type="hidden" id="kode_produksi_sewing" name="kode_produksi_sewing" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 

        <div class="form-group">
            <label for="timesheetinput3">Tanggal Mulai Sewing</label>
            <div class="position-relative has-icon-left">
                <input type="text" class="form-control" id="tgl_mulai_sewing" name="tgl_mulai_sewing">
                <div class="form-control-position">
                    <i class="ft-calendar"></i>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="timesheetinput3">Tanggal Kirim</label>
            <div class="position-relative has-icon-left">
                <input type="text" class="form-control" id="tgl_diambil_sewing" name="tgl_diambil_sewing">
                <div class="form-control-position">
                      <i class="ft-calendar"></i>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Vendor</label>
            <select name="vendor_sewing" id="vendor_sewing" class="form-control">
                <option value="0">-Pilih Vendor-</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Biaya Sewing</label>
            <input type="text" id="biaya_sewing" name="biaya_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">PIC</label>
            <input type="text" id="pic_sewing" name="pic_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Jenis Barang</label>
            <input type="text" id="jenis_barang_sewing" name="jenis_barang_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Berat</label>
            <input type="text" id="berat_sewing" name="berat_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Berat</label>
            <input type="text" id="berat_sewing" name="berat_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Jumlah Akhir</label>
            <input type="text" id="jumlah_akhir_sewing" name="jumlah_akhir_sewing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Upload Gambar Selesai</label>
            <input type="file" id="c_gambar_sewing" name="c_gambar_sewing" class="form-control">
            <input type="hidden" id="c_gambar_sewing_asli" name="c_gambar_sewing_asli" class="form-control">
            <div id="c_gambar_sewing_view" style="display:none"></div>
        </div>

    </form>

    <button type="button" id="btn_simpan_data_sewing" class="btn btn-info"><i class="ft-save"></i> Simpan Data Sewing</button>
    <button type="button" id="btn_selesai_sewing" class="btn btn-success"><i class="ft-check"></i> Selesai Sewing</button>