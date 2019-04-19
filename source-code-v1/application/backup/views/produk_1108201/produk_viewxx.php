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

                    var link_detail  = "<a href='javascript:void(0)' onclick=\"getpopup('produk/detail_list','"+tokens+"','popupedit','"+result[i].kode+"','"+result[i].status+"');\" data-placement='top' ><div class='btn btn-info btn-sm btn-icon la la-eye' title='Detail Produk' ></div></a>";
                    
                    var img_qrcode_produksi  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode_produksi+'</span></div>';
                    var img_qrcode_produk  = '<div style="width:100%;text-align:center"><img src="uploads/qrcode/'+result[i].img_qrcode+'" style="width:60px;height:60px"> <span style="font-size:12px"><br>'+result[i].kode+'</span></div>';
                    
                    var img;
                    if(result[i].gambar == '' || result[i].gambar == null){
                        img = '';
                    }else{
                        img  = '<div style="width:100%;text-align:center"><img src="uploads/produksi/'+result[i].gambar+'" style="width:80px;height:80px"></div>';
                    }
                    
                    var status;
                    if(result[i].beli == 0){
                        status = '<span style="color:blue">Tersedia</span>';
                    }else{
                        status = '<span style="color:red">Terjual</span>';
                    }
                    
                    data.push([img_qrcode_produksi,img_qrcode_produk,img,status,'Rp. ' +result[i].hargas]);
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
            <p class="br-section-text"></p>

            <div class="table-wrapper table-responsive">
            <table id="tabel_produk" class="table  display nowrap">
                        <thead>
                            <tr>
                                <th>Kode Produksi</th>
                                <th>Kode Produk</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                    </table>   
            </div>
            
        </div>
    </div>



    

