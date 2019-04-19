<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_karyawan = function(){
        $('#table_karyawan').hide();
        $.ajax({ 
            url: base_url + 'karyawan/karyawan_data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                 
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('karyawan/karyawan_edit','"+tokens+"','popupedit','"+result[i].nik+"');\"><div class='btn btn-info btn-sm' title='Edit Data Karyawan' ><i class='fa fa-edit'></i></div></a>";    
                   
                    data.push(['<b>'+result[i].nik+'</b>',result[i].nama,result[i].inisial,result[i].tempat_lahir,result[i].tgl_lahir,result[i].email,result[i].no_hp,link_edit]);
                   
                }
                $('#table_karyawan').DataTable({
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
                $('#table_karyawan').show();
            }
        });
    }
    data_karyawan();
    
    
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Karyawan</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-people"></i>
        <div>
          <h4>Karyawan</h4>
          <p class="mg-b-0">Halaman data karyawan.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Karyawan</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('karyawan/karyawan_tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Karyawan </button></p>

            <div class="table-wrapper table-responsive">
            <table id="table_karyawan" class="table  display nowrap">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Inisial</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>
        <!-- end content -->


    

