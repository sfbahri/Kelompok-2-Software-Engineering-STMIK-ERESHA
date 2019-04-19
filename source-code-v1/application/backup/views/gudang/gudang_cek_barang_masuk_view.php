<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'gudang/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                    var gambar = '<img src='+result[i].path+' style="width:300px;height:300px">';
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('gudang/cek_barang_masuk_detail','"+tokens+"','popupedit','"+result[i].kode+"');\"><div class='btn btn-info' title='Detail Barang Kode : "+result[i].kode+" ' ><i class='fa fa-eye'></i></div></a>";
                    
                    var btn_aksi;
                    if(result[i].status_produksi == 5){
                        btn_aksi = '<div style="width:100%;text-align:center">'+link_edit+'</div>';
                    }else{
                        btn_aksi = '<div style="width:100%;text-align:center"><i class="fa fa-refresh fa-spin"></i></div>';
                    }
                    
                    var status_cek_gudang;
                    if(result[i].gudang_in == 1){
                        status_cek_gudang = '<div style="width:100%;text-align:center"><i class="fa fa-check" style="color:green"> Sudah dicek gudang</i></div>';
                    }else{
                        status_cek_gudang = '<div style="width:100%;text-align:center"><i class="fa fa-remove" style="color:red"> Belum dicek gudang</i></div>';
                    }
                    
                    
                   
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:50px;height:50px"> <br> '+result[i].kode+'</div>';
                   
                   
                    data.push([img_qrcode,result[i].nama,result[i].tgl_mulai,result[i].jumlah,status_cek_gudang,result[i].cek_gudang_tanggal,btn_aksi]);
                   
                }
                $('#tabel_sablon').DataTable({
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
                $('#tabel_sablon').show();
            }
        });
    }
    data_produksi();
    
    
    $('#tanggal').datepicker();
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Ke Data Produksi ?",
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
                url       : base_url + 'produksi/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama        : $("#nama").val(),
                            kode         : $("#kode").val(),
                            tanggal      : $("#tanggal").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Produksi berhasil disimpan", "Berhasil");
                        getcontents('produksi','<?php echo $tokens;?>');
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
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Warehouse (Cek Barang Masuk)</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-keypad"></i>
        <div>
          <h4>Warehouse (Cek Barang Masuk)</h4>
          <p class="mg-b-0">Halaman Cek Barang Masuk.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_sablon" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Kode Produksi</th>
                    <th>Nama Produksi</th>
                    <th>Tgl Mulai Produksi</th>
                    <th>Jumlah PCS</th>
                    <th>Cek Gudang Status</th>
                    <th>Cek Gudang Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            </table> 
            </table> 
            </div>
            
        </div>
    </div>


<!--
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Cek Barang Masuk</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Cek Barang Masuk</a></li>
                        <li class="breadcrumb-item active">Data Barang Produksi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section id="initialization">
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Data Barang Produksi</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_sablon" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Qrcode Produk</th>
                                    <th>Total Stok Awal Barang</th>
                                    <th>Total Ril Barang</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            </table> 
                    
                    
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>-->






    

