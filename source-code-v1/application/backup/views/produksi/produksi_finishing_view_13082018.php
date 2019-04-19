<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    
    get_produksi_detailss = function(){
        
        $.ajax({
        url       : base_url + 'produksi/get_jumlah_akhir',
        type      : "post",
        dataType  : 'json',
        async     : false,
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            
            $("#jumlah_barang_awal").val(res.jumlah);
            
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        
        
        
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        async     : false,
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (response) {
            
            //inisial produk
            $('#small_warna_1_inisial_akhir').val(response.small_warna_1_inisial);
            $('#small_warna_2_inisial_akhir').val(response.small_warna_2_inisial);
            $('#large_warna_1_inisial_akhir').val(response.large_warna_1_inisial);
            $('#large_warna_2_inisial_akhir').val(response.large_warna_2_inisial);
            
            //jumlah produksi
            $('#small_warna_1_jumlah_akhir').val(response.small_warna_1_jumlah_akhir);
            $('#small_warna_2_jumlah_akhir').val(response.small_warna_2_jumlah_akhir);
            $('#large_warna_1_jumlah_akhir').val(response.large_warna_1_jumlah_akhir);
            $('#large_warna_2_jumlah_akhir').val(response.large_warna_2_jumlah_akhir);
            
            
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        
        
        
    }
    get_produksi_detailss();
    
    
    
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
            $('#catatan_finishing').val(response.catatan);
            if(response.jumlah == 0){
                $('#jumlah_akhir_finishing').val('');
            }else{
                $('#jumlah_akhir_finishing').val(response.jumlah);
            }
            //$('#jumlah_akhir_finishing').val(response.jumlah);
            if(response.gambar == '' || response.gambar == null){
                $("#c_gambar_finishing_view").hide();
            }else{
                $("#c_gambar_finishing_view").show();
                $("#c_gambar_finishing_asli").val(response.gambar);
                $("#c_gambar_finishing_view").html('<img src="uploads/produksi/'+response.gambar+'" style="width:80px;height:80px;margin-top:10px">');
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
        
    });
    
    
});
</script>


          
        <form id="form_input_finishing"  method=POST enctype='multipart/form-data'>
        
        <input type="hidden" id="kode_produksi_finishing" name="kode_produksi_finishing" class="form-control" value="<?php echo $id_row;?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none"> 
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstName2">Tanggal Serah Terima :</label>
                <div class="position-relative has-icon-left">
                    <input type="text" class="form-control" id="tgl_serah_terima" name="tgl_serah_terima">
                    <div class="form-control-position">
                        <i class="ft-calendar"></i>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date2">Jumlah Barang Awal:</label>
                        <input type="text" id="jumlah_barang_awal" name="jumlah_barang_awal" readonly="" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="date2">Satuan:</label>
                    <br>
                    <b>Pcs</b>
                </div>
                </div>
                </div>
          </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location2">Jenis Barang :</label>
                    <input type="text" id="jenis_barang_finishing" name="jenis_barang_finishing" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date2">Berat:</label>
                        <input type="text" id="berat_finishing" name="berat_finishing" class="form-control">
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
                <input type="text" id="jumlah_akhir_finishing" name="jumlah_akhir_finishing" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="date2">Gambar Selesai :</label>
                <input type="file" id="c_gambar_finishing" name="c_gambar_finishing" class="form-control">
                <input type="hidden" id="c_gambar_finishing_asli" name="c_gambar_finishing_asli" class="form-control">
                <div id="c_gambar_finishing_view" style="display:none"></div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="small_warna_1_inisial_akhir" name="small_warna_1_inisial_akhir" class="form-control small_warna_1_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Small (S) Warna 1  :</label>
                        <input type="text" id="small_warna_1_jumlah_akhir" name="small_warna_1_jumlah_akhir" class="form-control" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
              
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="small_warna_2_inisial_akhir" name="small_warna_2_inisial_akhir" class="form-control small_warna_2_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Small (S) Warna 2  :</label>
                        <input type="text" id="small_warna_2_jumlah_akhir" name="small_warna_2_jumlah_akhir" class="form-control" placeholder="Jumlah">
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
                    <input type="text" id="large_warna_1_inisial_akhir" name="large_warna_1_inisial_akhir" class="form-control large_warna_1_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Large (L) Warna 1  :</label>
                        <input type="text" id="large_warna_1_jumlah_akhir" name="large_warna_1_jumlah_akhir" class="form-control" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label for="demo-vs-definput" class="control-label">Inisial Warna</label>
                    <input type="text" id="large_warna_2_inisial_akhir" name="large_warna_2_inisial_akhir" class="form-control large_warna_2_inisial" maxlength="2">
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="date2">Jumlah Large (L) Warna 2  :</label>
                        <input type="text" id="large_warna_2_jumlah_akhir" name="large_warna_2_jumlah_akhir" class="form-control" placeholder="Jumlah">
                    </div>
                </div>
            </div>
          </div>
        </div>
        
        
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label for="phoneNumber2">Catatan :</label>
                <textarea id="catatan_finishing" name="catatan_finishing" class="form-control"></textarea>
            </div>
          </div>
        </div>
          
        </form>
            <button type="button" id="btn_simpan_data_finishing" class="btn btn-info pull-left finish_bro"><i class="ft-save"></i> Simpan Data Finishing</button>
            <button type="button" id="btn_selesai_finishing" class="btn btn-success pull-right"><i class="ft-check"></i> Selesai Finishing</button>
            
            <hr>
            <a href="<?php echo base_url('cetak/cetak_produksi_finishing/'.$id_row);?>" target="_blank"><button type="button" id="btn_cetak_finishing" class="btn btn-info pull-right"><i class="fa fa-print"></i> Cetak </button><a/>
