<script type="text/javascript">
$(document).ready(function(){
    var tokens      = '<?php echo $tokens;?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var id_role    = '<?php echo $id_row;?>';
    
    $("#idrole").val(id_role);
    
    $.ajax({
        url       : base_url + 'role/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_role       : id_role,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
                $("#nama_role").val(res.nama);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan_role").click(function(){
        swal({
            title: "Update Role Akses ?",
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
            
            var form_data = new FormData($('#form_input')[0]);
            
            $.ajax({
                url       : base_url + 'role/role_akses_update', 
                type      : "POST",
                dataType  : 'json',
                mimeType  : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(data)
                {

                    if(data == true){
                        $('#'+id_modal).modal('hide');
                        swal.close();
                        Command: toastr["success"]("Role Akses  Berhasil Di Update", "Berhasil");
                        getcontents('role','<?php echo $tokens;?>');   
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    }
                }
            });

        });
        
    });

});    

</script>




<div id="<?php echo $id_modal;?>" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Role Permission</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                  
                  <form id="form_input" method=POST enctype='multipart/form-data'>
        <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" class="form-control" name="idrole" id="idrole">
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Role</label>
                <input type="text" id="nama_role" name="nama_role" class="form-control" readonly="">
                </div>
                
                <div class="panel panel-primary" style="width: 100%">
                    <div class="panel-heading">
                        <label for="demo-vs-definput" class="control-label">Akses Modul Permission</label>
                    </div>
                    <ul class="list-group">
                      
                        <div class="list-group" id="list1" >
                        <?php 
                        //header
                        foreach($modules as $a){
                            if($a['have_child'] == 'Y' && $a['position'] == '1'){
                                
                                // <--- Start Headmenu --->
                                $checked_1;
                                if($a['cbx'] == 1){
                                    $checked_1 = 'checked';
                                }else{
                                    $checked_1 = '';
                                }
                                
                                echo '<a href="javascript:void(0)" class="list-group-item list-group-item-info">'.$a[name].' <input title="toggle all" type="checkbox" value="'.$a['id_modules'].'" class="all pull-right" '.$checked_1.' name="cbx_module[]"></a>';
                                
                                // <--- End Headmenu --->
                                
                                    // <--- Start Submenu --->
                                    foreach($modules as $c){
                                        if($c['have_child'] == 'N' && $c['position'] == '2' && $c['parent'] == $a['id']){
                                            
                                            $checked_2;
                                            if($c['cbx'] == 1){
                                                $checked_2 = 'checked';
                                            }else{
                                                $checked_2 = '';
                                            }
                                            
                                            echo '<a href="javascript:void(0)" class="list-group-item list-group-item-default">'.$c['name'].' <input title="toggle all" type="checkbox" class="all pull-right" value="'.$c['id_modules'].'" '.$checked_2.' name="cbx_module[]"></a>';
                                        }
                                    }
                                    // <--- End Submenu --->
                            
                            }else if($a['have_child'] == 'N' && $a['position'] == '1'){
                                
                                // <--- Start Menu Single --->
                                $checked_3;
                                if($a['cbx'] == 1){
                                    $checked_3 = 'checked';
                                }else{
                                    $checked_3 = '';
                                }
                                
                                echo '<a href="javascript:void(0)" class="list-group-item list-group-item-success">'.$a['name'].' <input title="toggle all" type="checkbox" value="'.$a['id_modules'].'" class="all pull-right" '.$checked_3.' name="cbx_module[]"></a>';
                                // <--- End Menu Single --->
                            }  
                        }
                        ?>
                        </div>
                    </ul>
                </div>
              
            
      </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btn_simpan_role"><i class="fa fa-save"></i> Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->

