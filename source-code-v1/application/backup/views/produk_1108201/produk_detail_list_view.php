<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produk    = '<?php echo $id_row;?>';
   
   
    var data_produk_list = function(){
        $('#tabel_produk_list').hide();
        $.ajax({ 
            url: base_url + 'produk/data_list',
            type: "post",
            data:{kode_produk:kode_produk,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                   
                    var statuss;
                    if(result[i].beli == 0){
                        statuss = '<span style="color:red;font-size:10px">Belum Terjual</span>';
                    }else{
                        statuss = '<span style="color:green;font-size:10px">Terjual</span>';
                    }
                   
                    data.push([no,result[i].kode_produk,result[i].nama_produk,'Rp. ' +result[i].hargass,statuss,result[i].nama_outlet]);
                }
                $('#tabel_produk_list').DataTable({
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
                $('#tabel_produk_list').show();
            }
        });
    }
    data_produk_list();
   
    
});    

</script>

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
      
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail List Produk </h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
           <div class="table-wrapper table-responsive">
            <table id="tabel_produk_list" class="table  display nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th width="10%">Outlet</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
    </div>
    <div class="modal-footer">
       <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
    </div>
    </div>

  </div>
</div>



