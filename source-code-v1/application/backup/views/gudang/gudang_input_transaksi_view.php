<script>
$(document).ready(function(){    
    var tokens = '<?php echo $tokens;?>';
    var nonota = '<?php echo $id_rows;?>';
    
     loading();
    
    //$("#btnLeftMenu").click();
    $("#scan_kode").focus();
    
    $('#scan_kode').on('change', function () {
        // your search code
        getscan_produk();
        setTimeout(function(){ $('#scan_kode').val(''); }, 10);
    });
    
    //detail transaksi 
    function get_detail_transaksi(){
        
        var no_nota = $("#no_nota").val();
            
            $.ajax({
                url       : base_url + 'penjualan/detailtransaksi',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota : nonota,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                         },
                success: function (res) {
                    $("#inf_no_nota").val(res.no_nota);
                    $("#inf_tanggal").val(res.tgl_order);
                    $("#inf_kasir").val(res.kasir);

                    $("#inf_outlet").val(res.nama_outlet);
                    
                    //order sales
                    data_order(res.no_order_sales);
                    var baseurl = '<?php echo base_url();?>';
                    $("#btnprint").html('<a href="'+baseurl+'order_sales/cetak_struk_dotmetrik_unpaid/'+res.no_order_sales+'" target="_blank"><div class="btn btn-success btn-sm pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" title="Print Invoice" ><i class="fa fa-print"></i> Print Order Sales (Unpaid)</div></a>');
                    
                    //pelanggan
                    $("#pelanggan_nama").val(res.nama);
                    $("#pelanggan_nohp").val(res.nohp);
                    $("#pelanggan_email").val(res.email);
                    $("#pelanggan_alamat").val(res.alamat);
                    $("#alamat_pengiriman").val(res.alamat);
                    $("#catatan_transaksi").val(res.catatan);
                    
                    if(res.status == 2){
                        $("#btn_siapkan").show();
                        $("#btn_selesai").hide();
                        $("#order_list").hide();
                    }else if(res.status == 3){
                        $("#btn_siapkan").hide();
                        $("#btn_selesai").show();
                        $("#order_list").show();
                        $("#scan_kode").focus();
                    }else if(res.status == 4){
                        $("#btn_siapkan").hide();
                        $("#btn_selesai").hide();
                        $("#order_list").hide();
                    }else{
                        //$("#btn_selesai").hide();
                        //$("#btn_selesai").hide();
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
        
    }
    get_detail_transaksi();
    
    
    var data_order_detail = function(){
        $('#tabel_order_detail').hide();
        //var n_nota = $("#no_nota").val();
        $.ajax({ 
            url: base_url + 'penjualan/data_order_detail',
            type: "post",
            data:{nonota : nonota,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                    var no = i+1;
                    var link_hapus = "<a href='javascript:void(0)' onclick=\"getpopup('users/module_permission','"+tokens+"','popupedit','"+result[i].nik+"');\"><div class='btn btn-danger btn-sm' title='Batal' disabled ><i class='fa fa-close'></i></div></a>";    
                    data.push([no,result[i].nama_produks+'<span class="tx-11 d-block"><b>KD_PRODUK : '+result[i].kode_produk+'</b></span>',result[i].hargas,result[i].count_qty,result[i].count_harga]);
                }
                $('#tabel_order_detail').DataTable({
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
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
                $('#tabel_order_detail').show();
            }
        });
    }
    data_order_detail();
    
    //ini untuk menampilkan total
    var data_total_order_detail = function(){
        var n_nota = $("#no_nota").val();
        $.ajax({
            url       : base_url + 'penjualan/data_total_order_detail',
            type      : "post",
            dataType  : 'json',
            data      : {no_nota : n_nota,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                     },
            success: function (resp) {
                $("#total").text(resp.total);
                $("#total_asli").val(resp.total_asli);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    
    //aksi simpan transaksi
    $("#btn_simpan_transaksi").click(function(){
        
        swal({
            title: "Selesai dan Simpan Transaksi ini ?",
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
                url       : base_url + 'penjualan/simpan_trans',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota            : $("#no_nota").val(),
                            jenis_pembayaran    : $('#jenis_pembayaran').val(),
                            jenis_wilayah       : $('#jenis_wilayah').val(),
                            jenis_pengiriman    : $('#jenis_pengiriman').val(),
                            jenis_kurir         : $('#jenis_kurir').val(),
                            alamat_pengiriman   : $('#alamat_pengiriman').val(),
                            uang_bayar          : $('#uang_bayar').val(),
                            uang_kembali        : $('#uang_kembali_asli').val(),
                            catatan             : $('#catatan_transaksi').val(),
                            id_pelanggan        : $('#list_member').val(),
                            nama_pelanggan      : $('#list_member :selected').text(),
                            nohp_pelanggan      : $('#pelanggan_nohp').val(),
                            email_pelanggan     : $('#pelanggan_email').val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Transaksi berhasil disimpan", "Berhasil");
                        $("#btn_simpan_transaksi").remove();
                        $("#btn_cetak").show();
                        $("#btn_keluar").show();
                        $("#btn_tersimpan").show();
                        $("#komponen").remove();
                        //getcontents('penjualan/invoice/<?php echo $kode_transaksi;?>','<?php echo $tokens;?>');
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
    
    
    $("#btn_keluar").click(function(){
        getcontents('penjualan/kasir','<?php echo $tokens;?>');
    });
    
    $("#btn_cetak").click(function(){
        var nonota = $("#no_nota").val();
        var url = '<?php echo base_url('penjualan/cetak_struk/');?>';
        newwindow=window.open(url+'/'+nonota,'name','height=800,width=325');
        if (window.focus) {newwindow.focus()}
        return false;
        //getcontents('penjualan/kasir','<?php echo $tokens;?>');
    });

    //<a href="<?php echo base_url('');?>" target="_blank">
    
    
    //scan produk 
    function getscan_produk(){
        
        var kode_produk = $("#scan_kode").val();
        
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
                
                if(res.beli == 1){
                        Command: toastr["warning"]("Maaf Produk dengan kode ini sudah terjual !", "Info");
                    }else{
                        
                        //cek dulu kode produk ini sudah ada ditransaksi belum
                        $.ajax({
                            url       : base_url + 'penjualan/cek_produk_order_detail',
                            type      : "post",
                            dataType  : 'json',
                            data      : {kode_produk  : res.kode,
                                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                     },
                            success: function (respz) {
                                if(respz == 0){
                                    var trans_kode_produk_header = res.kode_produk_header;
                                    var trans_kode_produk   = res.kode;
                                    var trans_harga         = res.harga;
                                    var trans_qty           = 1;
                                    //var nonota              = $("#no_nota").val();
                                    //kalo produk ini belum ada di tabel order detail, maka aksi insert ke order detail
                                    $.ajax({
                                        url       : base_url + 'penjualan/input_order_detail',
                                        type      : "post",
                                        dataType  : 'json',
                                        data      : {kode_produk_header  : trans_kode_produk_header,
                                                    kode_produk     : trans_kode_produk,
                                                    harga           : trans_harga,
                                                    qty             : trans_qty,
                                                    no_nota         : nonota,
                                                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                                 },
                                        success: function (resp) {
                                            if(resp == true){
                                                $("#kode_produk").val('');
                                                Command: toastr["success"]("Produk ini berhasil ditambahkan ke dalam transaksi ini", "Oke Berhasil");
                                                data_order_detail();
                                                data_total_order_detail();
                                            }else{
                                                Command: toastr["error"]("Transaksi Error, data tidak tersimpan !!", "Error");
                                            }
                                            
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                            Command: toastr["error"]("Ajax Error !!", "Error");
                                        }
                                    });
                                }else{
                                    Command: toastr["warning"]("Maaf Produk dengan kode ini sudah terjual !", "Info");
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Command: toastr["error"]("Ajax Error !!", "Error");
                            }
                        });
                        
                        
                    }
                    
                }
                
//                if (res.id == null){
//                    Command: toastr["error"]("Maaf Kode Produk ini tidak tersedia  !", "Info");
//                }else{
//                    
//                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    
    
    
    
    var data_order_detail2 = function(){
        $('#tabel_order_detail2').hide();
        var n_nota = $("#inf_no_nota").val();
        $.ajax({ 
            url: base_url + 'penjualan/data_order_request_barang',
            type: "post",
            data:{nonota : nonota,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                    var no = i+1;
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].gambar+'" style="width:100px;height:100px"></div>';
                    }
                    
                    var link_hapus = "<a href='javascript:void(0)' onclick=\"getpopup('users/module_permission','"+tokens+"','popupedit','"+result[i].nik+"');\"><div class='btn btn-danger btn-sm' title='Batal' ><i class='fa fa-close'></i></div></a>";    
                    data.push([no,result[i].nama,img,'<span style="color:red">'+result[i].qty_s+'</span> Pcs','<span style="color:red">'+result[i].qty_m+'</span> Pcs','<span style="color:red">'+result[i].qty_l+'</span> Pcs']);
                   
                }
                $('#tabel_order_detail2').DataTable({
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
                $('#tabel_order_detail2').show();
            }
        });
    }
    data_order_detail2();
    
    
    
    $("#btn_siapkan").click(function(){
        
        swal({
            title: "Siapkan Barang ?",
            text: "Jika ok, silahkan klik button siapkan sekarang",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Siapkan Sekarang",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'penjualan/update_status_penjualan',
                type      : "post",
                dataType  : 'json',
                data      : {nonota : nonota, status : 3,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Silahkan Siapkan Barang..", "Berhasil");
                        $("#btn_siapkan").hide();
                        $("#btn_selesai").show();
                        $("#order_list").show();
                        //getcontents('penjualan/invoice/<?php echo $kode_transaksi;?>','<?php echo $tokens;?>');
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
        
        
        $("#btn_selesai").click(function(){
        
        swal({
            title: "Selesai Input Orderan ?",
            text: "Jika ok, silahkan klik button Selesai",
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
                url       : base_url + 'penjualan/update_status_penjualan',
                type      : "post",
                dataType  : 'json',
                data      : {nonota : nonota, status : 4,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Sudah Selesai", "Berhasil");
                        $("#btn_siapkan").hide();
                        $("#btn_selesai").hide();
                        $("#order_list").show();
                        //getcontents('penjualan/invoice/<?php echo $kode_transaksi;?>','<?php echo $tokens;?>');
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
        
        
        var data_order = function(no_order_sales){
        $('#tabel_order_list').hide();
        $.ajax({ 
            url: base_url + 'order_sales/data_produk_order',
            type: "post",
            data:{id_order_sales:no_order_sales,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '<div style="width:100%;text-align:center"><img src="assets/img/noimages.jpg" style="width:80px;height:80px"></div>';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].img+'" style="width:150px;height:150px"></div>';
                    }
                    
                    data.push([result[i].nama_produk,result[i].count_qty+' Pcs',result[i].count_berat,result[i].count_harga,result[i].catatan]);
                   
                }
                $('#tabel_order_list').DataTable({
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
                    }
                });
               
            },
            beforeSend: function () {

            },
            complete: function () {
                $('#tabel_order_list').show();
            }
        });
    }
    data_order();
        
        
    });
</script>

<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
      <span class="breadcrumb-item active">Edit Transaksi Penjualan</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-pagetitle">
    <i class="icon icon ion-ios-repeat"></i>
    <div>
      <h4>Warehouse (Input Order Transaksi)</h4>
      <p class="mg-b-0">Halaman edit transaksi penjualan.</p>
    </div>
</div><!-- d-flex -->

<div class="card" style="margin:20px;">
  <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header tx-white bg-info">
                        <i class="fa fa-file"></i> Informasi Nota
                    </div><!-- card-header -->
                    <div class="card-body">
                        <small>No. Nota</small>
                        <input type="text" id="inf_no_nota" name="inf_no_nota" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Tanggal</small>
                        <input type="text" id="inf_tanggal" name="inf_tanggal" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Kasir</small>
                        <input type="text" id="inf_kasir" name="inf_kasir" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Outlet</small>
                        <input type="text" id="inf_outlet" name="inf_outlet" maxlength="30" value="" class="form-control" readonly=""/>
                    </div><!-- card-body -->
                </div><!-- card -->
                <br>
                <div class="card">
                    <div class="card-header tx-white bg-info">
                        <i class="fa fa-user-circle"></i> Informasi Pelanggan
                    </div><!-- card-header -->
                    <div class="card-body">
                        <small>Nama Pelanggan</small>
                        <input type="text" id="pelanggan_nama" name="pelanggan_nama" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Telp / HP</small>
                        <input type="text" id="pelanggan_nohp" name="pelanggan_nohp" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Email</small>
                        <input type="text" id="pelanggan_email" name="pelanggan_email" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Alamat</small>
                        <input type="text" id="pelanggan_alamat" name="pelanggan_email" maxlength="30" value="" class="form-control" readonly=""/>
                        
                    </div><!-- card-body -->
                </div><!-- card -->
                
            </div><!-- col -->
            <div class="col-md-8">
                    <nav class="pd-0 mg-0 tx-12" style="font-weight:bold">
                        <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon icon ion-ios-cart"></i> Penjualan</a>
                        <span class="breadcrumb-item active">Edit Transaksi</span>
                    </nav>
                    <br>
                    <hr>
                    
                        <div id="form_input_button">
                            <div id="order_list" style="display:none">
                                <div class="d-md-flex pd-y-20 pd-md-y-0" id="komponen">
                                 <input type="text" class="form-control" name="scan_kode" id="scan_kode" placeholder="Klik Disini Untuk Scan Produk">
                                <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_scan" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal2"><i class="icon ion-ios-search"></i> Cari Manual</button>
                                </div>
                            </div>
                            <br>
                            <div class="row table-responsive">
                                <div class="col-md-12">
                                 <table class="table table-striped table-hover" id="tabel_order_detail">
                                    <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Kode Barang</th>
                                      <th>Harga</th>
                                      <th>Qty</th>
                                      <th>Subtotal</th>
                                    </tr>
                                  </thead>
                                </table>
                                </div>
                            </div>
                            
                            <br>
                            
                            <nav class="pd-0 mg-0 tx-12" style="font-weight:bold">
                                <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon icon ion-ios-cart"></i> Request Admin Penjualan</a>
                                <span class="breadcrumb-item active">Request</span>
                            </nav>
                            
                            <br>
                            <hr>
                            
                            <div class="row table-responsive">
                                <div class="col-md-12">
                                <table id="tabel_order_list" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Berat</th>
                                        <th>Harga</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                </table>
                                <!--<table class="table table-striped table-hover" id="tabel_order_detail2">
                                    <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Nama Produk</th>
                                      <th>Gambar</th>
                                      <th>Ukuran S</th>
                                      <th>Ukuran M</th>
                                      <th>Ukuran L</th>
                                    </tr>
                                  </thead>
                                </table>-->
                                </div>
                            </div>
                            <br>
                            
                            <div class="d-md-flex pd-y-20 pd-md-y-0 pull-right">
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_siapkan" style="cursor:pointer;display: none"><i class="fa fa-refresh"></i> Siapkan Barang </button>
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_selesai" style="cursor:pointer;display: none"><i class="fa fa-save"></i> Selesai </button>
                            <div id="btnprint"></div>
                            </div>
                            
                            
                            
                        </div>
            </div>
        </div>
        
      
  </div>
</div>



    

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Pelanggan</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama_member" name="nama_member" class="form-control clear_member" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Email</label>
                    <input type="text" id="email_member" name="email_member" class="form-control clear_member">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">No Telp</label>
                    <input type="text" id="nohp_member" name="nohp_member" class="form-control clear_member">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Alamat</label>
                    <textarea name="alamat_member" id="alamat_member" class="form-control clear_member"></textarea>
                </div>
            </div> 
        </div>      
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-info" id="btn_simpan_member"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
      </div>
    </div>
    </div>
</div>    
   
        
        
        
        
 <!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Cari Kode Produk</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" name="kode_produk" id="kode_produk" placeholder="Input Kode Produk Disini">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_tambah"><i class="fa fa-search"></i> Cari</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>