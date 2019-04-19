<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
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
                    var baseurl = '<?php echo base_url();?>';
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getcontents('gudang/input_transaksi','"+tokens+"','"+result[i].no_nota+"');\"><div class='btn btn-info btn-sm' title='Edit Data Transaksi' ><i class='fa fa-pencil'></i></div></a>";    
                    var link_print = '<a href="'+baseurl+'gudang/cetak_resi_pdf/'+result[i].no_nota+'" target="_blank"><div class="btn btn-primary btn-sm" title="Print Resi Keluar" ><i class="fa fa-print"></i></div></a>';
//                    var select_status = '<select style="width:90%" class="form-control" onchange=loadUbahStatus("'+result[i].status+'","ipul")>'
//                        select_status +='<option value=0>- Pilih -</option>'
//                        select_status +='<option value=3>- Barang Sedang Disiapkan -</option>'
//                        select_status +='<option value=4>- Barang Sudah Siap -</option>'
//                        select_status +='</select>';
//                    
                    
                    data.push([no,'<span style="color:#04ba93;font-weight:bold">'+result[i].no_nota+'</span><span class="tx-11 d-block"><b>KASIR : '+result[i].kasir+'</b></span>',result[i].tgl_order,result[i].nama,result[i].nohp,status,'<span style="color:#04ba93;font-weight:bold">'+result[i].nama_outlet+'</span>',link_edit,link_print]);
                }
                
                loadUbahStatus = function(id,value){
                    alert(id)
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

            },
            complete: function () {
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
          <span class="breadcrumb-item active">Data der Transaksi</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-cart"></i>
        <div>
          <h4>Warehouse (Data Order Transaksi)</h4>
          <p class="mg-b-0">Halaman data order transaksi.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Order Transaksi</h6>
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
                                <th>Status</th>
                                <th>Outlet</th>
                                <th>Aksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
            
        </div>
    </div>



    

