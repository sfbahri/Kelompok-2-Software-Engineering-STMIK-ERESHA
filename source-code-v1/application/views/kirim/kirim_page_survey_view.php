<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_berita = function(){
        $('#tabel_berita').hide();
        $.ajax({ 
            url: base_url + 'kirim/survey_data',
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
                    
                    
                    data.push([no,result[i].nama,result[i].judul,result[i].email,result[i].nohp,result[i].catatan]);
                }
                $('#tabel_berita').DataTable({
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
                $('#tabel_berita').show();
            }
        });
    }
    data_berita();
    
   
    
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Booking Online</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-clipboard"></i>
        <div>
          <h4>Booking Online</h4>
          <p class="mg-b-0">Halaman data booking online </p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
     
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Booking Online</h6>
           
            <div class="table-wrapper table-responsive">
            <table id="tabel_berita" class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>Layanan</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Pesan</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>
