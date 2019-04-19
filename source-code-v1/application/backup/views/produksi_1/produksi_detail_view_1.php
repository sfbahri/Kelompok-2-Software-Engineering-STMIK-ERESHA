<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var status       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    get_produksi_master = function(){
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            $(".nav-link").removeClass("intro");
            $("#nama_produksi").val(res.nama);
            if(res.status == 1){
                $("#btn_selesai_cutting").remove();
                $("#base-tab11").addClass('active');
            }else if(res.status == 2){
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab12").addClass('active');
            }else if(res.status == 3){
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab13").addClass('active');
            }else if(res.status == 4){
                $("#btn_selesai_sewing").remove();
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab14").addClass('active');
            }else if(res.status == 5){
                $("#btn_selesai_finishing").remove();
                $("#btn_selesai_sewing").remove();
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab15").addClass('active');
            }else{
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_master();

    $('#tanggal').datepicker();
    
   
});    

</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  

.color_text{
    color:gray;
}

</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detail Produksi | Kode Produksi : <b><?php echo $id_row;?></b></h4>
        </div>
        <div class="modal-body">
           
            <ul class="nav nav-tabs nav-top-border no-hover-bg">
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab11" data-toggle="tab" aria-controls="tab11"
                           href="#tab11" aria-expanded="true"><i class="ft-edit-2 icon-bg-circle bg-grey-blue bg-darken-3"></i> Cutting</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab12" name="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12"
                        aria-expanded="false"><i class="ft-edit-2 icon-bg-circle bg-grey-blue bg-darken-3"></i> Sablon</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab13" data-toggle="tab" aria-controls="tab13" href="#tab13"
                        aria-expanded="false"><i class="ft-edit-2 icon-bg-circle bg-grey-blue bg-darken-3"></i> Aksesoris</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab14" data-toggle="tab" aria-controls="tab14" href="#tab14"
                        aria-expanded="false"><i class="ft-edit-2 icon-bg-circle bg-grey-blue bg-darken-3"></i> Sewing</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab15" data-toggle="tab" aria-controls="tab15" href="#tab15"
                        aria-expanded="false"><i class="ft-edit-2 icon-bg-circle bg-grey-blue bg-darken-3"></i> Finishing</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="base-tab16" data-toggle="tab" aria-controls="tab16" href="#tab16"
                        aria-expanded="false">L. Qrcode</a>
                      </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                          <?php include "produksi_cutting_view.php";?>
                        </div>
                        <div class="tab-pane" id="tab12" aria-labelledby="base-tab12">
                          <?php include "produksi_sablon_view.php";?>
                        </div>
                        <div class="tab-pane" id="tab13" aria-labelledby="base-tab13">
                          <?php include "produksi_aksesoris_view.php";?>
                        </div>
                        <div class="tab-pane" id="tab14" aria-labelledby="base-tab14">
                            <?php include "produksi_sewing_view.php";?>
                        </div>
                        <div class="tab-pane" id="tab15" aria-labelledby="base-tab15">
                            <?php include "produksi_finishing_view.php";?>
                        </div>
                        <div class="tab-pane" id="tab16" aria-labelledby="base-tab16">
                            <?php include "produksi_label_view.php";?>
                        </div>
                    </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan2" hidden=""><i class="ft-check"></i> Sudah Di Publish</button>
            <button type="button" class="btn btn-info" id="btn_publish" style="display:none"><i class="la la-check-square-o"></i> Publish Ke Produksi</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>


