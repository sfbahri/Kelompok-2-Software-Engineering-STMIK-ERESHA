<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'finance/data',
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
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('finance/detail','"+tokens+"','popupedit','"+result[i].kode_produk+"');\"><div class='btn btn-info' title='Detail Cutting' ><i class='ft-edit'></i></div></a>";
                    var btn_aksi = '<div style="width:100%;text-align:center">'+link_edit+'</div>';
                   
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:100px;height:100px"> <br> #'+result[i].kode_produksi_detail+'</div>';
                    
                   
                    data.push([img_qrcode,gambar,result[i].stok,result[i].harga_modal,result[i].harga_jual,btn_aksi]);
                   
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
            <h3 class="content-header-title">Produk</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Produk</a></li>
                        <li class="breadcrumb-item active">Data Produk</li>
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
                  <h4 class="card-title">Data Produk</h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_sablon" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5%">Qrcode Produk</th>
                                    <th style="width: 10%">Gambar</th>
                                    <th>Stok</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
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






    

