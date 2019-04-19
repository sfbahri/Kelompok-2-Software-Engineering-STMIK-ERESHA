<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var kode_produk     = '<?php echo $id_rows;?>';
    
    $.ajax({
            url       : base_url + 'produk/details',
            type      : "post",
            dataType  : 'json',
            data      : {kode_produk : kode_produk,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
             $(".nama_produk").text(response.nama);
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
	    url: "<?php echo base_url('produk/proses_upload_media') ?>",
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
	            return kode_produk+'_'+'img'+'_'+tanggals+'_'+tokenname1+'_'+tokenname2+'_'+tokenname3+'_'+filename; //<- ini untuk rubah nama file gambar
	            
	    },
	    addRemoveLinks:true
	    });
	
	    foto_upload.on('sending', function(file, xhr, formData) {
	        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
	        formData.append('kode_produk', '<?php echo $id_rows;?>');
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
        url       : base_url + 'produk/data_gambar_produk',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produk:kode_produk,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (res) {
            
            document.getElementById("list_gambar").innerHTML = "";
            
            for ( var i=0 ; i<res.length ; i++ ) {
                //style="width:600px;height:450px;"
                
                
                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./uploads/produk/'+res[i].gambar+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
                                html+='<div class="img-option">'
                                  html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
                                  html+='<a href="./uploads/produk/'+res[i].gambar+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
                                html+='</div>'
                              html+='</figcaption></figure>'
                $("#list_gambar").append(html);
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    list_gambar_produksi();
    
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
                url       : base_url + 'produk/gambar_hapus',
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
          <span class="breadcrumb-item active">Data Gambar Produk</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-shirt"></i>
        <div>
            <h4>Gambar Produk <span class="nama_produk"></span></h4>
          <p class="mg-b-0">Halaman data gambar produk.</p>
        </div>
        <div class="">
                
            </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">GAMBAR PRODUK</h6>

                       
            
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

