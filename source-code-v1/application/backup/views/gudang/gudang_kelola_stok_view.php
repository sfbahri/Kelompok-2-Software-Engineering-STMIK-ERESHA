<script>
$(document).ready(function(){    
    var tokens = '<?php echo $tokens;?>';
  
    $("#scan_kode").focus();
    
    $('#scan_kode').on('change', function () {
        // your search code
        getscan_produk();
        setTimeout(function(){ $('#scan_kode').val(''); }, 100);
    });
    
    function getscan_produk(){
        
        var kode_produk = $("#scan_kode").val();
        var id_outlet = $("#outlet").val();
        
        $.ajax({
            url       : base_url + 'produk/cari',
            type      : "post",
            dataType  : 'json',
            data      : {kodeproduk : kode_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                     },
            success: function (res) {
                
                if (res.id == null){
                    Command: toastr["error"]("Maaf Kode Produk ini tidak tersedia  !", "Info");
                }else{
                    
                    $.ajax({
                        url       : base_url + 'gudang/update_kelola_stok',
                        type      : "post",
                        dataType  : 'json',
                        data      : {kode_produk  : kode_produk,
                                    id_outlet     : id_outlet,
                                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                 },
                        success: function (resp) {
                            if(resp == true){
                                Command: toastr["success"]("Produk ini berhasil dipindahkan", "Oke Berhasil");
                                data_produk_list();
                            }else{
                                Command: toastr["error"]("Transaksi Error, data tidak tersimpan !!", "Error");
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Command: toastr["error"]("Ajax Error !!", "Error");
                        }
                    });
                    
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    
    
    $.ajax({
        type: 'POST',
        url: base_url + 'outlet/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#outlet').empty();
            var $kategori = $('#outlet');
            $kategori.append('<option value=0>- Pilih Outlet -</option>')
            for (var i = 0; i < data.length; i++) {
                $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + ' - '+ data[i].alamat +'</option>');
            }
            
            $("#outlet").chosen({width: "100%"});
        }
    });
    
    
    var data_produk_list = function(){
        $('#tabel_produk_list').hide();
        $.ajax({ 
            url: base_url + 'produk/data_list2',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                   
                    var statuss;
                    if(result[i].beli == 0){
                        statuss = '<span style="color:red;font-size:10px">Belum Terjual</span>';
                    }else{
                        statuss = '<span style="color:green;font-size:10px">Terjual</span>';
                    }
                   
                    data.push([no,result[i].kode_produk,result[i].nama_produk,'Rp. ' +result[i].hargass,statuss,result[i].nama_outlet]);
                }
                $('#tabel_produk_list').DataTable({
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
                $('#tabel_produk_list').show();
            }
        });
    }
    data_produk_list();
    
    
    
    });
</script>

<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
      <span class="breadcrumb-item active">Kelola Stok Produk</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-pagetitle">
    <i class="icon icon ion-ios-repeat"></i>
    <div>
      <h4>Warehouse (Kelola Stok Produk)</h4>
      <p class="mg-b-0">Halaman kelola stok produk.</p>
    </div>
</div><!-- d-flex -->

<div class="card" style="margin:20px;">
  <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header tx-white bg-info">
                        <i class="fa fa-file"></i> Form
                    </div><!-- card-header -->
                    <div class="card-body">
                        <small>Pilihan Outlet (Target Produk Dipindahkan)</small>
                        <select id="outlet" name="outlet" class="form-control"></select>
                        <small>Scan Disini</small>
                        <input type="text" id="scan_kode" name="scan_kode" class="form-control"/>
                    </div><!-- card-body -->
                </div><!-- card -->
                <br>
                
            </div><!-- col -->
            <div class="col-md-12">
                        <div id="form_input_button">
                            <div id="order_list" style="display:none">
                                <div class="d-md-flex pd-y-20 pd-md-y-0" id="komponen">
                                 <input type="text" class="form-control" name="scan_kode" id="scan_kode" placeholder="Klik Disini Untuk Scan Produk">
                                <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_scan" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal2"><i class="icon ion-ios-search"></i> Cari Manual</button>
                                </div>
                            </div>
                            <br>
                            <div class="table-wrapper table-responsive">
                            <table id="tabel_produk_list" class="table  display nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode</th>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th width="10%">Outlet</th>
                                            </tr>
                                        </thead>
                                    </table>   
                            </div>
                            
                            
                        </div>
            </div>
        </div>
        
      
  </div>
</div>

