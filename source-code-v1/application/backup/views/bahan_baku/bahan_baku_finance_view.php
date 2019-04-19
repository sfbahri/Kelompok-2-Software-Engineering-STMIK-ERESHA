<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_produksi').hide();
        $.ajax({ 
            url: base_url + 'bahan_baku/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var link_edit   = "<a href='javascript:void(0)' onclick=\"getpopup('bahan_baku/finance_detail','"+tokens+"','popupedit','"+result[i].kode+"');\" data-placement='top' data-toggle='tooltip' data-original-title='Tooltip on top'><div class='btn btn-info btn-sm' title='Detail Bahan Baku' ><i class='fa fa-eye'></i></div></a>";
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:80px;height:80px"><br> <a href="javascript:void(0)" style="font-weight:bold">'+result[i].kode+'</a></div>';
                    data.push([result[i].tgl_sampai,img_qrcode,link_edit]);
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
    
    
    $("#btn_simpan").click(function(){
    
        if($("#tanggal").val() == ''){
            $("#tanggal").focus();
            Command: toastr["error"]("Silahkan isi Tanggal Sampai !", "Error !");
        }else{
    
        $.ajax({
            url       : base_url + 'bahan_baku/cek_tanggal',
            type      : "post",
            dataType  : 'json',
            data      : {tanggal : $("#tanggal").val(),
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {

                if(response == 1){  
                        Command: toastr["error"]("Tanggal ini tidak bisa digunakan, Silahkan pilih tanggal lain !", "Error");
                }else{

                    swal({
                        title: "Simpan Tanggal Bahan Baku ?",
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
                            url       : base_url + 'bahan_baku/simpan',
                            type      : "post",
                            dataType  : 'json',
                            data      : {kode   : $("#kode").val(),
                                        tanggal : $("#tanggal").val(),
                                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                    },
                            success: function (response) {
                            if(response == true){  
                                    swal.close();
                                    Command: toastr["success"]("Tanggal Bahan Baku berhasil disimpan", "Berhasil");
                                    getcontents('bahan_baku','<?php echo $tokens;?>');
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
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        
        
        }
    
        
    });
    
   
});    
</script>
    
    <?php 
        $token = "";
        $codeAlphabet = "33434343556789934343434567812345667980909";
        $codeAlphabet.= "54979319491320389885589989898989867733333";
        $codeAlphabet.= "65987111444779789865326549845123248498565";
        $codeAlphabet.= "55555889897713687985198713498498165498987";
        $codeAlphabet.= "0123456789";
        $codeAlphabet.= "9876543210";

        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 

        $today = date("Ymd");
        $kode_produksi = $token.$today;
    ?>


    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Bahan Baku</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-ribbon"></i>
        <div>
          <h4>Bahan Baku</h4>
          <p class="mg-b-0">Halaman data bahan baku.</p>
        </div>
        <div class="">
                
        </div>
    </div>
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="row">
            <div class="col-md-12">
                <table id="tabel_produksi" class="table table-striped table-bordered table-responsive" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 10%">Tanggal Sampai</th>
                        <th style="width: 10%">Kode Bahan Baku</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                    </thead>
                </table>
            </div>
            </div>
            </div>
            
        </div>
    </div>

