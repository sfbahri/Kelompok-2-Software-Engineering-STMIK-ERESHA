<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var no_so     = '<?php echo $id_rows;?>';
    
    
    $.ajax({
            type: 'POST',
            url: base_url + 'markom/design_gambar_produksi_detail',
            data: {noso:no_so,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (data) {
                $("#noso").val(data.noso);
                $("#tema").val(data.nama);
                $("#id").val(data.id);
                
                selects(data.noso);
            }
    });
    
    selects = function(no_so){
        $.ajax({
            type: 'POST',
            url: base_url + 'markom/select_noso_gambar',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (data) {
                for ( var i=0 ; i<data.length ; i++ ) {
                    
                    if(no_so == data[i].noso){
                        $("#noso").append('<option value="'+data[i].noso+'" selected>'+data[i].noso+'</option>');
                    }else{
                        $("#noso").append('<option value="'+data[i].noso+'">'+data[i].noso+'</option>');
                    }
                    
                    
                }
               $("#noso").chosen({width: "100%"});
            }
        });
    }
    
    
    $("#btn_simpan").click(function(){
        
        $.ajax({
            type: 'POST',
            url: base_url + 'markom/cek_no_so',
            data: {nopo:$("#nopo").val(),<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (data) {
                if(data == 1){
                    Command: toastr["error"]("No PO sudah ada, tidak bisa double !", "Error");
                }else{
                    swal({
                        title: "Simpan No. SO ?",
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
                            type: 'POST',
                            url: base_url + 'markom/design_gambar_update_so',
                            data: {noso:$("#noso").val(),id:$("#id").val(),tema:$("#tema").val(),<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                            dataType  : 'json',
                            success: function (data) {
                               if(data == true){
                                    $('#'+id_modal).modal('hide');   
                                    swal.close();
                                    Command: toastr["success"]("No SO Berhasil disimpan", "Berhasil");
                                    getcontents('markom/design_gambar_produksi','<?php echo $tokens;?>');
                                }
                            }
                        });
                    });
                }
            }
        });
        
    });
    //tambah
    
    
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit NO. SO</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">NO. SO</label>
                <select name="noso" id="noso" class="form-control"></select>
<!--                <input type="text" id="noso" name="noso" class="form-control" >-->
                <input type="hidden" id="id" name="id" class="form-control" >
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Tema Gambar</label>
                <input type="text" id="tema" name="tema" class="form-control" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



