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
    
    
    
    /* random nama file */
	    function makeid(countint) {
	      var text = "";
	      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	
	      for (var i = 0; i < countint; i++)
	        text += possible.charAt(Math.floor(Math.random() * possible.length));
	      return text;
	    }
	    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
	    var date = new Date();
	    var day = date.getDate();
	    var month = date.getMonth();
	    var yy = date.getYear();
	    var year = (yy < 1000) ? yy + 1900 : yy;
	    var tanggals  = day + "_" + months[month] + "_" + year;
	    /* random nama file */
	
	
	// ====================== Start : Upload Dropzone ==================== //
	
	    Dropzone.autoDiscover = false;
	    // var nama_file;
	    var foto_upload= new Dropzone(".dropzone",{
	    url: "<?php echo base_url('markom/proses_upload_media2') ?>",
	    maxFilesize: 5,
	    method:"post",
	    acceptedFiles: 'image/jpeg, image/jpg, image/png',
	    //acceptedFiles:"image/*",
	    paramName:"userfile",
	    dictInvalidFileType:"Type file ini tidak dizinkan",
	    renameFilename: function (filename) {
	            var tokenname1 = makeid(8);
	            var tokenname2 = makeid(4);
	            var tokenname3 = makeid(4);
	            var tokenname4 = makeid(2);
	            return noso+'_'+'img'+'_'+tanggals+'_'+tokenname1+'_'+tokenname2+'_'+tokenname3+'_'+filename; //<- ini untuk rubah nama file gambar
	            
	    },
	    addRemoveLinks:true
	    });
	
	    foto_upload.on('sending', function(file, xhr, formData) {
	        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
	        formData.append('noso', '<?php echo $id_rows;?>');
	        //formData.append('id_obyek_wisata', $("#obyekwisata_media option:selected").val());
	        //formData.append('nama_file', file.previewElement.querySelector('[data-dz-name]').innerHTML);
	    });
	
	    foto_upload.on("complete", function(file) {
                foto_upload.removeFile(file);
                //$(".dropzone").html('');
                
	        $(".dz-remove").html("<div style='cursor:pointer'><small><span class='fa fa-trash text-danger'></span> Hapus </small></div>");
	        list_gambar_produksi();
	        //cekdatamedia();
	    });
	
	    foto_upload.on('removedfile', function(file, response) {
	            var name_file = file.previewElement.querySelector('[data-dz-name]').innerHTML;
	          
//	            $.ajax({ 
//	                url: base_url + 'foto/hapus_media_dropzone',
//	                type: "post",
//	                data:{name_file:name_file,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//	                dataType: "json",
//	                async : 'false',
//	                success: function(result)
//	                {
//	                    if(result == true){
//	                        Command: toastr["success"]("foto terhapus", "Berhasil");
//	                        datalistmedia();
//	                    }else{
//	                        alert("Error");
//	                    }
//	
//	                }
//	            });
	    });
	
	
	// ====================== End : Upload Dropzone ==================== //  
    
    
    list_gambar_produksi = function(){
        
         
    
        $.ajax({
        url       : base_url + 'markom/data_gambar_produksi_admin',
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
                        html+='<span style="color:black;font-size:12px;margin-left:10px">'+namagambar+'</span><div style="margin-top:20px"></div>'
                        html+='<button class="btn btn-'+btn_warna+' btn-sm" style="font-size:11px">Status : '+res[i].status_gambar_produksi+'</button></div></div>';
                $("#list_gambar").append(html);
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    list_gambar_produksi();
    
    img_input_nama = function(id){
        
                swal({
                  title: "Update Nama Gambar",
                  text: "Silahkan input nama gambar di bawah ini :",
                  type: "input",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  animation: "slide-from-top",
                  inputPlaceholder: "Nama Gambar yang diinginkan"
                },
                function(inputValue){
                  if (inputValue === false) return false;

                  if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                  }
                  
                  var namatheme = $(".nama_tema").text();
                  var nama_imgs = namatheme+' '+inputValue;
                  $.ajax({
                        url       : base_url + 'markom/gambar_nama',
                        type      : "post",
                        dataType  : 'json',
                        data      : {id : id,nama_gambar:nama_imgs,
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
                url       : base_url + 'markom/gambar_approve',
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
    
    img_note = function(){
        swal({
            title: 'Submit your Github username',
            input: 'text',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Look up',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
              return fetch(`//api.github.com/users/${login}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json()
                })
                .catch(error => {
                  swal.showValidationError(
                    `Request failed: ${error}`
                  )
                })
            },
            allowOutsideClick: () => !swal.isLoading()
          }).then((result) => {
            if (result.value) {
              swal({
                title: `${result.value.login}'s avatar`,
                imageUrl: result.value.avatar_url
              })
            }
          })
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
            <h4>Upload Gambar Produksi | NO.SO : <?php echo $id_rows;?> | Tema : <span class="nama_tema"></span></h4>
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
            
                <form action="/file-upload" class="dropzone">
                    
                    <div class="fallback">
                      <input name="file" type="file" multiple />
                    </div>
                  </form>
                
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div id="list_gambar"></div>
                    </div>
                </div>
                
                
                
            </div>
            
            
            
            
        </div>
    </div>


<!--
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Produksi</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Produksi</a></li>
                        <li class="breadcrumb-item active">Data Produksi</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" style="margin-bottom: 10px">
              <div class="btn btn-info round dropdown-menu-right box-shadow-2 px-2" onclick="getpopup('produksi/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="ft-plus-circle icon-left"></i> Tambah Produksi </div>
              <div class="btn btn-warning round dropdown-menu-right box-shadow-2 px-2" onclick="getpopup('produksi/tambah_manual','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="ft-plus-circle icon-left"></i> Tambah Manual </div>
            </div>
        </div>
    </div>

    -->
<!--

    <section id="initialization">
        
        <div class="row">
            
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Produksi</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    
                    <div class="table-responsive">
                    <table id="tabel_produksi" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 10%">Kode Produksi</th>
                                <th style="width: 10%">Gambar Produksi</th>
                                <th>Nama Produksi</th>
                                <th style="width: 10%">Tanggal Mulai</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Progress</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                        
                    </div>
                    
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>-->






    

