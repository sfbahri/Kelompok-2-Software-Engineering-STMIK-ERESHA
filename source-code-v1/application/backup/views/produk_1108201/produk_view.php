<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    var data_produk = function(){
        $('#tabel_produk').hide();
        $.ajax({ 
            url: base_url + 'produk/data',
            type: "post",
            data:{<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
            dataType: "json",
            async : 'false',
            success: function(result)
            {
                var data = [];
                for ( var i=0 ; i<result.length ; i++ ) {
                    var no = i+1;
                    var baseurl = '<?php echo base_url();?>';

                    var link_detail  = "<a href='javascript:void(0)' onclick=\"getpopup('produk/detail_list_produk','"+tokens+"','popupedit','"+result[i].kode+"');\" data-placement='top' ><div class='btn btn-info btn-sm fa fa-eye' title='Detail Produk' ></div></a>";
                    var link_print  = "<a href='cetak/cetak_produk_label/"+result[i].kode+"' target='_blank' data-placement='top' ><div class='btn btn-success btn-sm fa fa-print' title='Print Label' ></div></a>";
                    
                    var img_qrcode_produksi  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode_produksi+'</span></div>';
                    var img_qrcode_produk  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode+'</span></div>';
                    
                    var img;
                    if(result[i].img == '' || result[i].img == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produk/'+result[i].img+'" style="width:80px;height:80px"></div>';
                    }
                    
                    var nama_v;
                    if(result[i].id_vendor == null){
                        nama_v = '-';
                    }else{
                        nama_v = result[i].nama_vendor;
                    }
                    
                    data.push([no,result[i].nama,img,'Rp. ' +result[i].hargas,result[i].stok+' Pcs',nama_v,link_detail,link_print]);
                }
                $('#tabel_produk').DataTable({
                    //"bJQueryUI"     : true,
                    data                : data,
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
               
            },
            beforeSend: function () {

            },
            complete: function () {
                $('#tabel_produk').show();
            }
        });
    }
    data_produk();
    
    
   
});    
</script>
    
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Produk</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-shirt"></i>
        <div>
          <h4>Data Produk</h4>
          <p class="mg-b-0">Halaman data produk.</p>
        </div>
    </div><!-- d-flex -->

      
    <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">Tabel Data Produk</h6>
            <p class="br-section-text"><button class="btn btn-warning btn-sm" onclick="getpopup('produk/tambah_manual','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Stok Manual </button>   <button class="btn btn-primary btn-sm" onclick="getpopup('produk/tambah_manual_by_vendor','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-plus-circle"></i> Tambah Stok Manual By Vendor </button></p>
            

            <div class="table-wrapper table-responsive">
            <table id="tabel_produk" class="table  display nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Vendor</th>
                                <th>Detail</th>
                                <th>Print Label</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
            
        </div>
    </div>



    

