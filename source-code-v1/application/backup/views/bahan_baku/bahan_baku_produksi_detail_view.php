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
                    
                    
                    var link_terima;
                    if(result[i].tgl_terima_produksi == null){
                        link_terima = "<span class='btn btn-danger btn-sm fa fa-save' onclick=func_terima_bahan_baku("+result[i].kode+") title='Terima Bahan Baku Ini'></span>"; 
                    }else{
                        link_terima = "<span class='btn btn-primary btn-sm fa fa-check'></span>";
                    }
                    
                    
                    
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
                    }else{
                        kategori = 'Bahan Bawahan';
                    }
                    
                    //,result[i].hargas
                    data.push([result[i].noso,result[i].noso+'<span class="tx-11 d-block"><b>QRCODE : '+result[i].kode+'</b></span>',result[i].nama,kategori,result[i].jenis,warna_view,'<span>'+result[i].stok_rol_akhir+' Rol</span>',stok_kilo,link_print,link_terima]);
                }
                $('#tabel_bahan_baku_detail').DataTable({
                    //"bJQueryUI"     : true,
                    data                : data,
                    "columnDefs": [
                        { "visible": false, "targets": [0] }
                    ],
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
                    "drawCallback": function ( row, data, index ) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null;

                        api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="10"><span style="color:black">'+group+'</span></td></tr>'
                                );
                                last = group;
                            }
                        } );
                    }
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
                url       : base_url + 'bahan_baku/update_status_bahan_baku_produksi',
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
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_bahan_baku_detail" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NO.SO</th>
                        <th>Nama Bahan Baku</th>
                        <th>Kategori</th>
                        <th>Jenis Bahan</th>
<!--                    <th>Harga</th>-->
                        <th>Warna</th>
                        <th>Jumlah Rol</th>
                        <th>Jumlah Kg</th>
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

