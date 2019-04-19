<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'karyawan/karyawan_data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                 
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('karyawan/karyawan_edit','"+tokens+"','popupedit','"+result[i].nik+"');\"><div class='btn btn-info btn-sm' title='Edit Data Karyawan' ><i class='fa fa-edit'></i></div></a>";    
                   
                    data.push(['<b>'+result[i].nik+'</b>',result[i].nama_karyawan,result[i].nama_divisi,result[i].nama_jabatan,result[i].nama_outlet,link_edit]);
                   
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



    actives = function(id_status,nik){

        var kt_status;
        var idstatus;
        if(id_status == 1){
            kt_status = 'Nonaktifkan';
            idstatus = 0;
        }else{
            kt_status = 'Aktifkan';
            idstatus = 1;
        }


        swal({
            title: ""+kt_status+" Users ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Submit",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'users/actives',
                type      : "post",
                dataType  : 'json',
                data      : {nik:nik,
                             id_status:idstatus,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){  
                            swal.close();
                            Command: toastr["success"]("Users berhasil di "+kt_status+"", "Berhasil");
                            getcontents('users',tokens);
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
    
    $(".dataTables_length label select").addClass('sss');
    

});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Karyawan</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-people"></i>
        <div>
          <h4>Karyawan</h4>
          <p class="mg-b-0">Halaman data karyawan.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Karyawan</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getpopup('karyawan/karyawan_tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Karyawan </button></p>

            <div class="table-responsive">
            <table id="tabel_sablon" class="table  display nowrap table-responsive">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Outlet</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>
    
    
    
    
        <!-- end content -->


    

