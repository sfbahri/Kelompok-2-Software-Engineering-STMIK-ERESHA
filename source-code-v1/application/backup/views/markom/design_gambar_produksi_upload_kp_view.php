<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var noso     = '<?php echo $id_rows;?>';
    
    $.ajax({
            url       : base_url + 'markom/design_gambar_data_so_detail',
            type      : "post",
            dataType  : 'json',
            data      : {noso : noso,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
             $(".nama_tema").text(response.nama);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    
    
    list_gambar_produksi = function(){
        
        $.ajax({
        url       : base_url + 'markom/data_gambar_produksi_kp',
        type      : "post",
        dataType  : 'json',
        data      : {noso:noso,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (res) {
            
            document.getElementById("list_gambar").innerHTML = "";
            
            for ( var i=0 ; i<res.length ; i++ ) {
                //style="width:600px;height:450px;"
                
                var namagambar;
                if(res[i].nama == null){
                    namagambar = '<span style="color:red;font-size:11px">Nama Gambar masih kosong !</span><br>';
                }else{
                    namagambar = res[i].nama;
                }
                
                var btn_warna;
                if(res[i].approve == 0){
                    btn_warna = 'danger';
                }else if(res[i].approve == 1){
                    btn_warna = 'info';
                }else if(res[i].approve == 2){
                    btn_warna = 'info';
                }else if(res[i].approve == 3){
                    btn_warna = 'primary';
                }else if(res[i].approve == 4){
                    btn_warna = 'success';
                }else{
                    btn_warna = 'default';
                }
                
                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./uploads/produksi/'+res[i].gambar+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
                                html+='<div class="img-option">'
                                  html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
                                  html+='<a href="javascript:void(0)" title="Approve" onclick=\"img_approve('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-check" style="color:green"></i></div></a>'
                                  html+='<a href="./uploads/produksi/'+res[i].gambar+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
                                  html+='<a href="javascript:void(0)" title="Nama Gambar" onclick=\"img_input_nama('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-pencil" style="color:gray"></i></div></a>'
                                html+='</div>'
                              html+='</figcaption></figure>'
                        html+='<span style="color:black;font-size:12px;margin-left:10px">'+namagambar+'</span><div style="margin-top:20px"></div> <a href="javascript:void(0)" onclick=\"get_catatan('+res[i].id+');\"><span style="color:blue;font-size:10px">Lihat Catatan Gambar</span></a>'
                        html+='<button class="btn btn-'+btn_warna+' btn-sm" style="font-size:11px">Status : '+res[i].status_gambar_produksi+'</button></div></div>';
                $("#list_gambar").append(html);
                
            }
            
//            for ( var i=0 ; i<res.length ; i++ ) {
//                //style="width:600px;height:450px;"
//                
//                var namagambar;
//                if(res[i].nama == null){
//                    namagambar = '<span style="color:red;font-size:10px">Nama Gambar masih kosong !</span>';
//                }else{
//                    namagambar = res[i].nama;
//                }
//               
//                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
//                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./uploads/produksi/'+res[i].gambar+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
//                                html+='<div class="img-option">'
////                                  html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
//                                  html+='<a href="javascript:void(0)" title="Approve" onclick=\"img_approve('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-check" style="color:green"></i></div></a>'
//                                  html+='<a href="./uploads/produksi/'+res[i].gambar+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
//                                  html+='<a href="javascript:void(0)" title="Catatan" onclick=\"img_catatan('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-edit" style="color:gray"></i></div></a>'
//                                html+='</div>'
//                              html+='</figcaption></figure>'
//                        html+='<div class="card-body">'
//                        html+='<p class="card-text">Nama Gambar : <b>'+namagambar+'</b></p>'
//                        html+='<p class="card-text"><a href="javascript:void(0)" onclick=\"get_catatan('+res[i].id+');\"><span style="color:blue;font-size:10px">Lihat Catatan Gambar</span></a></p>'
//                        html+='</div>'
//                        html+='</div></div>';
//                $("#list_gambar").append(html);
//                
//            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    list_gambar_produksi();
    
    
    get_catatan = function(id){
        getpopup('markom/gambar_catatan_view','<?php echo $this->session->userdata('sess_token');?>','popupedit',id);
    }
    
    img_catatan = function(id){
        
                swal({
                  title: "Input Catatan",
                  text: "Silahkan input catatan untuk gambar ini :",
                  type: "input",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  animation: "slide-from-top",
                  inputPlaceholder: "Catatan Umum / Catatan Perubahan"
                },
                function(inputValue){
                  if (inputValue === false) return false;

                  if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                  }
                  
                  var img_catatan = inputValue;
                  $.ajax({
                        url       : base_url + 'markom/gambar_catatan',
                        type      : "post",
                        dataType  : 'json',
                        data      : {id : id,img_catatan:img_catatan,
                                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                                },
                        success: function (response) {
                        if(response == true){  
                                swal.close();
                                Command: toastr["success"]("Catatan Gambar berhasil disimpan", "Berhasil");
                                list_gambar_produksi();
                        }else{
                            Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                        } 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Command: toastr["error"]("Ajax Error !!", "Error");
                    }

                    });

                //swal("Nice!", "You wrote: " + inputValue, "success");
                });


    
    }
    
    img_hapus = function(id){
        swal({
            title: "Hapus gambar yang dipilih ?",
            text: "Jika ingin disimpan, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
        },
        function(){

            $.ajax({
                url       : base_url + 'markom/gambar_hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Gambar berhasil dihapus", "Berhasil");
                        list_gambar_produksi();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
    }
    
    
    img_approve= function(id){
        swal({
            title: "Kirim gambar ini ke data Produksi ?",
            text: "Jika ingin disimpan, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Kirim",
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'markom/gambar_approve_kp',
                type      : "post",
                dataType  : 'json',
                data      : {id : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Gambar berhasil dikirim ke produksi", "Berhasil");
                        list_gambar_produksi();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
    }
    
});    
</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  

#fileToUploadAlert {
    display: block !important;
    margin: 0 !important;
    padding: 0 50px !important;
    border: 0;
    box-shadow: none;
}


</style>
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Gambar Produksi</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-shirt"></i>
        <div>
          <h4>List Gambar Produksi | NO.SO : <?php echo $id_rows;?> | Tema : <span class="nama_tema"></span></h4>
          <p class="mg-b-0">Halaman data gambar produksi.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">GAMBAR PRODUKSI</h6>

                       
            
            <div class="table-wrapper table-responsive">
            
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div id="list_gambar"></div>
                    </div>
                </div>
                
                
                
            </div>
            
            
            
            
        </div>
    </div>

