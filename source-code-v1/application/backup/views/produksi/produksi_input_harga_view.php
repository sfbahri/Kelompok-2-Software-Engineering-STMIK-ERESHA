<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var status       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    get_produksi_mastera = function(){
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            $("#nama_produksi").val(res.nama);
            $("#tgl_mulais").val(res.tgl_mulai);
            $("#harga_modal").val(res.harga_modal);
            $("#harga_jual").val(res.harga_jual);
            $("#tot_estimasi_produk").val(res.jumlah_estimasi_produk);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_mastera();

    var hitung_modal = function(){
        
        $.ajax({ 
            url: base_url + 'produksi/get_all_biaya',
            type: "post",
            data:{kode_produksi   :kode_produksi,
                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                //semua biaya dan harga dalam 1 produksi
                var biaya_cutting    = result.biaya_cutting;
                var biaya_sewing     = result.biaya_sewing;
                var biaya_sablon     = result.biaya_sablon;
                var harga_aksesoris  = result.harga_aksesoris;
                var harga_bahan_baku = result.harga_bahan_baku;
                var jumlah_estimasi_produk = result.jumlah_estimasi_produk;
                var jumlah_finishing = result.jumlah_finishing;
                
                var totals_biaya = parseInt(biaya_cutting)+parseInt(biaya_sewing)+parseInt(biaya_sablon)+parseInt(harga_aksesoris)+parseInt(harga_bahan_baku);
                
                //kalo jumlah finishingnya masih kosong belum bisa melakukan perhitungan, defaultnya kosong
                if(result.jumlah_finishing == null){
                    $("#harga_jual").val(0);
                    $("#harga_jual_temp").val(0);
                }else{
                    var h_jual = parseInt(totals_biaya)/parseInt(jumlah_finishing)*(0.5);//50 / 100
                    $("#harga_jual").val(h_jual);
                    $("#harga_jual_temp").val(convertToRupiah(h_jual));
                }
                
                // harga modal 
                $("#harga_modal").val(totals_biaya);
                $("#harga_modal_temp").val(convertToRupiah(totals_biaya));
                
                //harga jual / hasil jadi finishing / pembulatan harga ke atas
                
                
                
                //$("#tot_aksesoris").val(result.tot_harga_aksesoris);
//
//                var harga_bb        = $("#tot_bahan_baku").val();
//                var harga_ac        = $("#tot_aksesoris").val();
//                var estimasi_produk = $("#tot_estimasi_produk").val();
//

                //var hasils = parseInt(harga_bb)+parseInt(harga_ac)/parseInt(estimasi_produk);

                //harga modals
                

                //harga jual
//                

            },
            beforeSend: function () {

            },
            complete: function () {

            }
        });
        
        
//        var js;
//        $.ajax({ 
//            url: base_url + 'bahan_baku/data_by_kode_produksi2',
//            type: "post",
//            data:{kode_produksi   :kode_produksi,
//                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//            dataType: "json",
//            async : 'false',
//            success: function(result)
//            {
//                $("#tot_bahan_baku").val(result.tot_harga_bahan_baku);
//                
//                $.ajax({ 
//                    url: base_url + 'aksesoris/data_by_kode_produksi2',
//                    type: "post",
//                    data:{kode_produksi   :kode_produksi,
//                          <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//                    dataType: "json",
//                    async : 'false',
//                    success: function(result)
//                    {
//                        $("#tot_aksesoris").val(result.tot_harga_aksesoris);
//                        
//                        var harga_bb        = $("#tot_bahan_baku").val();
//                        var harga_ac        = $("#tot_aksesoris").val();
//                        var estimasi_produk = $("#tot_estimasi_produk").val();
//                        
//                        
//                        var hasils = parseInt(harga_bb)+parseInt(harga_ac)/parseInt(estimasi_produk);
//                        
//                        //harga modals
//                        $("#harga_modal").val(hasils);
//                        $("#harga_modal_temp").val(convertToRupiah(hasils));
//                        
//                        //harga jual
//                        var hhh = parseInt(hasils)*(0.5);//50 / 100
//                        $("#harga_jual").val(hhh);
//                        $("#harga_jual_temp").val(convertToRupiah(hhh));
//          
//                    },
//                    beforeSend: function () {
//
//                    },
//                    complete: function () {
//
//                    }
//                });
//                
//                
//            },
//            beforeSend: function () {
//                
//            },
//            complete: function () {
//               
//            }
//        });
        
        
        
        
        
        
        
    }
    hitung_modal();
    
    
    
    var data_list_bahan_baku_harga = function(){
        
        $.ajax({ 
            url: base_url + 'bahan_baku/data_by_kode_produksi',
            type: "post",
            data:{kode_produksi   :kode_produksi,
                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                 $("#list_bahan_baku_harga").empty();
                 
                if(result.length == 0){
                    var html='';
                        html += "<tr><td colspan='4' align='center'> No data available in table </td></tr>";
                        $("#list_bahan_baku_harga").append(html);
                }else{
                   var data = [];
                    for ( var i=0 ; i<result.length ; i++ ) {
                    
                    var satuans;
                    if(result[i].satuan == 1){
                        satuans = 'Rol';
                    }else if(result[i].satuan == 2){
                        satuans = 'Kg';
                    }else if(result[i].satuan == 3){
                        satuans = 'Cm';
                    }else{
                        satuans = '-';
                    }
                    
                    var html='';
                        html += "<tr id='blok_non_formal"+result[i].id+"'>"
                        html += "<td>"+ result[i].nama + "</td>"
                        html += "<td>"+ result[i].jumlah + "</td>"
                        html += "<td>"+ satuans + "</td>"
                        html += "<td>"+ result[i].hargas + "</td>"
                        html += "</tr>";
                        $("#list_bahan_baku_harga").append(html);
                    } 
                } 
  
            },
            beforeSend: function () {
                
            },
            complete: function () {
               
            }
        });
    }
    data_list_bahan_baku_harga();
    
    
    
    var data_list_aksesoris_harga = function(){
        
        $.ajax({ 
            url: base_url + 'aksesoris/data_by_kode_produksi',
            type: "post",
            data:{kode_produksi   :kode_produksi,
                  <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                 $("#list_aksesoris_harga").empty();
                 
                if(result.length == 0){
                    var html='';
                        html += "<tr><td colspan='4' align='center'> No data available in table </td></tr>";
                        $("#list_aksesoris_harga").append(html);
                }else{
                   var data = [];
                    for ( var i=0 ; i<result.length ; i++ ) {
                    
                    var satuans;
                    if(result[i].satuan == 1){
                        satuans = 'Rol';
                    }else if(result[i].satuan == 2){
                        satuans = 'Kg';
                    }else if(result[i].satuan == 3){
                        satuans = 'Cm';
                    }else{
                        satuans = '-';
                    }
                    
                    var html='';
                        html += "<tr id='blok_non_formal"+result[i].id+"'>"
                        html += "<td>"+ result[i].nama + "</td>"
                        html += "<td>"+ result[i].jumlah + "</td>"
                        html += "<td>"+ satuans + "</td>"
                        html += "<td>"+ result[i].hargas + "</td>"
                        html += "</tr>";
                        $("#list_aksesoris_harga").append(html);
                    } 
                } 
  
            },
            beforeSend: function () {
                
            },
            complete: function () {
               
            }
        });
    }
    data_list_aksesoris_harga();
    
    
    $("#btn_simpan_harga").click(function(){
        
        swal({
            title: "Simpan Harga ?",
            text: "Silahkan periksa kembali harga yang ingin disimpan.",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Selesai",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){
            
            $.ajax({
                url       : base_url + 'produksi/update_harga',
                type      : "post",
                dataType  : 'json',
                data      : {harga_modal : $("#harga_modal").val(),harga_jual :$("#harga_jual").val() , kode_produksi:kode_produksi, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        $('#'+id_modal).modal('hide');
                        swal.close();
                        Command: toastr["success"]("Update Harga Berhasil", "Berhasil");
                        get_produksi_mastera();
                        getcontents('produksi/produksi_finance','<?php echo $tokens;?>');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
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
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  

.color_text{
    color:gray;
}

</style>


<input type="text" id="tot_bahan_baku" name="tot_bahan_baku" class="form-control" hidden="">
<input type="text" id="tot_aksesoris" name="tot_aksesoris" class="form-control" hidden="">
<input type="text" id="tot_estimasi_produk" name="tot_estimasi_produk" class="form-control" hidden="">


<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Harga Dasar | Kode Produksi : <b><?php echo $id_row;?></b></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Nama Produksi</label>
            <input type="text" id="nama_produksi" name="nama_produksi" class="form-control" readonly>
        </div> 
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Tgl Mulai</label>
            <input type="text" id="tgl_mulais" name="tgl_mulais" class="form-control" readonly>
        </div>
            
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Harga Modal</label>
            <input type="hidden" id="harga_modal" name="harga_modal" class="form-control" readonly>
            <input type="text" id="harga_modal_temp" name="harga_modal_temp" class="form-control" readonly>
            
        </div> 
            
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Harga Jual</label>
            <input type="hidden" id="harga_jual" name="harga_jual" class="form-control" readonly>
            <input type="text" id="harga_jual_temp" name="harga_jual_temp" class="form-control" readonly>
            
        </div> 
            
        <div class="card">
            <div class="card-header tx-medium bd-0 tx-white bg-info">Bahan Baku Yang Dipakai</div>
            <div class="card-content table-responsive">

                <table class="table table-de mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah dipakai</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="list_bahan_baku_harga"></tbody>
                </table>

                </div>
            </div>   
            
            <br>   
        <div class="card">
        <div class="card-header tx-medium bd-0 tx-white bg-info">Aksesoris Yang Dipakai</div>
        <div class="card-content table-responsive">
            
            <table class="table table-de mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah dipakai</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody id="list_aksesoris_harga"></tbody>
            </table>

            </div>
        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan_harga" ><i class="fa fa-save"></i> Simpan Harga</button>
          <button type="button" class="btn btn-danger btn-clear" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

<!--
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

     Modal content
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Input Harga Dasar | Kode Produksi : <b><?php echo $id_row;?></b></h4>
        </div>
        <div class="modal-body">
        
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Nama Produksi</label>
            <input type="text" id="nama_produksi" name="nama_produksi" class="form-control" readonly>
        </div> 
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Tgl Mulai</label>
            <input type="text" id="tgl_mulais" name="tgl_mulais" class="form-control" readonly>
        </div>
            
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Harga Modal</label>
            <input type="text" id="harga_modal" name="harga_modal" class="form-control" readonly>
        </div> 
            
        <div class="form-group">
            <label for="demo-vs-definput" class="control-label">Harga Jual</label>
            <input type="text" id="harga_jual" name="harga_jual" class="form-control" readonly>
        </div> 
            
        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Bahan Baku Yang Dipakai</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content table-responsive">

                <table class="table table-de mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah dipakai</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="list_bahan_baku_harga"></tbody>
                </table>

                </div>
            </div>   
            
            
        <div class="card">
        <div class="card-header">
          <h4 class="card-title">Aksesoris Yang Dipakai</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content table-responsive">
            
            <table class="table table-de mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah dipakai</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody id="list_aksesoris_harga"></tbody>
            </table>

            </div>
        </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan_harga" ><i class="ft-check"></i> Simpan Harga</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>
-->

