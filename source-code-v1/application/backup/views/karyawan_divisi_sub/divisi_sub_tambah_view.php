<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    
    
    
    //Divisi
    $.ajax({
        type: 'POST',
        url: base_url + 'divisi/data_divisi',
        data: {},
        dataType  : 'json',
        success: function (data) {
            $('#divisi').empty();
            var $kategori = $('#divisi');
            $kategori.append('<option value=0>- Pilih Divisi -</option>')
            for (var i = 0; i < data.length; i++) {
                $kategori.append('<option value=' + data[i].id + '>' + data[i].nama + '</option>');
            }
            
            $("#divisi").chosen({width: "100%"});
        }
    });

    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Sub Divisi Baru ?",
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
                url       : base_url + 'divisi_sub/divisi_sub_simpan',
                type      : "post",
                dataType  : 'json',
                data      : {
                            nama          : $("#nama").val(),
                            id_divisi        : $("#divisi").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Data sub divisi berhasil disimpan", "Berhasil");
                        getcontents('divisi_sub','<?php echo $tokens;?>');
                }else{
                    Command: toastr["error"](response, "Error");
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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Tambah Divisi</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <input type="hidden" id="username" name="username" readonly="" class="form-control" value="<?php echo $id;?>">
          <input type="hidden" id="password" name="password" class="form-control" readonly="" value="<?php echo date('dms');?>">
          <div class="row"> 
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label"> Nama Divisi</label>
                        <select id="divisi" name="divisi" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="demo-vs-definput" class="control-label">Nama Sub Divisi</label>
                        <input type="text" id="nama" name="nama" class="form-control" >
                    </div>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
                    </div>
        </div>
    </div>
  </div>
</div>
</div>


