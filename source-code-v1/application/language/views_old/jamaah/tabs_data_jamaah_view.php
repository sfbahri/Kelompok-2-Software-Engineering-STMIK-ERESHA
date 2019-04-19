<script type="text/javascript">
$(document).ready(function(){
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var id_kloter_1 = '<?php echo $id_rows;?>';
    
    
    $("#btn_simpan_jamaah").click(function(){
        
        if($("#no_paspor_j").val() == ''){
            Command: toastr["warning"]("Silahkan isi no paspor", "Opss !");
            $("#no_paspor_j").focus();
        }else if($("#nama_j").val() == ''){
            Command: toastr["warning"]("Silahkan isi nama", "Opss !");
            $("#nama_j").focus();
        }else if($("#email_j").val() == ''){
            Command: toastr["warning"]("Silahkan isi email", "Opss !");
            $("#email_j").focus();
        }else{
            swal({
                title: "Simpan Data Jamaah ?",
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
                    url       : base_url + 'jamaah/simpan',
                    type      : "post",
                    dataType  : 'json',
                    data      : {nama        : $("#nama_j").val(),
                                no_paspor    : $("#no_paspor_j").val(),
                                email        : $("#email_j").val(),
                                id_kloter    : id_kloter_1,
                                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                            },
                    success: function (response) {
                    if(response == true){
                            swal.close();
                            Command: toastr["success"]("Data Jamaah berhasil disimpan", "Berhasil");
                            $('.clears_1').val('');
                            get_data_by_kloter();
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
   
    myFunction = function() {
        var x = document.getElementById("nama_j");
        x.value = x.value.toUpperCase();
    }
    
    myFunction3 = function() {
        var x = document.getElementById("no_paspor_j");
        x.value = x.value.toUpperCase();
    }
    
    $("#tgl_lahir").datepicker();
    
    get_data_by_kloter = function(){
        $('#tabel_jamaah').hide();
        $.ajax({ 
            url: base_url + 'jamaah/data_by_kloter',
            type: "post",
            data:{id_kloter:id_kloter_1,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                   
                    var link_edit    = "<a href='javascript:void(0)' onclick=\"getpopup('jamaah/edit','"+tokens+"','popupedit','"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-info btn-sm' title='Detail Jamaah' ><i class='fa fa-eye'></i></div></a>";    
                    var link_hapus   = "<a href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-danger btn-sm' title='Hapus' ><i class='fa fa-trash'></i></div></a>";
                    var link_bayar   = "<a href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Pembayaran' ><i class='fa fa-money'></i></div></a>";
                    var link_dokumen = "<a href='javascript:void(0)' onclick=\"getpopup('jamaah/dokumen','"+tokens+"','popupedit','"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-primary btn-sm' title='Pembayaran' ><i class='fa fa-folder-open-o'></i></div></a>";;
                    var link_reset    = "<a href='javascript:void(0)' onclick=\"getpopup('jamaah/reset','"+tokens+"','popupedit','"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-warning btn-sm' title='Akses' ><i class='fa fa-key'></i></div></a>";
                   
                    var jmh = '<span style="color:#04ba93;">'+result[i].id+'</span><span class="tx-11 d-block">Paspor : '+result[i].paspor_no+'</span>';
                    var nmh = '<span style="color:black;">'+result[i].nama+'</span><span class="tx-11 d-block">Email : '+result[i].email+'</span>';
                    //,link_dokumen,link_bayar
                    data.push([no,jmh,nmh,result[i].tgl_lahir,result[i].kota_asal,link_reset,link_edit,link_hapus]);

                }
                $('#tabel_jamaah').DataTable({
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
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
                $('#tabel_jamaah').show();
            }
        });
    }
    get_data_by_kloter();
    
    
    hapus = function(id_jamaah,id_kloter){
    
        swal({
            title: "Hapus ?",
            text: "Yakin hapus kloter ini ? jika ya silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
            //confirmButtonColor: "#286090"
        },
        function(){
            
            $.ajax({
                url       : base_url + 'jamaah/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id_jamaah:id_jamaah,id_kloter : id_kloter, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Jamaah berhasil dihapus", "Berhasil");
                        get_data_by_kloter();
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
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
<div class="row">  
            <div class="col-md-2" style="padding-right: 0px">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nomor PASPOR</label>
                    <input type="text" id="no_paspor_j" name="no_paspor_j" class="form-control clears_1" onkeyup="myFunction3()">
                </div>
            </div>
            <div class="col-md-3" style="padding-right: 0px">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama_j" name="nama_j" class="form-control clears_1" onkeyup="myFunction()">
                </div>
            </div>
            <div class="col-md-3" style="padding-right: 0px">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Email</label>
                <input type="text" id="email_j" name="email_j" class="form-control clears_1" placeholder="Email Aktif">
                </div>
            </div>
            <div class="col-md-2" style="padding-right: 0px">
                <div style="padding-top: 28px"></div>
                <button type="button" class="btn btn-info" id="btn_simpan_jamaah"><i class="fa fa-save"></i> Simpan</button>
            </div>
    </div>

<div class="table-wrapper table-responsive">
<table id="tabel_jamaah" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Jamaah</th>
            <th>Nama Lengkap</th>
            <th>TTL</th>
            <th>Kota Asal</th>
            <th>Reset</th>
            <th>Detail</th>
            <th>Hapus</th>
        </tr>
    </thead>
</table> 
</div>