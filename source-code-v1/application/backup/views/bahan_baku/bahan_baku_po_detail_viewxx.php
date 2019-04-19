<script type="text/javascript">
$(document).ready(function(){
    var id_modal         = '<?php echo $id_modal;?>';
    var tokens           = '<?php echo $tokens;?>';
    var kode_bahan_baku  = '<?php echo $id_row;?>';
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
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
                $("#no_so").val('BN'+response.po_tahun+response.po_bulan);
                $("#no_so_teks").text('BN'+response.po_tahun+response.po_bulan);
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
                    var link_edit = "<a href='javascript:void(0)' onclick=edit_bahan_baku_detail("+result[i].kode+")><span class='btn btn-primary btn-sm fa fa-pencil' title='Edit Bahan Baku'></span></a>";
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:50px;height:50px"> <br> <a href="javascript:void(0)" style="font-weight:bold">'+result[i].kode+'</a></div>';
                    var stn;
                    if(result[i].satuan == 1){
                        stn = 'Rol';
                    }else if(result[i].satuan == 2){
                        stn = 'Kg';
                    }else{
                        stn = 'Cm';
                    }
                    
                    var baseurl = '<?php echo base_url();?>';
                    var link_print = "<a href='"+baseurl+"cetak/cetak_bahanbaku_label/"+result[i].kode+"' target='_blank'><span class='btn btn-success btn-sm fa fa-print' title='Print Label Aksesoris'></span></a>";
                    
                    var warna_view = '<div style="background-color:'+result[i].warna+';width:80px;height:80px"></div>';
                    
                    var stok_kilo;
                    if(result[i].stok_kilo_akhir == ''){
                        stok_kilo = '<span style="color:red;font-size:10px">Belum Dikilo</span>';
                    }else{
                        stok_kilo = '<span>'+result[i].stok_kilo_akhir+' Kilo</span>'
                    }
                    
                    var kategori;
                    if(result[i].kategori == 1){
                        kategori = 'Bahan Atasan';
                    }else if(result[i].kategori == 2){
                        kategori = 'Bahan Bawahan';
                    }else{
                        kategori = 'Rib';
                    }
                    
                    var link_terima;
                    if(result[i].tgl_terima == null){
                        link_terima = "<span class='btn btn-danger btn-sm fa fa-save' onclick=func_terima_bahan_baku("+result[i].kode+") title='Terima Bahan Baku Ini'></span>"; 
                    }else{
                        link_terima = "<span class='btn btn-primary btn-sm fa fa-check'></span>";
                    }
                    
                    //,result[i].hargas
                    data.push([result[i].noso+'<span class="tx-11 d-block"><b>QRCODE : '+result[i].kode+'</b></span>',result[i].nama,kategori,result[i].jenis,warna_view,'<span>'+result[i].stok_rol_akhir+' Rol</span>',stok_kilo,'<div style="width:100%;text-align:center">'+link_edit+'</div>',link_print,link_terima]);
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
    
    
    func_terima_bahan_baku = function(kode_bahan_baku_detail){
        //alert(kode_bahanbaku_detail)
        
        swal({
            title: "Bahan Baku ini Sudah Sampai ?",
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
                url       : base_url + 'bahan_baku/update_status_bahan_baku_finance',
                type      : "post",
                dataType  : 'json',
                data      : {kode_bahan_baku_detail  :kode_bahan_baku_detail,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Bahan Baku berhasil disimpan", "Berhasil");
                        get_seq();
                        $('.clears').val('');
                        $('#kategori').val('0');
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
                $("#nourut").val(response.nourut);
                $("#kategori").val(response.kategori);
                alert(response.kategori)
                $("#tgl_kirim").val(response.tgl_kirim);
                
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
                url       : base_url + 'bahan_baku/simpan_bahan_baku_detail_po',
                type      : "post",
                dataType  : 'json',
                data      : {nama                   : $("#nama").val(),
                            jenis                   : $("#jenis").val(),
                            warna                   : $("#warna").val(),
                            no_so                   : $("#no_so").val(),
                            nourut                 : $("#nourut").val(),
                            tgl_kirim               : $("#tgl_kirim").val(),
                            harga                   : $("#harga").val(),
                            jumlah_rol              : $("#jumlah_rol").val(),
                            jumlah_kilo             : $("#jumlah_kilo").val(),
                            harga                   : $("#harga").val(),
                            satuan                  : $('input[name="satuan"]:checked').val(),
                            seq                     : $("#seq").val(),
                            kategori                : $("#kategori").val(),
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
                        $('#kategori').val('0');
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
    
    $('#tgl_kirim').datepicker();
    
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
                url       : base_url + 'bahan_baku/update_bahan_baku_detail_po',
                type      : "post",
                dataType  : 'json',
                data      : {nama                   : $("#nama").val(),
                            jenis                   : $("#jenis").val(),
                            warna                   : $("#warna").val(),
                            no_so                   : $("#no_so").val(),
                            nourut                 : $("#nourut").val(),
                            tgl_kirim               : $("#tgl_kirim").val(),
                            kategori                : $("#kategori").val(),
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
   
    $("#kategori").append('<option value="0">- Kategori Bahan -</option><option value="1">Bahan Atasan</option><option value="2">Bahan Bawahan</option><option value="3">Rib</option>');
   
});    

</script>

<style>
    .modal-lg{
        width: 90% !important;
    }
</style>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail PO Bahan Baku | NO : <span id="no_so_teks"></span> | Kode Bahan Baku : <a href="javascript:void(0)" style="font-weight:bold"><?php echo $id_row;?></a></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div class="row" id="oketop">          
            <div class="col-md-6">   

                <input id="seq" type="hidden">
                <input id="kode_detail" type="hidden">
                <input id="kodedetailbahanbaku" type="hidden">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Nama Bahan Baku</label>
                            <input type="text" id="nama" name="nama" class="form-control clears">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Kategori Bahan</label>
                            <select id="kategori" name="kategori" class="form-control">
                                
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Jenis Bahan Baku</label>
                            <input type="text" id="jenis" name="jenis" class="form-control clears">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Tgl Estimasi Kirim</label>
                            <input type="text" id="tgl_kirim" name="tgl_kirim" class="form-control clears">
                        </div>
                    </div>
                </div>
                
            </div> 

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">No.Master SO</label>
                            <input type="text" id="no_so" name="no_so" class="form-control" readonly="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">No Urut SO</label>
                            <input type="text" id="nourut" name="nourut" class="form-control clears">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Harga</label>
                            <input type="text" id="harga" name="harga" class="form-control clears maskmoney">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                         <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Kode Warna</label>
                            <input type="text" id="warna" name="warna" class="form-control clears" placeholder="Exp: #FFFFF">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Jumlah Rol</label>
                            <input type="text" id="jumlah_rol" name="jumlah_rol" class="form-control clears" onkeypress="return isNumber(event)">
                        </div> 
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Jumlah Kilo (Kg)</label>
                            <input type="text" id="jumlah_kilo" name="jumlah_kilo" class="form-control clears" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                
                
              
                

                <button type="button" class="btn btn-info pull-right btn-sm" id="btn_simpan_detail" style="margin-bottom:10px" title="Submit Bahan Baku"><i class="fa fa-save la-3x"></i></button>
                <button type="button" class="btn btn-success pull-right btn-sm" title="Update Bahan Baku" id="btn_update_detail" style="margin-bottom:10px;display: none"><i class="fa fa-save"></i></button>

            </div>
            </div>
            <hr>
            <div class="table-wrapper table-responsive">
            <table id="tabel_bahan_baku_detail" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>NO.SO</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th>Jenis Bahan</th>
<!--                    <th>Harga</th>-->
                        <th>Warna</th>
                        <th>Jumlah Rol</th>
                        <th>Jumlah Kg</th>
                        <th>Aksi</th>
                        <th>Print</th>
                        <th>Aksi</th>
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

