<script>
$(document).ready(function(){    
    var tokens = '<?php echo $tokens;?>';
    var nonota = '<?php echo $id_rows;?>';
    
    
    //$("#btnLeftMenu").click();
    $("#scan_kode").focus();
    
    $('#scan_kode').on('change', function () {
        // your search code
        getscan_produk();
        setTimeout(function(){ $('#scan_kode').val(''); }, 50);
    });
    
    //detail transaksi 
    function get_detail_transaksi(){
        
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
                    
                    if(res.status == 6){
                        $("#btn_selesai").show();
                    }else{
                        $("#btn_belum_selesai").show();
                    }
                    
                    
                    $("#uang_bayar").val(res.uangbayar);
                    $("#uang_kembali").val(res.uangkembali);
                    
                    //pelanggan
                    $("#pelanggan_nama").val(res.nama);
                    $("#pelanggan_nohp").val(res.nohp);
                    $("#pelanggan_email").val(res.email);
                    $("#pelanggan_alamat").val(res.alamat);
                    $("#alamat_pengiriman").val(res.alamat);
                    $("#catatan_transaksi").val(res.catatan);
                    
                    //nama outlet
                    $('#nm_outlet').val(res.nama_outlet);
                    
                    //jenis wilayah 
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'jenis_wilayah_pengiriman/data_select',
                        data: {},
                        dataType  : 'json',
                        success: function (data1) {
                            $('#jenis_wilayah').empty();
                            var $jenis_wilayah = $('#jenis_wilayah');
                            $jenis_wilayah.append('<option value=0>- Pilih Jenis Pengiriman -</option>');
                            for (var i = 0; i < data1.length; i++) {
                                if(res.id_jenis_wilayah_pengiriman == data1[i].id){
                                    $jenis_wilayah.append('<option value=' + data1[i].id + ' selected>' + data1[i].nama + '</option>');
                                }else{
                                    $jenis_wilayah.append('<option value=' + data1[i].id + '>' + data1[i].nama + '</option>');
                                }
                            }
                        }
                    });
                    //end jenis wilayah
                    
                    
                    //jenis pengiriman
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'jenis_pengiriman/data_select',
                        data: {},
                        dataType  : 'json',
                        success: function (data2) {
                            $('#jenis_pengiriman').empty();
                            var $jenis_pengiriman = $('#jenis_pengiriman');
                            $jenis_pengiriman.append('<option value=0>- Pilih Jenis Pengiriman -</option>');
                            for (var i = 0; i < data2.length; i++) {
                                if(res.id_jenis_pengiriman == data2[i].id){
                                    $jenis_pengiriman.append('<option value=' + data2[i].id + ' selected>' + data2[i].kode + ' - ' + data2[i].nama + '</option>');
                                }else{
                                    $jenis_pengiriman.append('<option value=' + data2[i].id + '>' + data2[i].kode + ' - ' + data2[i].nama + '</option>');
                                }
                            }
                        }
                    });
                    //jenis pengiriman 
                    
                    
                    //jenis kurir
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'jenis_kurir/data_select',
                        data: {},
                        dataType  : 'json',
                        success: function (data) {
                            $('#jenis_kurir').empty();
                            var $jenis_kurir = $('#jenis_kurir');
                            $jenis_kurir.append('<option value=0>- Pilih Jenis Kurir -</option>');
                            for (var i = 0; i < data.length; i++) {
                                 if(res.id_jenis_kurir == data[i].id){
                                     $jenis_kurir.append('<option value=' + data[i].id + ' selected>' + data[i].nama + ' </option>');
                                 }else{
                                     $jenis_kurir.append('<option value=' + data[i].id + '>' + data[i].nama + ' </option>');
                                 }
                                
                            }
                        }
                    });
                    
                    
                    $.ajax({
                        type: 'POST',
                        url: base_url + 'jenis_pembayaran/data_select',
                        data: {},
                        dataType  : 'json',
                        success: function (datas) {
                            $('#jenis_pembayaran').empty();
                            var $jenis_pembayaran = $('#jenis_pembayaran');
                            $jenis_pembayaran.append('<option value=0>- Pilih Jenis Pembayaran -</option>');
                            for (var i = 0; i < datas.length; i++) {
                                if(res.id_jenis_pembayaran == datas[i].id){
                                    $jenis_pembayaran.append('<option value=' + datas[i].id + ' selected>' + datas[i].nama + ' </option>');
                                }else{
                                    $jenis_pembayaran.append('<option value=' + datas[i].id + '>' + datas[i].nama + ' </option>');
                                }
                                
                            }
                        }
                    });
                    
                    
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
        
    }
    get_detail_transaksi();
    
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
 
    $("#list_member").change(function(){
        var id = $(this).val();
        get_detail_pelanggan(id);
    });
    
    function get_detail_pelanggan(id_pelanggan){
      
            $.ajax({
                url       : base_url + 'pelanggan/get_detail_pelanggan',
                type      : "post",
                dataType  : 'json',
                data      : {id_pelanggan : id_pelanggan,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                         },
                success: function (res) {
                    $("#pelanggan_nohp").val(res.nohp);
                    $("#pelanggan_email").val(res.email);
                    $("#pelanggan_alamat").val(res.alamat);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
        
    }
    
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
                    data.push([no,result[i].nama_produks+'<span class="tx-11 d-block"><b>KD_PRODUK : '+result[i].kode_produk+'</b></span>',result[i].hargas,result[i].qty,result[i].hargas,link_hapus]);
                   
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

            },
            complete: function () {
                $('#tabel_order_detail').show();
            }
        });
    }
    data_order_detail();
    
    //ini untuk menampilkan total
    var data_total_order_detail = function(){
        //var n_nota = $("#no_nota").val();
        $.ajax({
            url       : base_url + 'penjualan/data_total_order_detail',
            type      : "post",
            dataType  : 'json',
            data      : {no_nota : nonota,
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
    data_total_order_detail();
    
    
    
//    $("#jenis_pengiriman").change(function(){
//       var id = $(this).val();
//       if(id == 1){
//           $("#div_kurir").show();
//       }else{
//           $("#div_kurir").hide();
//           $("#jenis_kurir").val('0');
//       }
//    });
    
    
    $("#uang_bayar").keyup(function() {
        var isi_temp = $(this).val();
        var isi_temp_split = isi_temp.split(",");
        var isi_temp_join = isi_temp_split.join("");
        var total_belanja = $('#total_asli').val(); 
        var hasil_hitung = parseInt(isi_temp_join) - parseInt(total_belanja);
        
        //convert to rupiah
        var rev     = parseInt(hasil_hitung, 10).toString().split('').reverse().join('');
            var rev2    = '';
            for(var i = 0; i < rev.length; i++){
                rev2  += rev[i];
                if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
                    rev2 += ',';
                }
            }
        var hasil =  rev2.split('').reverse().join('') + '';
        
        
        $('#uang_kembali').val(hasil);
        $('#uang_kembali_asli').val(hasil_hitung);
    });
    
    $("#btn_belum_selesai").click(function(){
        
        swal({
            title: "Ubah Status Selesai pada Transaksi ini ?",
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
                url       : base_url + 'penjualan/update_status_selesai',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota            : nonota,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Perubahan Status Transaksi menjadi Selesai berhasil disimpan", "Berhasil");
                        get_detail_transaksi();
                        $("#btn_belum_selesai").hide();
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
    
    
    //aksi simpan transaksi
    $("#btn_simpan_transaksi").click(function(){
        
        swal({
            title: "Update Transaksi ini ?",
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
                url       : base_url + 'penjualan/update_trans',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota            : nonota,
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
                            total               : $('#total_asli').val(),
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
        getcontents('penjualan/transaksi','<?php echo $tokens;?>');
    });
    
    $("#btn_cetak").click(function(){
        //var nonota = $("#no_nota").val();
        var url = '<?php echo base_url('penjualan/cetak_struk/');?>';
        newwindow=window.open(url+'/'+nonota,'name','height=800,width=325');
        if (window.focus) {newwindow.focus()}
        return false;
        //getcontents('penjualan/kasir','<?php echo $tokens;?>');
    });
    
    
    $("#btn_cetak_dotmetrik").click(function(){
        //var nonota = $("#no_nota").val();
        var url = '<?php echo base_url('penjualan/cetak_struk_dotmetrik/');?>';
        newwindow=window.open(url+'/'+nonota,'name','height=800,width=900');
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
      <h4>Edit Transaksi Penjualan</h4>
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
                        <input type="text" id="nm_outlet" name="nm_outlet" maxlength="30" value="" class="form-control" readonly=""/>
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
                        <hr>
<!--                        <small style="cursor:pointer" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i> Tambah Pelanggan Baru ?</small>-->
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
                            <div class="d-md-flex pd-y-20 pd-md-y-0" id="komponen">
                               
                             <input type="text" class="form-control" name="scan_kode" id="scan_kode" placeholder="Klik Disini Untuk Scan Produk">

<!--                            <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_scan" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal2"><i class="icon ion-ios-search"></i> Cari Manual</button>
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_lihat_stok" style="cursor:pointer" title="Lihat Stok Produk"><i class="fa fa-eye"></i> Lihat Stok </button>-->
                            <button class="btn btn-danger pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_scan" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-remove"></i> Cancel</button>
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
                                      <th>Aksi</th>
                                    </tr>
                                  </thead>
                                </table>
                                </div>
                            </div>
                            <br>
                            <div class="pd-md-y-0" style="width:100%">    
                                <div class="alert alert-success" role="alert">
                                    <div class="d-flex align-items-center justify-content-start" style="font-size:15px">
                                      <i class="icon ion-ios-wallet alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                                      <span><strong>Total : </strong> <span id="total"></span><input type="hidden" id="total_asli" name="total_asli" class="form-control"/></span>
                                    </div><!-- d-flex -->
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <small>Wilayah Pengiriman</small>
                                            <select class="form-control"  id="jenis_wilayah" name="jenis_wilayah"></select>
                                            <small>Jenis Pengiriman</small>
                                            <select class="form-control"  id="jenis_pengiriman" name="jenis_pengiriman"></select>
                                            <div id="div_kurir">
                                                <small>Kurir</small>
                                                <select class="form-control"  id="jenis_kurir" name="jenis_kurir"></select>
                                            </div>
                                            <small>Alamat Pengiriman</small>
                                            <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman"/></textarea>
                                        </div><!-- card-body -->
                                    </div><!-- card -->
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <small>Jenis Pembayaran</small>
                                            <select class="form-control"  id="jenis_pembayaran" name="jenis_pembayaran"></select>
                                            <small>Uang Bayar</small>
                                            <input type="text" id="uang_bayar" name="uang_bayar" class="form-control maskmoney"/>
                                            <small>Uang Kembali</small>
                                            <input type="text" id="uang_kembali" name="uang_kembali" class="form-control" readonly=""/>
                                            <input type="hidden" id="uang_kembali_asli" name="uang_kembali_asli" class="form-control" readonly=""/>
                                        </div><!-- card-body -->
                                    </div><!-- card -->
                                </div>
                            </div>
                            <small>Catatan Transaksi</small>
                            <textarea class="form-control" id="catatan_transaksi" name="catatan_transaksi" placeholder="Masukan Catatan Transaksi disini (Jika Ada)"/></textarea>
                            <br>
                            <div class="d-md-flex pd-y-20 pd-md-y-0 pull-right">
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_simpan_transaksi" style="cursor:pointer"><i class="fa fa-save"></i> Update Transaksi</button>
<!--                                <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_simpan_transaksi" style="cursor:pointer"><i class="fa fa-save"></i> Update Pembayaran</button>-->
                            
                            <button class="btn btn-success pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_selesai" style="cursor:pointer;display:none"><i class="fa fa-check"></i> Transaksi Selesai</button>
                            <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_belum_selesai" style="cursor:pointer;display:none"><i class="fa fa-remove"></i> Transaksi Belum Selesai</button>
                            <button class="btn btn-warning pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_cetak" style="cursor:pointer;"><i class="fa fa-print"></i> Cetak Mini Thermal</button>
                            <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_cetak_dotmetrik" style="cursor:pointer;"><i class="fa fa-print"></i> Cetak Dotmetrik</button>
                            
                            
                            <button class="btn btn-danger pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_keluar" style="cursor:pointer;"> Keluar <i class="fa fa-sign-out"></i></button>
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