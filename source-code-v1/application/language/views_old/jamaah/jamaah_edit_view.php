<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_jamaah   = '<?php echo $id_row;?>';
    var id_kloter   = '<?php echo $id_row2;?>';
    var tokens      = '<?php echo $tokens;?>';
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/detail',
        data: {id_jamaah:id_jamaah},
        dataType  : 'json',
        success: function (data) {
            
            $("#text_nama").text(data.nama);
            $("#text_no_paspor").text(data.paspor_no);
            $("#text_kode_jamaah").text(data.id);
            
            /*if(data.img_foto == '' || data.img_foto == null){
                $("#fotoku").html('<img src="'+base_url+'/assets/img/no-available.png" class="wd-100 rounded-circle" alt="">');
            }else{
                $("#fotoku").html('<img src="'+base_url+'/uploads/img_jamaah/'+data.img_foto+'" style="width: 130px;height: 160px;border: 1px solid grey;border-style: dashed;" >');
            }*/
            
            
             if(data.img_foto == '' || data.img_foto == null){
                $("#fotoku").html('<img src="'+base_url+'/assets/img/no-available.png" class="wd-100 rounded-circle" alt="">');
            }else{
                $("#fotoku").html('<img src="'+base_url+'/uploads/files/kloter_'+data.id_kloter+'/'+data.img_foto+'" style="width: 130px;height: 170px;border: 1px solid grey;border-style: dashed;" >');
            }
            
            
            $("#nama").val(data.nama);
            $("#kode_jamaah").val(data.id);
            $("#no_paspor").val(data.paspor_no);
            $("#kota_asal").val(data.kota_asal);
            $("#tempat_lahir").val(data.tempat_lahir);
            $("#tgl_lahir").val(data.tgl_lahir);
            $("#jenis_kelamin").val(data.jenis_kelamin);
            $("#email").val(data.email);
            $("#no_hp").val(data.no_telp);
            $("#pendidikan").val(data.pendidikan_terakhir);
            $("#no_ktp").val(data.no_ktp);
            $("#no_kk").val(data.no_kk);
            $("#agama").val(data.agama);
            $("#status").val(data.status);
            $("#pekerjaan").val(data.pekerjaan);
            $("#warga_negara").val(data.warga_negara);
            $("#pekerjaan").val(data.pekerjaan);
            $("#warga_negara").val(data.warga_negara);
            $("#tgl_keluar_paspor").val(data.paspor_tgl_keluar);
            $("#tgl_exp_paspor").val(data.paspor_tgl_exp);
            $("#kota_penerbit_paspor").val(data.paspor_kota_penerbit);
            $("#nama_ibu").val(data.nama_ibu);
            $("#nama_ayah").val(data.nama_ayah);
            $("#nama_kakek").val(data.nama_kakek);
            $("#berangkat_dengan_siapa").val(data.berangkat_sama_siapa);
            $("#alamat").val(data.alamat);
            var gambar = '<div style="width:100%;text-align:left"><img src="uploads/aksesoris/rz_'+response.gambar+'" style="width:100px;height:100px"></div>';
            $("#gambar_asli_view").append(gambar);
        }
    });

    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Data Jamaah ?",
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
                url             : base_url + 'jamaah/update', 
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
                        Command: toastr["success"]("Data Jamaah berhasil disimpan", "Berhasil");
                        getcontents('aksesoris','<?php echo $tokens;?>');
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
    
    
    

    $('.uppercase').keyup(function(event){
        this.value = this.value.toUpperCase();
    });


    
    
//    myFunction = function() {
////        var x = $('.uppercase').val();
////        x.value = x.value.toUpperCase();
//    }
    
    $("#tgl_lahir,#tgl_keluar_paspor,#tgl_exp_paspor").datepicker();
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Jamaah</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="gambar_asli" name="gambar_asli" class="form-control" readonly="">
            
          <div class="row"> 
              
              
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Jamaah</label>
                <input type="text" id="kode_jamaah" name="kode_jamaah" class="form-control" readonly="">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control uppercase">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Agama</label>
                    <select class="form-control" id="agama" name="agama">
                        <option value="0">-Pilih Agama-</option>
                        <option value="1"> ISLAM </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Pendidikan Terakhir</label>
                    <select class="form-control" id="pendidikan" name="pendidikan">
                        <option value="0">-Pilih Pendidikan-</option>
                        <option value="1"> SD </option>
                        <option value="2"> SMP </option>
                        <option value="3"> SMA </option>
                        <option value="4"> D3 </option>
                        <option value="5"> S1 </option>
                        <option value="6"> S2 </option>
                        <option value="7"> S3 </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Warga Negara</label>
                    <select class="form-control" id="warga_negara" name="warga_negara">
                        <option value="0">-Pilih Warga Negara-</option>
                        <option value="1"> WNI </option>
                        <option value="2"> WNA </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Expired Paspor</label>
                    <input type="text" id="tgl_exp_paspor" name="tgl_exp_paspor" class="form-control" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Ayah</label>
                    <input type="text" id="nama_ayah" name="nama_ayah" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Kakek</label>
                    <input type="text" id="nama_kakek" name="nama_kakek" class="form-control uppercase" onkeyup="myFunction()">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. PASPOR</label>
                    <input type="text" id="no_paspor" name="no_paspor" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                    <label for="sel1">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="0">-Pilih Jenis Kelamin-</option>
                        <option value="1"> Laki-Laki </option>
                        <option value="2"> Perempuan </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. KK</label>
                    <input type="text" id="no_kk" name="no_kk" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="0">-Pilih Status-</option>
                        <option value="1"> Belum Kawin </option>
                        <option value="2"> Kawin </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Keluar Paspor</label>
                    <input type="text" id="tgl_keluar_paspor" name="tgl_keluar_paspor" class="form-control">
                </div>
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kota Penerbit Paspor</label>
                    <input type="text" id="kota_penerbit_paspor" name="kota_penerbit_paspor" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Ibu</label>
                    <input type="text" id="nama_ibu" name="nama_ibu" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Berangkat Dengan Siapa</label>
                    <input type="text" id="berangkat_dengan_siapa" name="berangkat_dengan_siapa" class="form-control uppercase" onkeyup="myFunction()">
                </div>
            </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="comment">Kota Asal</label>
                    <input type="text" id="kota_asal" name="kota_asal" class="form-control uppercase" onkeyup="myFunction()">
                  </div>
                  <div class="form-group">
                    <label for="comment">Alamat Lengkap Tinggal</label>
                    <textarea class="form-control" rows="5" id="alamat" name="alamat"></textarea>
                  </div>
                  <div class="form-group">
                      
                    <label for="demo-vs-definput" class="control-label">Foto Saat Ini</label><br>
                    <div id="fotoku"></div>
                    </div>
                  <hr>
                <div class="form-group">
                      <div id="fotoku"></div>
                    <label for="demo-vs-definput" class="control-label">Ganti Foto</label><br>
                    <input type="file" id="gambar" name="gambar">
                </div>
                
              </div>
             
        </div>
          </form>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



