<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'aksesoris/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var satuan;
                    if(result[i].satuan == 1){
                        satuan = 'Pcs';
                    }else{
                        satuan = 'Kg';
                    }
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('aksesoris/finance_edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info fa fa-edit' title='Edit Aksesoris'></span></a>";
                    
                    var gambar = '<div style="width:100%;text-align:center"><img src="uploads/aksesoris/rz_'+result[i].gambar+'" style="width:100px;height:100px"></div>';
                    data.push([no,result[i].nama,'<span class="label label-purple">'+result[i].stok_awal+' '+satuan+'</span>','<span class="label label-purple">'+result[i].stok_akhir+' '+satuan+'</span>',result[i].hargas,gambar,result[i].tgl,'<div style="width:100%;text-align:center">'+link_edit+'</div>']);
                }
                $('#tabel_bahan_baku').DataTable({
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
    
   
   
    hapus = function(id_produk){
        swal({
            title: "Hapus Produk ?",
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
                url       : base_url + 'produk/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_produk:id_produk,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Produk berhasil dihapus", "Berhasil");
                        data_produk();
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
          <span class="breadcrumb-item active">Data Aksesoris</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-ribbon"></i>
        <div>
          <h4>Aksesoris</h4>
          <p class="mg-b-0">Halaman data Aksesoris.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Aksesoris</h6>
            <p class="br-section-text"></p>
            
            
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_bahan_baku" class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aksesoris</th>
                        <th>Stok Awal</th>
                        <th>Stok Akhir (Sisa)</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>
