<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_order_sales    = '<?php echo $id_row;?>';
    var baseurl = '<?php echo base_url();?>';
   
    $("#no_os_text").text(id_order_sales);
 
    loading();
 
    function data_order_sales(){
        /* select Kategori */
        $.ajax({
            type: 'POST',
            url: base_url + 'pelanggan/detail',
            data: {id_order_sales:id_order_sales,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (ref) {
                
                if(ref.kategori == 1){
                    $("#grosir").attr("checked","checked");
                }else if(ref.kategori == 2){
                    $("#retail").attr("checked","checked");
                }else{
                    
                }
                
                $.ajax({
                    type: 'POST',
                    url: base_url + 'pelanggan/data_select',
                    data: {},
                    dataType  : 'json',
                    success: function (data) {
                        $('#list_member').empty();
                        var $kategori = $('#list_member');
                        $kategori.append('<option value=0>- Pilih Nama Pelanggan -</option>');
                        for (var i = 0; i < data.length; i++) {
                            if(ref.id_pelanggan == data[i].id){
                                $kategori.append('<option value=' + data[i].id + ' selected>' + data[i].nama + '</option>');
                            }else{
                                $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                            }
                            
                        }
                        $('#list_member').trigger("chosen:updated");
                        $("#list_member").chosen({width: "100%"});
                    }
                });
                
            }
        });
        /* select Kategori */
    }
    data_order_sales();
 
 
   $("#btn_update").click(function(){
        swal({
            title: "Update Order Sales ?",
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
                url       : base_url + 'order_sales/update',
                type      : "post",
                dataType  : 'json',
                data      : {list_member        : $("#list_member").val(),
                            kategori_pemesanan  : $("input[name=kategori_pemesanan]:checked").val(),
                            id_order_sales      : id_order_sales,
                            ongkos_kirim        : $("#ongkos_kirim").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        swal.close();
                        Command: toastr["success"]("Data Order Sales berhasil diupdate", "Berhasil");
                        data_order_sales();
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
    
    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Order Sales ?",
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
                url       : base_url + 'order_sales/hapus_order_sales',
                type      : "post",
                dataType  : 'json',
                data      : {id_order_sales      : id_order_sales,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Order Sales berhasil dihapus", "Berhasil");
                        getcontents('order_sales','<?php echo $tokens;?>');
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
   
    
    function data_pelanggan(){
        /* select Kategori */
        $.ajax({
            type: 'POST',
            url: base_url + 'pelanggan/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#list_member').empty();
                var $kategori = $('#list_member');
                $kategori.append('<option value=0>- Pilih Nama Pelanggan -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                }
                $('#list_member').trigger("chosen:updated");
                $("#list_member").chosen({width: "100%"});
            }
        });
        /* select Kategori */
    }
    data_pelanggan();
    
    $("#btn_simpan_member").click(function(){
        swal({
            title: "Simpan Data Pelanggan ?",
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
                url       : base_url + 'pelanggan/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {nama    : $("#nama_member").val(),
                            nohp     : $("#nohp_member").val(),
                            email    : $("#email_member").val(),
                            alamat    : $("#alamat_member").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#exampleModal').modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Pelanggan berhasil disimpan", "Berhasil");
                        data_pelanggan();
                        $('.clear_member').val('');
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
    
    
    var data_produksi = function(){
        $('#tabel_tambah_order_sales').hide();
        $.ajax({ 
            url: base_url + 'order_sales/data_produk',
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
                        img = '<div style="width:100%;text-align:center"><img src="assets/img/noimages.jpg" style="width:80px;height:80px"></div>';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].img+'" style="width:150px;height:150px"></div>';
                    }
                    
                    var input_request = '<input type="hidden" class="form-control" style="width:60px" name="kode_produk_header[]" value='+result[i].kode_produk_header+'>'
                        input_request += '<input type="hidden" class="form-control" style="width:60px" name="id_gambar[]" value='+result[i].id_gambar+'>'
                        input_request += '<input type="hidden" class="form-control" style="width:60px" name="harga_'+result[i].kode_produk_header+'" id="harga_'+result[i].kode_produk_header+'" value='+result[i].harga+'>'
                        input_request += '<input type="number" class="form-control" style="width:40px" name="qty_'+result[i].kode_produk_header+'" min="1" value="1" id="qty_'+result[i].kode_produk_header+'">';
                        var catatan = '<textarea rows="4" class="clears" cols="4" id="catatan_'+result[i].kode_produk_header+'"></textarea>';
                    
                    var btn_order = "<a href='javascript:void(0)' onclick=\"inputs_order('"+result[i].kode_produk_header+"','"+id_order_sales+"');\"><div class='btn btn-info btn-sm' title='Order'> Order</div></a>";  
                    
                    data.push([img,result[i].nama_produk,result[i].stok_akhir_allogio+' Pcs',result[i].stok_akhir_tanah_abang+' Pcs',input_request,catatan,btn_order]);
                   
                }
                $('#tabel_tambah_order_sales').DataTable({
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
                    }
                });
               
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            complete: function () {
                loadingPannel.hide();
                $('#tabel_tambah_order_sales').show();
            }
        });
    }
    data_produksi();
    
    inputs_order = function(kd_produk_header,no_order_sales){
        var qty = $("#qty_"+kd_produk_header).val();
        var catatan = $("#catatan_"+kd_produk_header).val();
        var harga = $("#harga_"+kd_produk_header).val();
        
        $.ajax({
                url       : base_url + 'order_sales/simpan',
                type      : "post",
                dataType  : 'json',
                data      : {qty    : qty,
                            catatan     : catatan,
                            kd_produk_header    : kd_produk_header,
                            no_order_sales    : no_order_sales,
                            harga:harga,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        //$('#exampleModal').modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Berhasil Ditambah ke Orderan List", "Berhasil");
                        $('.clears').val('');
                        $("#qty_"+kd_produk_header).val(1);
                        data_order();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });
        
    }
    
    
    
    
    var data_order = function(){
        $('#tabel_order_list').hide();
        $.ajax({ 
            url: base_url + 'order_sales/data_produk_order',
            type: "post",
            data:{id_order_sales:id_order_sales,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                   
                   var no = i+1;
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '<div style="width:100%;text-align:center"><img src="assets/img/noimages.jpg" style="width:80px;height:80px"></div>';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].img+'" style="width:150px;height:150px"></div>';
                    }
                    
                    var btn_order = "<a href='javascript:void(0)' onclick=\"hapus_order('"+result[i].kode_produk_header+"','"+result[i].noos+"');\"><div class='btn btn-danger btn-sm' title='Order'> Batal</div></a>";  
                    
                    data.push([result[i].nama_produk,result[i].count_qty+' Pcs',result[i].count_berat,result[i].count_harga,btn_order]);
                   
                }
                $('#tabel_order_list').DataTable({
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
                    }
                });
               
            },
            beforeSend: function () {
                
            },
            complete: function () {
                $('#tabel_order_list').show();
            }
        });
    }
    data_order();
    
    hapus_order = function(kd_produk_header,no_order_sales){

        $.ajax({
                url       : base_url + 'order_sales/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {kd_produk_header    : kd_produk_header,
                            no_order_sales    : no_order_sales,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        //$('#exampleModal').modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Berhasil Dihapus", "Berhasil");
                        data_order();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });
        
    }
    
    
    $("#btnprint").html('<a href="'+baseurl+'order_sales/cetak_struk_dotmetrik_unpaid/'+id_order_sales+'" target="_blank"><div class="btn btn-success btn-sm" title="Print Invoice" ><i class="fa fa-print"></i> Print Order Sales (Unpaid)</div></a>');
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
});    

</script>
<style>
    .modal-lg{
        width:2000px;max-width: 90% !important;
    }
    
    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 450px;
        overflow-y: auto;
    }
    
</style>
<div class="modal fade" id="<?php echo $id_modal;?>" role="dialog" aria-labelledby="<?php echo $id_modal;?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal_utama" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">ORDER SALES NO. <span id="no_os_text" style="color:red"></span></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body modal_utama_body">
            <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Pelanggan</label>
                    <input type="hidden" id="no_os" name="no_os" class="form-control">
                    <select class="form-control list_member"  id="list_member" name="list_member"></select>
                    <small style="cursor:pointer" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus-circle"></i> Tambah Pelanggan Baru ?</small>
                </div>
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kategori Pemesanan</label>
                <br>
                    <input type="radio" class="kategori_pemesanan" name="kategori_pemesanan" value="1" id="grosir" /> Grosir  
                    <input type="radio" class="kategori_pemesanan" name="kategori_pemesanan" value="2" id="retail"/> Retail  
                </div>
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Ongkos Kirim</label>
                <input type="text" id="ongkos_kirim" name="ongkos_kirim" class="form-control maskmoney" style="width:200px">
                </div>
                
                
            </div> 
            </div>
            
            <div class="row">
                <div class="col-sm-8">
                    <table id="tabel_tambah_order_sales" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Stok Allogio</th>
                            <th>Stok Tanah Abang</th>
                            <th>Qty</th>
                            <th>Catatan</th>
                            <th>Order</th>
                        </tr>
                    </thead>
                    </table>
                </div>
                <div class="col-sm-4">
                    
                    <table id="tabel_order_list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Berat</th>
                            <th>Harga</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    </table>
                    <br>
                    <div id="btnprint"></div>
                </div>
            </div> 
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_update"><i class="fa fa-save"></i> Update</button>
            <button type="button" class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
            <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>



<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Pelanggan</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama_member" name="nama_member" class="form-control clear_member" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Email</label>
                    <input type="text" id="email_member" name="email_member" class="form-control clear_member">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">No Telp</label>
                    <input type="text" id="nohp_member" name="nohp_member" class="form-control clear_member">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Alamat</label>
                    <textarea name="alamat_member" id="alamat_member" class="form-control clear_member"></textarea>
                </div>
            </div> 
        </div>      
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-info" id="btn_simpan_member"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
      </div>
    </div>
    </div>
</div>
