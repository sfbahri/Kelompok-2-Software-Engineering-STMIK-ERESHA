<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var no_notas    = '<?php echo $id_row;?>';
    
   
    var data_produksi = function(){
        $('#tabel_sablon').hide();
        $.ajax({ 
            url: base_url + 'produk/data_produk_publish',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].gambar+'" style="width:150px;height:150px"></div>';
                    }
                    
                    var img_qrcode  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:50px;height:50px"> <br> '+result[i].kode+'</div>';
                   
                    var input_request = '<input type="hidden" class="form-control" style="width:60px" name="kode_produk_header[]" value='+result[i].kode_produk_header+'>'
                        input_request += '<input type="hidden" class="form-control" style="width:60px" name="id_gambar[]" value='+result[i].id_gambar+'>'
                        input_request += '<input type="hidden" class="form-control" style="width:60px" name="rows[]" value='+i+'>'
                        input_request += '<input type="text" class="form-control" style="width:60px" name="ukuran_s[]">';
                    var input_ukuran_m = '<input type="text" class="form-control" style="width:60px" name="ukuran_m[]">';
                    var input_ukuran_l = '<input type="text" class="form-control" style="width:60px" name="ukuran_l[]">';
                        
                   
                    data.push([result[i].kode_produk_header,result[i].nama_produk,img,result[i].stok+' Pcs',input_request,input_ukuran_m,input_ukuran_l]);
                   
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
                    "drawCallback": function ( row, data, index ) {
                        var api = this.api();
                        var rows = api.rows( {page:'current'} ).nodes();
                        var last=null;

                        api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                            if ( last !== group ) {
                                $(rows).eq( i ).before(
                                    '<tr class="group"><td colspan="10"><span style="color:black">'+group+'</span></td></tr>'
                                );
                                last = group;
                            }
                        } );
                    }
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
   
   
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Order ?",
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
                url             : base_url + 'penjualan/simpan_order', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(response){
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Aksesoris berhasil disimpan", "Berhasil");
                        getcontents('penjualan/kasir','<?php echo $tokens;?>');
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
   
    $('#tanggal').datepicker();
    
    
});    

</script>

<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Order Produk | No Nota : <span style="color:blue"><?php echo $id_row;?></span></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type='hidden' class='form-control' name='nonota' value="<?php echo $id_row;?>">
                <div class="table-wrapper table-responsive">
                <table id="tabel_sablon" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Kode Produk Header</th>
                        <th>Nama Produk</th>
                        <th>Gambar</th>
                        <th>Stok Akhir</th>
                        <th>Ukuran S</th>
                        <th>Ukuran M</th>
                        <th>Ukuran L</th>
                    </tr>
                </thead>
                </table> 
                </table> 
                </div>
                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Order </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

