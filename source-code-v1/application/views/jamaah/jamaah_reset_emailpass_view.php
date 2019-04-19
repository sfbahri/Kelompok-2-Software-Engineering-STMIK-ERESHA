<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_jamaah   = '<?php echo $id_row;?>';
    var id_kloter   = '<?php echo $id_row2;?>';
    var tokens      = '<?php echo $tokens;?>';
    
    $("#id_klter").val(id_kloter);
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/detail',
        data: {id_jamaah:id_jamaah},
        dataType  : 'json',
        success: function (data) {
            
            $("#text_nama").text(data.nama);
            $("#text_no_paspor").text(data.paspor_no);
            $("#text_kode_jamaah").text(data.id);
            
            
            $("#nama").val(data.nama);
            $("#kode_jamaah").val(data.id);
            $("#no_paspor").val(data.paspor_no);
            $("#email").val(data.email);
        }
    });

    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Reset Email dan Password ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Submit",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url             : base_url + 'jamaah/reset_aksi', 
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
                        Command: toastr["success"]("Email dan Password Jamaah berhasil direset", "Berhasil");
                        getcontents('jamaah/by_kloter','<?php echo $tokens;?>',id_kloter);
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

    $("#tgl_lahir,#tgl_keluar_paspor,#tgl_exp_paspor").datepicker();
    
});    

</script>



<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Reset Password / Email</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="id_klter" name="id_klter" class="form-control" readonly="">
            
          <div class="row"> 
              
              
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Jamaah</label>
                <input type="text" id="kode_jamaah" name="kode_jamaah" class="form-control" readonly="">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" readonly="">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. Paspor</label>
                    <input type="text" id="no_paspor" name="no_paspor" class="form-control" readonly="">
                </div>
            </div>
        </div>
          </form>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-refresh"></i> Reset Sekarang !</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



