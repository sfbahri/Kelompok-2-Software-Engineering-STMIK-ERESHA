<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'finishing/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                    var gambar = '<img src='+result[i].path+' style="width:300px;height:300px">';
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('finishing/detail','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info' title='Detail Cutting' ><i class='ft-edit'></i></div></a>";
                    var btn_aksi = '<div style="width:100%;text-align:center">'+link_edit+'</div>';
                   
                    var status_cutting;
                    if(result[i].cutting_status == 2){
                        status_cutting = '<span class="badge badge-primary"><i class="la la-spinner la-spin"></i> Cutting</span>';
                    }else if(result[i].cutting_status == 3){
                        status_cutting = '<span class="badge badge-success"><i class="la la-check"></i> Cutting</span>';
                    }else{
                        status_cutting = '<span class="badge badge-primary" style="background:gray">Cutting</span>';
                    }
                    
                    
                    var status_sablon;
                    if(result[i].sablon_status == 2){
                        status_sablon = '<span class="badge badge-primary"><i class="la la-spinner la-spin"></i> Sablon</span>';
                    }else if(result[i].sablon_status == 3){
                        status_sablon = '<span class="badge badge-success"><i class="la la-check"></i> Sablon</span>';
                    }else{
                        status_sablon = '<span class="badge badge-primary" style="background:gray">Sablon</span>';
                    }
                    
                    var status_aksesoris;
                    if(result[i].aksesoris_status == 2){
                        status_aksesoris = '<span class="badge badge-primary"><i class="la la-spinner la-spin"></i> Aksesoris</span>';
                    }else if(result[i].aksesoris_status == 3){
                        status_aksesoris = '<span class="badge badge-success"><i class="la la-check"></i> Aksesoris</span>';
                    }else{
                        status_aksesoris = '<span class="badge badge-primary" style="background:gray">Aksesoris</span>';
                    }
                    
                    
                    var status_sewing;
                    if(result[i].sewing_status == 2){
                        status_sewing = '<span class="badge badge-primary"><i class="la la-spinner la-spin"></i> Sewing</span>';
                    }else if(result[i].sewing_status == 3){
                        status_sewing = '<span class="badge badge-success"><i class="la la-check"></i> Sewing</span>';
                    }else{
                        status_sewing = '<span class="badge badge-primary" style="background:gray">Sewing</span>';
                    }
                    
                    var status_finish;
                    if(result[i].finishing_status == 1){
                        status_finish = '<span class="badge badge-primary"><i class="la la-spinner la-spin"></i> Finishing</span>';
                    }else if(result[i].finishing_status == 2){
                        status_finish = '<span class="badge badge-success"><i class="la la-check"></i> Finishing</span>';
                    }else{
                        status_finish = '<span class="badge badge-primary" style="background:gray">Finishing</span>';
                    }
                    
                    var status = status_cutting+' <i class="la la-angle-right"></i> '+status_sablon+' <i class="la la-angle-right"></i> '+status_aksesoris+' <i class="la la-angle-right"></i> '+status_sewing+' <i class="la la-angle-right"></i> '+status_finish;
                    
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:100px;height:100px"> <br> #'+result[i].kode_produksi_detail+'</div>';
                    
                   
                    data.push([no,img_qrcode,gambar,status,btn_aksi]);
                   
                }
                $('#tabel_sablon').DataTable({
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
                $('#tabel_sablon').show();
            }
        });
    }
    data_produksi();
    
    
    $('#tanggal').datepicker();
    
    
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
    

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Proses Finishing</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Proses Finishing</a></li>
                        <li class="breadcrumb-item active">Data Finishing</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section id="initialization">
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Data Finishing</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_sablon" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 2%">Qrcode Artikel</th>
                                    <th style="width: 5%">Qrcode Produk</th>
                                    <th style="width: 10%">Gambar</th>
                                    <th>Status</th>
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






    

