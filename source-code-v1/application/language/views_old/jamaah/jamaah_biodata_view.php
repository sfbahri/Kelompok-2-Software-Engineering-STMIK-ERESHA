<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    $('.uppercase').keyup(function(event){
        this.value = this.value.toUpperCase();
    });
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/biodata_detail',
        data: {},
        dataType  : 'json',
        success: function (data) {

            $("#text_nama").text(data.nama);
            $("#text_no_paspor").text(data.paspor_no);
            $("#text_kode_jamaah").text(data.id);
            $("#text_alamat").text(data.alamat);
            $("#text_kota_asal").text(data.kota_asal);
            
            if(data.img_foto == '' || data.img_foto == null){
                $("#fotoku").html('<img src="'+base_url+'/assets/img/no-available.png" class="wd-100 rounded-circle" alt="">');
            }else{
                $("#fotoku").html('<img src="'+base_url+'/uploads/files/kloter_'+data.id_kloter+'/'+data.img_foto+'" style="width: 130px;height: 170px;border: 1px solid grey;border-style: dashed;" >');
            }
            
            if(data.id_kamar == '' || data.id_kamar == null){
                $("#kamar").val('0');
            }else{
                $("#kamar").val(data.id_kamar);
            }
            
            $("#ambil_koper").val(data.koper);
            if(data.koper == 1){
                $("#div_alamat_koper").show();
            }else{
                $("#div_alamat_koper").hide();
                $("#alamat_koper").val('');
            }
            
            
            $("#idkloter").val(data.id_kloter);
            $("#nama").val(data.nama);
            $("#nama_paspor").val(data.nama_paspor);
            $("#kode_jamaah").val(data.id);
            $("#no_paspor").val(data.paspor_no);
            $("#kota_asal").val(data.kota_asal);
            $("#tempat_lahir").val(data.tempat_lahir);
            $("#tgl_lahir").val(data.tgl_lahir);
            $("#jenis_kelamin").val(data.jenis_kelamin);
            $("#email").val(data.email);
            $("#no_hp").val(data.no_telp);
            $("#pendidikan").val(data.pendidikan_terakhir);
            $("#no_ktp").val(data.no_ktp);
            $("#no_kk").val(data.no_kk);
            $("#agama").val(data.agama);
            $("#status").val(data.status);
            $("#pekerjaan").val(data.pekerjaan);
            $("#warga_negara").val(data.warga_negara);
            $("#pekerjaan").val(data.pekerjaan);
            $("#warga_negara").val(data.warga_negara);
            $("#tgl_keluar_paspor").val(data.paspor_tgl_keluar);
            $("#tgl_exp_paspor").val(data.paspor_tgl_exp);
            $("#kota_penerbit_paspor").val(data.paspor_kota_penerbit);
            $("#nama_ibu").val(data.nama_ibu);
            $("#nama_ayah").val(data.nama_ayah);
            $("#nama_kakek").val(data.nama_kakek);
            $("#berangkat_dengan_siapa").val(data.berangkat_sama_siapa);
            $("#alamat").val(data.alamat);
            $("#alamat_koper").val(data.alamat_pengiriman_koper);
            //var gambar = '<div style="width:100%;text-align:left"><img src="uploads/aksesoris/rz_'+response.gambar+'" style="width:100px;height:100px"></div>';
            //$("#gambar_asli_view").append(gambar);
            $("#foto_asli").val(data.img_foto);
            $("#dok_surat_pernyataan_asli").val(data.upload_dok_surat_pernyataan_sipatuh);
            $("#dok_paspor_asli").val(data.upload_dok_paspor);
            $("#dok_ktp_asli").val(data.upload_dok_ktp);
            $("#dok_kk_asli").val(data.upload_dok_kk);
            
            
//            if(data.upload_dok_surat_pernyataan_sipatuh == '' || data.upload_dok_surat_pernyataan_sipatuh == null){
//                $("#dok_surat_pernyataan_view").html('<span>Belum ada file yang diupload</span>');
//            }else{
//                //data.id_kloter
//                $("#dok_surat_pernyataan_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_surat_pernyataan_sipatuh+'">Lihat Files Surat Pernyataan Sipatuh</a>');
//            }
//            
//            
//            if(data.upload_dok_paspor == '' || data.upload_dok_paspor == null){
//                $("#dok_paspor_view").html('<span>Belum ada file yang diupload</span>');
//            }else{
//                //data.id_kloter
//                $("#dok_paspor_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_paspor+'">Lihat Files Paspor</a>');
//            }
//            
//            
//            if(data.upload_dok_ktp == '' || data.upload_dok_ktp == null){
//                $("#dok_ktp_view").html('<span>Belum ada file yang diupload</span>');
//            }else{
//                //data.id_kloter
//                $("#dok_ktp_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_ktp+'">Lihat Files KTP</a>');
//            }
//            
//            if(data.upload_dok_kk == '' || data.upload_dok_kk == null){
//                $("#dok_kk_view").html('<span>Belum ada file yang diupload</span>');
//            }else{
//                //data.id_kloter
//                $("#dok_kk_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_kk+'">Lihat Files Kartu Keluarga</a>');
//            }
            
            $("#btn_download_pdf").click(function(){
        
                var url = '<?php echo base_url('jamaah/biodata_pdf');?>';
                newwindow=window.open(url+'/'+data.id,'Biodata Jamaah','_blank');
                if (window.focus) {newwindow.focus()}
                return false;

            });
            
            
        }
    });
    
    
    
    $("#tgl_lahir,#tgl_keluar_paspor,#tgl_exp_paspor").datepicker({
    autoclose: true,
    }).on('change', function(){
        $('.datepicker').hide();
    });
    
    
    $("#btn_simpan").click(function(){
        
        var form_data = new FormData($('#form_input')[0]);
        
        swal({
            title: "Update Biodata ?",
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
                url             : base_url + 'jamaah/update', 
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
                        Command: toastr["success"]("Biodata berhasil disimpan", "Berhasil");
                        getcontents('jamaah/biodata','<?php echo $tokens;?>');
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
    
    
    $("#ambil_koper").change(function(){
        var vals = $(this).val();
        if(vals == 1){
            $("#div_alamat_koper").show();
        }else{
            $("#div_alamat_koper").hide();
            $("#alamat_koper").val('');
        }
    });
    
});    
</script>
 <form id="form_input"  method=POST enctype='multipart/form-data'>
            <input type='hidden' class='form-control' name='<?php echo $this->security->get_csrf_token_name(); ?>' value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="foto_asli" name="foto_asli" class="form-control" readonly="">
            <input type="hidden" id="dok_surat_pernyataan_asli" name="dok_surat_pernyataan_asli" class="form-control" readonly="">
            <input type="hidden" id="dok_paspor_asli" name="dok_paspor_asli" class="form-control" readonly="">
            <input type="hidden" id="dok_ktp_asli" name="dok_ktp_asli" class="form-control" readonly="">
            <input type="hidden" id="dok_kk_asli" name="dok_kk_asli" class="form-control" readonly="">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Jamaah</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-contacts"></i>
        <div>
            <h4>Biodata Jamaah <div id="nama_kloter"></div></h4>
          <p class="mg-b-0">Halaman data jamaah.</p>
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
                              <h4 class="tx-normal tx-inverse tx-roboto mg-t-20 mg-b-2"><span id="text_nama"></span></h4>
                              <p class="mg-b-20"><span id="text_kode_jamaah"></span> / <span id="text_no_paspor"></span></p>
                              <p class="mg-b-20"><span id="text_alamat"></span> </p>
                              <p class="mg-b-25 tx-20">
                                  <a href="" class="tx-primary mg-r-5" id="btn_download_pdf"><i class="fa fa-print"></i></a>
<!--                                <a href="" class="tx-danger mg-r-5"><i class="fa fa-file-o"></i></a>-->
                              </p>
                              <p class="mg-b-0">
                                  <a href="#" class="btn btn-info pd-x-50"><span id="text_kota_asal"></span></a>
                              </p>
                              
                            
                              
                            </div>
                        </div><!-- card -->
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="br-section-wrapper">
                    <div class="row"> 
                        <div class="col-md-12">
                            <h6 class="br-section-label">BIODATA</h6>
                            <hr>
                        </div>
                        
              
            <div class="col-md-6">
                
                
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Jamaah</label>
                
                <input type="hidden" id="idkloter" name="idkloter" class="form-control" readonly="">
                <input type="text" id="kode_jamaah" name="kode_jamaah" class="form-control" readonly="">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap (KTP)</label>
                    <input type="text" id="nama" name="nama" class="form-control uppercase">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Lahir</label>
                <div class="input-group">
                <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" readonly style="background:white">
                <label class="input-group-addon btn-tanggal-sanksi" for="tgl_lahir" style="cursor:pointer">
                   <span class="fa fa-calendar"></span>
                </label>
                </div>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. KTP</label>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Agama</label>
                    <select class="form-control" id="agama" name="agama">
                        <option value="0">-Pilih Agama-</option>
                        <option value="1"> ISLAM </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Pendidikan Terakhir</label>
                    <select class="form-control" id="pendidikan" name="pendidikan">
                        <option value="0">-Pilih Pendidikan-</option>
                        <option value="1"> SD </option>
                        <option value="2"> SMP </option>
                        <option value="3"> SMA </option>
                        <option value="4"> D3 </option>
                        <option value="5"> S1 </option>
                        <option value="6"> S2 </option>
                        <option value="7"> S3 </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Warga Negara</label>
                    <select class="form-control" id="warga_negara" name="warga_negara">
                        <option value="0">-Pilih Warga Negara-</option>
                        <option value="1"> WNI </option>
                        <option value="2"> WNA </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Expired Paspor</label>
                <div class="input-group">
                <input type="text" class="form-control" id="tgl_exp_paspor" name="tgl_exp_paspor" readonly style="background:white">
                <label class="input-group-addon btn-tanggal-sanksi" for="tgl_exp_paspor" style="cursor:pointer">
                   <span class="fa fa-calendar"></span>
                </label>
                </div>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Ayah</label>
                    <input type="text" id="nama_ayah" name="nama_ayah" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Kakek</label>
                    <input type="text" id="nama_kakek" name="nama_kakek" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Berangkat Dengan Siapa</label>
                    <input type="text" id="berangkat_dengan_siapa" name="berangkat_dengan_siapa" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. PASPOR</label>
                    <input type="text" id="no_paspor" name="no_paspor" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Lengkap (Paspor)</label>
                    <input type="text" id="nama_paspor" name="nama_paspor" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tempat Lahir</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                    <label for="sel1">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                        <option value="0">-Pilih Jenis Kelamin-</option>
                        <option value="1"> Laki-Laki </option>
                        <option value="2"> Perempuan </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. KK</label>
                    <input type="text" id="no_kk" name="no_kk" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sel1">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="0">-Pilih Status-</option>
                        <option value="1"> Belum Kawin </option>
                        <option value="2"> Kawin </option>
                    </select>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Pekerjaan</label>
                    <input type="text" id="pekerjaan" name="pekerjaan" class="form-control">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Tanggal Keluar Paspor</label>
                <div class="input-group">
                <input type="text" class="form-control" id="tgl_keluar_paspor" name="tgl_keluar_paspor" readonly style="background:white">
                <label class="input-group-addon btn-tanggal-sanksi" for="tgl_keluar_paspor" style="cursor:pointer">
                   <span class="fa fa-calendar"></span>
                </label>
                </div>
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kota Penerbit Paspor</label>
                    <input type="text" id="kota_penerbit_paspor" name="kota_penerbit_paspor" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Ibu</label>
                    <input type="text" id="nama_ibu" name="nama_ibu" class="form-control uppercase" onkeyup="myFunction()">
                </div>
                <div class="form-group">
                        <label for="comment">Kota Asal</label>
                        <input type="text" id="kota_asal" name="kota_asal" class="form-control uppercase" onkeyup="myFunction()">
                    </div>
            </div>
                <div class="col-md-12">
                    
                    
                    <div class="form-group">
                        <label for="sel1">Pilih Kamar atau LA</label>
                        <select class="form-control" id="kamar" name="kamar">
                            <option value="0">-Pilih LA-</option>
                            <option value="1"> Quad - (Kamar Ber 4) </option>
                            <option value="2"> Triple - (Kamar Ber 3) </option>
                            <option value="3"> Double - (Kamar Ber 2) </option>
                            <option value="4"> Quad Campur / Keluarga (Kamar Ber 4) </option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Alamat Lengkap Tinggal</label>
                        <textarea class="form-control" rows="5" id="alamat" name="alamat"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="sel1">Pengambilan Koper</label>
                        <select class="form-control" id="ambil_koper" name="ambil_koper">
                            <option value="0">-Pilih-</option>
                            <option value="1"> Dikirim </option>
                            <option value="2"> Diambil </option>
                            <option value="3"> Diambil di Manasik </option>
                        </select>
                    </div>
                    
                    
                    <div class="form-group" id="div_alamat_koper" style="display:none">
                        <label for="comment">Koper akan dikirim ke Alamat ini, silahkan isi dengan lengkap alamatnya :</label>
                        <textarea class="form-control" rows="5" id="alamat_koper" name="alamat_koper" placeholder="Tulis Alamat dengan lengkap,RT,RW,Nama Kota,Nama Desa,beserta patokannya dan nomor kontak /HP, atau nama kontak penerima Dirumah"></textarea>
                    </div>
                    
                    
                    
                    <hr>
                    <div class="form-group">
                          <div id="fotoku"></div>
                        <label for="demo-vs-definput" class="control-label">Ganti Foto</label><br>
                        <input type="file" id="gambar" name="gambar">
                    </div>
<!--                    <hr>
                    UPLOAD DOKUMEN
                    <hr>
                    
                    <div class="form-group">
                      <div id="fotoku"></div>
                    <label for="demo-vs-definput" class="control-label">Upload Surat Pernyataan Sipatuh</label><br>
                    <input type="file" id="dok_surat_pernyataan" name="dok_surat_pernyataan">
                    <br>
                    <span style="font-size: 10px">Format Files : PDF / jpg / jpeg / png</span>
                    <div id="dok_surat_pernyataan_view"></div>
                    <hr>
                     <div class="form-group">
                        <div id="fotoku"></div>
                        <label for="demo-vs-definput" class="control-label">Upload Paspor</label><br>
                        <input type="file" id="dok_paspor" name="dok_paspor">
                        <br>
                        <span style="font-size: 10px">Format Files : PDF / jpg / jpeg / png</span>
                        <div id="dok_paspor_view"></div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div id="fotoku"></div>
                        <label for="demo-vs-definput" class="control-label">Upload KTP</label><br>
                        <input type="file" id="dok_ktp" name="dok_ktp">
                        <br>
                        <span style="font-size: 10px">Format Files : PDF / jpg / jpeg / png</span>
                        <div id="dok_ktp_view"></div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div id="fotoku"></div>
                        <label for="demo-vs-definput" class="control-label">Upload Kartu Keluarga</label><br>
                        <input type="file" id="dok_kk" name="dok_kk">
                        <br>
                        <span style="font-size: 10px">Format Files : PDF / jpg / jpeg / png</span>
                        <div id="dok_kk_view"></div>
                    </div>-->
                </div>
                <div class="modal-footer pull-right">
                    <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Update Biodata </button>
                </div>
             
        </div>
                </div>
            </div>
        </div>
        
    </div>
 </form>