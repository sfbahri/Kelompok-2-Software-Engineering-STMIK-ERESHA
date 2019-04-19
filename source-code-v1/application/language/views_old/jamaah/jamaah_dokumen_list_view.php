<script type="text/javascript">
$(document).ready(function(){
    

get_dok_upload = function(){ 
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/biodata_detail',
        data: {},
        dataType  : 'json',
        success: function (data) {
            
            $(".id_kloter").val(data.id_kloter);
            $(".kode_jamaah").val(data.id);
            $("#dok_ktp_asli").val(data.upload_dok_ktp);
            $("#dok_sipatuh_asli").val(data.upload_dok_surat_pernyataan_sipatuh);
            $("#dok_paspor_asli").val(data.upload_dok_paspor);
            $("#dok_kk_asli").val(data.upload_dok_kk);
            
            if(data.upload_dok_surat_pernyataan_sipatuh == '' || data.upload_dok_surat_pernyataan_sipatuh == null){
                $("#dok_surat_pernyataan_view").html('<span>Belum ada file yang diupload</span>');
            }else{
                //data.id_kloter
                $("#dok_surat_pernyataan_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_surat_pernyataan_sipatuh+'">Lihat Files Surat Pernyataan Sipatuh</a>');
            }
            
            
            if(data.upload_dok_paspor == '' || data.upload_dok_paspor == null){
                $("#dok_paspor_view").html('<span>Belum ada file yang diupload</span>');
            }else{
                //data.id_kloter
                $("#dok_paspor_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_paspor+'">Lihat Files Paspor</a>');
            }
            
            
            if(data.upload_dok_ktp == '' || data.upload_dok_ktp == null){
                $("#dok_ktp_view").html('<span>Belum ada file yang diupload</span>');
            }else{
                //data.id_kloter
                $("#dok_ktp_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_ktp+'">Lihat Files KTP</a>');
            }
            
            if(data.upload_dok_kk == '' || data.upload_dok_kk == null){
                $("#dok_kk_view").html('<span>Belum ada file yang diupload</span>');
            }else{
                //data.id_kloter
                $("#dok_kk_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_kk+'">Lihat Files Kartu Keluarga</a>');
            }
            
            
        }
    });
    
}
get_dok_upload();
    
    $('#tabel_dokumen_upload,#tabel_jamaah').DataTable({
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
                    language: {
                      searchPlaceholder: 'Cari',
                      sSearch: '',
                      lengthMenu: '_MENU_',
                    },
    });
    
    
    
    $('#dok_ktp').change(function () {
        if(this.files[0].size > 2000000) {
            swal("Gagal Upload KTP !", "Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !", "error");
            //alert("Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !");
            $(this).val('');
        }else{
            var property = document.getElementById('dok_ktp').files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

        if($.inArray(image_extension,['gif','jpg','jpeg','pdf','png']) == -1){
            swal("Format File Salah !", "Pastikan Format Files : gif, jpg, jpeg, pdf, png", "error");
            $(this).val('');
        }else{
            
            var form_data = new FormData($('#form_input_ktp')[0]);
//                form_data.append('kode_jamaah', $("#kode_jamaah").val());
                form_data.append("file",property);
                $.ajax({
                    url:base_url + 'jamaah/upload_ktp', 
                    method:'POST',
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                      //$('#msg').html('Loading......');
                    },
                    success:function(data){
                      if(data == 'true'){
                        Command: toastr["success"]("Dokumen KTP berhasil Diupload", "Berhasil");
                        get_dok_upload();
                        $('#dok_ktp').val('');
                        //getcontents('jamaah/dokumen_list','<?php echo $tokens;?>');
                      }
                    }
                });
        }
        
        }
    });
    
    
    
     $('#dok_sipatuh').change(function () {
        if(this.files[0].size > 2000000) {
            swal("Gagal Upload Pernyataan Sipatuh !", "Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !", "error");
            //alert("Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !");
            $(this).val('');
        }else{
            var property = document.getElementById('dok_sipatuh').files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

        if($.inArray(image_extension,['gif','jpg','jpeg','pdf','png']) == -1){
            swal("Format File Salah !", "Pastikan Format Files : gif, jpg, jpeg, pdf, png", "error");
            $(this).val('');
        }else{
            
            var form_data = new FormData($('#form_input_sipatuh')[0]);
//                form_data.append('kode_jamaah', $("#kode_jamaah").val());
                form_data.append("file",property);
                $.ajax({
                    url:base_url + 'jamaah/upload_sipatuh', 
                    method:'POST',
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                      //$('#msg').html('Loading......');
                    },
                    success:function(data){
                      if(data == 'true'){
                        Command: toastr["success"]("Dokumen Pernyataan Sipatuh berhasil Diupload", "Berhasil");
                        get_dok_upload();
                        $('#dok_sipatuh').val('');
                      }
                    }
                });
        }
        
        }
    });
    
    
    
    $('#dok_paspor').change(function () {
        if(this.files[0].size > 2000000) {
            swal("Gagal Upload Paspor !", "Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !", "error");
            //alert("Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !");
            $(this).val('');
        }else{
            var property = document.getElementById('dok_paspor').files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

        if($.inArray(image_extension,['gif','jpg','jpeg','pdf','png']) == -1){
            swal("Format File Salah !", "Pastikan Format Files : gif, jpg, jpeg, pdf, png", "error");
            $(this).val('');
        }else{
            
            var form_data = new FormData($('#form_input_paspor')[0]);
//                form_data.append('kode_jamaah', $("#kode_jamaah").val());
                form_data.append("file",property);
                $.ajax({
                    url:base_url + 'jamaah/upload_paspor', 
                    method:'POST',
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                      //$('#msg').html('Loading......');
                    },
                    success:function(data){
                      if(data == 'true'){
                        Command: toastr["success"]("Dokumen Paspor berhasil Diupload", "Berhasil");
                        get_dok_upload();
                        $('#dok_paspor').val('');
                      }
                    }
                });
        }
        
        }
    });
    
    
    $('#dok_kk').change(function () {
        if(this.files[0].size > 2000000) {
            swal("Gagal Upload Paspor !", "Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !", "error");
            //alert("Ukuran File Melebihi 2MB. Silahkan Resize Gambar ini !");
            $(this).val('');
        }else{
            var property = document.getElementById('dok_kk').files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

        if($.inArray(image_extension,['gif','jpg','jpeg','pdf','png']) == -1){
            swal("Format File Salah !", "Pastikan Format Files : gif, jpg, jpeg, pdf, png", "error");
            $(this).val('');
        }else{
            
            var form_data = new FormData($('#form_input_kk')[0]);
//                form_data.append('kode_jamaah', $("#kode_jamaah").val());
                form_data.append("file",property);
                $.ajax({
                    url:base_url + 'jamaah/upload_kk', 
                    method:'POST',
                    data:form_data,
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend:function(){
                      //$('#msg').html('Loading......');
                    },
                    success:function(data){
                      if(data == 'true'){
                        Command: toastr["success"]("Dokumen Kartu Keluarga berhasil Diupload", "Berhasil");
                        get_dok_upload();
                        $('#dok_kk').val('');
                      }
                    }
                });
        }
        
        }
    });
    
   }); 
</script>


    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Dokumen</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-cloud-upload"></i>
        <div>
            <h4>Data Dokumen</h4>
            <p class="mg-b-0">Halaman data dokumen.</p>
        </div>
    </div>
    
    
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">DOKUMEN UPLOAD</h6>
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_dokumen_upload" class="table table-hover table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen Upload</th>
                        <th>Browse</th>
                        <th>URL Files</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td><form id="form_input_sipatuh"  method=POST enctype='multipart/form-data'>
                            <input type="hidden" class="id_kloter" name="id_kloter">
                            <input type="hidden" class="kode_jamaah" name="kode_jamaah">
                            <input type="hidden" id="dok_sipatuh_asli" name="dok_sipatuh_asli">
                            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" id="dok_sipatuh" name="dok_sipatuh">
                            </form></td>
                        <td><div id="dok_surat_pernyataan_view"></div></td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>PASPOR</td>
                        <td><form id="form_input_paspor"  method=POST enctype='multipart/form-data'>
                            <input type="hidden" class="id_kloter" name="id_kloter">
                            <input type="hidden" class="kode_jamaah" name="kode_jamaah">
                            <input type="hidden" id="dok_papsor_asli" name="dok_papsor_asli">
                            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" id="dok_paspor" name="dok_paspor">
                            </form></td>
                        <td><div id="dok_paspor_view"></div></td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>KTP</td>
                        <td> <form id="form_input_ktp"  method=POST enctype='multipart/form-data'>
                            <input type="hidden" class="id_kloter" name="id_kloter">
                            <input type="hidden" class="kode_jamaah" name="kode_jamaah">
                            <input type="hidden" id="dok_ktp_asli" name="dok_ktp_asli">
                            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" id="dok_ktp" name="dok_ktp">
                            </form></td>
                        <td><div id="dok_ktp_view"></div></td>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td>KK</td>
                        <td><form id="form_input_kk"  method=POST enctype='multipart/form-data'>
                            <input type="hidden" class="id_kloter" name="id_kloter">
                            <input type="hidden" class="kode_jamaah" name="kode_jamaah">
                            <input type="hidden" id="dok_papsor_asli" name="dok_kk_asli">
                            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" id="dok_kk" name="dok_kk">
                            </form></td>
                        <td><div id="dok_kk_view"></div></td>
                    </tr>
                </tbody>
            </table>              
            </div>
                
                
                
            <hr>
            
            <h6 class="br-section-label">DOKUMEN KIRIM</h6>
            
            <div class="alert alert-danger" role="alert">
                Mohon Maaf, Halaman Informasi Dokumen Kirim sedang dalam maintenance, segera akan diaktifkan kembali. Terima Kasih
              </div>
            
        </div>
    </div>