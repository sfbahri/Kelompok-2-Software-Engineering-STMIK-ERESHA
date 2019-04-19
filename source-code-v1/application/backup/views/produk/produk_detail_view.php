<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'produk/data_detail',
            type: "post",
            data:{kode_produksi:kode_produksi,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:50px;height:50px"><br><span style="font-size:12px">'+result[i].kode+'</span></div>';
                    
                    var status;
                    if(result[i].beli == 0){
                        status = '<span class="notification-tag badge badge-warning float-center m-0">Belum Terjual</span>';
                    }else{
                        status = '<span class="notification-tag badge badge-success float-center m-0">Terjual</span>';
                    }
                    
                    data.push([img_qrcode,status]);
                }
                $('#tabel_produk').DataTable({
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
                $('#tabel_produk').show();
            }
        });
    }
    data_produk();
    
});    

</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  
</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Produk Detail</h4>
        </div>
        <div class="modal-body">
            
                <table id="tabel_produk" class="table table-striped table-bordered table-responsive" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 10%">Kode Produk</th>
                            <th style="width: 10%">Status</th>
                        </tr>
                    </thead>
                </table>

        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="la la-refresh"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>


