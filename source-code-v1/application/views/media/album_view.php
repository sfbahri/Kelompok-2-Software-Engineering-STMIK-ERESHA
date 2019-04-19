<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';

    

    var data_album = function(){
        
        $.ajax({ 
            url: base_url + 'media/get_data_album',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('media/album_edit','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Edit Data Album' ><i class='fa fa-edit'></i></div></a>";
                    var link_hapus = "<a href='javascript:void(0)' onclick=\"gethapus('"+result[i].id+"');\"><div class='btn btn-danger btn-sm' title='Hapus Data Album' ><i class='fa fa-trash'></i></div></a>";
                    var link_foto = "<a href='javascript:void(0)' onclick=\"getpopup('media/album_galeri_list','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-primary btn-sm' title='Lihat Detail Foto' ><i class='fa fa-eye'></i></div></a>";
                    data.push([no,result[i].nama,result[i].tglcreated,link_edit,link_hapus,link_foto]);
                    
                }
                $('#tabel_album').DataTable({
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
                $('#tabel_album').show();
            }
        });
    }
    data_album();
    
    gethapus = function (id_album){
        
            swal({
                title: "Hapus Album ?",
                text: "Silahkan periksa kembali harga yang ingin disimpan.",
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
                url       : base_url + 'media/album_hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_album : id_album, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response){
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Nama Album Terismpan", "Berhasil");
                        data_album();
                        $("#nama_album").val('');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });

            });
       
        
    }
    
    $("#btn_simpan").click(function(){
        
        
        if($("#nama_album").val() == ''){
                Command: toastr["warning"]("Nama Album tidak boleh kosong!", "Info");
            $("#nama_album").focus();
        }else{
            swal({
                title: "Simpan Album ?",
                text: "Silahkan periksa kembali harga yang ingin disimpan.",
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
                url       : base_url + 'media/album_simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama_album : $("#nama_album").val(), <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response){
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Nama Album Terismpan", "Berhasil");
                        data_album();
                        $("#nama_album").val('');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });

            });
        }
        
    });
    
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Album Foto</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-md-images"></i>
        <div>
            <h4>Album Foto</h4>
            <p class="mg-b-0">Halaman data album foto.</p>
        </div>
        <div class="">
                
        </div>
    </div>
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="row">
            <div class="col-md-4">
                
                <div class="row">
                    <div class="col-md-12">
                    <div class="card">
                    <div class="card-header tx-medium bd-0 tx-white bg-info">Album Foto</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="row" style="margin:5px">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="demo-vs-definput" class="control-label">Nama / Judul Album</label>
                                <input type="text" id="nama_album" name="nama_album" class="form-control">
                            </div>
                            <hr>
                            <button type="button" class="btn btn-info btn-min-width mr-1 mb-1" id="btn_simpan"><i class="ft-save"></i> Simpan </button>
                            </div> 
                        </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                
            </div>
            
            
            <div class="col-md-8">
                <div class="card">
                <div class="card-header tx-medium bd-0 tx-white bg-info">Data Album</div>
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_album" class="table table-striped table-bordered table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Album</th>
                                    <th>Tgl Created</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                    <th>Foto</th>
                                </tr>
                                </thead>
                            </table> 
                    
                    
                </div>
                </div>
                </div>
            </div>
            </div>
            
        </div>