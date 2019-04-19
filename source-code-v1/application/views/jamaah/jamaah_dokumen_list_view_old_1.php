<script>
    
    $.ajax({
        type: 'POST',
        url: base_url + 'jamaah/biodata_detail',
        data: {},
        dataType  : 'json',
        success: function (data) {
            
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
                $("#dok_kk_view").html('<a target="_blank" href="'+base_url+'uploads/files/kloter_'+data.id_kloter+'/'+data.upload_dok_kk+'">Lihat Files Kartu Kredit</a>');
            }
            
            if(data.upload_verif_sipatuh == 0){
                $("#stssipatuh").html('<i class="fa fa-warning" style="color:red"></i>');
            }else{
                $("#stssipatuh").html('<i class="fa fa-check" style="color:green"></i>');
            }
            
            
            if(data.upload_verif_paspor == 0){
                $("#stspaspor").html('<i class="fa fa-warning" style="color:red"></i>');
            }else{
                $("#stspaspor").html('<i class="fa fa-check" style="color:green"></i>');
            }
            
            
            if(data.upload_verif_ktp == 0){
                $("#stsktp").html('<i class="fa fa-warning" style="color:red"></i>');
            }else{
                $("#stsktp").html('<i class="fa fa-check" style="color:green"></i>');
            }
            
            if(data.upload_verif_kk == 0){
                $("#stskk").html('<i class="fa fa-warning" style="color:red"></i>');
            }else{
                $("#stskk").html('<i class="fa fa-check" style="color:green"></i>');
            }
            
            
        }
    });
    
    
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
            
            <div class="table-wrapper">
            <table id="tabel_dokumen_upload" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen Upload</th>
                        <th>URL Files</th>
                        <th>Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td><div id="dok_surat_pernyataan_view"></div></td>
                        <td><div id="stssipatuh"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>PASPOR</td>
                        <td><div id="dok_paspor_view"></div></td>
                        <td><div id="stspaspor"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>KTP</td>
                        <td><div id="dok_ktp_view"></div></td>
                        <td><div id="stsktp"></div></td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KK</td>
                        <td><div id="dok_kk_view"></div></td>
                        <td><div id="stskk"></div></td>
                    </tr>
                </tbody>
            </table>              
                
            <hr>
            
            <h6 class="br-section-label">DOKUMEN KIRIM</h6>
            
            <table id="tabel_dokumen_kirim" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen KIRIM</th>
                        <th>Tgl Kirim</th>
                        <th>Verifikasi</th>
                        <th>Tgl Verifikasi</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>FOTO 4X6 BG PUTIH</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>BUKU VAKSIN MININGITIS</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>PASPOR</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>BUKU NIKAH</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>AKTE KELAHIRAN</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>TIKET PP</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KARTU KELUARGA</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KTP</td>
                        <td><input class="form-control" id="tgl_kirim_foto" style="width:100px;padding:5px" placeholder="Pilih Tanggal"></td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                </tbody>
            </table>
                
                
            </div>
            
        </div>
    </div>