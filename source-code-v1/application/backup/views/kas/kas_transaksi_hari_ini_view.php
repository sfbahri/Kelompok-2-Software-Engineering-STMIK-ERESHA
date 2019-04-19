<script type="text/javascript">
$(document).ready(function(){
    var id_modal           = '<?php echo $id_modal;?>';
    var id_kas_kategori    = '<?php echo $id_row;?>';
    
    var data_kas_transaksi_hari_ini = function(){
        
        $.ajax({ 
            url: base_url + 'kas/get_data_kas_hari_ini',
            type: "post",
            data:{id_kas_kategori:id_kas_kategori,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
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
                $('#tabel_kas_promosi').DataTable({
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
                $('#tabel_kas_promosi').show();
            }
        });
    }
    data_kas_transaksi_hari_ini();
    
    
});    

</script>

<?php 

$nama;

if($id_row == 1){
 $nama = 'Kas Produksi Cutting';   
}else if($id_row == 2){
  $nama = 'Kas Produksi Sablon';  
}else if($id_row == 3){
  $nama = 'Kas Produksi Aksesoris';  
}else if($id_row == 4){
  $nama = 'Kas Produksi Sewing';  
}else if($id_row == 5){
  $nama = 'Kas Promosi';  
}else if($id_row == 6){
  $nama = 'Kas Besar';  
}else if($id_row == 7){
  $nama = 'Kas Kecil';  
}else if($id_row == 8){
  $nama = 'Kas Pickup';  
}else{
    
}

?>


<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Data <?php echo $nama;?> Transaksi Hari Ini</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <table id="tabel_kas_promosi" class="table table-striped table-bordered table-responsive" style="width: 100%">
                <thead>
                    <tr>
                        <th style="width: 2%">No</th>
                        <th style="width: 15%">Karyawan</th>
                        <th style="width: 10%">Nominal</th>
                        <th style="width: 10%">Tgl Transaksi</th>
                        <th style="width: 10%">Catatan</th>
                    </tr>
                    </thead>
                </table> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

