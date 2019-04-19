<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var status       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var baseurl='<?= base_url();?>';

        // Rinci cutting//
        $.ajax({
        url       : base_url + 'produksi/data_rinci_cutting',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (result) 
            { 
                
                var cutting="<table id='tabel_sablon' class='table  display nowrap'><tr><th>Kode produksi</th><td>"+result.kode_produksi+"</td></tr><tr><th>Tanggal Mulai</th><td>"+result.tgl_mulai+"</td></tr><tr><th>Tanggal selesai</th><td>"+result.tgl_selesai+"</td></tr><tr><th>Bahan Terpakai</th><td>"+result.bahan_terpakai+"</td></tr><tr><th>hasil</th><td>"+result.hasil+"</td></tr><tr><th>Sisa Bahan</th><td>"+result.sisa_bahan+"</td></tr><tr><th>Berat</th><td>"+result.berat+"</td></tr><tr><th>Vendor</th><td>"+result.nm_vendor+"</td></tr><tr><th>Jumlah</th><td>"+result.jumlah+"</td></tr><tr><th>Biaya</th><td>"+result.biaya+"</td></tr><tr><td colspan='2'><img align='center' src='"+baseurl+"uploads/produksi/"+result.gambar+"'/></td></tr></table>";
           
            $("#cutting").html(cutting);
             
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        //end rinci cutting//
        //Rinci sablon//
        $.ajax({
        url       : base_url + 'produksi/data_rinci_sablon',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (result) 
            { 
                var sablon="<table id='tabel_sablon' class='table  display nowrap'><tr><th>Kode produksi</th><td>"+result.kode_produksi+"</td></tr><tr><th>Tanggal Mulai</th><td>"+result.tgl_mulai+"</td></tr><tr><th>Tanggal Ambil</th><td>"+result.tgl_ambil+"</td></tr><tr><th>Jenis Barang</th><td>"+result.jenis_barang+"</td></tr><tr><th>Biaya</th><td>"+result.biaya+"</td></tr><tr><th>Berat</th><td>"+result.berat+"</td></tr><tr><th>Jumlah Akhir</th><td>"+result.jumlah_akhir+"</td></tr><tr><th>Vendor</th><td>"+result.nm_vendor+"</td></tr><tr><td colspan='2'><img align='center' src='"+baseurl+"uploads/produksi/"+result.gambar+"'/></td></tr></table>";
           
            $("#sablon").html(sablon);
             
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        //End rinci sablon//
        //Rinci aksesoris//
        $.ajax({
        url       : base_url + 'produksi/data_rinci_aksesoris',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (result) 
            { 
                var aksesoris="<table id='tabel_akasesoris' class='table  display nowrap'><tr><th>Kode produksi</th><td>"+result.kode_produksi+"</td></tr><tr><th>Tanggal Mulai</th><td>"+result.tgl_mulai+"</td></tr><tr><th>Tanggal Ambil</th><td>"+result.tgl_ambil+"</td></tr><tr><th>Jenis Barang</th><td>"+result.jenis_barang+"</td></tr><tr><th>PIC</th><td>"+result.pic+"</td></tr><tr><th>Berat</th><td>"+result.berat+"</td></tr><tr><th>Jumlah</th><td>"+result.jumlah+"</td></tr><tr><th>Biaya</th><td>"+result.biaya+"</td></tr><tr><th>Vendor</th><td>"+result.nm_vendor+"</td></tr><tr><td colspan='2'><img align='center' src='"+baseurl+"uploads/produksi/"+result.gambar+"'/></td></tr></table>";
           
            $("#aksesoris").html(aksesoris);
             
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        //End rinci aksesoris//
        //Rinci sewing//
        $.ajax({
        url       : base_url + 'produksi/data_rinci_sewing',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (result) 
            { 
                var sewing="<table id='tabel_sewing' class='table  display nowrap'><tr><th>Kode produksi</th><td>"+result.kode_produksi+"</td></tr><tr><th>Tanggal Mulai</th><td>"+result.tgl_mulai+"</td></tr><tr><th>Tanggal Ambil</th><td>"+result.tgl_ambil+"</td></tr><tr><th>Tanggal Kembali</th><td>"+result.tgl_kembali+"</td></tr><tr><th>Jenis Barang</th><td>"+result.jenis_barang+"</td></tr><tr><th>Berat</th><td>"+result.berat+"</td></tr><tr><th>Jumlah</th><td>"+result.jumlah+"</td></tr><tr><th>Biaya</th><td>"+result.biaya+"</td></tr><tr><th>Vendor</th><td>"+result.nm_vendor+"</td></tr><tr><td colspan='2'><img align='center' src='"+baseurl+"uploads/produksi/"+result.gambar+"'/></td></tr></table>";
           
            $("#sewing").html(sewing);
             
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
        //End rinci sewing//
        //Rinci finishing//
        $.ajax({
        url       : base_url + 'produksi/data_rinci_finishing',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (result) 
            { 
                var finishing="<table id='tabel_finishing' class='table  display nowrap'><tr><th>Kode produksi</th><td>"+result.kode_produksi+"</td></tr><tr><th>Tanggal Serah Terima</th><td>"+result.tgl_serah_terima+"</td></tr><tr><tr><th>Berat</th><td>"+result.berat+"</td></tr><tr><th>Jumlah</th><td>"+result.jumlah+"</td></tr><tr><th>Catatan</th><td>"+result.catatan+"</td></tr><tr><td colspan='2'><img align='center' src='"+baseurl+"uploads/produksi/"+result.gambar+"'/></td></tr></table>";
           
            $("#finishing").html(finishing);
             
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"](errorThrown, "Error");
        }

        });
        //End rinci sablon//

});
</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  

.color_text{
    color:gray;
}
table th{
    width: 200px;
}
</style>

<div class="modal fade" id="<?php echo $id_modal;?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        
    <div class="modal-content">
        <div class="modal-header pd-y-20 pd-x-25">
            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Detail Produksi</h6>
            <button type="button" class="close btn-clear" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="cutting-tab" data-toggle="tab" href="#cutting" role="tab" aria-controls="cutting" aria-selected="true">Cutting</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="sablon-tab" data-toggle="tab" href="#sablon" role="tab" aria-controls="sablon" aria-selected="false">Sablon</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="aksesoris-tab" data-toggle="tab" href="#aksesoris" role="tab" aria-controls="aksesoris" aria-selected="false">Aksesoris</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="sewing-tab" data-toggle="tab" href="#sewing" role="tab" aria-controls="sewing" aria-selected="false">Sewing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="finishing-tab" data-toggle="tab" href="#finishing" role="tab" aria-controls="finishing" aria-selected="false">Finishing</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane active" id="cutting" role="tabpanel" aria-labelledby="cutting-tab"></div>
          <div class="tab-pane" id="sablon" role="tabpanel" aria-labelledby="sablon-tab"></div>
          <div class="tab-pane" id="aksesoris" role="tabpanel" aria-labelledby="aksesoris-tab"></div>
          <div class="tab-pane" id="sewing" role="tabpanel" aria-labelledby="sewing-tab">halaman setting</div>
          <div class="tab-pane" id="finishing" role="tabpanel" aria-labelledby="finishing-tab">halaman setting</div>
        </div>

        <script>
          $(function () {
            $('#myTab li:last-child a').tab('show');
          })
        </script>






        <!--end-->
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan2" hidden=""><i class="ft-check"></i> Sudah Di Publish</button>
            <button type="button" class="btn btn-info" id="btn_publish" style="display:none"><i class="la la-check-square-o"></i> Publish Ke Produksi</button>
<!--            <button type="button" class="btn btn-success" id="reloads"><i class="ft-refresh-cw"></i> Reload</button>-->
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div> 
    </div>
</div>

