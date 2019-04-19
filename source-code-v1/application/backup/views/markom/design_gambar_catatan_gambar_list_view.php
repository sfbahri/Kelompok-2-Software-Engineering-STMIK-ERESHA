<script type="text/javascript">
$(document).ready(function(){
    var id_modal         = '<?php echo $id_modal;?>';
    var tokens           = '<?php echo $tokens;?>';
    var idgambar  = '<?php echo $id_row;?>';
   
    var get_seq = function(){
        
        $.ajax({
            url       : base_url + 'markom/gambar_details',
            type      : "post",
            dataType  : 'json',
            data      : {kodegambar : idgambar,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#gambarbro").html('<img src="./uploads/produksi/'+response.gambar+'" style="width:200px;heigth:200px">'); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
        
    }
    get_seq();
    
    
    var get_data_bahan_baku_detail = function(){
        $('#tabel_bahan_baku_detail').hide();
        $.ajax({ 
            url: base_url + 'markom/gambar_catatan_list',
            type: "post",
            data:{idgambar:idgambar,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    data.push([no,result[i].catatan,result[i].nama_karyawan]);
                }
                $('#tabel_bahan_baku_detail').DataTable({
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
                $('#tabel_bahan_baku_detail').show();
            }
        });
    }
    get_data_bahan_baku_detail();
    
    
   
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Kode Gambar : <a href="javascript:void(0)" style="font-weight:bold"><?php echo $id_row;?></a></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div id="gambarbro"></div>
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_bahan_baku_detail" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Catatan</th>
                        <th>PIC</th>
                    </tr>
                </thead>
            </table>
            </div>
            
        </div>
        <div class="modal-footer">
<!--            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>-->
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

