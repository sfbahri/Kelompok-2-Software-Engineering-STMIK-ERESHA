<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    loading();

    var data_testimoni = function(){
        $('#tabel_testimoni').hide();
        $.ajax({ 
            url: base_url + 'testimoni/data',
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
                    
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('testimoni/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info btn-sm fa fa-edit' title='Edit Aksesoris'></span></a>";
                 
                    data.push([no,result[i].nama,result[i].perusahaan,result[i].jabatan,result[i].created_at,'<div style="width:100%;text-align:center">'+link_edit+'</div>']);
                }
                $('#tabel_testimoni').DataTable({
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
                $('#tabel_testimoni').show();
            }
        });
    }
    data_testimoni();
    
   
   
    hapus = function(id_produk){
        swal({
            title: "Hapus Testimoni ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Simpan",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'testimoni/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_produk:id_produk,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Testimoni berhasil dihapus", "Berhasil");
                        data_testimoni();
                }else{
                    Command: toastr["error"]("Hapus error, data tidak berhasil dihapus", "Error");
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
          <span class="breadcrumb-item active">Data Testimoni</span>
        </nav>
    </div>

    <div class="br-pagetitle">
        <i class="icon icon ion-ios-chatboxes"></i>
        <div>
          <h4>Testimoni</h4>
          <p class="mg-b-0">Halaman Data Testimoni</p>
        </div>
        <div class="">  </div>
    </div>

    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Testimoni</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('testimoni/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Testimoni </button></p>
            
            
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_testimoni" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Perusahaan</th>
                        <th>Jabatan</th>
                        <th>Tgl Posting</th>
                        <th>Edit</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>



    