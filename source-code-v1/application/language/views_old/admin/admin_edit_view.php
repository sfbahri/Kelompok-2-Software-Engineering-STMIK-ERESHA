<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_kloter   = '<?php echo $id_row;?>';
    var tokens           = '<?php echo $tokens;?>';
    
    $.ajax({
        type: 'POST',
        url: base_url + 'kloter/detail',
        data: {id_kloter:id_kloter},
        dataType  : 'json',
        success: function (data) {
            $("#nama").val(data.nama);
            $("#tgl_berangkat").val(data.tgl_berangkat);
            $("#tgl_pulang").val(data.tgl_pulang);
        }
    });


    $("#btn_simpan").click(function(){
        swal({
            title: "Update Data Kloter ?",
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
                url       : base_url + 'kloter/update_rute',
                type      : "post",
                dataType  : 'json',
                data      : {nama         :$("#nama").val(),
                            tgl_berangkat :$("#tgl_berangkat").val(),
                            tgl_pulang    :$("#tgl_pulang").val(),
                            id_kloter     :id_kloter,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data Kloter berhasil diupdate", "Berhasil");
                        getcontents('kloter','<?php echo $tokens;?>');
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
    
    $("#tgl_berangkat,#tgl_pulang").datepicker();
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Kloter</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Kloter</label>
                    <input type="text" id="nama" name="nama" class="form-control" onkeyup="myFunction()">
                </div>
              </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Berangkat</label>
                    <input type="text" id="tgl_berangkat" name="tgl_berangkat" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Pulang</label>
                    <input type="text" id="tgl_pulang" name="tgl_pulang" class="form-control" onkeyup="myFunction()">
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



