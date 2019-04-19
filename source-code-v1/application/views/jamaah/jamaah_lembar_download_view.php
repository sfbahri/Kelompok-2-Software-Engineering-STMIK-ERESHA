<script type="text/javascript">
$(document).ready(function(){
    
    var id_kloter = '<?php echo $id_rows;?>';

    
    
    $("#btn_download_pdf").click(function(){
       
        var url = '<?php echo base_url('jamaah/lembar_checklist_dokumen/');?>';
        
        newwindow=window.open(url,'Checklist Dokumen Kirim','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    
    $("#btn_download_pdf_2").click(function(){
       
        var url = '<?php echo base_url('jamaah/lembar_dokumen_kop_map/');?>';
        
        newwindow=window.open(url,'Checklist Dokumen Kirim','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    
    $('#table_download').DataTable({
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
    
   
});    
</script>
    
   <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Download</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-cloud-download"></i>
        <div>
            <h4>Data Download <div id="nama_kloter"></div></h4>
          <p class="mg-b-0">Halaman data download.</p>
        </div>
    </div>
    
    
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <div class="table-wrapper table-responsive">
            <table id="table_download" class="table table-hover table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th width="350px">Keterangan</th>
                        <th>Link Unduh</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <td>Format Lembar Pernyataan Sipatuh</td>
                        <td>Lembar ini diperlukan untuk persayarat pembuatan/pengurusan visa , silahkan dilengkapi biodata pernyataan sipatuh dan <b>bermateri di tanda tangan bagian jamaah</b>, dan <b>tanda tangan saksi yang tidak berangkat</b> umroh.</td>
                        <td><a href="<?php echo base_url('files/Pernyataan_Sipatuh.pdf');?>" target="_blank" style="color:blue">Unduh</a></td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>Lembar Checklist Pengiriman Dokumen</td>
                        <td>Silahkan Download lembar ini dan silahkan checklist dokumen yang dikirim, dan masukan lembar ini pada map dokumen yang dikirim.</td>
                        <td><a id="btn_download_pdf" style="color:blue;cursor:pointer">Unduh</a></td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>Lembar Kop Surat Pengiriman dan Penerima Dokumen</td>
                        <td>Silahkan Download lembar ini dan tempel pada map dokumen yang mau dikirim</td>
                        <td><a id="btn_download_pdf_2" style="color:blue;cursor:pointer">Unduh</a></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>