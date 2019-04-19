<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
    $('.maskmoney').maskMoney({thousands:',', decimal:'.', precision:0});
   
    $("#btn_simpan_produksi").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Produk Manual ?",
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
                url             : base_url + 'produk/simpan_manual_by_vendor', 
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
   
   
   
    select_vendor = function(id){
        $.ajax({
            url       : base_url + 'vendor/data_select',
            type      : "post",
            dataType  : 'json',
            data      : {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function (response) {
                    document.getElementById("vendor").innerHTML = "";
                    $('#vendor').append('<option value="0">- Pilih Vendor -</option>');
                    for ( var i=0 ; i<response.length ; i++ ) {
                        var ids = response[i].id;
                        if(id == ids){
                            $('#vendor').append('<option value="'+response[i].id+'" selected>'+response[i].nama+'</option>');
                        }else{
                            $('#vendor').append('<option value="'+response[i].id+'">'+response[i].nama+'</option>');
                        }
                        
                    }
                    
                    
                    $("#vendor").chosen({width: "100%"});
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }
        });
    }
    select_vendor();
   
   
    $('#tanggal_mulai').datepicker();
    
    
});    

</script>

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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Produk Manual</h6>
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
                <label for="demo-vs-definput" class="control-label">Kode Produksi</label>
                <input type="text" id="kode_produksi" name="kode_produksi" class="form-control" value="<?php echo $kd_produksi;?>" readonly>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Utama</label>
                <input type="text" id="kode_utama" name="kode_utama" class="form-control" value="<?php echo $kd_produk;?>" readonly>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Produk</label>
                <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Harga Modal</label>
                <input type="text" id="harga_modal" name="harga_modal" class="form-control maskmoney">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Harga Jual</label>
                <input type="text" id="harga_jual" name="harga_jual" class="form-control maskmoney">
                </div>
                <div class="form-group">
                    <label for="phoneNumber2">Vendor :</label>
                    <select name="vendor" id="vendor" class="form-control">
                        <option value="0">-Pilih Vendor-</option>
                    </select>
                </div>
                <div class="row">
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="small_warna_1_inisial" name="small_warna_1_inisial" class="form-control small_warna_1_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Small (S) Warna 1  :</label>
                              <input type="text" id="small_warna_1_jumlah" onkeypress="return isNumber(event)" name="small_warna_1_jumlah" class="form-control small_warna_1_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="small_warna_2_inisial" name="small_warna_2_inisial" class="form-control small_warna_2_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Small (S) Warna 2  :</label>
                              <input type="text" id="small_warna_2_jumlah" onkeypress="return isNumber(event)" name="small_warna_2_jumlah" class="form-control small_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="small_warna_3_jumlah" name="small_warna_3_inisial" class="form-control small_warna_3_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Small (S) Warna 3  :</label>
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
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="medium_warna_1_inisial" name="medium_warna_1_inisial" class="form-control medium_warna_1_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Medium (M) Warna 1  :</label>
                              <input type="text" id="medium_warna_1_jumlah" onkeypress="return isNumber(event)" name="medium_warna_1_jumlah" class="form-control medium_warna_1_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="medium_warna_2_inisial" name="medium_warna_2_inisial" class="form-control medium_warna_2_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Medium (M) Warna 2  :</label>
                              <input type="text" id="medium_warna_2_jumlah" onkeypress="return isNumber(event)" name="medium_warna_2_jumlah" class="form-control medium_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>  
                </div>
                <div class="col-md-4">

                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="medium_warna_3_jumlah" name="medium_warna_3_inisial" class="form-control medium_warna_3_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Medium (M) Warna 3  :</label>
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
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="large_warna_1_inisial" name="large_warna_1_inisial" class="form-control large_warna_1_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Large (L) Warna 1  :</label>
                              <input type="text" id="large_warna_1_jumlah" name="large_warna_1_jumlah" class="form-control large_warna_1_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="large_warna_2_inisial" name="large_warna_2_inisial" class="form-control large_warna_2_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Large (L) Warna 2  :</label>
                              <input type="text" id="large_warna_2_jumlah" name="large_warna_2_jumlah" class="form-control large_warna_2_jumlah" placeholder="Jumlah">
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                      <div class="col-md-4">
                          <label for="demo-vs-definput" class="control-label">INS. Warna</label>
                          <input type="text" id="large_warna_3_inisial" name="large_warna_3_inisial" class="form-control large_warna_3_inisial" maxlength="3">
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <label for="date2">Jumlah Large (L) Warna 3  :</label>
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



