<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    loading();
    
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'web_produk/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var baseurl = '<?php echo base_url();?>';

                    var link_detail                 = "<a href='javascript:void(0)' onclick=\"getpopup('produk/detail_list_produk','"+tokens+"','popupedit','"+result[i].kode+"');\" data-placement='top' ><div class='btn btn-info btn-sm fa fa-eye' title='Detail Produk' ></div></a>";
                    var link_kolola_produk          = "href='javascript:void(0)' onclick=\"getpopup('produk/kelola','"+tokens+"','popupedit','"+result[i].kode+"');\"";
                    var link_hapus                  = "<a href='javascript:void(0)' onclick=\"hapus_produk_web('"+result[i].kode+"');\" data-placement='top' ><div class='btn btn-danger btn-sm fa fa-remove' title='Hapus Produk' ></div></a>";
                    var url_upload_gambar           = "href='javascript:void(0)' onclick=\"getcontents('produk/produk_gambar_upload','"+tokens+"','"+result[i].kode+"');\"";
                    var url_upload_gambar_utama     = "href='javascript:void(0)' onclick=\"getpopup('produk/upload_gambar_utama','"+tokens+"','popupedit','"+result[i].kode+"');\"";
                    var setting_nama                = "href='javascript:void(0)' onclick=\"img_input_nama('"+result[i].kode+"','"+result[i].nama+"');\"";
                    var link_update                 = "<a href='javascript:void(0)' onclick=\"getpopup('web_produk/update','"+tokens+"','popupedit','"+result[i].kode+"');\" data-placement='top' ><div class='btn btn-primary btn-sm fa fa-pencil' title='Update Produk'></div></a>";
                    
                    
                    var linkedit  = '<span class="dropdown">'
                                    +'<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary btn-sm dropdown-toggle dropdown-menu-right"><i class="fa fa-cog"></i></button>'
                                        +'<span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">'
                                            +'<a '+url_upload_gambar+' class="dropdown-item"><i class="fa fa-file-image-o"></i> Gambar Detail</a>'
                                            +'<a '+url_upload_gambar_utama+' class="dropdown-item"><i class="fa fa-file-image-o"></i> Gambar Utama</a>'
                                            +'<a '+link_kolola_produk+' class="dropdown-item"><i class="fa fa-edit"></i> Kelola Produk</a>'
                                            +'<a '+setting_nama+' class="dropdown-item"><i class="fa fa-edit"></i> Edit Nama Gambar</a>'
                                        +'</span>'
                                      +'</span>';
                    
                    var gambar;
                    if(result[i].img == null){
                        gambar = '<span style="color:red"><img src="assets/img/noimages.jpg" style="width:100px;height:100px"></span>';
                    }else{
                        gambar = '<div style="width:100%;text-align:left"><img src="uploads/produk/rz_'+result[i].img+'" style="width:100px;height:100px"></div>';
                    }
                    
                    
                    var img_qrcode_produksi  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode_produksi+'</span></div>';
                    var img_qrcode_produk  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode+'</span></div>';
                    
                    var img;
                    if(result[i].img == '' || result[i].img == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].img+'" style="width:80px;height:80px"></div>';
                    }
                    
                    var nama_v;
                    if(result[i].id_vendor == null){
                        nama_v = '-';
                    }else{
                        nama_v = result[i].nama_vendor;
                    }
                    
                    
                    var status_publish;
                    if(result[i].website_publish == 0){
                        status_publish = '<span style="color:red"> Belum Dipublish !</span>';
                    }else{
                        status_publish = '<span style="color:green"> Sudah Dipublish !</span>';
                    }
                    
                    var hargasx;
                    if(result[i].hargas == null){
                        hargasx = '0';
                    }else{
                        hargasx = result[i].hargas;
                    }
                    
                    var stoks;
                    if(result[i].stok == null){
                        stoks = '0';
                    }else{
                        stoks = result[i].stok;
                    }
                    
                    var aktif;
                    //var sts_btn;
                    if(result[i].website_publish == 1){
                        aktif = "<div style='width:100%;font-size:30px;cursor:pointer' onclick=\"actives('"+result[i].website_publish+"','"+result[i].kode+"');\"><i class='fa fa-check' style='color:green'></i></div> <br> <span style='color:green'> Sudah Dipublish !</span>";
                    //    sts_btn = "<a href='javascript:void(0)' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><div class='btn btn-warning btn-sm' title='Nonaktifkan' ><i class='ft-list'></i></div></a>";
                    }else{
                        aktif = "<div style='width:100%;font-size:30px;cursor:pointer' onclick=\"actives('"+result[i].website_publish+"','"+result[i].kode+"');\"><i class='fa fa-refresh' style='color:red'></i></div> <br> <span style='color:red'> Belum Dipublish !</span>";
                    //    sts_btn = "<a href='javascript:void(0)' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Aktifkan' ><i class='ft-list'></i></div></a>";
                    }
                    
                    data.push([no,gambar,result[i].nama,'Rp. ' +hargasx,aktif,'<span class="bg-success pd-y-3 pd-x-10 tx-white tx-11 tx-roboto">'+result[i].nama_kategori+'</span>',link_update,link_hapus]);
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
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
                $('#tabel_produk').show();
            }
        });
    }
    data_produk();
    
    hapus_produk_web = function(kode){
    
        swal({
                    title: "Hapus Produk Dari Web ?",
                    text: "Jika ingin disimpan, silahkan klik button simpan",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Update",
                    //confirmButtonColor: "#E73D4A"
                    confirmButtonColor: "#286090"
                },
                function(){

                    $.ajax({
                        url       : base_url + 'web_produk/hapus',
                        type      : "post",
                        dataType  : 'json',
                        data      : {kode : kode,
                                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                },
                        success: function (response) {
                        if(response == true){  
                                swal.close();
                                Command: toastr["success"]("Nama Gambar berhasil Diupdate", "Berhasil");
                                getcontents('web_produk','<?php echo $tokens;?>');
                        }else{
                            Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                        } 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Command: toastr["error"]("Ajax Error !!", "Error");
                    }

                    });

                //swal("Nice!", "You wrote: " + inputValue, "success");
                });
    
    }
    
    img_input_nama = function(kode,nama){
        
                swal({
                  title: "Update Nama Gambar",
                  text: "Silahkan input nama gambar di bawah ini :",
                  type: "input",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  animation: "slide-from-top",
                  inputPlaceholder: "Update Nama Gambar",
                  inputValue: nama,
                },
                function(inputValue){
                  if (inputValue === false) return false;

                  if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                  }
                  

                  swal({
                    title: "Update Nama Produk ?",
                    text: "Jika ingin disimpan, silahkan klik button simpan",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonText: "Update",
                    //confirmButtonColor: "#E73D4A"
                    confirmButtonColor: "#286090"
                },
                function(){

                    $.ajax({
                        url       : base_url + 'produk/gambar_nama_update',
                        type      : "post",
                        dataType  : 'json',
                        data      : {kode : kode,nama_gambar:inputValue,
                                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                },
                        success: function (response) {
                        if(response == true){  
                                swal.close();
                                Command: toastr["success"]("Nama Gambar berhasil Diupdate", "Berhasil");
                                getcontents('produk','<?php echo $tokens;?>');
                        }else{
                            Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                        } 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Command: toastr["error"]("Ajax Error !!", "Error");
                    }

                    });

                //swal("Nice!", "You wrote: " + inputValue, "success");
                });

                });    
    }
    
    
    function data_select_produk(){
        /* select Kategori */
        $.ajax({
            type: 'POST',
            url: base_url + 'web_produk/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#list_produk').empty();
                var $kategori = $('#list_produk');
                $kategori.append('<option value=0>- Pilih Produk -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].kode + '>'+ data[i].nama + '</option>');
                }
                $('#list_produk').trigger("chosen:updated");
                $("#list_produk").chosen({width: "100%"});
            }
        });
        /* select Kategori */
    }
    data_select_produk();
    
    function data_select_kategori(){
        /* select Kategori */
        $.ajax({
            type: 'POST',
            url: base_url + 'web_produk/data_select_kategori',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#list_kategori').empty();
                var $kategori = $('#list_kategori');
                $kategori.append('<option value=0>- Pilih Kategori -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].id + '>'+ data[i].nama_kategori + '</option>');
                }
                $('#list_kategori').trigger("chosen:updated");
                $("#list_kategori").chosen({width: "100%"});
            }
        });
        /* select Kategori */
    }
    data_select_kategori();
    
    
    $("#btn_publish").click(function(){
        
       $.ajax({
            url       : base_url + 'web_produk/update_publish_keweb',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk  : $('#list_produk').val(),
                        kategori : $("#list_kategori").val(),
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                     },
            success: function (resp) {
                if(resp == true){
                    Command: toastr["success"]("Produk Berhasil di Publish Ke Website", "Oke Berhasil");
                    data_select_produk();
                    data_produk();
                    $('#exampleModal3').modal('hide');
                }else{
                    Command: toastr["error"]("Transaksi Error, data tidak tersimpan !!", "Error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        }); 
    });
    
    
    
    actives = function(id_status,kode){

        var kt_status;
        var idstatus;
        if(id_status == 1){
            kt_status = 'Hide Produk';
            idstatus = 0;
        }else{
            kt_status = 'Show Produk';
            idstatus = 1;
        }


        swal({
            title: ""+kt_status+" ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Submit",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'web_produk/actives',
                type      : "post",
                dataType  : 'json',
                data      : {kode:kode,
                             id_status:idstatus,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){  
                            swal.close();
                            Command: toastr["success"]("Berhasil di "+kt_status+"", "Berhasil");
                            getcontents('web_produk',tokens);
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
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Produk</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-shirt"></i>
        <div>
          <h4>Data Produk</h4>
          <p class="mg-b-0">Halaman data produk.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Produk</h6>
            <p class="br-section-text"><button class="btn btn-primary btn-sm" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal3"><i class="fa fa-plus-circle"></i> Tambah Produk </button></p>
            

            <div class="table-wrapper table-responsive">
            <table id="tabel_produk" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Publish</th>
                                <th>Kategori</th>
                                <th>Update</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
            
        </div>
    </div>


<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">DATA PRODUK</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <label for="demo-vs-definput" class="control-label">Kode / Nama Produk :</label>
            <select class="form-control"  id="list_produk" name="list_produk"></select>
            <label for="demo-vs-definput" class="control-label">Nama Kategori :</label>
            <select class="form-control"  id="list_kategori" name="list_kategori"></select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_publish"><i class="fa fa-refresh"></i> Publish Ke Website</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>
    
    
    
    
    

