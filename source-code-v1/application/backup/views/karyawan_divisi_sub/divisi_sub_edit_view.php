<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id         = '<?php echo $id_row;?>';
    $.ajax({
        type: 'POST',
        url: base_url + 'divisi_sub/divisi_sub_detail',
        data: {id:id,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        dataType  : 'json',
        success: function (data) {
            $("#id").val(data.id);
            $("#nama").val(data.nama);
            $("#cc").val(data.id_divisi);
            var id_divisi = data.id_divisi;
            $.ajax({
                type: 'POST',
                url: base_url + 'divisi/data_divisi',
                data: {},
                dataType  : 'json',
                success: function (data1) {
                    $('#divisi').empty();
                    var $kategori = $('#divisi');
                    $kategori.append('<option value=0>- Pilih Divisi -</option>')
                    for (var i = 0; i < data1.length; i++) {
                        if(id_divisi == data1[i].id){
                            $kategori.append('<option value=' + data1[i].id + ' selected>' + data1[i].nama + '</option>');
                        }else{
                            $kategori.append('<option value=' + data1[i].id + '>' + data1[i].nama + '</option>');
                        }
                        
                    }
                }
            });
        }
    });
    
    //agama
    
    
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Data Sub Divisi Baru ?",
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
                url       : base_url + 'divisi_sub/divisi_sub_update',
                type      : "post",
                dataType  : 'json',
                data      : {id             : $("#id").val(),
                            nama            : $("#nama").val(),
                            id_divisi       : $("#divisi").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data divisi berhasil disimpan", "Berhasil");
                        getcontents('divisi_sub','<?php echo $tokens;?>');
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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit divisi</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row"> 
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label for="demo-vs-definput" class="control-label"> Nama Divisi</label>
                        <select id="divisi" name="divisi" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="id" name="">
                        <label for="demo-vs-definput" class="control-label">Nama Divisi</label>
                        <input type="text" id="nama" name="nama" class="form-control" >
                    </div>
                </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



