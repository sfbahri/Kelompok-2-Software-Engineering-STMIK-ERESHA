<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    $("#btnLeftMenu").click();
    var data_order_sales = function(){
        $('#tabel_order_sales').hide();
        var baseurl = '<?php echo base_url();?>';
        $.ajax({ 
            url: base_url + 'order_sales/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('order_sales/edit','"+tokens+"','popupedit','"+result[i].noos+"');\"><span class='btn btn-info fa fa-edit btn-sm' title='Edit'></span></a>";
                    var btn_HPS = "<a href='javascript:void(0)' onclick=\"hapuss_order('"+result[i].noos+"');\"><span class='btn btn-danger fa fa-remove btn-sm' title='Hapus'></span></a>";  
                      
                    var link_print_inv = '<a href="'+baseurl+'order_sales/cetak_struk_dotmetrik_unpaid/'+result[i].noos+'" target="_blank"><div class="btn btn-primary btn-sm" title="Print Order Sales" ><i class="fa fa-print"></i></div></a>';
                    
                    var status_bayar;
                    var btn_bayar;
                    if(result[i].bayar == 0){
                        status_bayar = '<span style="color:red"> Belum Bayar </span>';
                        btn_bayar = "<a href='javascript:void(0)' onclick=\"bayar_order('"+result[i].noos+"');\"><span class='btn btn-danger fa fa-money btn-sm' title='Belum Bayar'></span></a>";
                    }else{
                        status_bayar = '<span style="color:green"> Sudah Bayar </span>';
                        btn_bayar = "<span class='btn btn-success fa fa-money btn-sm' title='Sudah Bayar'></span>";
                    }
                    
                    
                    var colors;
                    if(result[i].created_at > result[i].expired_at){
                        colors = 'red';
                    }else{
                        colors = 'green';
                    }
                    
                    var expiredat;
                    if(result[i].expired_at == null){
                        expiredat = '';
                    }else{
                        expiredat = result[i].expired_at;
                    }
                    
                    data.push([no,result[i].noos,result[i].nama_pelanggan,result[i].kategori_status,result[i].nonota,'<span style="color:blue">'+result[i].created_at+'</span>','<span style="color:'+colors+'">'+expiredat+'</span>',result[i].nama_karyawan,status_bayar,'<div style="width:100%;text-align:center">'+link_edit+'</div>',btn_HPS,link_print_inv,btn_bayar]);
        
                }
                $('#tabel_order_sales').DataTable({
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
                $('#tabel_order_sales').show();
            }
        });
    }
    data_order_sales();
    
    
    $("#btn_buat_order_sales").click(function(){
        swal({
            title: "Buat Sales Order ?",
            text: "Jika ingin buat sales order, silahkan klik button ya buat sekarang",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Ya, Buat Sekarang",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){
            var nooss = $("#noos").val();
            $.ajax({
                url       : base_url + 'order_sales/tambah_baru',
                type      : "post",
                dataType  : 'json',
                data      : {noos        : nooss,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Produksi berhasil disimpan", "Berhasil");
                        getpopup('order_sales/tambah','<?php echo $tokens;?>','popupedit',nooss);
                        getcontents('order_sales','<?php echo $tokens;?>');
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
    
    
    hapuss_order = function(no_order_sales){
        swal({
            title: "Hapus Order Sales ?",
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
                url       : base_url + 'order_sales/hapus_order_sales',
                type      : "post",
                dataType  : 'json',
                data      : {no_order_sales      : no_order_sales,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Order Sales berhasil dihapus", "Berhasil");
                        getcontents('order_sales','<?php echo $tokens;?>');
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
    
    
    bayar_order = function(no_order_sales){
        swal({
            title: "Customer Sudah Melakukan Pembayaran ?",
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
                url       : base_url + 'order_sales/bayar_order_sales',
                type      : "post",
                dataType  : 'json',
                data      : {id_order_sales      : no_order_sales,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Perubahan Status Pembayaran Berhasil", "Berhasil");
                        getcontents('order_sales','<?php echo $tokens;?>');
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
    
    <?php 
    $token = "";
    $codeAlphabet = "64842123699851354698461989851";
    $codeAlphabet = "88887712336887987912169848652";
    $codeAlphabet = "32132654654989853242423424222";
    $codeAlphabet.= "01234567890123456789128718983";
    $max = strlen($codeAlphabet) - 1;
    for ($i=0; $i < 2; $i++) {
        $token .= $codeAlphabet[mt_rand(0, $max)];
    } 
    
    
    $token2 = "";
    $codeAlphabet2 = "12387236625362536278276927323";
    $codeAlphabet2 = "12345687989123456798246580000";
    $codeAlphabet2 = "12313213321213254654654654653";
    $codeAlphabet2.= "21323215687965465456532165665";
    $max2 = strlen($codeAlphabet2) - 1;
    for ($i=0; $i < 2; $i++) {
        $token2 .= $codeAlphabet2[mt_rand(0, $max2)];
    }
    
    $token3 = "";
    $codeAlphabet3 = "ABCDEFGH";
    $codeAlphabet3 = "HDGAYTWE";
    $codeAlphabet3 = "SDSCUUOO";
    $codeAlphabet3.= "SDSJDKSH";
    $max3 = strlen($codeAlphabet3) - 1;
    for ($i=0; $i < 1; $i++) {
        $token3 .= $codeAlphabet3[mt_rand(0, $max3)];
    }
    
    $date = date('mdY');
    
    $tokenssss = $token.$token2.$token3.'-'.$date;
    
    ?>


    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Order Sales</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-book"></i>
        <div>
          <h4>Order Sales</h4>
          <p class="mg-b-0">Halaman data Order Sales.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper table-responsive">
            <h6 class="br-section-label">Tabel Data Order Sales</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" id="btn_buat_order_sales"><i class="fa fa-plus-circle"></i> Buat Order Sales </button></p>
            
            <input id="noos" type="hidden" value="<?php echo $tokenssss;?>">
            
            <div class="table-responsive">
            <table id="tabel_order_sales" class="table  display table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NO ORDER SALES</th>
                        <th>NAMA PELANGGAN</th>
                        <th>KATEGORI</th>
                        <th>NO Nota</th>
                        <th>TGL Buat</th>
                        <th>TGL Expired</th>
                        <th>ADMIN</th>
                        <th>Status Bayar</th>
                        <th>AKSI</th>
                        <th>HAPUS</th>
                        <th>INVOICE</th>
                        <th>BAYAR</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>


