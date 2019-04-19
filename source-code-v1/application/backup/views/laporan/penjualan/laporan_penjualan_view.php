<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    loading();
    
    var data_transaksi = function(){
        $('#tabel_transaksi').hide();
        
        var outlet = $("#outlet").val();
        var tanggal = $("#tanggal").val();
        
        $.ajax({ 
            url: base_url + 'laporan/penjualan_data',
            type: "post",
            data:{outlet:outlet,tanggal:tanggal,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                   
                    var nama_pembeli;
                    if(result[i].nama == '- Pilih Nama Pelanggan -'){
                        nama_pembeli = '';
                    }else{
                        nama_pembeli = '<span style="color:gray">'+result[i].nama+'</span>';
                    }
                    
                    var namas;
                    if(result[i].nama == null){
                        namas = '<span style="color:green;font-size:10px">Nama Belum dipilih</span>';
                    }else{
                        namas = result[i].nama;
                    }
                    //result[i].id_jenis_pembayaran
                    data.push([no,'<span style="color:#04ba93;">'+result[i].no_nota+'</span><span class="tx-11 d-block"><b>Adm : '+result[i].nama_karyawan+' / Outlet : '+result[i].nama_outlet+'</b></span>',result[i].nama_dummy +' / '+nama_pembeli,result[i].nama_jenis_pembayaran,result[i].tgl_order,'<span style="color:#0040ff;float:left">Rp. </span> <span style="color:#0040ff;float:right;">'+result[i].total+'</span>']);
                }
                $('#tabel_transaksi').DataTable({
                    //"bJQueryUI"     : true,
                    
                    data                : data,
                    deferRender         : true,
                    processing          : true,
                    ordering            : false,
                    retrieve            : false,
                    paging              : false,
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
//                    "drawCallback": function ( row, data, index ) {
//                        var api = this.api();
//                        var rows = api.rows( {page:'current'} ).nodes();
//                        var last=null;
//
//                        api.column(0, {page:'current'} ).data().each( function ( group, i ) {
//                            if ( last !== group ) {
//                                $(rows).eq( i ).before(
//                                    '<tr class="group"><td colspan="7">'+group+'</td></tr>'
//                                );
//                                last = group;
//                            }
//                        } );
//                    }
                });
               
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
                $('#tabel_transaksi').show();
            }
        });
    }
    data_transaksi();
    
    
    
    var data_transaksi_total = function(){

        var outlet = $("#outlet").val();
        var tanggal = $("#tanggal").val();

        $.ajax({ 
            url: base_url + 'laporan/penjualan_data_total',
            type: "post",
            data:{outlet:outlet,tanggal:tanggal,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
               $("#total").text(result.total);
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
            }
        });
    }
    data_transaksi_total();
    
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
                $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + ' </option>');
            }
            
            $("#outlet").chosen({width: "100%"});
        }
    });
    
    $('#tanggal').datepicker();
   
    $("#btn_tampilkan").click(function(){
        data_transaksi_total();
        data_transaksi();
        $("#tablesss").show();
    });
    
    $("#btn_download_pdf").click(function(){
        
        var outlet = $("#outlet").val();
        var tanggal = $("#tanggal").val();
        
        var url = '<?php echo base_url('laporan/penjualan_data_pdf');?>';
        newwindow=window.open(url+'/'+outlet+'/'+tanggal,'Laporan','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Laporan Penjualan</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-bookmarks"></i>
        <div>
          <h4>Laporan Penjualan</h4>
          <p class="mg-b-0">Halaman data laporan penjualan.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Laporan Data Penjualan</h6>
            <p class="br-section-text">
            <div class="col-md-3" style="padding:0px">
                    <small>Outlet / Lokasi</small>
                    <select id="outlet" name="outlet" class="form-control"></select>
                    <small>Tanggal</small>
                    <input type="text" id="tanggal" name="tanggal" class="form-control"/>
                    <br>
                    <button id="btn_tampilkan" class="btn btn-block btn-info"> <i class="fa fa-search"></i> Tampilkan </button> 
                    <hr>
                    <button id="btn_download_pdf" class="btn btn-danger btn-info btn-block"> Download PDF </button>
                </div>
            </p>
            
            
            
            <div class="table-wrapper table-responsive" style="display:none" id="tablesss">
                
                
                
                <table id="tabel_transaksi" class="table  table-responsive table-striped" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Nota</th>
                        <th>Nama Pelanggan</th>
                        <th>Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                    
                </thead>
            </table>  
           <div class="alert alert-success" role="alert">
                <div class="d-flex align-items-center justify-content-start" style="font-size:15px;float:right">
                  <i class="icon ion-ios-wallet alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                  <span><strong>Total : Rp. <span id="total"></span></strong> 
                </div><!-- d-flex -->
                <br>
                <br>
            </div>
            </div>
            
        </div>
    </div>


