<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    get_finishing_detail = function(){
        
    $.ajax({
        url       : base_url + 'finishing/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            $('#tgl_serah_terima').val(response.tgl_serah_terima);
            $('#jenis_barang_finishing').val(response.jenis_barang);
            $('#berat_finishing').val(response.berat);
            $('#jumlah_akhir_finishing').val(response.jumlah);
            if(response.gambar == ''){
                $("#c_gambar_finishing_view").hide();
            }else{
                $("#c_gambar_finishing_view").show();
                $("#c_gambar_finishing_asli").val(response.gambar);
                $("#c_gambar_finishing_view").html('<img src="uploads/produk/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_finishing_detail();
    
    
    $("#btn_simpan_data_finishing").click(function(){
        
         var form_data = new FormData($('#form_input_finishing')[0]);
        
        swal({
            title: "Simpan Data Finishing ?",
            text: "Silahkan periksa kembali inputan hasil pengerjaan finishing.",
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
                url             : base_url + 'finishing/update', 
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
                        Command: toastr["success"]("Data Inputan Finishing Berhasil Disimpan", "Berhasil");
                        get_finishing_detail();
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

    $('#tgl_serah_terima').datepicker();
    
    
    $("#btn_selesai_finishing").click(function(){
        
        swal({
            title: "Selesai Produksi Finishing ?",
            text: "Silahkan periksa kembali inputan Finishing.",
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
                data      : {status : 5 , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Proses Produksi Finishing Selesai", "Berhasil");
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


    <form id="form_input_finishing"  method=POST enctype='multipart/form-data'>
                
        <input type="hidden" id="kode_produksi_finishing" name="kode_produksi_finishing" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 

        <div class="form-group">
            <label for="timesheetinput3">Tanggal Serah Terima</label>
            <div class="position-relative has-icon-left">
                <input type="text" class="form-control" id="tgl_serah_terima" name="tgl_serah_terima">
                <div class="form-control-position">
                    <i class="ft-calendar"></i>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Jenis Barang</label>
            <input type="text" id="jenis_barang_finishing" name="jenis_barang_finishing" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Berat</label>
            <input type="text" id="berat_finishing" name="berat_finishing" class="form-control">
        </div>
       
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Jumlah Akhir</label>
            <input type="text" id="jumlah_akhir_finishing" name="jumlah_akhir_finishing" class="form-control">
        </div>
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Upload Gambar Selesai</label>
            <input type="file" id="c_gambar_finishing" name="c_gambar_finishing" class="form-control">
            <input type="hidden" id="c_gambar_finishing_asli" name="c_gambar_finishing_asli" class="form-control">
            <div id="c_gambar_finishing_view" style="display:none"></div>
        </div>
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Catatan</label>
            <textarea name="catatan_finishing" id="catatan_finishing" class="form-control"></textarea>
        </div>
        

    </form>

    <button type="button" id="btn_simpan_data_finishing" class="btn btn-info"><i class="ft-save"></i> Simpan Data Finishing</button>
    <button type="button" id="btn_selesai_finishing" class="btn btn-success"><i class="ft-check"></i> Selesai Finishing</button>