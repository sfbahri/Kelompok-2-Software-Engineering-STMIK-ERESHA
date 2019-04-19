<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_warna = function(){
        $('#table_warna').hide();
        $.ajax({ 
            url: base_url + 'warna/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('warna/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info fa fa-edit' title='Edit Warna'></span></a>";
                    data.push([no,result[i].inisial,result[i].nama,'<div style="width:100%;text-align:center">'+link_edit+'</div>']);
        
                }
                $('#table_warna').DataTable({
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
                $('#table_warna').show();
            }
        });
    }
    data_warna();
    
   
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Warna</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-color-palette"></i>
        <div>
          <h4>Warna</h4>
          <p class="mg-b-0">Halaman data Warna.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Warna</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('warna/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Warna </button></p>
            
            
            
            <div class="table-wrapper table-responsive">
            <table id="table_warna" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Inisial</th>
                        <th>Nama Warna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>


