<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
   
   
    $("#btn_simpan_produksi").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Simpan Produksi Manual ?",
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
                url             : base_url + 'produksi/simpan_manual', 
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
    
    
});    

</script>

<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
      
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
            <h4 class="modal-title">Tambah Produksi Manual</h4>
      </div>
      <div class="modal-body">
        <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <div class="row">  
            <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Produksi</label>
                <input type="text" id="kode" name="kode" class="form-control" readonly="" value="<?php echo $kd_produksi;?>">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Nama Produksi</label>
                    <input type="text" id="nama" name="nama" class="form-control">
                </div>
                <div class="form-group">
                    <label for="timesheetinput3">Tanggal Mulai</label>
                    <div class="position-relative has-icon-left">
                        <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        <div class="form-control-position">
                              <i class="ft-calendar"></i>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Harga Modal</label>
                    <input type="text" id="harga_modal" name="harga_modal" class="form-control">
                </div>
                <div class="form-group">
                    <label for="demo-vs-definput" class="control-label">Harga Jual</label>
                    <input type="text" id="harga_jual" name="harga_jual" class="form-control">
                </div>
            </div>  
        </form>   
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-info" id="btn_simpan_produksi"><i class="ft-save"></i> Simpan</button>
        <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
    </div>
    </div>

  </div>
</div>



