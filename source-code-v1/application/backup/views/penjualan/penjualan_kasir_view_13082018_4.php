<script>
    
    var tokens = '<?php echo $tokens;?>';
    
    //$("searchField")
    
    $('#scan_kode').on('change', function () {
        // your search code
        getscan_produk();
        setTimeout(function(){ $('#scan_kode').val(''); }, 3000);
    });
    
    
    
    $("#btn_submit").click(function(){
        
        var form_data = new FormData($('#form_input1')[0]);
            
            var customer = $("input[name='customer']:checked").val()
            if(customer == 1 && $("#list_member").val() == 0){
                Command: toastr["error"]("Silahkan Pilih Member !", "Opss");
            }else{
                
                $.ajax({
                    url             : base_url + 'penjualan/simpan_transaksi_baru', 
                    type            : "POST",
                    dataType        : 'json',
                    mimeType        : 'multipart/form-data',
                    data            : form_data,
                    contentType     : false,
                    cache           : false,
                    processData     : false,
                    success     : function(response){
                        if(response == true){  
                            swal.close();
                            Command: toastr["success"]("Transaksi Baru Berhasil dibuat", "Berhasil");
                            $("#btn_simpan_transaksi").hide();
                            document.getElementById("nama").disabled = true;
                            document.getElementById("no_hp").disabled = true;
                            $("#btn_submit").remove();
                            $("#pos_input_produk").show();
                            var kdproduksi = $("#kode_transaksi").val();
                            getcontents('penjualan/kasir_transaksi/'+kdproduksi,'<?php echo $tokens;?>');
                            //kode_transaksi
                        }else{
                            Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                        } 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }

                });
            }
    });
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
    
    //Onclick Status Customer : 
    //ini member
    $("#customer_1").click(function(){
        $("#non_member").hide();
        $("#nama").val('');
        $("#no_hp").val('');
        data_pelanggan();
        $("#div_lits_member").show();
    });
        
    //ini bukan member
    $("#customer_0").click(function(){
        $("#non_member").show();
        $("#list_member").val(0);
        $("#div_lits_member").hide();
    });
    
    function data_pelanggan(){
        /* select Kategori */
        $.ajax({
            type: 'POST',
            url: base_url + 'pelanggan/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#list_member').empty();
                var $kategori = $('#list_member');
                $kategori.append('<option value=0>- Pilih Nama Pelanggan -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                }
                
                $("#list_member").chosen({width: "100%"});
            }
        });
        /* select Kategori */
    }
    data_pelanggan();
    
    
    
    //=================================== START TAMBAH MEMBER ======================//
    
    function myFunction() {
        var x = document.getElementById("nama_member");
        x.value = x.value.toUpperCase();
    }

    $("#btn_simpan_member").click(function(){
        swal({
            title: "Simpan Data Pelanggan ?",
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
                url       : base_url + 'pelanggan/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama    : $("#nama_member").val(),
                            nohp     : $("#nohp_member").val(),
                            email    : $("#email_member").val(),
                            alamat    : $("#alamat_member").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#exampleModal').modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Pelanggan berhasil disimpan", "Berhasil");
                        data_pelanggan();
                        $('.clear_member').val('');
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
    
    $(".btn-clear").click(function(){
        $('.clear_member').val('');
    });
    
    //================================== END TAMBAH MEMBER ======================//


    $("#btn_mulai").click(function(){
       $(this).hide();
       $("#btn_cancel").show();
       
       // start : mulai transaksi
            var no_nota = $("#no_nota").val();
            var nama_dummy = $("#nama_dummy").val();
            
            $.ajax({
                url       : base_url + 'penjualan/mulai',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota : no_nota,nama_dummy:nama_dummy,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                         },
                success: function (response) {
                    if(response == true){
                            $('#exampleModal').modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Silahkan tambahkan item produk pada baris tabel.", "Nota dengan Nomor : "+no_nota+" berhasil dibuat.");
                            data_pelanggan();
                            $('.clear_member').val('');
                            //$("#btnLeftMenu").click();
                            get_detail_transaksi();
                            $("#form_input_no_nota").hide();
                            $("#form_input_button").show();
                            $("#scan_kode").focus();
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    } 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
       
       // end : transkasi
       
    });
    
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
    
    
    function get_detail_transaksi(){
        
        var no_nota = $("#no_nota").val();
            
            $.ajax({
                url       : base_url + 'penjualan/detailtransaksi',
                type      : "post",
                dataType  : 'json',
                data      : {no_nota : no_nota,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                         },
                success: function (res) {
                    $("#inf_no_nota").val(res.no_nota);
                    $("#inf_tanggal").val(res.tgl_order);
                    $("#inf_kasir").val(res.kasir);
                    $("#inf_outlet").val(res.nama_outlet);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
        
    }
    
    
    $("#btn_tambah").click(function(){
        
        var kode_produk = $("#kode_produk").val();
        
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
                                    var trans_kode_produksi = res.kode_produksi;
                                    var trans_kode_produk   = res.kode;
                                    var trans_harga         = res.harga;
                                    var trans_qty           = 1;
                                    var nonota              = $("#no_nota").val();
                                    //kalo produk ini belum ada di tabel order detail, maka aksi insert ke order detail
                                    $.ajax({
                                        url       : base_url + 'penjualan/input_order_detail',
                                        type      : "post",
                                        dataType  : 'json',
                                        data      : {kode_produksi  : trans_kode_produksi,
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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    });
    
    var data_order_detail = function(){
        $('#tabel_order_detail').hide();
        var n_nota = $("#no_nota").val();
        $.ajax({ 
            url: base_url + 'penjualan/data_order_detail',
            type: "post",
            data:{nonota : n_nota,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
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
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jenis_wilayah_pengiriman/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#jenis_wilayah').empty();
            var $jenis_wilayah = $('#jenis_wilayah');
            $jenis_wilayah.append('<option value=0>- Pilih Wilayah Pengiriman -</option>');
            for (var i = 0; i < data.length; i++) {
                $jenis_wilayah.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
            }
            
            $("#jenis_wilayah").chosen({width: "100%"});
        }
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jenis_pengiriman/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#jenis_pengiriman').empty();
            var $jenis_wilayah = $('#jenis_pengiriman');
            $jenis_wilayah.append('<option value=0>- Pilih Jenis Pengiriman -</option>');
            for (var i = 0; i < data.length; i++) {
                $jenis_wilayah.append('<option value=' + data[i].id + '>' + data[i].kode + ' - ' + data[i].nama + '</option>');
            }
            
            $("#jenis_pengiriman").chosen({width: "100%"});
        }
    });
    
    $("#jenis_pengiriman").change(function(){
       var id = $(this).val();
       if(id == 1){
           $("#div_kurir").show();
       }else{
           $("#div_kurir").hide();
           $("#jenis_kurir").val('0');
       }
    });
    
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jenis_kurir/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#jenis_kurir').empty();
            var $jenis_kurir = $('#jenis_kurir');
            $jenis_kurir.append('<option value=0>- Pilih Kurir Pengiriman -</option>');
            for (var i = 0; i < data.length; i++) {
                $jenis_kurir.append('<option value=' + data[i].id + '>' + data[i].nama + ' </option>');
            }
            
            $("#jenis_kurir").chosen({width: "100%"});
        }
    });
    
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jenis_pembayaran/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#jenis_pembayaran').empty();
            var $jenis_pembayaran = $('#jenis_pembayaran');
            $jenis_pembayaran.append('<option value=0>- Pilih Jenis Pembayaran -</option>');
            for (var i = 0; i < data.length; i++) {
                $jenis_pembayaran.append('<option value=' + data[i].id + '>' + data[i].nama + ' </option>');
            }
        }
    });
    
    
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
                            email_pelanggan       : $('#pelanggan_email').val(),
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
                                    var nonota              = $("#no_nota").val();
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
    
    
    $("#btn_order").click(function(){
        var sd = $("#inf_no_nota").val();
        getpopup('penjualan/order_produk','<?php echo $tokens;?>','popuporder',sd);

    });
    
    
</script>

<?php 
//ini kode random untuk token
    $token = "";
    $codeAlphabet = "5787925558799823546985165654";
    $codeAlphabet = "8888771233688798791216984865";
    $codeAlphabet = "5558788733659987914411878766";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < 5; $i++) {
        $token .= $codeAlphabet[mt_rand(0, $max)];
    } 
    
    
    $token2 = "";
    $codeAlphabet2 = "5787925558799823546985165654";
    $codeAlphabet2 = "8888771233688798791216984865";
    $codeAlphabet2 = "5558788733659987914411878766";
    $codeAlphabet2.= "0123456789";
    //$codeAlphabet2.= "ASBDUTRWEYTASBKASGKG";
    $max2 = strlen($codeAlphabet2) - 1;
    for ($ix=0; $ix < 3; $ix++) {
        $token2 .= $codeAlphabet2[mt_rand(0, $max2)];
    } 
//    
    $token3 = "";
    $codeAlphabet3 = "SFYWGRUYUHAHBAJHDBAJHDJAHDJH";
    $codeAlphabet3 = "RTERTERTYGFBFJSIUNCOWERIUEYR";
    $codeAlphabet3 = "ACSDEREWTFDGRETTETTERTEUHBCN";
    $codeAlphabet3.= "ABCDEFGHRSYUYASGJHAJSHGAJHSG";
    //$codeAlphabet2.= "ASBDUTRWEYTASBKASGKG";
    $max3 = strlen($codeAlphabet3) - 1;
    for ($ix2=0; $ix2 < 3; $ix2++) {
        $token3 .= $codeAlphabet3[mt_rand(0, $max3)];
    }
    
    $tanggal = date("Ydm");
//ini kode random untuk token
?>
    
<div class="br-pageheader">
    <nav class="breadcrumb pd-0 mg-0 tx-12">
      <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
      <span class="breadcrumb-item active">Admin Penjualan</span>
    </nav>
</div><!-- br-pageheader -->
<div class="br-pagetitle">
    <i class="icon icon ion-ios-calculator"></i>
    <div>
      <h4>Admin Penjualan</h4>
      <p class="mg-b-0">Halaman admin penjualan.</p>
    </div>
</div><!-- d-flex -->

<div class="card col-md-6" style="margin:20px;" id="form_input_no_nota">
<div class="card-body">
    <label>No Nota :</label>
    <div class="d-md-flex pd-y-20 pd-md-y-0">
        <input type="text" readonly="" class="form-control" name="no_nota" id="no_nota" value="<?php echo $tanggal.$token.$token3.$token2;?>" style="margin-right:3px"> 
        <input type="text" class="form-control" name="nama_dummy" id="nama_dummy" placeholder="Nama Sementara" >
        <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_mulai" style="cursor:pointer" title="Mulai Transaksi Baru">Mulai <i class="fa fa-sign-in"></i></button>
        <button class="btn btn-danger pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" style="display:none;cursor:pointer" id="btn_cancel">Cancel <i class="fa fa-remove"></i></button>
    </div>
</div>
</div>

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
                        <select class="form-control list_member"  id="list_member" name="list_member"></select>
                        <small>Telp / HP</small>
                        <input type="text" id="pelanggan_nohp" name="pelanggan_nohp" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Email</small>
                        <input type="text" id="pelanggan_email" name="pelanggan_email" maxlength="30" value="" class="form-control" readonly=""/>
                        <small>Alamat</small>
                        <input type="text" id="pelanggan_alamat" name="pelanggan_email" maxlength="30" value="" class="form-control" readonly=""/>
                        <hr>
                        <small style="cursor:pointer" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i> Tambah Pelanggan Baru ?</small>
                    </div><!-- card-body -->
                </div><!-- card -->
                
            </div><!-- col -->
            <div class="col-md-8">
                    <nav class="pd-0 mg-0 tx-12" style="font-weight:bold">
                        <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon icon ion-ios-cart"></i> Penjualan</a>
                        <span class="breadcrumb-item active">Transaksi</span>
                    </nav>
                    <br>
                    <hr>
                    
                        <div id="form_input_button" style="display:none">
                            <div class="d-md-flex pd-y-20 pd-md-y-0" id="komponen">
                               
                             <input type="text" class="form-control" name="scan_kode" id="scan_kode" placeholder="Klik Disini Untuk Scan Produk">

                            <button class="btn btn-info pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_scan" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal2"><i class="icon ion-ios-search"></i> Cari Manual</button>
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_order" style="cursor:pointer" title="Order Produk"><i class="fa fa-shopping-bag"></i> Order Produk </button>
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
                                            <div id="div_kurir" style="display:none">
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
                            <button class="btn btn-primary pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_simpan_transaksi" style="cursor:pointer"><i class="fa fa-save"></i> Simpan </button>
                            <button class="btn btn-success pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_tersimpan" style="cursor:pointer;display:none"><i class="fa fa-check"></i> Transaksi Berhasil Tersimpan</button>
                            <button class="btn btn-warning pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_cetak" style="cursor:pointer;display:none"><i class="fa fa-print"></i> Cetak </button>
                            <button class="btn btn-danger pd-y-13 pd-x-20 bd-0 mg-md-l-10 mg-t-10 mg-md-t-0 tx-uppercase tx-11 tx-spacing-2" id="btn_keluar" style="cursor:pointer;display:none"> Keluar <i class="fa fa-sign-out"></i></button>
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