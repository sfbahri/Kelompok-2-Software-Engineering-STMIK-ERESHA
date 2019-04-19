<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_gambar_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'markom/design_gambar_data_so',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                     var link_lihat_gambar = "<a href='javascript:void(0)' onclick=\"getcontents('markom/design_gambar_produksi_upload_kp','"+tokens+"','"+result[i].noso+"');\"><div class='btn btn-info btn-sm' title='Lihat Data Gambar' ><i class='fa fa-file-image-o'></i></div></a>";
                   
                    data.push([no,result[i].noso,result[i].nama,link_lihat_gambar]);
                   
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
    data_gambar_produksi();
    
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Gambar Produksi</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-analytics"></i>
        <div>
          <h4>Draft Gambar Produksi</h4>
          <p class="mg-b-0">Halaman data gambar produksi.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Gambar By NO. SO</h6>
            <p class="br-section-text"></p>

            <div class="table-wrapper table-responsive">
            <table id="tabel_sablon" class="table  display nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori Gambar (By NO. SO)</th>
                        <th>Nama Tema</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>
        <!-- end content -->


    

