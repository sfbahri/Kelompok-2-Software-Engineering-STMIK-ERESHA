<script type="text/javascript">
$(document).ready(function(){
    var tokens      = '<?php echo $tokens;?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var user_nik    = '<?php echo $id_row;?>';
    
    $("#idusers").val(user_nik);
    
    $.ajax({
        url       : base_url + 'users/detail',
        type      : "post",
        dataType  : 'json',
        data      : {nik       : user_nik,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
                $("#nama").val(res.nama);
                $("#nohp").val(res.no_hp);
                $("#email").val(res.email);
                $("#username").val(res.nik);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

    });
   
   
    $("#btn_simpan").click(function(){
        swal({
            title: "Update Menu Akses ?",
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
                url       : base_url + 'module/update_users_akses', 
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
                        Command: toastr["success"]("Akses Pengguna Berhasil Di Update", "Berhasil");
                        getcontents('users','<?php echo $tokens;?>');   
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    }
                }
            });

        });
        
    });
    
    $("#btn_hapus").click(function(){
        swal({
            title: "Hapus Users ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'users/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {nik:user_nik,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Users berhasil dihapus", "Berhasil");
                            getcontents('users',tokens);
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




    $("#btn_nonaktif").click(function(){
        swal({
            title: "Nonaktifkan Users ?",
            text: "Jika ingin disimpan, silahkan klik button simpan",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            //confirmButtonColor: "#E73D4A"
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'users/hapus',
                type      : "post",
                dataType  : 'json',
                data      : {nik:user_nik,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Users berhasil dihapus", "Berhasil");
                            getcontents('users',tokens);
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
    
   
});    

</script>




<div id="<?php echo $id_modal;?>" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Modul Permission</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                  
                  <form id="form_input" method=POST enctype='multipart/form-data'>
        <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" class="form-control" name="idusers" id="idusers">
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">NIK</label>
                <input type="text" id="username" name="username" class="form-control" readonly="">
                </div>
        
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" readonly="">
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
                  <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->



<div id="<?php echo $id_modal;?>" class="modal fade">
            <div class="modal-dialog modal-dialog-vertical-center" role="document">
              <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-y-20 pd-x-25">
                  <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-25">
                  <h4 class="lh-3 mg-b-20"><a href="" class="tx-inverse hover-primary">Why We Use Electoral College, Not Popular Vote</a></h4>
                  <p class="mg-b-5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Save changes</button>
                  <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div><!-- modal -->
