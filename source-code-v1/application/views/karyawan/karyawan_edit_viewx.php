<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var nik         = '<?php echo $id_row;?>';
    
    $.ajax({
        type: 'POST',
        url: base_url + 'karyawan/karyawan_detail',
        data: {nik:nik},
        dataType  : 'json',
        success: function (data) {
            $('#nik').val(data.nik);
            $("#nama").val(data.nama);
            $("#inisial").val(data.inisial);
            $("#tempat_lahir").val(data.tempat_lahir);
            $("#tgl_lahir").val(data.tanggal_lahir);
            $("#tgl_masuk").val(data.tgl_in);
            $("#email").val(data.email);
            $("#alamat").val(data.alamat);
            $("#no_hp").val(data.no_hp);
            $("#no_ktp").val(data.no_ktp);
            var idagama = data.agama;
            
            $.ajax({
                type: 'POST',
                url: base_url + 'agama/data_select',
                data: {},
                dataType  : 'json',
                success: function (data) {
                    $('#agama').empty();
                    var $kategori = $('#agama');
                    $kategori.append('<option value=0>- Pilih Agama -</option>')
                    for (var i = 0; i < data.length; i++) {
                        if(idagama == data[i].id){
                            $kategori.append('<option value=' + data[i].id + ' selected>' + data[i].nama + '</option>');
                        }else{
                            $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
                        }
                        
                    }
                    
                    


                    $("#agama").chosen({width: "100%"});    

//                    
//                    $('#agama').append('<option value="0">-Pilih Agama-</option>');
//                    for ( var i=0 ; i<data.length ; i++ ) {
//                        $('#agama').append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
//                    }

                    //$("#agama").chosen({width: "100%"});
                    
                }
            });
            
        }
    });
    
    //agama
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Data Karyawan Baru ?",
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
                url       : base_url + 'karyawan/karyawan_update',
                type      : "post",
                dataType  : 'json',
                data      : {nik          : $("#nik").val(),
                            nama          : $("#nama").val(),
                            inisial       : $("#inisial").val(),
                            tempat_lahir  : $("#tempat_lahir").val(),
                            tgl_lahir     : $("#tgl_lahir").val(),
                            tgl_masuk     : $("#tgl_masuk").val(),
                            email         : $("#email").val(),
                            alamat        : $("#alamat").val(),
                            no_hp         : $("#no_hp").val(),
                            no_ktp        : $("#no_ktp").val(),
                            agama        : $("#agama").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Karyawan berhasil disimpan", "Berhasil");
                        getcontents('hrd/karyawan','<?php echo $tokens;?>');
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
   
    //$('#biaya_asuransi').maskMoney();
    
    myFunction = function() {
        var x = document.getElementById("nama");
        x.value = x.value.toUpperCase();
    }
    
    $("#tgl_masuk,#tgl_lahir").datepicker();
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Karyawan</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">  
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">NIK</label>
                <input type="text" id="nik" name="nik" class="form-control" value="<?php echo $nik;?>" readonly="">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Inisial</label>
                <input type="text" id="inisial" name="inisial" class="form-control" placeholder="Tiga Huruf">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Masuk</label>
                    <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Lahir</label>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Agama</label>
                <select id="agama" name="agama" class="form-control"></select>
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Email <span style="color:red">*</span></label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
            </div>
        </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control"></textarea>
                    </div>
              </div>
          </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



