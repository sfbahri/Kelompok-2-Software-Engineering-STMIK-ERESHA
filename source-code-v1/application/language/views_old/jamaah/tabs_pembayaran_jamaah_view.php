<script type="text/javascript">
$(document).ready(function(){
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_kloter_2 = '<?php echo $id_rows;?>';
    
    get_data_by_kloter_bayar = function(){
        $('#tabel_jamaah_bayar').hide();
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
                    var bayar_pernak;
                    if(result[i].bayar_pernakpernik == 0){
                        bayar_pernak = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'PERNAK');\"></div>";
                    }else{
                        bayar_pernak = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'PERNAK');\"></div>";
                    }
                    
                    var bayar_adm;
                    if(result[i].bayar_adm == 0){
                        bayar_adm = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'ADM');\"></div>";
                    }else{
                        bayar_adm = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'ADM');\"></div>";
                    }
                    
                    
                    var bayar_la;
                    if(result[i].bayar_la == 0){
                        bayar_la = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'LA');\"></div>";
                    }else{
                        bayar_la = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'LA');\"></div>";
                    }
                    
                    
                    var bayar_visa;
                    if(result[i].bayar_visa == 0){
                        bayar_visa = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'VISA');\"></div>";
                    }else{
                        bayar_visa = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'VISA');\"></div>";
                    }
                    
                    var bayar_batik;
                    if(result[i].bayar_batik == 0){
                        bayar_batik = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'BATIK');\"></div>";
                    }else{
                        bayar_batik = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'BATIK');\"></div>";
                    }
                    
                     var bayar_manasik;
                    if(result[i].bayar_manasik == 0){
                        bayar_manasik = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'MANASIK');\"></div>";
                    }else{
                        bayar_manasik = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'MANASIK');\"></div>";
                    }
                    
                     var bayar_mahrom;
                    if(result[i].bayar_mahrom == 0){
                        bayar_mahrom = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'MAHROM');\"></div>";
                    }else{
                        bayar_mahrom = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'MAHROM');\"></div>";
                    }
                    
                     var bayar_lunas;
                    if(result[i].bayar_lunas == 0){
                        bayar_lunas = "<div style='text-align:center'><input type='checkbox' onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',1,'LUNAS');\"></div>";
                    }else{
                        bayar_lunas = "<div style='text-align:center'><input type='checkbox' checked onclick=\"fun_pembayaran('"+result[i].id+"','"+result[i].id_kloter+"',0,'LUNAS');\"></div>";
                    }
                    
                    data.push([no,jmh,nmh,bayar_pernak,bayar_adm,bayar_mahrom,bayar_batik,bayar_la,bayar_visa,bayar_manasik,bayar_lunas]);

                }
                $('#tabel_jamaah_bayar').DataTable({
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
                $('#tabel_jamaah_bayar').show();
            }
        });
    }
    get_data_by_kloter_bayar();
    
    
    fun_pembayaran = function(id_jamaah,id_kloter,id_value,kategori){
        $.ajax({
            url       : base_url + 'jamaah/pembayaran',
            type      : "post",
            dataType  : 'json',
            data      : {id_jamaah:id_jamaah,id_kloter : id_kloter,id_value:id_value,kategori:kategori, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                if(response == true){
                    swal.close();
                    Command: toastr["success"]("Ubah Status Pembayaran ", "Berhasil");
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
<table id="tabel_jamaah_bayar" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Jamaah</th>
            <th>Nama Lengkap</th>
            <th>PERNAKNIK</th>
            <th>ADM</th>
            <th>MAHROM</th>
            <th>BATIK</th>
            <th>LA</th>
            <th>VISA</th>
            <th>MANASIK</th>
            <th>LUNAS</th>
        </tr>
    </thead>
</table> 
</div>