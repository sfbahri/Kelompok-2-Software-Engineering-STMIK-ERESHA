<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_jamaah   = '<?php echo $id_row;?>';
    var id_kloter   = '<?php echo $id_row2;?>';
    var tokens      = '<?php echo $tokens;?>';
     
    //loading(); 
        
    data_list_dokumen_upload = function(){    
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/detail',
        data: {id_jamaah:id_jamaah},
        dataType  : 'json',
        success: function (data) {
            
            $("#nama_jamaah").val(data.nama);
            $("#nopaspor_jamaah").val(data.paspor_no);
            $("#kode_jamaah").val(data.id);
            
            
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
            
            
            if(data.upload_verif_sipatuh == 0){
                $("#stssipatuh").html('<i class="fa fa-warning" style="color:red"></i>');
                $("#btnsipatuh").html('<button class="btn btn-primary btn-sm" id="btn_verif_dok_sipatuh" onclick=verif_dok_upload("sipatuh")><i class="fa fa-check"></i></button>');
            }else{
                $("#stssipatuh").html('<i class="fa fa-check" style="color:green"></i>');
                $("#btnsipatuh").html('<button class="btn btn-danger btn-sm" id="btn_verif_dok_sipatuh" onclick=un_verif_dok_upload("sipatuh")><i class="fa fa-remove"></i></button>');
            }
            
            
            if(data.upload_verif_paspor == 0){
                $("#stspaspor").html('<i class="fa fa-warning" style="color:red"></i>');
                $("#btnpaspor").html('<button class="btn btn-primary btn-sm" id="btn_verif_dok_sipatuh" onclick=verif_dok_upload("paspor")><i class="fa fa-check"></i></button>');
            }else{
                $("#stspaspor").html('<i class="fa fa-check" style="color:green"></i>');
                $("#btnpaspor").html('<button class="btn btn-danger btn-sm" id="btn_verif_dok_sipatuh" onclick=un_verif_dok_upload("paspor")><i class="fa fa-remove"></i></button>');
            }
            
            
            if(data.upload_verif_ktp == 0){
                $("#stsktp").html('<i class="fa fa-warning" style="color:red"></i>');
                $("#btnktp").html('<button class="btn btn-primary btn-sm" id="btn_verif_dok_sipatuh" onclick=verif_dok_upload("ktp")><i class="fa fa-check"></i></button>');
            }else{
                $("#stsktp").html('<i class="fa fa-check" style="color:green"></i>');
                $("#btnktp").html('<button class="btn btn-danger btn-sm" id="btn_verif_dok_sipatuh" onclick=un_verif_dok_upload("ktp")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.upload_verif_kk == 0){
                $("#stskk").html('<i class="fa fa-warning" style="color:red"></i>');
                $("#btnkk").html('<button class="btn btn-primary btn-sm" id="btn_verif_dok_sipatuh" onclick=verif_dok_upload("kk")><i class="fa fa-check"></i></button>');
            }else{
                $("#stskk").html('<i class="fa fa-check" style="color:green"></i>');
                $("#btnkk").html('<button class="btn btn-danger btn-sm" id="btn_verif_dok_sipatuh" onclick=un_verif_dok_upload("kk")><i class="fa fa-remove"></i></button>');
            }
            
            
        },
        beforeSend: function () {
                //loadingPannel.show();
        },
        complete: function () {
            //loadingPannel.hide();
        }
    });
    }
    data_list_dokumen_upload();
    
    verif_dok_upload = function(kategori){
        $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/verif_dok_upload',
        data: {id_jamaah:id_jamaah,id_kloter:id_kloter,kategori:kategori},
        dataType  : 'json',
        success: function (response){
            if(response == true){
                Command: toastr["success"]("Dokumen Berhasil di verifikasi", "Berhasil");
                data_list_dokumen_upload();
            }else{
                Command: toastr["error"]("Dokumen Belum berhasil di verifikasi", "Verifikasi Gagagl !");
                data_list_dokumen_upload();
            }
        }
        });
    }
    
    
    
    un_verif_dok_upload = function(kategori){
        $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/un_verif_dok_upload',
        data: {id_jamaah:id_jamaah,id_kloter:id_kloter,kategori:kategori},
        dataType  : 'json',
        success: function (response){
            if(response == true){
                Command: toastr["success"]("Dokumen Berhasil di unverifikasi", "Berhasil");
                data_list_dokumen_upload();
            }else{
                Command: toastr["error"]("Dokumen Belum berhasil di verifikasi", "Verifikasi Gagagl !");
                data_list_dokumen_upload();
            }
        }
        });
    }
    
        


                $('#tabel_dokumen_upload,#tabel_dokumen_kirim').DataTable({
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
                    responsive: true,
                    language: {
                      searchPlaceholder: 'Cari',
                      sSearch: '',
                      lengthMenu: '_MENU_',
                    },
                });

});    

</script>






<div class="modal fade" id="<?php echo $id_modal;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> 
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Dokumen Jamaah</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Kode Jamaah</label>
                <input type="text" id="kode_jamaah" name="kode_jamaah" class="form-control" readonly="">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">Nama Jamaah</label>
                <input type="text" id="nama_jamaah" name="nama_jamaah" class="form-control" readonly="">
                </div>
            </div>
                
            <div class="col-md-4">
                <div class="form-group">
                <label for="demo-vs-definput" class="control-label">No Paspor</label>
                <input type="text" id="nopaspor_jamaah" name="nopaspor_jamaah" class="form-control" readonly="">
                </div>
            </div>
            </div>
            
<!--            DOKUMEN UPLOAD
            <hr>
            
-->            <table id="tabel_dokumen_upload" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen Upload</th>
                        <th>URL Files</th>
                        <th>Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td><div id="dok_surat_pernyataan_view"></div></td>
                        <td><div id="stssipatuh"></div></td>
                        <td><div id="btnsipatuh"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>PASPOR</td>
                        <td><div id="dok_paspor_view"></div></td>
                        <td><div id="stspaspor"></div></td>
                        <td><div id="btnpaspor"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>KTP</td>
                        <td><div id="dok_ktp_view"></div></td>
                        <td><div id="stsktp"></div></td>
                        <td><div id="btnktp"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KK</td>
                        <td><div id="dok_kk_view"></div></td>
                        <td><div id="stskk"></div></td>
                        <td><div id="btnkk"></div></td>
                    </tr>
                </tbody>
            </table>
            
            
<hr>

<!--DOKUMEN KIRIM-->
            

            <table id="tabel_dokumen_kirim" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen KIRIM</th>
                        <th>Tgl Upload</th>
                        <th>Verifikasi</th>
                        <th>Tgl Verifikasi</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>FOTO 4X6 BG PUTIH</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>BUKU VAKSIN MININGITIS</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>PASPOR</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>BUKU NIKAH</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>AKTE KELAHIRAN</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>TIKET PP</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KARTU KELUARGA</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KTP</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                </tbody>
            </table>


        </div> 
        <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>



