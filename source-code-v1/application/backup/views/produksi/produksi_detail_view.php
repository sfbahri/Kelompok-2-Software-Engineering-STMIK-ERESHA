<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var status       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    
    $('.steps-item-class').removeClass('current');
    $('.steps-form').css('display','none');
    
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
            reload_steps(res.status);
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
    
    $("button").attr("aria-expanded","true");
    
    
    $(".icons-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        //transitionEffect: "fade",
        setStep :"4",
        titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert('Status 5')
        },
        onStepChanged: function(event, currentIndex, priorIndex)
        {
            $('.actions').remove();
            if(currentIndex == 1){
                alert('Status 1')
            }else if(currentIndex == 2){
                alert('Status 2')
            }else if(currentIndex == 3){
                alert('Status 3')
            }else if(currentIndex == 4){
                alert('Status 4')
            }
//            alert('On step changed'); // you can see the step change was picked up
//            var current = $("#steps").steps("getCurrentStep"); // get the current step            
//            if(current.title == "My Step Two") // see if it matches the name of the step
//                alert('Step two was selected');
        },
        onInit: function (event, current) {
        //$('.actions').attr('style', 'display:none');
        $('.actions').remove();
        },
//        onStepChanged: function (event, current, next) {
////            if (current > 0) {
////                $('.actions > ul > li:first-child').attr('style', '');
////            } else {
////                $('.actions > ul > li:first-child').attr('style', 'display:none');
////            }
//        },
        labels: {
            finish: 'Selesai <i class="fa fa-chevron-right"></i>',
            next: 'Selanjutnya <i class="fa fa-chevron-right"></i>',
            previous: '<i class="fa fa-chevron-left"></i> Sebelumnya'
        }
    });
    
    var  list = document.querySelectorAll(".steps li");

    for (var i = 0; i < list.length; i++) {
      var li = list[i];
      var no = i + 1;
      li.id = 'steps-item-'+no+'';
      $('#steps-item-'+i).addClass('steps-item-class');
      $('.steps-form').css('display','none');
    }
    
    
    $("#reloads").click(function(){
        $('.steps-form').css('display','none');
        $('.icons-tab-steps').hide();
        $('#steps-loading').show();
        //$('#'+id_modal).modal('hide');
        reload_steps(2);
        //getpopup('produksi/detail','<?php echo $tokens;?>','popupedit','<?php echo $id_row;?>','<?php echo $id_row2;?>')
        setTimeout(function(){ 
            $('.icons-tab-steps').show();
            $('#steps-loading').hide();
        }, 2000);
    });
    
    reload_steps = function(steps_active){
        
        //ini untuk menghapus stesp class yang mempunyai class current dan done, dihapus dulu, baru dibawah direload kembali
        $('.steps-item-class').removeClass('current');
        $('.steps-item-class').removeClass('done');
        //$('.steps-form').css('display','none');
        
        //alert(steps_active)
        if(steps_active == 0){
            $('#steps-item-1').addClass('current'); //stesp 1
            $('#steps-item-2').addClass('');        //stesp 2
            $('#steps-item-3').addClass('');        //stesp 3
            $('#steps-item-4').addClass('');        //stesp 4
            $('#steps-item-5').addClass('');        //stesp 5
        }else if(steps_active == 1){
            $('#steps-item-1').addClass('done');    //stesp 1
            $('#steps-item-2').addClass('current'); //stesp 2
            $('#steps-item-3').addClass('');        //stesp 3
            $('#steps-item-4').addClass('');        //stesp 4
            $('#steps-item-5').addClass('');        //stesp 5
        }else if(steps_active == 2){
            $('#steps-item-1').addClass('done');    //stesp 1
            $('#steps-item-2').addClass('done');    //stesp 2
            $('#steps-item-3').addClass('current'); //stesp 3
            $('#steps-item-4').addClass('');        //stesp 4
            $('#steps-item-5').addClass('');        //stesp 5
        }else if(steps_active == 3){
            $('#steps-item-1').addClass('done');    //stesp 1
            $('#steps-item-2').addClass('done');    //stesp 2
            $('#steps-item-3').addClass('done');    //stesp 3
            $('#steps-item-4').addClass('current'); //stesp 4
            $('#steps-item-5').addClass('');        //stesp 5
        }else if(steps_active == 4){
            $('#steps-item-1').addClass('done');    //stesp 1
            $('#steps-item-2').addClass('done');    //stesp 2
            $('#steps-item-3').addClass('done');    //stesp 3
            $('#steps-item-4').addClass('done');    //stesp 4
            $('#steps-item-5').addClass('current'); //stesp 5
        }else if(steps_active == 5){
            $('#steps-item-1').addClass('done');    //stesp 1
            $('#steps-item-2').addClass('done');    //stesp 2
            $('#steps-item-3').addClass('done');    //stesp 3
            $('#steps-item-4').addClass('done');    //stesp 4
            $('#steps-item-5').addClass('done');    //stesp 5
        }

        //status 1 (1 done, 2 current)
        //status 2 (1 done, 2 done, 3 current)
        //status 3 (1 done, 2 done, 3 done, 4 current)
        //status 4 (1 done, 2 done, 3 done, 4 done, 5 current)
        //status 5 (1 done, 2 done, 3 done, 4 done, 5 done)

        if(steps_active == 5){
            $('.steps-form-5').show();
            $('.finish_bro').remove();
        }else{
            var sss = parseInt(steps_active)+parseInt(1);
            $('.steps-form-'+sss).show();
        }
        
    }
    
    
    $(".steps").attr('href', '').css({'cursor': 'pointer', 'pointer-events' : 'none'});


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

<div class="modal fade" id="<?php echo $id_modal;?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Proses Produksi | Kode Produksi : <b><?php echo $id_row;?></b></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <div class="text-center" id="steps-loading" style="display:none">
                <i class="fa fa-spinner fa-spin" style="font-size:80px"></i><br>
                Mohon Tunggu ...
            </div>
            
                    <div class="icons-tab-steps wizard-circle" id="rumahsteps">
                        
                       <!--Step 1--> 
                      <h6> Cutting </h6>
                      <fieldset class="steps-form-1 steps-form">
                      <?php include "produksi_cutting_view.php";?>
                      </fieldset>
                      <!--Step 1-->  
                      
                       <!--Step 2--> 
                      <h6> Sablon </h6>
                      <fieldset class="steps-form-2 steps-form">
                      <?php include "produksi_sablon_view.php";?>
                      </fieldset>
                       <!--Step 2-->  
                      
                       <!--Step 3--> 
                      <h6> Aksesoris </h6>
                      <fieldset class="steps-form-3 steps-form">
                      <?php include "produksi_aksesoris_view.php";?>
                      </fieldset>
                       <!--Step 3-->  
                      
                       <!--Step 4-->  
                      <h6> Sewing </h6>
                      <fieldset class="steps-form-4 steps-form">
                      <?php include "produksi_sewing_view.php";?>
                      </fieldset>
                       <!--Step 4-->  
                      
                       <!--Step 5-->  
                      <h6> Finishing </h6>
                      <fieldset class="steps-form-5 steps-form">
                      <?php include "produksi_finishing_view.php";?>
                      </fieldset>
                       <!--Step 5-->  
                      
                    </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan2" hidden=""><i class="ft-check"></i> Sudah Di Publish</button>
            <button type="button" class="btn btn-info" id="btn_publish" style="display:none"><i class="la la-check-square-o"></i> Publish Ke Produksi</button>
<!--            <button type="button" class="btn btn-success" id="reloads"><i class="ft-refresh-cw"></i> Reload</button>-->
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

