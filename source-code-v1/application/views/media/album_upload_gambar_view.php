<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_album    = '<?php echo $id_row;?>';
    
    $.ajax({
        type: 'POST',
        url: base_url + 'media/album_detail',
        data: {id_album:id_album},
        dataType  : 'json',
        success: function (data) {
            
            $('#idalbum').val(data.id);
            $("#namaalbum").text("Album Galeri : "+ data.nama);
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
	    url: "<?php echo base_url('media/proses_upload_media_galeri') ?>",
	    maxFilesize: 500,
	    method:"post",
            dictDefaultMessage: "Letakkan atau drag gambar/foto di sini atau klik untuk mengunggah",
	    //acceptedFiles: 'image/jpeg, image/jpg, image/png',
	    acceptedFiles:"image/*",
	    paramName:"userfile",
	    dictInvalidFileType:"Type file ini tidak dizinkan",
	    renameFilename: function (filename) {
	            var tokenname1 = makeid(8);
	            var tokenname2 = makeid(4);
	            var tokenname3 = makeid(4);
	            var tokenname4 = makeid(2);
	            return 'img_'+ id_album +'_'+tanggals+'_'+tokenname1+'_'+tokenname2+'_'+tokenname3+'_'+filename; //<- ini untuk rubah nama file gambar
	            
	    },
	    addRemoveLinks:true
	    });
	
	    foto_upload.on('sending', function(file, xhr, formData) {
	        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
	        formData.append('id_album', id_album);
                formData.append('nama_file', file.previewElement.querySelector('[data-dz-name]').innerHTML);
	        //formData.append('id_obyek_wisata', $("#obyekwisata_media option:selected").val());
	        
	    });
	
	    foto_upload.on("complete", function(file) {
                foto_upload.removeFile(file);
                //$(".dropzone").html('');
                
	        $(".dz-remove").html("<div style='cursor:pointer'><small><span class='fa fa-trash text-danger'></span> Hapus </small></div>");
	        lis_img_galeri();
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


    $("#btn_update").click(function(){
        
        
        if($("#namaalbum").val() == ''){
                Command: toastr["warning"]("Nama Album tidak boleh kosong!", "Info");
            $("#namaalbum").focus();
        }else{
            swal({
                title: "Update Album ?",
                text: "Silahkan periksa kembali harga yang ingin disimpan.",
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
                url       : base_url + 'media/album_update',
                type      : "post",
                dataType  : 'json',
                data      : {id_album:id_album,nama_album : $("#namaalbum").val(), <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response){
                    if(response == true){
                        $('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Album berhasil diupdate", "Berhasil");
                        getcontents('media/album','<?php echo $tokens;?>');
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });

            });
        }
        
    });
    
    
    
    lis_img_galeri = function(){
        
         
    
        $.ajax({
        url       : base_url + 'media/get_data_galeri',
        type      : "post",
        dataType  : 'json',
        data      : {id_album:id_album,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (res) {
            
            document.getElementById("list_gambar").innerHTML = "";
            
            for ( var i=0 ; i<res.length ; i++ ) {
                //style="width:600px;height:450px;"
                
                var imgtitle;
                if(res[i].title == null || res[i].title == ''){
                    imgtitle = 'Isi Title Disini !';
                }else{
                    imgtitle = res[i].title;
                }
                
                //btn-'+btn_warna+
                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./'+res[i].path+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
                                html+='<div class="img-option">'
                                    html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_galeri_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
                                    html+='<a href="./'+res[i].path+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
                                html+='</div>'
                            html+='</figcaption></figure>'
                        html+='<span style="color:black;font-size:12px;margin:10px"><input name="texta" type="text" class="form-control" value="'+imgtitle+'" title="Isi Title Disini"/></span><div style="margin-top:20px"></div>';
                $("#list_gambar").append(html);
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    lis_img_galeri();
    
    
    
    img_galeri_hapus = function(id){
        swal({
            title: "Hapus gambar yang dipilih ?",
            text: "Jika ingin dihapus, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
        },
        function(){

            $.ajax({
                url       : base_url + 'media/media_galeri_hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Gambar berhasil dihapus", "Berhasil");
                        lis_img_galeri();
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
    background: white;
    border-radius: 5px;
    border: 2px dashed rgb(0, 135, 247);
    border-image: none;
    max-width: 80%;
    margin-left: auto;
    margin-right: auto;
}
</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <b><div id="namaalbum"></div></b>
        </div>
        <div class="modal-body">
            
            <form action="/file-upload" class="dropzone">    
                <div class="fallback">
                    <input name="file" type="file" multiple />
                </div>
            </form>
            
            <br>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div id="list_gambar"></div>
                </div>
            </div>
            
            
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-refresh"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



