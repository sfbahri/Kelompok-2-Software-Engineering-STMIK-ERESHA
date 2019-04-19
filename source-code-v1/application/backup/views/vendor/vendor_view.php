<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'vendor/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('vendor/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info fa fa-edit' title='Edit Vendor'></span></a>";
                    data.push([no,result[i].nama,result[i].no_telp,result[i].email,result[i].alamat,'<div style="width:100%;text-align:center">'+link_edit+'</div>']);
        
                }
                $('#tabel_vendor').DataTable({
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
                $('#tabel_produk').show();
            }
        });
    }
    data_produk();
    
   
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Vendor</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-ribbon"></i>
        <div>
          <h4>Vendor</h4>
          <p class="mg-b-0">Halaman data Vendor.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Vendor</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('vendor/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Vendor </button></p>
            
            
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_vendor" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>


