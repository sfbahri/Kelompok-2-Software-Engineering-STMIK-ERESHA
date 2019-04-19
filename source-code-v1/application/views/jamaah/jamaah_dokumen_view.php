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
            
            
            
            /*
             * Dokumen Terima
             */
            if(data.kirim_foto == 0){
                $("#kirim_foto").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_foto").text(data.terima_tgl_foto);
                $("#usr_kirim_foto").text(data.terima_usr_foto);
                $("#btn_kirim_foto").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("foto")><i class="fa fa-check"></i></button>');
            }else{
                $("#tgl_kirim_foto").text(data.terima_tgl_foto);
                $("#usr_kirim_foto").text(data.terima_usr_foto);
                $("#kirim_foto").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#btn_kirim_foto").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("foto")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.kirim_buku_vaksin == 0){
                $("#kirim_buku_vaksin").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_vaksin").text(data.terima_tgl_buku_vaksin);
                $("#usr_kirim_vaksin").text(data.terima_usr_buku_vaksin);
                $("#btn_kirim_vaksin").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("vaksin")><i class="fa fa-check"></i></button>');
            }else{
                $("#kirim_buku_vaksin").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_vaksin").text(data.terima_tgl_buku_vaksin);
                $("#usr_kirim_vaksin").text(data.terima_usr_buku_vaksin);
                $("#btn_kirim_vaksin").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("vaksin")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.kirim_paspor == 0){
                $("#kirim_paspor").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_paspor").text(data.terima_tgl_paspor);
                $("#usr_kirim_paspor").text(data.terima_usr_paspor);
                $("#btn_kirim_paspor").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("paspor")><i class="fa fa-check"></i></button>');
            }else{
                 $("#kirim_paspor").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_paspor").text(data.terima_tgl_paspor);
                $("#usr_kirim_paspor").text(data.terima_usr_paspor);
                $("#btn_kirim_paspor").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("paspor")><i class="fa fa-remove"></i></button>')
            }
            
            if(data.kirim_buku_nikah == 0){
                $("#kirim_buku_nikah").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_buku_nikah").text(data.terima_tgl_buku_nikah);
                $("#usr_kirim_buku_nikah").text(data.terima_usr_buku_nikah);
                $("#btn_kirim_buku_nikah").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("buku_nikah")><i class="fa fa-check"></i></button>');
            }else{
                 $("#kirim_buku_nikah").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_buku_nikah").text(data.terima_tgl_buku_nikah);
                $("#usr_kirim_buku_nikah").text(data.terima_usr_buku_nikah);
                $("#btn_kirim_buku_nikah").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("buku_nikah")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.kirim_akte_kelahiran == 0){
                $("#kirim_akte_kelahiran").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_akte_kelahiran").text(data.terima_tgl_akte_kelahiran);
                $("#usr_kirim_akte_kelahiran").text(data.terima_usr_akte_kelahiran);
                $("#btn_kirim_akte_kelahiran").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("akte_kelahiran")><i class="fa fa-check"></i></button>');
            }else{
                 $("#kirim_akte_kelahiran").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_akte_kelahiran").text(data.terima_tgl_akte_kelahiran);
                $("#usr_kirim_akte_kelahiran").text(data.terima_usr_akte_kelahiran);
                $("#btn_kirim_akte_kelahiran").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("akte_kelahiran")><i class="fa fa-remove"></i></button>');
            }
               

             if(data.kirim_tiket_pp == 0){
                $("#kirim_tiket_pp").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_tiket_pp").text(data.terima_tgl_tiket_pp);
                $("#usr_kirim_tiket_pp").text(data.terima_usr_tiket_pp);
                $("#btn_kirim_tiket_pp").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("tiket_pp")><i class="fa fa-check"></i></button>');
            }else{
                $("#kirim_tiket_pp").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_tiket_pp").text(data.terima_tgl_tiket_pp);
                $("#usr_kirim_tiket_pp").text(data.terima_usr_tiket_pp);
                $("#btn_kirim_tiket_pp").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("tiket_pp")><i class="fa fa-remove"></i></button>');

            }   

            if(data.kirim_ktp == 0){
                $("#kirim_ktp").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_ktp").text(data.terima_tgl_ktp);
                $("#usr_kirim_ktp").text(data.terima_usr_ktp);
                $("#btn_kirim_ktp").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("ktp")><i class="fa fa-check"></i></button>');
            }else{
                 $("#kirim_ktp").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_ktp").text(data.terima_tgl_ktp);
                $("#usr_kirim_ktp").text(data.terima_usr_ktp);
                $("#btn_kirim_ktp").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("ktp")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.kirim_kk == 0){
               $("#kirim_kk").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_kk").text(data.terima_tgl_kk);
                $("#usr_kirim_kk").text(data.terima_usr_kk);
                $("#btn_kirim_kk").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("kk")><i class="fa fa-check"></i></button>');
            }else{
                $("#kirim_kk").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_kk").text(data.terima_tgl_kk);
                $("#usr_kirim_kk").text(data.terima_usr_kk);
                $("#btn_kirim_kk").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("kk")><i class="fa fa-remove"></i></button>');
            }
            
            if(data.kirim_surat_pernyataan_sipatuh == 0){
                $("#kirim_sipatuh").html('<span>Dokumen Belum Di Terima</span> <i class="fa fa-warning" style="color:red"></i>');
                $("#tgl_kirim_sipatuh").text(data.terima_tgl_surat_pernyataan_sipatuh);
                $("#usr_kirim_sipatuh").text(data.terima_usr_surat_pernyataan_sipatuh);
                $("#btn_kirim_sipatuh").html('<button class="btn btn-primary btn-sm" onclick=verif_dok_kirim_upload("sipatuh")><i class="fa fa-check"></i></button>');
            }else{
                $("#kirim_sipatuh").html('<span style="color:green">Dokumen Sudah Di Terima</span> <i class="fa fa-check" style="color:green"></i>');
                $("#tgl_kirim_sipatuh").text(data.terima_tgl_surat_pernyataan_sipatuh);
                $("#usr_kirim_sipatuh").text(data.terima_usr_surat_pernyataan_sipatuh);
                $("#btn_kirim_sipatuh").html('<button class="btn btn-danger btn-sm" onclick=verif_dok_kirim_upload_cancel("sipatuh")><i class="fa fa-remove"></i></button>');
            }
            
            /*
             * 
             */
            
            
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
    
    verif_dok_kirim_upload = function(kategori){
        $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/verif_dok_kirim_upload',
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

    verif_dok_kirim_upload_cancel = function(kategori){
        $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/verif_dok_kirim_upload_cancel',
        data: {id_jamaah:id_jamaah,id_kloter:id_kloter,kategori:kategori},
        dataType  : 'json',
        success: function (response){
            if(response == true){
                Command: toastr["success"]("Verifikasi Dokumen Berhasil di batalkan", "Berhasil");
                data_list_dokumen_upload();
            }else{
                Command: toastr["error"]("Dokumen Belum berhasil di verifikasi", "Verifikasi Gagagl !");
                data_list_dokumen_upload();
            }
        }
        });
    }
    
    
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
                        <th>Verifikasi</th>
                        <th>Tgl Verifikasi</th>
                        <th>Admin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>FOTO 4X6 BG PUTIH</td>
                        <td><div id="kirim_foto"></div></td>
                        <td><div id="tgl_kirim_foto"></div></td>
                        <td><div id="usr_kirim_foto"></div></td>
                        <td><div id="btn_kirim_foto"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>BUKU VAKSIN MININGITIS</td>
                        <td><div id="kirim_buku_vaksin"></div></td>
                        <td><div id="tgl_kirim_vaksin"></div></td>
                        <td><div id="usr_kirim_vaksin"></div></td>
                        <td><div id="btn_kirim_vaksin"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>PASPOR</td>
                        <td><div id="kirim_paspor"></div></td>
                        <td><div id="tgl_kirim_paspor"></div></td>
                        <td><div id="usr_kirim_paspor"></div></td>
                        <td><div id="btn_kirim_paspor"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>BUKU NIKAH</td>
                        <td><div id="kirim_buku_nikah"></div></td>
                        <td><div id="tgl_kirim_buku_nikah"></div></td>
                        <td><div id="usr_kirim_buku_nikah"></div></td>
                        <td><div id="btn_kirim_buku_nikah"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>AKTE KELAHIRAN</td>
                        <td><div id="kirim_akte_kelahiran"></div></td>
                        <td><div id="tgl_kirim_akte_kelahiran"></div></td>
                        <td><div id="usr_kirim_akte_kelahiran"></div></td>
                        <td><div id="btn_kirim_akte_kelahiran"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>TIKET PP</td>
                        <td><div id="kirim_tiket_pp"></div></td>
                        <td><div id="tgl_kirim_tiket_pp"></div></td>
                        <td><div id="usr_kirim_tiket_pp"></div></td>
                        <td><div id="btn_kirim_tiket_pp"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td><div id="kirim_sipatuh"></div></td>
                        <td><div id="tgl_kirim_sipatuh"></div></td>
                        <td><div id="usr_kirim_sipatuh"></div></td>
                        <td><div id="btn_kirim_sipatuh"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KARTU KELUARGA</td>
                        <td><div id="kirim_kk"></div></td>
                        <td><div id="tgl_kirim_kk"></div></td>
                        <td><div id="usr_kirim_kk"></div></td>
                        <td><div id="btn_kirim_kk"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KTP</td>
                        <td><div id="kirim_ktp"></div></td>
                        <td><div id="tgl_kirim_ktp"></div></td>
                        <td><div id="usr_kirim_ktp"></div></td>
                        <td><div id="btn_kirim_ktp"></div></td>
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



