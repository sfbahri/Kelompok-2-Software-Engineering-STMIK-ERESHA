<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'users/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                 
                    var link_edit = "<a href='javascript:void(0)' onclick=\"getpopup('users/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Edit Users' ><i class='ft-edit'></i></div></a>";
                    var link_module_permission = "<a href='javascript:void(0)' onclick=\"getpopup('users/module_permission','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Module Permission' ><i class='ft-edit'></i></div></a>";    
                    var btn_aksi = '<div style="width:100%;text-align:center">'+link_edit+'</div>';
                   
                    var sts;
                    //var sts_btn;
                    if(result[i].status == 1){
                        sts = "<div style='width:100%;font-size:30px;cursor:pointer' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><i class='ft-user-check success'></i></div>";
                    //    sts_btn = "<a href='javascript:void(0)' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><div class='btn btn-warning btn-sm' title='Nonaktifkan' ><i class='ft-list'></i></div></a>";
                    }else{
                        sts = "<div style='width:100%;font-size:30px;cursor:pointer' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><i class='ft-user-x danger'></i></div>";
                    //    sts_btn = "<a href='javascript:void(0)' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Aktifkan' ><i class='ft-list'></i></div></a>";
                    }
                    
                    var sts_btn = "<a href='javascript:void(0)' onclick=\"actives('"+result[i].status+"','"+result[i].id+"');\"><div class='btn btn-warning btn-sm' title='Nonaktifkan' ><i class='ft-list'></i></div></a>";
                    
                    //no,
                    data.push([result[i].fullname,result[i].username,result[i].email,result[i].nohp,sts,btn_aksi,link_module_permission]);
                   
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



    actives = function(id_status,id_users){

        var kt_status;
        var idstatus;
        if(id_status == 1){
            kt_status = 'Nonaktifkan';
            idstatus = 2;
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
                data      : {id_users:id_users,
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

    
   
});    
</script>
    

    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Akses Pengguna</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Akses Pengguna</a></li>
                        <li class="breadcrumb-item active">Data Akses Pengguna</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn btn-info round dropdown-menu-right box-shadow-2 px-2" onclick="getpopup('users/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="ft-plus-circle icon-left"></i> Tambah Users</div>
            </div>
            </div>
    </div>


    <section id="initialization">
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Akses Pengguna </h4>
                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    
                    <table id="tabel_sablon" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 2%">Nama Lengkap</th>
                                    <th style="width: 5%">Username</th>
                                    <th style="width: 10%">Email</th>
                                    <th style="width: 10%">No Hp</th>
                                    <th>Aktif</th>
                                    <th>#</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            </table> 
                    
                    
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>






    

