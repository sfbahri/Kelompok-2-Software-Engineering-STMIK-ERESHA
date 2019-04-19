<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    get_produksi_masteras = function(){
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            
            $("#harga_jual").val(res.harga_jual);
            $("#jum_label").val(res.stok);
           
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_masteras();
    
    
    $("#btn_created").click(function(){
        
        swal({
            title: "Create Label Qrcode Produk ?",
            text: "Silahkan periksa kembali harga yang ingin disimpan.",
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
                url       : base_url + 'produksi/created_label',
                type      : "post",
                dataType  : 'json',
                data      : {harga_jual :$("#harga_jual").val(), jum_label :$("#jum_label").val() , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Created Label Qrcode Berhasil", "Berhasil");
                        get_produksi_masteras();
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


    <form id="form_input_label"  method=POST enctype='multipart/form-data'>
                
        <input type="hidden" id="harga_jual" name="harga_jual" class="form-control">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 

        <div class="form-group">
            <label for="timesheetinput3">Jumlah Label Qrcode</label>
            <input type="text" id="jum_label" name="jum_label" class="form-control col-md-3">
        </div>
        <button type="button" id="btn_created" class="btn btn-info"><i class="ft-save"></i> Buat Label Qrcode</button>
    </form>
