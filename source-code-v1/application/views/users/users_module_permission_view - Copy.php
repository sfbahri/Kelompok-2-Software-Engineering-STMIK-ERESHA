<script type="text/javascript">
$(document).ready(function(){
    var tokens      = '<?php echo $tokens;?>';
    var id_modal    = '<?php echo $id_modal;?>';
    var id_users    = '<?php echo $id_row;?>';
   
    $.ajax({
        url       : base_url + 'users/detail',
        type      : "post",
        dataType  : 'json',
        data      : {id_users       : id_users,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
                $("#nama").val(res.fullname);
                $("#nohp").val(res.nohp);
                $("#email").val(res.email);
                $("#username").val(res.username);
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

            $.ajax({
                url       : base_url + 'users/update',
                type      : "post",
                dataType  : 'json',
                data      : {nama       : $("#nama").val(),
                            nohp        : $("#nohp").val(),
                            email       : $("#email").val(),
                            id_users   :id_users,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                    if(response == true){
                            $('#'+id_modal).modal('hide');   
                            swal.close();
                            Command: toastr["success"]("Users berhasil diupdate", "Berhasil");
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
                data      : {id_users:id_users,
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
                data      : {id_users:id_users,
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


<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Module Permission</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
          <div class="col-md-12">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="form-control" readonly="">
                </div>
                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <label for="demo-vs-definput" class="control-label">Akses Module Permission</label>
                    </div>
                    <ul class="list-group">
                      
                        <div class="list-group" id="list1">
                        <?php 
                        //header
                        foreach($modules as $a){
                            if($a['have_child'] == 'Y' && $a['position'] == '1' ){
                                
                                $hasil;
                                foreach($modules_users as $b){
                                    if($a['id'] == $b['id_module']){
                                        $hasil = '<input title="toggle all" type="checkbox" class="all pull-right" checked>';  
                                    }else{
                                        $hasil = '<input title="toggle all" type="checkbox" class="all pull-right">';
                                    }
                                }
                                
  
                                echo '<a href="javascript:void(0)" class="list-group-item list-group-item-info">'.$a[name].' <input title="toggle all" type="checkbox" class="all pull-right"></a>';      
                                    
                                    foreach($modules as $c){
                                        if($c['have_child'] == 'N' && $c['position'] == '2' && $c['parent'] == $a['id']){
                                            echo '<a href="#" class="list-group-item list-group-item-default">'.$c['name'].' <input title="toggle all" type="checkbox" class="all pull-right"></a>';
                                        }
                                    }
                            
                            }else if($a['have_child'] == 'N' && $a['position'] == '1'){
                                echo '<a href="javascript:void(0)" class="list-group-item list-group-item-success">'.$a['name'].' <input title="toggle all" type="checkbox" class="all pull-right"></a>';
                            }  
                        }
                        ?>
                        </div>
<!--                        <a href="#" class="list-group-item">Second item <input type="checkbox" class="pull-right"></a>
                        <a href="#" class="list-group-item">Third item <input type="checkbox" class="pull-right"></a>
                        <a href="#" class="list-group-item">More item <input type="checkbox" class="pull-right"></a>
                        <a href="#" class="list-group-item">Another <input type="checkbox" class="pull-right"></a>
                        </div>-->

                    </ul>
                </div>
              
              
            </div> 
        </div>      
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="ft-save"></i> Update</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
      </div>
    </div>

  </div>
</div>



