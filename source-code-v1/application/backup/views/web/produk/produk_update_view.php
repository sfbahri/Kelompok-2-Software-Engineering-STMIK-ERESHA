<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produk = '<?php echo $id_row;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
    
    tinyMCE.remove();
    getMCE();
    loading();
    
    
    //detail produk
    var produk = function(){
        $.ajax({
            url       : base_url + 'web_produk/details',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk : kode_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                $("#kode").val(response.kode);
                $("#nama").val(response.nama);
                $("#harga").val(response.web_harga);
                $("#harga_diskon").val(response.web_harga_diskon);
                $("#gambars").html('<img class="card-img-top img-fluid" src="./uploads/produk/'+response.img+'" alt="Image" class="img-fluid" style="margin-bottom:15px;border-radius:10px">');
                var ed1 = tinyMCE.get('deskripsi');
                // Do you ajax call here, window.setTimeout fakes ajax call
                ed1.setProgressState(1); // Show progress
                window.setTimeout(function() {
                    ed1.setProgressState(0); // Hide progress
                    ed1.setContent(response.deskripsi);
                }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    produk();
    
    
    //detail produk
    var produk_gambar_detail = function(){
        $.ajax({
            url       : base_url + 'web_produk/detail_gambar',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk : kode_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
                for ( var i=0 ; i<response.length ; i++ ) {
                    var list_gambar  = '<div class="row" style="margin:5px">'
                                        +'<div class="col-md-2" style="padding:2px">'
                                            +'<img class="card-img-top img-fluid" src="./uploads/produk/rz_'+response[i].gambar+'" alt="Image" class="img-fluid" style="width:100px" >'
                                            +'<input class="form-control" id="id_gambar_'+response[i].id+'" name="id_gambar_'+response[i].id+'" type="hidden" value="'+response[i].id+'">'
                                        +'</div>'
                                        +'<div class="col-md-3" style="padding:2px">'
                                            +'<label for="ex1">Size/Ukuran</label>'
                                            +'<input class="form-control clears" id="size_'+response[i].id+'" name="size_'+response[i].id+'" type="text">'
                                        +'</div>'
                                        +'<div class="col-md-3" style="padding:2px;" id="prev_gambar">'
                                            +'<label for="ex1">Nama Warna</label>'
                                            +'<input class="form-control clears" id="nama_warna_'+response[i].id+'" name="nama_warna_'+response[i].id+'" type="text" >'
                                        +'</div>'
                                        +'<div class="col-md-2" style="padding:2px">'
                                            +'<label for="ex1">Stok (Pcs)</label>'
                                            +'<input class="form-control maskmoney clears" id="stok_'+response[i].id+'" name="stok_'+response[i].id+'" type="text" onkeypress="return isNumber(event)">'
                                        +'</div>'
                                        +'<div class="col-md-2" style="padding:2px">'
                                            +'<div style="margin-top:28px"></div>'
                                            +'<button type="button" class="btn btn-primary" onclick=\"simpan_stok('+response[i].id+');\">Simpan</button>'
                                        +'</div>'
                                    +'</div>';
                            
                            $("#gambar_list").append(list_gambar);
                }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    produk_gambar_detail();
    
    
    simpan_stok = function(id){
        var size        = $("#size_"+id).val();
        var nama_warna  = $("#nama_warna_"+id).val();
        var stok        = $("#stok_"+id).val();
        var id_gambar   = $("#id_gambar_"+id).val();
        
      
        if(size == '' || nama_warna == '' || stok == ''){
            $("#size_"+id).css("border-color", "red");
            $("#nama_warna_"+id).css("border-color", "red");
            $("#stok_"+id).css("border-color", "red");
            Command: toastr["error"]("Gagal Simpan, silahkan lengkapi kolom size,nama warna,stok", "Error");
        }else{
            $("#size_"+id).attr("style", "zoom:normal;");
            $("#nama_warna_"+id).attr("style", "zoom:normal;");
            $("#stok_"+id).attr("style", "zoom:normal;");
            $(".clears").val('');
            
            $.ajax({
                url       : base_url + 'web_produk/simpan_size_warna_stok',
                type      : "post",
                dataType  : 'json',
                data      : {size : size,
                            nama_warna:nama_warna,
                            stok:stok,
                            id_gambar:id_gambar,
                            kode_produk:kode_produk,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Size Warna dan Stok berhasil disimpan", "Berhasil");
                        data_stok_warna_size();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });
            
            //Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
        }
        
    }
    
    
    var data_stok_warna_size = function(){
        $('#table_sws2').hide();
        $.ajax({ 
            url: base_url + 'web_produk/data_size_warna_stok',
            type: "post",
            data:{kode_produk:kode_produk,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    
                    var link_detail = "<a href='javascript:void(0)' onclick=\"getpopup('produk/detail_list_produkx','"+tokens+"','popupedit','"+result[i].kode+"');\" data-placement='top' ><div class='btn btn-danger btn-sm fa fa-trash' title='Hapusx' ></div></a>";
                    
                    data.push([no,result[i].size,result[i].warna,result[i].stok,link_detail]);
                }
                $('#table_sws2').DataTable({
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
                //loadingPannel.show();
            },
            complete: function () {
                //loadingPannel.hide();
                $('#table_sws2').show();
            }
        });
    }
    data_stok_warna_size();
//    
    
    $("#btn_simpan").click(function(){
      
            tinyMCE.triggerSave();
            var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Produk ?",
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
                url             : base_url + 'web_produk/web_update_produk', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success         : function(response){
          
                    if(response == true){
                        produk();
                        //$('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Produk berhasil diupdate", "Berhasil");
                        //getcontents('web_produk','<?php echo $tokens;?>');
                    } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
        
    });
   
   
   
});    

</script>
<style>

.selected2
{
    border-color:red !important;
}
</style>

      
<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Produk</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
        <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
        
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Kode Produk</label>
                        <input type="text" id="kode" name="kode" class="form-control" readonly="">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Nama Produk</label>
                        <input type="text" id="nama" name="nama" class="form-control">
                    </div>
                </div>
                
                <div class="col-md-6">
            
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Harga</label>
                                <input type="text" id="harga" name="harga" class="form-control maskmoney">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Harga Diskon</label>
                                <input type="text" id="harga_diskon" name="harga_diskon" class="form-control maskmoney">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="gambars"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                <div class="card-header tx-medium bd-0 tx-white bg-info">Warna & Ukuran & Stok</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="gambar_list"></div>
                        <br>
                        
                        <table id="table_sws2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Size</th>
                                    <th>Warna</th>
                                    <th>Stok</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                        </table> 
                        
                        
                    </div>
                </div>
                </div>
                </div>
            </div>
            <br>
        
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                <div class="card-header tx-medium bd-0 tx-white bg-info">Deskripsi</div>
                <div class="card-body">
                    <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control mceEditor"></textarea>
                </div>
                </div>
                </div>
            </div>
            
            
        </form>   
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>  
      
      
      