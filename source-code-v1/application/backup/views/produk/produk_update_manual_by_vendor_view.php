<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_produk   = '<?php echo $id_row;?>';
    
    $.ajax({
            url       : base_url + 'produk/details',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk : id_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
             $("#nama").val(response.nama);
             $("#stok").val(response.stok);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    
    
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
   
    $("#btn_simpan_produksi").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Produk Manual By Vendor ?",
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
                url             : base_url + 'produk/update_manual_by_vendor', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success         : function(response){
          
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Produk berhasil disimpan", "Berhasil");
                        getcontents('produk','<?php echo $tokens;?>');
                    } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
        
    });
   
    
    $.ajax({
        type: 'POST',
        url: base_url + 'warna/data_select',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('.select_warna').empty();
            var $jenis_wilayah = $('.select_warna');
            $jenis_wilayah.append('<option value=0>- Pilih Warna -</option>');
            for (var i = 0; i < data.length; i++) {
                $jenis_wilayah.append('<option value=' + data[i].id + '>' + data[i].inisial + ' - ' + data[i].nama + '</option>');
            }
            
            $(".select_warna").chosen({width: "100%"});
        }
    });
   
   
    $('#tanggal_mulai').datepicker();
    
    
});    

</script>
<style>
    .modal-lg{
        width:1200px;max-width: 70% !important;
    }
</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
      
    <?php 

        $token = "";
        $codeAlphabet = "33434343556789934343434567812345667980909";
        $codeAlphabet.= "54979319491320389885589989898989867733333";
        $codeAlphabet.= "87326484602476248762342t48723487623472868";
        $codeAlphabet.= "87987498222249833598969897985203254564555";
        $codeAlphabet.= "98710912873698173621386776342498238178187";
        $codeAlphabet.= "48375683765837659234713791873987391987239";
        $codeAlphabet.= "0123456789";

        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < 5; $i++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        } 

        $today = date("Ymd");
        $kd_produksi = $token.$today;
        
        
        
        
        //ini kode random untuk token
            $tokensss = "";
            $codeAlphabet2.= "87326484602476248762342t48723487623472868";
            $codeAlphabet2.= "87987498222249833598969897985203254564555";
            $codeAlphabet2.= "0123456789";
            $maxs = strlen($codeAlphabet2) - 1;
            for ($i=0; $i < 5; $i++) {
                $tokensss .= $codeAlphabet2[mt_rand(0, $maxs)];
            } 
            
            $kd_produk = $tokensss.$today;
        //ini kode random untuk token
        
        
    ?>  
      
      
    <!-- Modal content-->
    <div class="modal-content ">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Produk Manual By Vendor</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Produk</label>
                <input type="text" id="kode_utama" name="kode_utama" class="form-control" value="<?php echo $id_row;?>" readonly>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Produk</label>
                <input type="text" id="nama" name="nama" class="form-control" readonly>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Stok (Pcs)</label>
                <input type="text" id="stok" name="stok" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Harga Modal</label>
                <input type="text" id="harga_modal" name="harga_modal" class="form-control maskmoney">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Harga Jual</label>
                <input type="text" id="harga_jual" name="harga_jual" class="form-control maskmoney">
                </div>
                
                <div class="col-md-12" style="margin:0px">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Berat Ukuran S</label>
                            <input type="text" value="0.15" readonly id="berat_s" name="berat_s" class="form-control" placeholder="Berat S">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Berat Ukuran M</label>
                            <input type="text" value="0.15" readonly id="berat_m" name="berat_m" class="form-control" placeholder="Berat M">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="demo-vs-definput" class="control-label">Berat Ukuran L</label>
                            <input type="text" value="0.15" readonly id="berat_l" name="berat_l" class="form-control" placeholder="Berat L">
                        </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(S) Warna 1</label>
                          <select class="form-control select_warna"  id="small_warna_1_inisial" name="small_warna_1_inisial"></select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date2">Jumlah W1  :</label>
                            <input type="text" id="small_warna_1_jumlah" onkeypress="return isNumber(event)" name="small_warna_1_jumlah" class="form-control small_warna_1_jumlah" placeholder="Jumlah">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(S) Warna 2</label>
                          <select class="form-control select_warna"  id="small_warna_2_inisial" name="small_warna_2_inisial"></select>
<!--                          <input type="text" id="small_warna_2_inisial" name="small_warna_2_inisial" class="form-control small_warna_2_inisial select_warna" maxlength="6">-->
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W2 :</label>
                              <input type="text" id="small_warna_2_jumlah" onkeypress="return isNumber(event)" name="small_warna_2_jumlah" class="form-control small_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(S) Warna 3</label>
                          <select class="form-control select_warna"  id="small_warna_3_inisial" name="small_warna_3_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W3 :</label>
                              <input type="text" id="small_warna_3_jumlah" onkeypress="return isNumber(event)" name="small_warna_3_jumlah" class="form-control small_warna_3_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>    
                    
              </div>

                <hr>
                
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(M) Warna 1</label>
                          <select class="form-control select_warna"  id="medium_warna_1_inisial" name="medium_warna_1_inisial"></select>
                       </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W1 :</label>
                              <input type="text" id="medium_warna_1_jumlah" onkeypress="return isNumber(event)" name="medium_warna_1_jumlah" class="form-control medium_warna_1_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(M) Warna 2</label>
                          <select class="form-control select_warna"  id="medium_warna_2_inisial" name="medium_warna_2_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W2 :</label>
                              <input type="text" id="medium_warna_2_jumlah" onkeypress="return isNumber(event)" name="medium_warna_2_jumlah" class="form-control medium_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(M) Warna 3</label>
                          <select class="form-control select_warna"  id="medium_warna_3_inisial" name="medium_warna_3_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W3 :</label>
                              <input type="text" id="medium_warna_3_jumlah" onkeypress="return isNumber(event)" name="medium_warna_3_jumlah" class="form-control medium_warna_3_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>    
                    
              </div>  
                
                
                <hr> 
                
              <div class="row">
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(L) Warna 1</label>
                         <select class="form-control select_warna"  id="large_warna_1_inisial" name="large_warna_1_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W1 :</label>
                              <input type="text" id="large_warna_1_jumlah" name="large_warna_1_jumlah" class="form-control large_warna_1_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(L) Warna 2</label>
                          <select class="form-control select_warna"  id="large_warna_2_inisial" name="large_warna_2_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W2 :</label>
                              <input type="text" id="large_warna_2_jumlah" name="large_warna_2_jumlah" class="form-control large_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-8">
                          <label for="demo-vs-definput" class="control-label">(L) Warna 3</label>
                          <select class="form-control select_warna"  id="large_warna_3_inisial" name="large_warna_3_inisial"></select>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="date2">Jumlah W3 :</label>
                              <input type="text" id="large_warna_3_jumlah" name="large_warna_3_jumlah" class="form-control large_warna_3_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
              </div>
                
                
                
            </div>  
        </form>   
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_simpan_produksi"><i class="ft-save"></i> Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
    </div>
    </div>

  </div>
</div>



