<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    tinyMCE.remove();
    getMCE();

    $('.uppercase').keyup(function(event){
        this.value = this.value.toUpperCase();
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + 'identitas/detail',
        data: {},
        dataType  : 'json',
        success: function (data) {

            $("#id_identitas").val(data.id_identitas);
            $("#title").val(data.title);
            $("#nama_perusahaan").val(data.nama);
            $("#no_telp_1").val(data.no_telp1);
            $("#no_telp_2").val(data.no_telp2);
            $("#email").val(data.email);
            $("#maps").val(data.maps);
            $("#facebook").val(data.facebook);
            $("#twitter").val(data.twitter);
            $("#instagram").val(data.instagram);
            //$("#profil_singkat").val(data.profil_singkat);
            $("#keyword").val(data.keywordseo);
            $("#foto_asli").val(data.logo);
            $("#alamat").val(data.alamat);
            $("#waktu_layanan").val(data.waktu_layanan);
            
            var ed1 = tinyMCE.get('profil_singkat');
            // Do you ajax call here, window.setTimeout fakes ajax call
            ed1.setProgressState(1); // Show progress
            window.setTimeout(function() {
                ed1.setProgressState(0); // Hide progress
                ed1.setContent(data.profil_singkat);
            }, 1000);


            var ed2 = tinyMCE.get('profil_visi');
            // Do you ajax call here, window.setTimeout fakes ajax call
            ed2.setProgressState(1); // Show progress
            window.setTimeout(function() {
                ed2.setProgressState(0); // Hide progress
                ed2.setContent(data.profil_visi);
            }, 1000);


             var ed3 = tinyMCE.get('profil_misi');
            // Do you ajax call here, window.setTimeout fakes ajax call
            ed3.setProgressState(1); // Show progress
            window.setTimeout(function() {
                ed3.setProgressState(0); // Hide progress
                ed3.setContent(data.profil_misi);
            }, 1000);
            
            
            if(data.logo == '' || data.logo == null){
                $("#fotoku").html('<img src="'+base_url+'/assets/img/no-available.png" class="wd-100 rounded-circle" alt="">');
            }else{
                $("#fotoku").html('<img src="'+base_url+'/uploads/img_logo/'+data.logo+'" style="width: 250px;height: 130px;border: 1px solid grey;border-style: dashed;" >');
            }
            
        }
    });
    
    
    
    $("#btn_simpan").click(function(){
        
        tinyMCE.triggerSave();
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Identitas Web ?",
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
                url             : base_url + 'identitas/update', 
                type            : "POST",
                dataType        : 'json',
                mimeType        : 'multipart/form-data',
                data            : form_data,
                contentType     : false,
                cache           : false,
                processData     : false,
                success     : function(response){
                    if(response == true){
                        //$('#'+id_modal).modal('hide');   
                        swal.close();
                        Command: toastr["success"]("Identitas Website berhasil disimpan", "Berhasil");
                        getcontents('identitas/index','<?php echo $tokens;?>');
                    }else{
                        Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                    } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"](errorThrown, "Error");
            }

            });

        });
        
    });
    
    
});    
</script>
 <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="foto_asli" name="foto_asli" class="form-control" readonly="">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Identitas Website</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-globe"></i>
        <div>
            <h4>Identitas Website <div id="nama_kloter"></div></h4>
          <p class="mg-b-0">Halaman data identitas website.</p>
        </div>
    </div>
    <div class="br-pagebody">
        
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-base widget-7">
                            <div class="tx-center">
                              <div id="fotoku"></div>
                            </div>
                        </div><!-- card -->
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="br-section-wrapper">
                    <div class="row"> 
                        <div class="col-md-12">
                            <h6 class="br-section-label">IDENTITAS</h6>
                            <hr>
                        </div>
                        
              
            <div class="col-md-6">
                
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama PT/Perusahaan</label>
                
                <input type="hidden" id="id_identitas" name="id_identitas" class="form-control" readonly="">
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nomor Kantor</label>
                    <input type="text" id="no_telp_1" name="no_telp_1" class="form-control">
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Title Website</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nomor Handphone</label>
                    <input type="text" id="no_telp_2" name="no_telp_2" class="form-control">
                </div>
                
            </div>
                <div class="col-md-12">
                    
                    <div class="form-group">
                        <label for="comment">Profil Singkat Perusahaan</label>
                        <textarea class="form-control mceEditor" rows="5" id="profil_singkat" name="profil_singkat"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="comment">Profil Visi</label>
                        <textarea class="form-control mceEditor" rows="5" id="profil_visi" name="profil_visi"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="comment">Profil Misi</label>
                        <textarea class="form-control mceEditor" rows="5" id="profil_misi" name="profil_misi"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="sel1">Email</label>
                        <input type="text" id="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment">Alamat</label>
                        <textarea class="form-control" rows="5" id="alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="sel1">Link Maps / Lokasi Peta</label>
                        <input type="text" id="maps" name="maps" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sel1">Link Facebook</label>
                        <input type="text" id="facebook" name="facebook" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sel1">Link Twitter</label>
                        <input type="text" id="twitter" name="twitter" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sel1">Link Instagram</label>
                        <input type="text" id="instagram" name="instagram" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sel1">Waktu Layanan</label>
                        <input type="text" id="waktu_layanan" name="waktu_layanan" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Keyword Pencarian</label>
                        <textarea class="form-control" rows="5" id="keyword" name="keyword"></textarea>
                    </div>
                    
                    <hr>
                    <div class="form-group">
                          <div id="fotoku"></div>
                        <label for="demo-vs-definput" class="control-label">Ganti Foto</label><br>
                        <input type="file" id="gambar" name="gambar">
                    </div>
                </div>
                <div class="modal-footer pull-right">
                    <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update Identitas Website </button>
                </div>
             
        </div>
                </div>
            </div>
        </div>
        
    </div>
 </form>