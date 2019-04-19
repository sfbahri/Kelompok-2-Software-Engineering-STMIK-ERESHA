<script type="text/javascript">
$(document).ready(function(){
    var id_modal         = '<?php echo $id_modal;?>';
    var tokens           = '<?php echo $tokens;?>';
    var kode_bahan_baku  = '<?php echo $id_row;?>';
   
    
    //prefix:'Rp. ', 
    var get_seq = function(){
        
        $.ajax({
            url       : base_url + 'bahan_baku/data_detail',
            type      : "post",
            dataType  : 'json',
            data      : {kode_bahan_baku : kode_bahan_baku,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#seq").val(response.seq); 
                $("#kode_detail").val(kode_bahan_baku+response.seq); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    get_seq();
    
    
    var get_data_bahan_baku_detail = function(){
        $('#tabel_bahan_baku_detail').hide();
        $.ajax({ 
            url: base_url + 'bahan_baku/data_bahan_baku_detail',
            type: "post",
            data:{kode_bahan_baku:kode_bahan_baku,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit = "<a href='javascript:void(0)' onclick=edit_bahan_baku_detail("+result[i].kode+")><span class='btn btn-primary btn-sm fa fa-print' title='Cetak Label Qrcode Bahan Baku'></span></a>";
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:50px;height:50px"> <br> <a href="javascript:void(0)" style="font-weight:bold">'+result[i].kode+'</a></div>';
                    var stn;
                   
                    var stok_kilo;
                    if(result[i].stok_kilo_akhir == ''){
                        stok_kilo = '<span style="color:red;font-size:10px">Belum Dikilo</span>';
                    }else{
                        stok_kilo = '<span>'+result[i].stok_kilo_akhir+' Kilo</span>'
                    }
                    
                    var kategori;
                    if(result[i].kategori == 1){
                        kategori = 'Bahan Atasan';
                    }else{
                        kategori = 'Bahan Bawahan';
                    }
                    
                    var warna_view = '<div style="background-color:'+result[i].warna+';width:80px;height:80px"></div>';
                    
                    //result[i].hargas
                    data.push([no,result[i].noso+'<span class="tx-11 d-block"><b>QRCODE : '+result[i].kode+'</b></span>',result[i].nama,kategori,result[i].jenis,'<input type="text" onkeyup="myFunction(this,'+result[i].kode+')" id="harga_bahan_baku_'+result[i].kode+'" value="'+result[i].hargas+'" style="width:100px;border-color:#ca706e" class="form-control maskmoney">',warna_view,'<span>'+result[i].stok_rol_akhir+' Rol</span>',stok_kilo]);
                    
               }
                $('#tabel_bahan_baku_detail').DataTable({
                    //"bJQueryUI"     : true,
                    data                : data,
                    deferRender         : true,
                    processing          : true,
                    ordering            : true,
                    retrieve            : false,
                    paging              : true,
                    deferLoading        : 57,
                    bDestroy            : true,
                    autoWidth           : false,
                    bFilter             : true,
                    iDisplayLength      : 10,
                    responsive: true,
                    language: {
                      searchPlaceholder: 'Cari',
                      sSearch: '',
                      lengthMenu: '_MENU_',
                    },
                });
               
            },
            beforeSend: function () {

            },
            complete: function () {
                $('#tabel_bahan_baku_detail').show();
            }
        });
    }
    get_data_bahan_baku_detail();
    
    myFunction = function(e,c){
        $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
        var harga = parseFloat(e.value.replace(/,/g, ''));
        $.ajax({
            url       : base_url + 'bahan_baku/finance_input_harga_bahan_baku',
            type      : "post",
            dataType  : 'json',
            data      : {kode_bahan_bakau_detail : c,harga:harga,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    
    
    
    
    edit_bahan_baku_detail = function(kode_bahanbaku_detail){
        //alert(kode_bahanbaku_detail)
        
        $("#btn_update_detail").show();
        $("#btn_simpan_detail").hide();
        
        $('#'+id_modal).animate({ scrollTop: 0 }, 'slow');

        $.ajax({
            url       : base_url + 'bahan_baku/bahanbaku_detail',
            type      : "post",
            dataType  : 'json',
            data      : {kode_bahanbaku_detail : kode_bahanbaku_detail,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#nama").val(response.nama); 
                $("#jenis").val(response.jenis); 
                $("#warna").val(response.warna); 
                $("#jumlah_rol").val(response.stok_rol_akhir);
                $("#jumlah_kilo").val(response.stok_kilo_akhir);
                $("#harga").val(response.harga);
                $("#no_faktur").val(response.no_faktur);
                $("#kodedetailbahanbaku").val(response.kode);
                
                if(response.satuan == 1){
                    $("#rol").attr('checked',true);
                }else if(response.satuan == 2){
                    $("#kg").attr('checked',true);
                }else{
                    $("#cm").attr('checked',true);
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        

    }
    
   
    $("#btn_simpan_detail").click(function(){
        swal({
            title: "Simpan Bahan Baku Detail ?",
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
                url       : base_url + 'bahan_baku/simpan_bahan_baku_detail',
                type      : "post",
                dataType  : 'json',
                data      : {nama                   : $("#nama").val(),
                            jenis                   : $("#jenis").val(),
                            warna                   : $("#warna").val(),
                            no_faktur               : $("#no_faktur").val(),
                            jumlah_rol              : $("#jumlah_rol").val(),
                            jumlah_kilo             : $("#jumlah_kilo").val(),
                            harga                   : $("#harga").val(),
                            satuan                  : $('input[name="satuan"]:checked').val(),
                            seq                     : $("#seq").val(),
                            kode_bahan_baku         :kode_bahan_baku,
                            kode_bahan_baku_detail  :$("#kode_detail").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Bahan Baku berhasil disimpan", "Berhasil");
                        get_seq();
                        $('.clears').val('');
                        get_data_bahan_baku_detail();
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
    
    
    
    $("#btn_update_detail").click(function(){
        swal({
            title: "Update Bahan Baku Detail ?",
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
                url       : base_url + 'bahan_baku/update_bahan_baku_detail',
                type      : "post",
                dataType  : 'json',
                data      : {nama                   : $("#nama").val(),
                            jenis                   : $("#jenis").val(),
                            warna                   : $("#warna").val(),
                            no_faktur               : $("#no_faktur").val(),
                            jumlah_rol              : $("#jumlah_rol").val(),
                            jumlah_kilo             : $("#jumlah_kilo").val(),
                            harga                   : $("#harga").val(),
                            satuan                  : $('input[name="satuan"]:checked').val(),
                            kode                    :$("#kodedetailbahanbaku").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Bahan Baku berhasil diupdate", "Berhasil");
                        get_seq();
                        get_data_bahan_baku_detail();
                        $("#btn_update_detail").hide();
                        $("#btn_simpan_detail").show();
                        $('.clears').val('');
                        $('input[name="satuan"]:checked').attr('checked',false);
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

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:1200px;max-width: 80% !important;">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Bahan Baku | Kode Bahan Baku : <a href="javascript:void(0)" style="font-weight:bold"><?php echo $id_row;?></a></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_bahan_baku_detail" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NO.SO</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th>Jenis Bahan</th>
                        <th>Harga</th>
                        <th>Warna</th>
                        <th>Jumlah Rol</th>
                        <th>Jumlah Kilogram (Kg)</th>
                    </tr>
                </thead>
            </table>
            </div>
            
        </div>
        <div class="modal-footer">
<!--            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>-->
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

