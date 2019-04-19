<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
   
    $("#btn_simpan_produksi").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Produksi ?",
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
                url             : base_url + 'produksi/simpan', 
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
                        Command: toastr["success"]("Produksi berhasil disimpan", "Berhasil");
                        getcontents('produksi','<?php echo $tokens;?>');
                    } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
        
    });
   
   
   
   
    $('#tanggal_mulai').datepicker();
    
    
    function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#gambar").change(function() {
    readURL(this);
  });
    
    
    /*============BAHAN BAKU========================*/
    
    bahan_baku = function(){
        $.ajax({
            type: 'POST',
            url: base_url + 'bahan_baku/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#bahan_baku').empty();
                var $kategori = $('#bahan_baku');
                $kategori.append('<option value=0>- Pilih Bahan Baku -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].kode + '>' + data[i].nama + ' - ' + data[i].warna + '</option>');
                }
            }
        });
    }
    bahan_baku();
    
    $('#bahan_baku').change(function(){
        var kode = $(this).val();
        
        $.ajax({
            type: 'POST',
            url: base_url + 'bahan_baku/bahanbaku_detail',
            data: {kode_bahanbaku_detail:kode,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (res) {
                var satuan_bahanbaku;
                if(res.satuan == 1){
                    satuan_bahanbaku = 'Rol';
                }else if(res.satuan == 2){
                    satuan_bahanbaku = 'Kg';
                }else{
                    satuan_bahanbaku = 'Cm';
                }
                $("#satuan_bahan_baku").val(satuan_bahanbaku);
                $("#stok_bahan_baku").val(res.stok_akhir+' '+satuan_bahanbaku);
                $("#harga_bahan_baku").val(res.harga);
                
            }
        });
    });
    
    /*============BAHAN BAKU========================*/
    
    
    
    /// DINAMIS BAHAN BAKU ///
    
    //list sertifikasi Temp   
    var countbahanbaku = 0;
    var obj=[];
    
    $("#btn_simpanbahan_baku").click(function() { 

        
        //ini untuk menghapus row ketika edit
        //var idrows_temp = $("#idrows_sertifikasi_id").val();
        //$("#blok_non_formal"+ idrows_temp).remove();
        
        if($("#bahan_baku").val()== '0'){
           Command: toastr["info"]("Silahkan pilih nama bahan baku", "Info");
        }else if($("#jumlah_bahan_baku").val()== ''){
           Command: toastr["info"]("Silahkan masukan jumlah yang mau dipakai", "Info");
           $("#jumlah_bahan_baku").focus()
        }else{
            
            var html = "";          
            var objbb={
                "ROW_ID" : countbahanbaku,
                "BAHAN_BAKU_NAMA"   : $("#bahan_baku option:selected").text(),
                "BAHAN_BAKU_ID"     : $("#bahan_baku").val(),
                "BAHAN_BAKU_HARGA"  : $("#harga_bahan_baku").val(),
                "BAHAN_BAKU_SATUAN" : $("#satuan_bahan_baku").val(),
                "JUMLAH"            : $('#jumlah_bahan_baku').val(),
            }   
            

            //kosongkan field input peserta rapat
            $("#bahan_baku").val(0);
            $("#jumlah_bahan_baku").val('');
            $("#stok_bahan_baku").val('');
            $("#harga_bahan_baku").val('');
            $("#satuan_bahan_baku").val('');

            // add object
            obj.push(objbb);
                  
            countbahanbaku++;
            
            // dynamically create rows in the table     
            var html='';
                html += "<tr id='rowbb"+countbahanbaku+"'>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='bahan_baku_id"+countbahanbaku+"' name='bahan_baku_id[]'  value='"+objbb['BAHAN_BAKU_ID']+"'>"+ objbb['BAHAN_BAKU_NAMA'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='jumlah_bahan_baku"+countbahanbaku+"' name='jumlah_bahan_baku[]'  value='"+objbb['JUMLAH']+"'>"+ objbb['JUMLAH'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='satuan_bahan_baku"+countbahanbaku+"' name='satuan_bahan_baku[]'  value='"+objbb['BAHAN_BAKU_SATUAN']+"'>"+ objbb['BAHAN_BAKU_SATUAN'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='harga_bahan_baku"+countbahanbaku+"' name='harga_bahan_baku[]'  value='"+objbb['BAHAN_BAKU_HARGA']+"'>"+ objbb['BAHAN_BAKU_HARGA'] + "</td>"
                html += "<td align='center'><input id='rows_"+countbahanbaku+"' name='rows_bahanbaku[]' value='"+countbahanbaku+"' type='hidden'><i class='btn btn-danger la la-close btn-sm' id='btn_hapus_bahan_baku_temp_"+countbahanbaku+"' idbb= '"+countbahanbaku+"' style=';cursor:pointer;'></i></td>"
                html += "</tr>";
                $("#list_bahan_baku").append(html);
			
            // The remove button click
            $("#btn_hapus_bahan_baku_temp_"+countbahanbaku).click(function() {
              var buttonId = $(this).attr("idbb");
              //write the logic for removing from the array
              $("#rowbb"+ buttonId).remove();
             
            });
	
        }

    });
    
    
    
    /*========AKSESORIS=========*/
    
    get_select_aksesoris = function(){
        $.ajax({
            type: 'POST',
            url: base_url + 'aksesoris/data_select',
            data: {},
            dataType  : 'json',
            success: function (data) {
                $('#aksesoris').empty();
                var $kategori = $('#aksesoris');
                $kategori.append('<option value=0>- Pilih Aksesoris -</option>');
                for (var i = 0; i < data.length; i++) {
                    $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                }
            }
        });
    }
    get_select_aksesoris();
    
    $('#aksesoris').change(function(){
        var id = $(this).val();
        $('#img_preview_aksesoris').empty();
        $.ajax({
            type: 'POST',
            url: base_url + 'aksesoris/detail',
            data: {id_aksesoris:id,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (res) {
                var satuan_aksesoris;
                if(res.satuan == 1){
                    satuan_aksesoris = 'Pcs';
                }else{
                    satuan_aksesoris = 'Kg';
                }
                $("#satuan_aksesoris").val(satuan_aksesoris);
                $("#stok_aksesoris").val(res.stok_akhir+' '+satuan_aksesoris);
                $("#harga_aksesoris").val(res.harga);
                if(id == 0){
                    $("#prev_gambar").hide();
                }else{
                     $("#prev_gambar").show();
                }
               
                var gambar = '<div style="width:100%;text-align:center;margin:0px;padding:0px"><img src="uploads/aksesoris/rz_'+res.gambar+'" style="width:70px;height:70px"></div>';
                $("#img_preview_aksesoris").append(gambar);
            }
        });
    });
    
    
    var countaksesoris = 0;
    var obj=[];
    
    $("#btn_simpan_aksesoris").click(function() { 

        //ini untuk menghapus row ketika edit
        //var idrows_temp = $("#idrows_sertifikasi_id").val();
        //$("#blok_non_formal"+ idrows_temp).remove();
        
        if($("#aksesoris").val()== '0'){
           Command: toastr["info"]("Silahkan pilih aksesoris", "Info");
        }else if($("#jumlah_aksesoris").val()== ''){
           Command: toastr["info"]("Silahkan masukan jumlah yang mau dipakai", "Info");
           $("#jumlah_aksesoris").focus()
        }else{
            
            var html = "";          
            var objbb={
                "ROW_ID" : countaksesoris,
                "AKSESORIS_NAMA"    : $("#aksesoris option:selected").text(),
                "AKSESORIS_ID"      : $("#aksesoris").val(),
                "AKSESORIS_HARGA"   : $("#harga_aksesoris").val(),
                "AKSESORIS_SATUAN"  : $("#satuan_aksesoris").val(),
                "JUMLAH"            : $('#jumlah_aksesoris').val(),
            }   
            

            //kosongkan field input peserta rapat
            $("#aksesoris").val(0);
            $("#jumlah_aksesoris").val('');
            $("#stok_aksesoris").val('');
            $("#harga_aksesoris").val('');
            $("#satuan_aksesoris").val('');

            // add object
            obj.push(objbb);
                  
            countaksesoris++;
            
            // dynamically create rows in the table     
            var html='';
                html += "<tr id='rowbb"+countaksesoris+"'>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='aksesoris_id"+countaksesoris+"' name='aksesoris_id[]'  value='"+objbb['AKSESORIS_ID']+"'>"+ objbb['AKSESORIS_NAMA'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='jumlah_aksesoris"+countaksesoris+"' name='jumlah_aksesoris[]'  value='"+objbb['JUMLAH']+"'>"+ objbb['JUMLAH'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='satuan_aksesoris"+countaksesoris+"' name='satuan_aksesoris[]'  value='"+objbb['AKSESORIS_SATUAN']+"'>"+ objbb['AKSESORIS_SATUAN'] + "</td>"
                html += "<td><input type='hidden' style='background-color:#FFFFCC;' class='form-control' id='harga_aksesoris"+countaksesoris+"' name='harga_aksesoris[]'  value='"+objbb['AKSESORIS_HARGA']+"'>"+ objbb['AKSESORIS_HARGA'] + "</td>"
                html += "<td align='center'><input id='rows_"+countaksesoris+"' name='rows_aksesoris[]' value='"+countaksesoris+"' type='hidden'><i class='btn btn-danger la la-close btn-sm' id='btn_hapus_aksesoris_temp_"+countbahanbaku+"' idbb= '"+countbahanbaku+"' style=';cursor:pointer;'></i></td>"
                html += "</tr>";
                $("#list_aksesoris").append(html);
			
            // The remove button click
            $("#btn_hapus_aksesoris_temp_"+countaksesoris).click(function() {
              var buttonId = $(this).attr("idbb");
              //write the logic for removing from the array
              $("#rowbb"+ buttonId).remove();
             
            });
	
        }

    });
    
    
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
    ?>  
      
      
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Produksi</h4>
      </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="row">  
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Produksi</label>
                <input type="text" id="kode" name="kode" class="form-control" readonly="" value="<?php echo $kd_produksi;?>">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Produksi</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
            </div>  
              
        <div class="col-md-6">
            
            <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="timesheetinput3">Tanggal Mulai</label>
                            <div class="position-relative has-icon-left">
                                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                                <div class="form-control-position">
                                      <i class="ft-calendar"></i>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-6">
                    <label for="demo-vs-definput" class="control-label">Total Estimasi Produk</label>
                    <input type="text" id="estimasi_produk" name="estimasi_produk" class="form-control" placeholder="Masukan Jumlah" onkeypress="return isNumber(event)">
                </div>
            </div>
            
            <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Gambar Produksi</label>
                <input type="file" id="gambar" name="gambar" class="form-control">
<!--                <img id="blah" src="#" alt="Preview Gambar" style="width:150px;border:1px solid #B0B0B0;margin-top: 5px" />-->
            </div>
        </div>
          
        </div>
            
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Biaya Estimasi Produksi</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
            <div class="card-content">
                <div class="table-responsive">
                    <div class="row" style="margin:5px">
                        <div class="col-md-4" style="padding:2px">
                            <label for="ex1">Biaya Cutting</label>
                            <input class="form-control" id="biaya_cutting" name="biaya_cutting" type="text" onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-md-4" style="padding:2px;" id="prev_gambar">
                            <label for="ex1">Biaya Sablon</label>
                            <input class="form-control" id="biaya_sablon" name="biaya_sablon" type="text" onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-md-4" style="padding:2px">
                            <label for="ex1">Biaya Sewing</label>
                            <input class="form-control" id="biaya_sewing" name="biaya_sewing" type="text" onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>     
            
          
        <div class="row">
            <div class="col-md-12">
            <div class="card">
            <div class="card-header">
              <h4 class="card-title">Master Bahan Baku</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                <div class="row" style="margin:5px">
                    <div class="col-md-4" style="padding:1px">
                        <label for="ex1">Pilih Bahan Baku</label>
                        <select class="form-control" id="bahan_baku"></select>
                    </div>
                    <div class="col-md-2" style="padding:1px">
                        <label for="ex1">Stok</label>
                        <input class="form-control" id="stok_bahan_baku" type="text" readonly="">
                    </div>
                    <div class="col-md-2" style="padding:1px">
                        <label for="ex1">Jumlah Dipakai</label>
                        <input class="form-control" id="jumlah_bahan_baku" type="text" onkeypress="return isNumber(event)">
                        <input class="form-control" id="harga_bahan_baku" type="hidden" readonly="">
                        <input class="form-control" id="satuan_bahan_baku" type="hidden" readonly="">
                    </div>
                    <div class="col-md-1" style="padding:1px">
                        <div class="btn btn-success" id="btn_simpanbahan_baku" style="margin-top:27px" title="Simpan Bahan Baku"><i class="ft-save"></i></div>
                    </div>
                </div>
                    
                    
                <table class="table table-de mb-0">
                    <thead>
                        <tr>
                            <th>Nama Bahan Baku</th>
                            <th>Jumlah yang dipakai</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="list_bahan_baku"></tbody>
                </table>
                    
                </div>
            </div>
            </div>
            </div>
        </div> 
          
          
          
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Master Aksesoris</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                </div>
            <div class="card-content">
                <div class="table-responsive">
                    <div class="row" style="margin:5px">
                        <div class="col-md-4" style="padding:1px">
                            <label for="ex1">Pilih Aksesoris</label>
                            <select class="form-control" id="aksesoris"></select>
                        </div>
                        <div class="col-md-2" style="padding:1px;display:none" id="prev_gambar">
                            <label for="ex1">Gambar</label>
                            <div id="img_preview_aksesoris" style="margin:0px;padding:0px"></div>
                        </div>
                        <div class="col-md-2" style="padding:1px">
                            <label for="ex1">Stok</label>
                            <input class="form-control" id="stok_aksesoris" type="text" readonly="">
                            <input class="form-control" id="harga_aksesoris" type="hidden" readonly="">
                            <input class="form-control" id="satuan_aksesoris" type="hidden" readonly="">
                        </div>
                        <div class="col-md-2" style="padding:1px">
                            <label for="ex1">Jumlah dipakai</label>
                            <input class="form-control" id="jumlah_aksesoris" type="text" onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-md-1" style="padding:1px">
                            <div class="btn btn-success" id="btn_simpan_aksesoris" style="margin-top:27px" title="Simpan Aksesoris"><i class="ft-save"></i></div>
                        </div>
                    </div>
                    
                    <table class="table table-de mb-0">
                        <thead>
                            <tr>
                                <th>Nama Aksesoris</th>
                                <th>Jumlah yang dipakai</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list_aksesoris"></tbody>
                    </table>
                    
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



