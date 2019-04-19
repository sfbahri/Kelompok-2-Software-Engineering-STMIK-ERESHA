<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_produksi').hide();
        $.ajax({ 
            url: base_url + 'kas/kas_data_kategori',
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

                    var url_detail = "href='javascript:void(0)' onclick=\"getpopup('kas/kas_kategori_update_saldo','"+tokens+"','popupedit','"+result[i].id+"');\"";
                    var url_detail2 = "href='javascript:void(0)' onclick=\"getpopup('kas/kas_transaksi_hari_ini','"+tokens+"','popupedit','"+result[i].id+"');\"";
                   // var url_hapus = "href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"";
     
                    var linkedit  = '<span class="dropdown">'
                                    +'<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="fa fa-cogs"></i></button>'
                                        +'<span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">'
                                          +'<a '+url_detail+'  class="dropdown-item" style="cursor:pointer"><i class="fa fa-money"></i> Tambah Saldo</a>'
                                          +'<a '+url_detail2+'  class="dropdown-item" style="cursor:pointer"><i class="fa fa-eye"></i> Lihat Transaksi Hari Ini</a>'
                                          //+'<a '+url_hapus+' class="dropdown-item"><i class="fa fa-trash"></i> Hapus</a>'
                                        +'</span>'
                                      +'</span>';
                    
                    data.push([no,result[i].id,result[i].nama,result[i].saldoawal,result[i].saldoakhir,result[i].tgl_transfer_saldo,linkedit]);
                    //progress
                }
                $('#tabel_produksi').DataTable({
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
                $('#tabel_produksi').show();
            }
        });
    }
    data_produksi();
    
    
    $('#tanggal').datepicker();
    
    hapus = function(kode_produksi){
        swal({
            title: "Hapus Produksi No : "+kode_produksi+" ?",
            text: "Jika ingin disimpan, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
        },
        function(){

            $.ajax({
                url       : base_url + 'produksi/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {kode_produksi : kode_produksi,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Produksi berhasil dihapus", "Berhasil");
                        getcontents('produksi','<?php echo $tokens;?>');
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
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Ke Data Produksi ?",
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
                url       : base_url + 'produksi/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama        : $("#nama").val(),
                            kode         : $("#kode").val(),
                            tanggal      : $("#tanggal").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Produksi berhasil disimpan", "Berhasil");
                        getcontents('produksi','<?php echo $tokens;?>');
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
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
          <span class="breadcrumb-item active">Data Kas Kategori</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-bookmarks"></i>
        <div>
          <h4>Kas Kategori</h4>
          <p class="mg-b-0">Halaman data kas kategori.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Kas Kategori</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('kas/kas_kategori_tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Kas Kategori </button> </p>
            
            
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_produksi" class="table  display nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Kas</th>
                        <th>Nama Kas</th>
                        <th>Saldo Awal</th>
                        <th>Saldo Akhir</th>
                        <th>Tgl Transfer Saldo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>

