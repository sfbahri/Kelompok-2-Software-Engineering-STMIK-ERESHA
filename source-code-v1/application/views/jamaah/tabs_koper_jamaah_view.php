<script type="text/javascript">
$(document).ready(function(){
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_kloter_2 = '<?php echo $id_rows;?>';
    
    get_data_by_kloter_koper = function(){
        $('#tabel_jamaah_koper').hide();
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
                    
                    var tml;
                    if(result[i].koper == 0){
                        tml = '<select class="sel1" onchange=fun_status_koper("'+result[i].id+'","'+result[i].id_kloter+'",0) id="selects_'+result[i].id+'_'+result[i].id_kloter+'"><option value=0 selected>- Pilih -</option><option value=1>Dikirim</option><option value=2>Diambil Dirumah Om Ikhsan</option><option value=3>Diambil Manasik</option></select>';
                    }else if(result[i].koper == 1){
                        tml = '<select class="sel1" onchange=fun_status_koper("'+result[i].id+'","'+result[i].id_kloter+'",1) id="selects_'+result[i].id+'_'+result[i].id_kloter+'"><option value=0>- Pilih -</option><option value=1 selected>Dikirim</option><option value=2>Diambil Dirumah Om Ikhsan</option><option value=3>Diambil Manasik</option></select>';
                    }else if(result[i].koper == 2){
                        tml = '<select class="sel1" onchange=fun_status_koper("'+result[i].id+'","'+result[i].id_kloter+'",2) id="selects_'+result[i].id+'_'+result[i].id_kloter+'"><option value=0>- Pilih -</option><option value=1 >Dikirim</option><option value=2 selected>Diambil Dirumah Om Ikhsan</option><option value=3>Diambil Manasik</option></select>';
                    }else if(result[i].koper == 3){
                        tml = '<select class="sel1" onchange=fun_status_koper("'+result[i].id+'","'+result[i].id_kloter+'",3) id="selects_'+result[i].id+'_'+result[i].id_kloter+'"><option value=0>- Pilih -</option><option value=1 >Dikirim</option><option value=2>Diambil Dirumah Om Ikhsan</option><option value=3 selected>Diambil Manasik</option></select>';
                    }
    
                    var biy = '<input type="text" style="margin-right:10px">';
                    
                    data.push([no,jmh,nmh,tml,biy]);

                }
                $('#tabel_jamaah_koper').DataTable({
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
                $('#tabel_jamaah_koper').show();
            }
        });
    }
    get_data_by_kloter_koper();
    
    
    fun_status_koper = function(id_jamaah,id_kloter,id_value){
    
        var sss = $("#selects_"+id_jamaah+"_"+id_kloter).val();
    
    
        $.ajax({
            url       : base_url + 'jamaah/koper_status',
            type      : "post",
            dataType  : 'json',
            data      : {id_jamaah:id_jamaah,id_kloter : id_kloter,id_value:sss, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                if(response == true){
                    swal.close();
                    Command: toastr["success"]("Status Koper Dan Pernak Pernik Berhasil diubah status", "Berhasil");
                    //get_data_by_kloter_koper();
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
<table id="tabel_jamaah_koper" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Jamaah</th>
            <th>Nama Lengkap</th>
            <th width="200px">KOPER</th>
            <th >BIAYA KIRIM</th>
        </tr>
    </thead>
</table> 
</div>