<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    loading();
    
    var data_transaksi = function(){
        $('#tabel_transaksi').hide();
        $.ajax({ 
            url: base_url + 'penjualan/transaksi_data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                   
                    var status;
                    if(result[i].status == 1){
                        status = '<span style="color:gray">Proses</span>';
                    }else if(result[i].status == 2){
                        status = '<span style="color:#d408f0">Order (Warehouse)</span>';
                    }else if(result[i].status == 3){
                        status = '<span style="color:#e43109">Barang Sedang Disiapkan (Warehouse)</span>';
                    }else if(result[i].status == 4){
                        status = '<span style="color:#0202d8">Barang Sudah Siap dari (Warehouse)</span>';
                    }else if(result[i].status == 5){
                        status = '<span style="color:blue">Menunggu Pembayaran</span>';
                    }else{
                        status = '<span style="color:green">Selesai</span>';
                    }
                    
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getcontents('penjualan/transaksi_edit','"+tokens+"','"+result[i].no_nota+"');\"><div class='btn btn-info btn-sm' title='Edit Data Transaksi' ><i class='fa fa-pencil'></i></div></a>";    
                    var link_retur = "<a href='javascript:void(0)' onclick=\"getcontents('penjualan/transaksi_retur','"+tokens+"','"+result[i].no_nota+"');\"><div class='btn btn-danger btn-sm' title='Retur Barang' ><i class='fa fa-refresh'></i></div></a>";
                   
                    var namas;
                    if(result[i].nama == null){
                        namas = '<span style="color:green;font-size:10px">Nama Belum dipilih</span>';
                    }else{
                        namas = result[i].nama;
                    }
                   
                    
                    data.push([no,'<span style="color:#04ba93;font-weight:bold">'+result[i].no_nota+'</span><span class="tx-11 d-block"><b>KASIR : '+result[i].kasir+'</b></span>',result[i].tgl_order,result[i].nama_dummy +' / '+namas,result[i].nohp,result[i].nama_jenis_pembayaran,status,'<span style="color:#04ba93;font-weight:bold">'+result[i].nama_outlet+'</span>',link_edit,link_retur]);
                }
                $('#tabel_transaksi').DataTable({
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
                $('#tabel_transaksi').show();
            }
        });
    }
    data_transaksi();
    
    
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Transaksi Penjualan</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-wallet"></i>
        <div>
          <h4>Data Transaksi Penjualan</h4>
          <p class="mg-b-0">Halaman data transaksi penjualan.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Transaksi Penjualan</h6>
            <p class="br-section-text"></p>

            <div class="table-wrapper table-responsive">
            <table id="tabel_transaksi" class="table  table-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Nota</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Pelanggan</th>
                                <th>No HP</th>
                                <th>Jenis Pembayaran</th>
                                <th>Status</th>
                                <th>Outlet</th>
                                <th>Aksi</th>
                                <th>Retur</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
            
        </div>
    </div>



    

