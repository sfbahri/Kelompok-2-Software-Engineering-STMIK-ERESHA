<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    var noso     = '<?php echo $id_rows;?>';
    
     $.ajax({
            url       : base_url + 'markom/design_gambar_data_so_detail',
            type      : "post",
            dataType  : 'json',
            data      : {noso : noso,
                        <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
            success: function (response) {
             $(".nama_tema").text(response.nama);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    
    
    list_gambar_produksi = function(){
        
        $.ajax({
        url       : base_url + 'markom/data_gambar_produksi_admin',
        type      : "post",
        dataType  : 'json',
        data      : {noso:noso,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
        success: function (res) {
            
            document.getElementById("list_gambar").innerHTML = "";
            
            for ( var i=0 ; i<res.length ; i++ ) {
                //style="width:600px;height:450px;"
                
                var namagambar;
                if(res[i].nama == null){
                    namagambar = '<span style="color:red;font-size:11px">Nama Gambar masih kosong !</span><br>';
                }else{
                    namagambar = res[i].nama;
                }
                
                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./uploads/produksi/'+res[i].gambar+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
//                                html+='<div class="img-option">'
//                                  html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
//                                  html+='<a href="javascript:void(0)" title="Approve" onclick=\"img_approve('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-check" style="color:green"></i></div></a>'
//                                  html+='<a href="./uploads/produksi/'+res[i].gambar+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
//                                  html+='<a href="javascript:void(0)" title="Nama Gambar" onclick=\"img_input_nama('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-pencil" style="color:gray"></i></div></a>'
//                                html+='</div>'
                              html+='</figcaption></figure>'
                        html+='<span style="color:black;font-size:12px;margin-left:10px">'+namagambar+'</span><div style="margin-top:20px"></div>'
                $("#list_gambar").append(html);
                
            }
            
//            for ( var i=0 ; i<res.length ; i++ ) {
//                //style="width:600px;height:450px;"
//                
//                var namagambar;
//                if(res[i].nama == null){
//                    namagambar = '<span style="color:red;font-size:10px">Nama Gambar masih kosong !</span>';
//                }else{
//                    namagambar = res[i].nama;
//                }
//                
//                var html = '<div class="col-md-4" style="float:left;margin-bottom:30px"><div class="card" >'
//                        html+='<figure class="overlay"><img class="card-img-top img-fluid" src="./uploads/produksi/'+res[i].gambar+'" alt="Image" class="img-fluid" ><figcaption class="overlay-body d-flex align-items-end justify-content-center">'
//                                html+='<div class="img-option">'
//                                  html+='<a href="javascript:void(0)" title="Hapus" onclick=\"img_hapus('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-trash" style="color:red"></i></div></a>'
//                                  html+='<a href="javascript:void(0)" title="Approve" onclick=\"img_approve('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-check" style="color:green"></i></div></a>'
//                                  html+='<a href="./uploads/produksi/'+res[i].gambar+'" title="Lihat Lebih Jelas" target="_blank" class="img-option-link"><div><i class="fa fa-eye" style="color:yellow"></i></div></a>'
                                  //html+='<a href="javascript:void(0)" title="Catatan" onclick=\"img_note('+res[i].id+');\" class="img-option-link"><div><i class="fa fa-pencil" style="color:blue"></i></div></a>'
//                                html+='</div>'
//                              html+='</figcaption></figure>'
//                        html+='<div class="card-body">'
//                        html+='<p class="card-text">Nama Gambar : <b>'+namagambar+'</b></p>'
//                        html+='</div>'
//                        html+='</div></div>';
//                $("#list_gambar").append(html);
//                
//            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    list_gambar_produksi();
    
    img_hapus = function(id){
        swal({
            title: "Hapus gambar yang dipilih ?",
            text: "Jika ingin disimpan, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Hapus",
            confirmButtonColor: "#E73D4A"
        },
        function(){

            $.ajax({
                url       : base_url + 'markom/gambar_hapus',
                type      : "post",
                dataType  : 'json',
                data      : {id : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Gambar berhasil dihapus", "Berhasil");
                        list_gambar_produksi();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
    }
    
    
    img_approve= function(id){
        swal({
            title: "Kirim gambar ini ke data Produksi ?",
            text: "Jika ingin disimpan, silahkan klik button hapus",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonText: "Kirim",
            confirmButtonColor: "#286090"
        },
        function(){

            $.ajax({
                url       : base_url + 'markom/gambar_approve',
                type      : "post",
                dataType  : 'json',
                data      : {id : id,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                success: function (response) {
                if(response == true){  
                        swal.close();
                        Command: toastr["success"]("Gambar berhasil dikirim ke produksi", "Berhasil");
                        list_gambar_produksi();
                }else{
                    Command: toastr["error"]("Simpan error, data tidak berhasil disimpan", "Error");
                } 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Command: toastr["error"]("Ajax Error !!", "Error");
            }

            });

        });
    }
    
});    
</script>
<style>
.dropzone {
width:100%;
height: 210px;
min-height: 0px !important;
margin-bottom: 10px;
}  
</style>
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Gambar Produksi</span>
        </nav>
        
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-shirt"></i>
        <div>
          <h4>List Gambar Produksi | NO.SO : <?php echo $id_rows;?> | Tema : <span class="nama_tema"></span></h4>
          <p class="mg-b-0">Halaman data gambar produksi.</p>
        </div>
        <div class="">
                
        </div>
    </div><!-- d-flex -->
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            <h6 class="br-section-label">GAMBAR PRODUKSI</h6>
            <p class="br-section-text"><button class="btn btn-info btn-sm" onclick="getcontents('markom/design_gambar_produksi_owner','<?php echo $this->session->userdata('sess_token');?>','popup_tambah')"><i class="fa fa-refresh"></i> Kembali ke Draft Gambar Produksi</button></p>
                       
            
            <div class="table-wrapper table-responsive">
            
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div id="list_gambar"></div>
                    </div>
                </div>
                
                
                
            </div>
            
            
            
            
        </div>
    </div>

