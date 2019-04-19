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
            $("#nama").text(data.nama);
        }
    });


    var data_rute_kloter = function(){
        
        $.ajax({ 
            url: base_url + 'kloter/kloter_rute_data',
            type: "post",
            data:{id_kloter:id_kloter,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var baseurl = '<?php echo base_url();?>';
                    
                    var link_edit = "<a href='javascript:void(0)' onclick=\"detail_kloter_rute('"+result[i].id_kloter+"','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Akses' ><i class='fa fa-pencil'></i></div></a>";    
                    var link_hapus = "<a href='javascript:void(0)' onclick=\"hapus_kloter_rute('"+result[i].id_kloter+"','"+result[i].id+"');\"><div class='btn btn-danger btn-sm' title='Hapus' ><i class='fa fa-trash'></i></div></a>";
                    
                    data.push([no,result[i].dari,result[i].ke,result[i].jam,link_edit,link_hapus]);

                }
                $('#tabel_kloter_rute').DataTable({
                    //"bJQueryUI"     : true,
                    data                : data,
                    deferRender         : true,
                    processing          : true,
                    ordering            : true,
                    retrieve            : false,
                    paging              : true,
                    deferLoading        : 57,
                    bDestroy            : true,
                    autoWidth           : false,
                    bFilter             : true,
                    iDisplayLength      : 10,
                    responsive: true,
                    language: {
                      searchPlaceholder: 'Cari',
                      sSearch: '',
                      lengthMenu: '_MENU_',
                    },
                });
               
            },
            beforeSend: function () {

            },
            complete: function () {
                $('#tabel_kloter_rute').show();
            }
        });
    }
    data_rute_kloter();

    detail_kloter_rute = function(id_kloter,id_rute){
        
        $.ajax({
            type: 'POST',
            url: base_url + 'kloter/kloter_rute_detail',
            data: {id_kloter:id_kloter,id_rute:id_rute,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (data) {
                $("#dari").val(data.dari);
                $("#kemana").val(data.ke);
                $("#jam").val(data.jam);
                $("#idrute").val(data.id);
                
                $("#btn_simpan").hide();
                $("#btn_simpan2").show();
            }
        });
        
    }
    
    hapus_kloter_rute = function(id_kloter,id_rute){
        
         swal({
            title: "Hapus Rute ?",
            text: "Jika ingin dihapus, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
           confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
            //confirmButtonColor: "#E73D4A"
        },
        function(){
        
        $.ajax({
            type: 'POST',
            url: base_url + 'kloter/hapus_rute',
            data: {id_kloter:id_kloter,id_rute:id_rute,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType  : 'json',
            success: function (response) {
                if(response == true){
                        data_rute_kloter();   
                        swal.close();
                        Command: toastr["success"]("Data Rute berhasil dihapus", "Berhasil");
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            }
        });
        
        });
        
    }
    

    $("#btn_simpan").click(function(){
        swal({
            title: "Simpan Rute ?",
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
                url       : base_url + 'kloter/simpan_rute',
                type      : "post",
                dataType  : 'json',
                data      : {dari  :$("#dari").val(),
                            kemana :$("#kemana").val(),
                            jam    :$("#jam").val(),
                            id_kloter     :id_kloter,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        data_rute_kloter();   
                        swal.close();
                        Command: toastr["success"]("Data Rute berhasil disimpan", "Berhasil");
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
    
    $("#btn_simpan2").click(function(){
        swal({
            title: "Update Rute ?",
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
                data      : {dari  :$("#dari").val(),
                            kemana :$("#kemana").val(),
                            jam    :$("#jam").val(),
                            id_kloter     :id_kloter,
                            idrute     :$("#idrute").val(),
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){
                        swal.close();
                        Command: toastr["success"]("Data Rute berhasil disimpan", "Berhasil");
                        data_rute_kloter();   
                        
                        $('.clear_edit_rute').val('');
                        
                        
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
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Kloter Rute <span id="nama"></span></h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
          <div class="row">  
            <div class="col-md-3" style="padding-right:0px">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Dari</label>
                <input type="text" id="dari" name="dari" class="form-control clear_edit_rute" placeholder="Dari Mana ?">
                <input type="hidden" id="idrute" name="idrute" class="form-control clear_edit_rute">
                </div>
            </div>
              <div class="col-md-3" style="padding-right:0px">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Ke</label>
                    <input type="text" id="kemana" name="kemana" class="form-control clear_edit_rute" placeholder="Ke Mana ?">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Jam</label>
                    <input type="text" id="jam" name="jam" class="form-control clear_edit_rute" placeholder="00:00">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <div style="padding-top:30px"></div>
                    <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i></button>
                    <button type="button" class="btn btn-success" id="btn_simpan2" style="display:none"><i class="fa fa-save"></i></button>
                </div>
            </div>
              
              
            
        </div>
          <hr>
          <div class="table-wrapper table-responsive">
            <table id="tabel_kloter_rute" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Dari</th>
                        <th>Ke</th>
                        <th>Jam</th>
                        <th>Edit</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
            </table>
            <br>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



