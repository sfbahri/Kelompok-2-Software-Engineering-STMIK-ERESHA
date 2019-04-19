<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_produksi').hide();
        $.ajax({ 
            url: base_url + 'produksi/data',
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
                    var link_hapus   = "<a href='javascript:void(0)' onclick=\"hapus('"+result[i].kode+"');\" data-placement='top' data-toggle='tooltip' data-original-title='Tooltip on top'><div class='btn btn-outline-danger btn-sm btn-icon fa fa-trash' title='Hapus Produksi' ></div></a>";
                    var link_detail  = "<a href='javascript:void(0)' onclick=\"getpopup('produksi/detail','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\" data-placement='top' ><div class='btn btn-outline-info btn-sm btn-icon fa fa-eye' title='Detail Produksi' ></div></a>";
                    var link_print  = "<a href='"+baseurl+"produksi/print_label/"+result[i].kode+"' data-placement='top' target='_blank' ><div class='btn btn-outline-primary btn-sm btn-icon la la-print' title='Print Label' ></div></a>";
                    
                    var url_detail = "href='javascript:void(0)' onclick=\"getpopup('produksi/detail','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\"";
                    var url_hapus = "href='javascript:void(0)' onclick=\"hapus('"+result[i].kode+"');\"";
                    var url_print = 'href="'+baseurl+'produksi/print_label/'+result[i].kode+'" target="_blank"';
                    var url_rinci = "href='javascript:void(0)' onclick=\"getpopup('produksi/rinci','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\"";
                    var linkedit  = '<span class="dropdown">'
                                    +'<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="fa fa-cog"></i></button>'
                                        +'<span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">'
                                          +'<a '+url_detail+'  class="dropdown-item"><i class="fa fa-refresh"></i> Lihat Proses Produksi</a>'
//                                          +'<a '+url_hapus+' class="dropdown-item"><i class="la la-trash danger"></i> Hapus</a>'
                                          +'<a '+url_print+' class="dropdown-item"><i class="fa fa-print primary"></i> Print Label</a>'
                                          +'<a '+url_rinci+'  class="dropdown-item"><i class="fa fa-refresh"></i> Ditail Produksi</a>'
                                        +'</span>'
                                      +'</span>';
                    
                    //var link_edit   = "<a href='javascript:void(0)' onclick=\"getpopup('produksi/detail','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].publish+"');\" data-placement='top' data-toggle='tooltip' data-original-title='Tooltip on top'><div class='btn btn-info btn-sm btn-icon la la-list add-tooltip' title='Lihat Produksi Gambar' ></div></a>";
//                    var link_edit = '<span class="dropdown">'
//                                    +'<button id="btnSearchDrop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-info btn-sm dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>'
//                                        +'<span aria-labelledby="btnSearchDrop2" class="dropdown-menu mt-1 dropdown-menu-right">'
//                                          +'<a href="#" class="dropdown-item"><i class="ft-edit-2"></i> Edit</a>'
//                                          +"<a href='javascript:void(0)' onclick=hapus('"+result[i].kode+"') class='dropdown-item'><i class='ft-trash danger'></i> Hapus</a>"
//                                          +"<a href='javascript:void(0)' onclick=\"getpopup('produksi/detail','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\" class='dropdown-item'><i class='ft-eye primary'></i> Detail Produksi</a>"
//                                            +"<a href='javascript:void(0)' onclick=\"getpopup('produksi/input_harga','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\" class='dropdown-item'><i class='ft-edit primary'></i> Input Harga</a>"
//                                          +'<a href="#" class="dropdown-item"><i class="ft-plus-circle info"></i> Sablon</a>'
//                                          +'<a href="#" class="dropdown-item"><i class="ft-plus-circle warning"></i> Aksesoris</a>'
//                                          +'<a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Sewing</a>'
//                                          +'<a href="#" class="dropdown-item"><i class="ft-plus-circle success"></i> Finishing</a>'
//                                        +'</span>'
//                                      +'</span>';
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:60px;height:60px"><br> <span style="font-size:12px">'+result[i].kode+'</span></div>';
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produksi/'+result[i].gambar+'" style="width:80px;height:80px"></div>';
                    }
                    
                    
                    //var progress = '<div class="progress progress-sm"><div aria-valuemin="82" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:82%" aria-valuenow="82"></div></div>';
                    
                    var progress;
                    if(result[i].status == 1){
                        progress = '<div class="progress progress-sm"><div aria-valuemin="20" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:20%" aria-valuenow="20"></div></div>';
                    }else if(result[i].status == 2){
                        progress = '<div class="progress progress-sm"><div aria-valuemin="40" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:40%" aria-valuenow="40"></div></div>';
                    }else if(result[i].status == 3){
                        progress = '<div class="progress progress-sm"><div aria-valuemin="60" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:60%" aria-valuenow="60"></div></div>';
                    }else if(result[i].status == 4){
                        progress = '<div class="progress progress-sm"><div aria-valuemin="82" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:80%" aria-valuenow="80"></div></div>';
                    }else if(result[i].status == 5){
                        progress = '<div class="progress progress-sm"><div aria-valuemin="100" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:100%" aria-valuenow="100"></div></div>';
                    }else{
                        progress = '<div class="progress progress-sm"><div aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-gradient-x-success" role="progressbar" style="width:0%" aria-valuenow="0"></div></div>';
                    }
                    
                    
                    
                    
                    var status;
                    if(result[i].status == 1){
                        status = '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-primary"><i class="fa fa-spinner fa-spin"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Finishing </span>';
                    }else if(result[i].status == 2){
                       status = '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-primary"><i class="fa fa-spinner fa-spin"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Finishing </span>';
                    }else if(result[i].status == 3){
                        status = '<span class="badge badge-default badge-success"><i class="fa fa-check "></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-primary"><i class="fa fa-spinner fa-spin"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Finishing </span>';
                    }else if(result[i].status == 4){
                        status = '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-primary"><i class="fa fa-spinner fa-spin"></i> Finishing </span>';
                    }else if(result[i].status == 5){
                        status = '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-success"><i class="fa fa-check"></i> Finishing </span>';
                    }else{
                        status = '<span class="badge badge-default badge-danger"><i class="fa fa-spinner fa-spin"></i> Belum Di Produksi </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Cutting </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Sablon </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Aksesoris </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Sewing </span><br>';
                        status += '<span class="badge badge-default badge-warning"><i class="fa fa-spinner fa-spin"></i> Finishing </span>';
                    }
                    
                    data.push([img_qrcode,img,result[i].nama,result[i].tgl_mulai,status,linkedit]);
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
          <span class="breadcrumb-item active">Data Produksi</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-cube"></i>
        <div>
          <h4>Produksi</h4>
          <p class="mg-b-0">Halaman data produksi.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Produksi</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('produksi/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Produksi </button> <button class="btn btn-warning btn-sm" onclick="getpopup('produksi/tambah_manual','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Manual Produksi </button></p>
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_produksi" class="table  display nowrap">
                <thead>
                    <tr>
                        <th>Kode Produksi</th>
                        <th>Gambar Produksi</th>
                        <th>Nama Produksi</th>
                        <th>Tanggal Mulai</th>
                        <th>Status</th>
    <!--                <th style="width: 10%">Progress</th>-->
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>


