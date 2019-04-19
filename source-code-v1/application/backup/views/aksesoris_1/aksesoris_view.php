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
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('aksesoris/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><span class='btn btn-info btn-icon ft-edit' title='Edit Aksesoris'></span></a>";
                    
                    var gambar = '<div style="width:100%;text-align:center"><img src="uploads/aksesoris/rz_'+result[i].gambar+'" style="width:100px;height:120px"></div>';
                    data.push([no,result[i].nama,'<span class="label label-purple">'+result[i].stok_awal+' '+satuan+'</span>',result[i].hargas,gambar,result[i].tgl,'<div style="width:100%;text-align:center">'+link_edit+'</div>']);
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
    
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Aksesoris</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Master Produksi</a></li>
                        <li class="breadcrumb-item active">Data Aksesoris</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn btn-info round dropdown-menu-right box-shadow-2 px-2" onclick="getpopup('aksesoris/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="ft-plus-circle icon-left"></i> Tambah Aksesoris</div>
            </div>
        </div>
    </div>


    <section id="initialization">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Data Aksesoris</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
<!--                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                  </div>-->
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">

                    <table id="tabel_bahan_baku" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Aksesoris</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th style="width: 80px">Gambar</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                   
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>


