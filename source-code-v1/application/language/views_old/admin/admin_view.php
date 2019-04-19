<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_admin = function(){
        $('#tabel_admin').hide();
        $.ajax({ 
            url: base_url + 'admin/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var link_edit = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"getpopup('kloter/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Akses' ><i class='fa fa-pencil'></i></div></a></div>";    
                    var link_hapus = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"><div class='btn btn-danger btn-sm' title='Hapus' ><i class='fa fa-trash'></i></div></a></div>";
                    
                    data.push([no,result[i].nama,result[i].email,result[i].no_telp,link_edit,link_hapus]);

                }
                $('#tabel_admin').DataTable({
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
                $('#tabel_admin').show();
            }
        });
    }
    data_admin();
    
    hapus = function(id_kloter){
    
        swal({
            title: "Hapus ?",
            text: "Yakin hapus kloter ini ? jika ya silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
            //confirmButtonColor: "#286090"
        },
        function(){
            
            $.ajax({
                url       : base_url + 'kloter/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_kloter : id_kloter, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Admin berhasil dihapus", "Berhasil");
                        data_admin();
                    }else{
                        Command: toastr["error"]("Data Tidak Tersimpan !", "Error");
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
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Admin</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-contacts"></i>
        <div>
          <h4>Data Admin</h4>
          <p class="mg-b-0">Halaman data admin.</p>
        </div>
    </div>
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            
            <h6 class="br-section-label">Tabel Data Admin</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('admin/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Admin </button></p>
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_admin" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Admin</th>
                        <th>No Hp</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>