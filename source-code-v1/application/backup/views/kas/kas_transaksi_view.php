<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    $("#tgl_start").focus();
    var data_kas_transaksi = function(){
        $("#tbl_list_transaksi").show();
        $('#tabel_produksi').hide();

        
        $.ajax({ 
            url: base_url + 'kas/get_data_kas_transaksi',
            type: "post",
            data:{tgl_start:$("#tgl_start").val(),tgl_end:$("#tgl_end").val(),<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var baseurl = '<?php echo base_url();?>';

                    var url_detail = "href='javascript:void(0)' onclick=\"getpopup('kas/kas_kategori_update_saldo','"+tokens+"','popupedit','"+result[i].id+"');\"";
                   // var url_hapus = "href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"";
     
                    var linkedit  = '<span class="dropdown">'
                                    +'<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="fa fa-cogs"></i></button>'
                                        +'<span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">'
                                          +'<a '+url_detail+'  class="dropdown-item" style="cursor:pointer"><i class="fa fa-money"></i> Tambah Saldo</a>'
                                          //+'<a '+url_hapus+' class="dropdown-item"><i class="fa fa-trash"></i> Hapus</a>'
                                        +'</span>'
                                      +'</span>';
                    
                    data.push([no,result[i].id,result[i].nama,result[i].saldoawal,result[i].saldoakhir,result[i].tgl_transfer_saldo,linkedit]);
                    //progress
                }
                $('#tabel_produksi').DataTable({
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
                $('#tabel_produksi').show();
            }
        });
    }
    //data_kas_transaksi();
    
    
    $("#btn_tampilkan").click(function(){
        data_kas_transaksi();
    });
    
    
    $("#tgl_start,#tgl_end").datepicker();
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Kas Transaksi</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-md-wallet"></i>
        <div>
          <h4>Kas Transaksi</h4>
          <p class="mg-b-0">Halaman data kas transaksi.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label"></h6>
            <p class="br-section-text">
            <div class="row">
                <div class="col-md-2">
                    <label>Tanggal Awal</label>
                    <input type="text" id="tgl_start" class="form-control" >
                </div> 
                <span style="margin-top:40px">s.d</span>
                <div class="col-md-2">
                    <label>Tanggal Akhir</label>
                    <input type="text" id="tgl_end" class="form-control" >
                </div>
                <div class="col-md-2">
                    <div style="margin-top:28px"></div>
                    <button class="btn btn-info" id="tampilkan"><i class="fa fa-search"></i> Tampilkan </button>
                </div>
            </div>
             
            <hr>
            
            <div class="table-wrapper table-responsive" id="tbl_list_transaksi" style="display:none">
            <table id="tabel_produksi" class="table  display nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Kas</th>
                        <th>Nama Kas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Tgl Transfer Saldo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>

