<script type="text/javascript">
$(document).ready(function(){
    
    //var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var id_kloter = '<?php echo $id_rows;?>';
    
    loading();

    get_data_detail_kloter = function(){ 
    $.ajax({
        type: 'POST',
        url: base_url + 'kloter/detail',
        data: {id_kloter:id_kloter},
        dataType  : 'json',
        success: function (data) {
            $("#nama_kloter").text(data.nama);
            $("#tgl_berangkat").val(data.tgl_berangkat);
            $("#tgl_pulang").val(data.tgl_pulang);
        }
    });
    }
    get_data_detail_kloter();
    
    refresh = function(){
        data_by_kloter();
    }
    
});    
</script>
    
   <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Jamaah</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-contacts"></i>
        <div>
            <h4>Data Jamaah <div id="nama_kloter"></div></h4>
          <p class="mg-b-0">Halaman data jamaah.</p>
        </div>
    </div>
    
    
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Jamaah</h6>
            <p class="br-section-text" style="padding-bottom: 0px">
                <button class="btn btn-danger btn-sm" onclick="getcontents('kloter','<?php echo $this->session->userdata('sess_token');?>')"><i class="fa fa-arrow-left"></i> Kembali </button> 
<!--                <button class="btn btn-success btn-sm" onclick="refresh()"><i class="fa fa-refresh"></i> Segarkan </button> 
                <button class="btn btn-info btn-sm" onclick="getpopup('jamaah/tambah','<?php echo $this->session->userdata('sess_token');?>','popup_tambah','<?php echo $id_rows;?>')"><i class="fa fa-plus-circle"></i> Tambah Jamaah </button> 
                <button id="btn_download_pdf" class="btn btn-primary btn-sm"><i class="fa fa-file-pdf-o"></i> Cetak List Jamaah </button>-->
            </p>
            
              <div class="card">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#data_j" data-toggle="tab">Data Jamaah</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#dok_j" data-toggle="tab">Dokumen</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#toprated" data-toggle="tab">Pembayaran</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#koper" data-toggle="tab">Koper & Pernak-Pernik</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#cetaks" data-toggle="tab">Laporan Cetak</a>
                    </li>
                  </ul>
                </div><!-- card-header -->
                <div class="card-body color-gray-lighter">
                  <div class="tab-content">
                    <div class="tab-pane active" id="data_j">
                        <?php include "tabs_data_jamaah_view.php";?>
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="dok_j">
                        <?php include "tabs_dok_jamaah_view.php";?>
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="toprated">
                        <?php include "tabs_pembayaran_jamaah_view.php";?>
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="koper">
                        <?php include "tabs_koper_jamaah_view.php";?>
                    </div><!-- tab-pane -->
                    <div class="tab-pane" id="cetaks">
                        <?php include "tabs_cetak_jamaah_view.php";?>
                    </div><!-- tab-pane -->
                  </div><!-- tab-content -->
                </div><!-- card-body -->
              </div><!-- card -->
            
        </div>
    </div>