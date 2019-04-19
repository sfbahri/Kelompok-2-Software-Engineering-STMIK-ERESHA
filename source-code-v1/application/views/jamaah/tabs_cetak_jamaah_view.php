<script>
    
    var id_kloterss = '<?php echo $id_rows;?>';
    
    $("#btn_download_jamaah").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_list_pdf/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'List Jamaah Kloter','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    $("#btn_download_pembayaran_jamaah").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_list_pembayaran_pdf/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'List Jamaah Kloter','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    $("#btn_download_pengiriman_koper_jamaah").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_list_pengiriman_koper_pdf/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'List Jamaah Kloter','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    $("#btn_download_pengiriman_koper_dikirim_jamaah").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_list_pengiriman_koper_dikirim_pdf/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'List Jamaah Kloter','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
     $("#btn_download_pengiriman_koper_dikirim_jamaah_excel").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_list_pengiriman_koper_dikirim_excel/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'List Jamaah Kloter','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
     $("#btn_download_rekap_sipatuh").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_rekap_sipatuh2/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'Rekap Sipatuh','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
    $("#btn_download_rekap_manifest").click(function(){
       
        var url = '<?php echo base_url('jamaah/jamaah_rekap_manifest/');?>';
        
        newwindow=window.open(url+'/'+id_kloterss,'Rekap Manifest','_blank');
        if (window.focus) {newwindow.focus()}
        return false;
        
    });
    
</script>
<div class="row">
    <div class="col-xl-6">
      <div class="alert alert-info alert-solid" role="alert">
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="fa fa-file-pdf-o lh-3 tx-48"></i>
          <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
            <h5 class="mg-b-2 pd-t-2">Laporan Data Jamaah</h5>
            <p class="mg-b-0 tx-xs op-8"><div id="btn_download_jamaah" style="cursor:pointer">Downloads</div></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
    </div><!-- col-xl-6 -->  

    <div class="col-xl-6">
      <div class="alert alert-info alert-solid" role="alert">
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="fa fa-file-pdf-o lh-3 tx-48"></i>
          <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
            <h5 class="mg-b-2 pd-t-2">Laporan Pembayaran Jamaah</h5>
            <p class="mg-b-0 tx-xs op-8"><div id="btn_download_pembayaran_jamaah" style="cursor:pointer">Downloads</div></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
    </div><!-- col-xl-6 -->  
    
    
    <div class="col-xl-6">
      <div class="alert alert-info alert-solid" role="alert">
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="fa fa-file-pdf-o lh-3 tx-48"></i>
          <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
            <h5 class="mg-b-2 pd-t-2">Laporan Pengiriman Koper Jamaah</h5>
            <p class="mg-b-0 tx-xs op-8"><a id="btn_download_pengiriman_koper_jamaah" style="cursor:pointer">Semuanya</a > / <a id="btn_download_pengiriman_koper_dikirim_jamaah" style="cursor:pointer">Dikirim Saja</a> / <a id="btn_download_pengiriman_koper_dikirim_jamaah_excel" style="cursor:pointer">Dikirim Saja Format Excel</a></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
    </div><!-- col-xl-6 -->
    
    <div class="col-xl-6">
      <div class="alert alert-info alert-solid" role="alert">
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="fa fa-file-pdf-o lh-3 tx-48"></i>
          <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
            <h5 class="mg-b-2 pd-t-2">Laporan Rekap SiPatuh</h5>
            <p class="mg-b-0 tx-xs op-8"><a id="btn_download_rekap_sipatuh" style="cursor:pointer">Downloads</a ></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
    </div><!-- col-xl-6 -->
    
    <div class="col-xl-6">
      <div class="alert alert-info alert-solid" role="alert">
        <div class="d-sm-flex align-items-center justify-content-start">
          <i class="fa fa-file-pdf-o lh-3 tx-48"></i>
          <div class="mg-sm-l-15 mg-t-15 mg-sm-t-0">
            <h5 class="mg-b-2 pd-t-2">Laporan Rekap Manifest</h5>
            <p class="mg-b-0 tx-xs op-8"><a id="btn_download_rekap_manifest" style="cursor:pointer">Downloads</a ></p>
          </div>
        </div><!-- d-flex -->
      </div><!-- alert -->
    </div><!-- col-xl-6 -->
    
    
</div><!-- row -->