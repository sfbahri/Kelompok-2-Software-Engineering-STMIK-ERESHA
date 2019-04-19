<script type="text/javascript">
$(document).ready(function(){
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_kloter_2 = '<?php echo $id_rows;?>';
    
    get_data_by_kloter_dok = function(){
        $('#tabel_jamaah_dok').hide();
        $.ajax({ 
            url: base_url + 'jamaah/data_by_kloter',
            type: "post",
            data:{id_kloter:id_kloter_2,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
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
                    var nmh = '<span style="color:black;">'+result[i].nama+'</span><span class="tx-11 d-block">Email : '+result[i].email+' / '+result[i].kota_asal+'</span>';
                    //,link_dokumen,link_bayar
                    
                    //alert(result[i].dokumen_terima)
                    var dok_terima;
                    if(result[i].dokumen_terima == 0){
                        dok_terima = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_dok_terima('"+result[i].id+"','"+result[i].id_kloter+"',1);\"></div>";
                    }else{
                        //
                        dok_terima = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_dok_terima('"+result[i].id+"','"+result[i].id_kloter+"',0);\"></div>";
                    }
                    
                    var dok_lengkap;
                    if(result[i].dokumen_lengkap == 0){
                        dok_lengkap = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_dok_lengkap('"+result[i].id+"','"+result[i].id_kloter+"',1);\"></div>";
                    }else{
                        //
                        dok_lengkap = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_dok_lengkap('"+result[i].id+"','"+result[i].id_kloter+"',0);\"></div>";
                    }
                    
                    data.push([no,jmh,nmh,dok_terima,dok_lengkap]);

                }
                $('#tabel_jamaah_dok').DataTable({
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
                $('#tabel_jamaah_dok').show();
            }
        });
    }
    get_data_by_kloter_dok();
    
    
    fun_dok_terima = function(id_jamaah,id_kloter,id_value){
        $.ajax({
            url       : base_url + 'jamaah/dok_terima',
            type      : "post",
            dataType  : 'json',
            data      : {id_jamaah:id_jamaah,id_kloter : id_kloter,id_value:id_value, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                if(response == true){
                    swal.close();
                    Command: toastr["success"]("Ubah Status dokumen diterima", "Berhasil");
                    //get_data_by_kloter_dok();
                }else{
                    Command: toastr["error"]("Response Ajax Error !!", "Error");
                }  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    
    fun_dok_lengkap = function(id_jamaah,id_kloter,id_value){
        $.ajax({
            url       : base_url + 'jamaah/dok_lengkap',
            type      : "post",
            dataType  : 'json',
            data      : {id_jamaah:id_jamaah,id_kloter : id_kloter,id_value:id_value, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                if(response == true){
                    swal.close();
                    Command: toastr["success"]("Ubah Status dokumen lengkap", "Berhasil");
                    //get_data_by_kloter_dok();
                }else{
                    Command: toastr["error"]("Response Ajax Error !!", "Error");
                }  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    
});    

</script>

<div class="table-wrapper table-responsive">
<table id="tabel_jamaah_dok" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Jamaah</th>
            <th>Nama Lengkap</th>
            <th>Dok Terima</th>
            <th>Dok Lengkap</th>
<!--            <th>Dok Yang Di terima</th>-->
        </tr>
    </thead>
</table> 
</div>