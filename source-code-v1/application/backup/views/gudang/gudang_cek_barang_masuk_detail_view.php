<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $.ajax({ 
            url: base_url + 'produksi/data_detail',
            type: "post",
            data:{kode_produksi:kode_produksi,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(res)
            {
                if(res.gudang_in == 0){
                    $('.kodeproduksi').attr('readonly', true);
                    
                    $('#'+id_modal).on('shown.bs.modal', function () {
                        $('#kodeproduksi').focus();
                    });
                    
                    ///$("#kodeproduksi").focus();
                }else{
                    $("#cek_detail").show();
                    $('#kodeproduksi').attr('readonly', true);
                    $("#kodeproduksi").val(kode_produksi);
                    
                    $('#'+id_modal).on('shown.bs.modal', function () {
                        $('#kodeproduk_scan').focus();
                    });
                    
                }
            },
            beforeSend: function () {

            },
            complete: function () {
                //$('#tabel_produk').show();
            }
        });
    }
    data_produksi();
    
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'produk/data_detail',
            type: "post",
            data:{kode_produksi:kode_produksi,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:50px;height:50px"><br><span style="font-size:10px">'+result[i].kode+'</span></div>';
                    
                    var cek;
                    if(result[i].gudang_in == 0){
                        cek = '<div style="text-align:center"><span class="fa fa-minus-circle ft-2x" style="color:red;font-size:25px"></span></div>';
                    }else{
                        cek = '<div style="text-align:center"><span class="fa fa-check-circle ft-2x" style="color:green;font-size:25px"></span></div>';
                    }
                    
                    data.push([img_qrcode,cek]);
                }
                $('#tabel_produk').DataTable({
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
                $('#tabel_produk').show();
            }
        });
    }
    data_produk();
    
    
    $("#btn_cek").click(function(){
    
        $.ajax({
                url       : base_url + 'produk/cek_gudang',
                type      : "post",
                dataType  : 'json',
                data      : {kodeproduk : $("#kodeproduk").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (res) {
                    
                    if(res == true){
                        Command: toastr["success"]("Produk ditemukan", "Tersimpan");
                        data_produk();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }

            });
    });
    
    
    //scan kode produksi 
    $('#kodeproduksi').change(function(){
        cek_kodeproduksi();
    });
    
    cek_kodeproduksi = function(){
        $.ajax({
                url       : base_url + 'gudang/cek_produksi',
                type      : "post",
                dataType  : 'json',
                data      : {kodeproduksi : $("#kodeproduksi").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (res) {
                    
                    if(res == true){
                        Command: toastr["success"]("", "Tersimpan");
                        data_produksi();
                        getcontents('gudang/cek_barang_masuk','<?php echo $tokens;?>');
                        $("#kodeproduk_scan").focus();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }

            });
    }
    
    
    //scan kode produk
    $('#kodeproduk_scan').change(function(){
        cek_kodeproduk();
    });
    
    cek_kodeproduk = function(){
        
        $.ajax({
                url       : base_url + 'gudang/cek_produk',
                type      : "post",
                dataType  : 'json',
                data      : {kode_produk : $("#kodeproduk_scan").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (res) {
                    
                    if(res == true){
                        Command: toastr["success"]("Produk berhasil discan", "Produk Ditemukan");
                        data_produk();
                        $('#kodeproduk_scan').focus();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }

            });
        
        setTimeout(function(){ $('#kodeproduk_scan').val(''); }, 3000);
            
            
    }
    
    
});    

</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  
</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Data List Produksi </h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div id="cek_header">
            <div class="input-group mb-4">
                <input type="text" class="form-control" id="kodeproduksi" placeholder="Untuk scan kode produksi, silahkan tempelkan kursor di textbox ini">
            </div>
            </div>
            
            <div id="cek_detail" style="display:none">
            
            <div class="input-group mb-4">
                <input type="text" class="form-control" id="kodeproduk_scan" placeholder="Untuk scan produk, silahkan tempelkan kursor di textbox ini" aria-describedby="basic-addon2">
<!--                <button class="btn btn-primary" id="btncari">TES</button>-->
            </div>
            
<!--            <div class="input-group mb-4">
                <input type="text" class="form-control" id="kodeproduk" placeholder="Masukan Kode Produk ( Cari Manual )" aria-describedby="basic-addon2">
                <div class="input-group-append" style="cursor: pointer;">
                    <button class="btn btn-primary" id="btn_cek"><i class="fa fa-check-circle"></i></button>
                    <span class="input-group-text primary-bg" id="btn_scan"><i class="ft-camera"></i></span>
                </div>
            </div>-->
            
                <table id="tabel_produk" class="table table-striped table-bordered table-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Kode Produk</th>
                            <th>Check Status</th>
                        </tr>
                    </thead>
                </table>
            
            </div>    
                
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="la la-refresh"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


