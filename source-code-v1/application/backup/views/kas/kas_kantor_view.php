<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
    var data_kas_kantor = function(){
        
        $.ajax({ 
            url: base_url + 'kas/get_data_kas_kantor',
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

                    data.push([no,result[i].nama+'<span class="tx-11 d-block"><b>NIK : '+result[i].nik+'</b></span>',result[i].saldo,result[i].tgl_transaksi,result[i].catatan]);

                }
                $('#tabel_kas_kantor').DataTable({
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
                $('#tabel_kas_kantor').show();
            }
        });
    }
    data_kas_kantor();
    
    
    $("#tanggal").datepicker();
    
    
    $("#btn_simpan").click(function(){
        
        swal({
            title: "Simpan Data ini Ke Kas Kantor ?",
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
                url       : base_url + 'kas/kas_kantor_simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nominal : $("#nominal").val(),tanggal :$("#tanggal").val(),catatan :$("#catatan").val(), <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Data Berhasil disimpan ke Kas Kantor", "Berhasil");
                        data_kas_kantor();
                        $("#nominal").val('');
                        $("#tanggal").val('');
                        $("#catatan").val('');
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
          <span class="breadcrumb-item active">Data Kas Kantor</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-md-wallet"></i>
        <div>
          <h4>Kas Kantor</h4>
          <p class="mg-b-0">Halaman data kas kantor.</p>
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
                    <div class="card-header tx-medium bd-0 tx-white bg-info">Form Input Kas Kantor</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <div class="row" style="margin:5px">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="demo-vs-definput" class="control-label">Nominal</label>
                                <input type="text" id="nominal" name="nominal" class="form-control maskmoney">
                            </div>
                            <div class="form-group">
                                <label for="demo-vs-definput" class="control-label">Tanggal Transaksi</label>
                                <input type="text" id="tanggal" name="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="demo-vs-definput" class="control-label">Catatan</label>
                                <textarea id="catatan" name="catatan" class="form-control"></textarea>
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
                <div class="card-header tx-medium bd-0 tx-white bg-info">Data Kas Kantor</div>
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_kas_kantor" class="table table-striped table-bordered table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 10%">No</th>
                                    <th style="width: 10%">Karyawan</th>
                                    <th style="width: 10%">Nominal</th>
                                    <th style="width: 10%">Tgl Transaksi</th>
                                    <th style="width: 10%">Catatan</th>
                                </tr>
                                </thead>
                            </table> 
                    
                    
                </div>
                </div>
                </div>
            </div>
            </div>
            
        </div>