<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_module = function(){
        $('#tabel_module').hide();
        $.ajax({ 
            url: base_url + 'module/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit; 
                    if(result[i].position == 1 && result[i].have_child == 'Y'){
                        link_edit  = "<a href='javascript:void(0)' onclick=\"getpopup('module/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-success btn-sm fa fa-plus' title='Tambah Modul Sub'></span></a>";
                    }else{
                        link_edit  = "";
                    }
                    
                    var link_edit_2  = "<a href='javascript:void(0)' onclick=\"getpopup('module/edit2','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info btn-sm fa fa-pencil' title='Edit Modul'></span></a>";
                    
                    var link_hapus = "<a href='javascript:void(0)' onclick=hapus_module("+result[i].id+")><span class='btn btn-danger btn-sm fa fa-trash' title='Hapus Modul'></span></a>";
                    
                    var position;
                    if(result[i].position == 1){
                        position = '<span style="color:#923535">Menu Utama</span>';
                    }else{
                        position = '<span style="color:#42c697">Menu Sub</span>';
                    }
    
                    data.push([no,result[i].id,result[i].name,result[i].icon,result[i].controller,position,result[i].have_child,result[i].parent,result[i].sequence,link_edit,link_edit_2,link_hapus]);
        
                }
                $('#tabel_module').DataTable({
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
                $('#tabel_module').show();
            }
        });
    }
    data_module();
    
   
    hapus_module = function(id){
        
        swal({
            title: "Hapus Modul ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
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
                url       : base_url + 'module/module_sub_hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_module_sub           : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){ 
                        swal.close();
                        Command: toastr["success"]("Module berhasil dihapus", "Berhasil");
                        data_module();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
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
          <span class="breadcrumb-item active">Data Module</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-arrow-dropdown"></i>
        <div>
          <h4>Module</h4>
          <p class="mg-b-0">Halaman data module.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Modul</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('module/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Modul </button></p>

            <div class="table-wrapper table-responsive">
            <table id="tabel_module" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Modul</th>
                        <th>Nama Modul</th>
                        <th>Icon</th>
                        <th>Controller</th>
                        <th>Position</th>
                        <th>Have Child</th>
                        <th>Parent</th>
                        <th>Sequence</th>
                        <th>#</th>
                        <th>#</th>
                        <th>#</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>




    
    

