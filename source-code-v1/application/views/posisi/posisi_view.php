<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_posisi = function(){
        
        $.ajax({ 
            url: base_url + 'posisi/data',
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
                    
                     var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('posisi/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Akses' ><i class='fa fa-pencil'></i></div></a>";    
                    
                    data.push([no,result[i].nama_posisi,link_edit]);

                }
                $('#table_posisi').DataTable({
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
                $('#table_posisi').show();
            }
        });
    }
    data_posisi();
    
    
    $("#btn_simpan").click(function(){
        
        swal({
            title: "Simpan data posisi ?",
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
                url       : base_url + 'posisi/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama : $("#nama").val(), <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Data Posisi Berhasil disimpan", "Berhasil");
                        data_posisi();
                        $("#nama").val('');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
            
        });
        
    });
    
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Posisi</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-md-wallet"></i>
        <div>
          <h4>Data Posisi</h4>
          <p class="mg-b-0">Halaman data posisi.</p>
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
                    <div class="card-header tx-medium bd-0 tx-white bg-info">Form Posisi</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="row" style="margin:5px">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="demo-vs-definput" class="control-label">Nama Posisi</label>
                                <input type="text" id="nama" name="nama" class="form-control">
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
                <div class="card-header tx-medium bd-0 tx-white bg-info">Data Posisi</div>
                <div class="card-body card-dashboard">
                    
                    <table id="table_posisi" class="table table-striped table-bordered table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 2%">No</th>
                                    <th style="width: 20%">Nama Posisi</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                                </thead>
                            </table> 
                    
                </div>
                </div>
                </div>
            </div>
            </div>
            
        </div>