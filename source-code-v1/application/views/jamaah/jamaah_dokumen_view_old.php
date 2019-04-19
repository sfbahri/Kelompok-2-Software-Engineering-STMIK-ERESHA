<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var id_jamaah   = '<?php echo $id_row;?>';
    var id_kloter   = '<?php echo $id_row2;?>';
    var tokens      = '<?php echo $tokens;?>';
//    
//    var data_dokumen_upload = function(){
//        
//        $.ajax({ 
//            url: base_url + 'jamaah/data_by_kloter',
//            type: "post",
//            data:{id_kloter:id_kloter,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//            dataType: "json",
//            async : 'false',
//            success: function(result)
//            {
//                var data = [];
//                for ( var i=0 ; i<4; i++ ) {
//                    var no = i+1;
//                    
//                   
////                   
////                    var link_edit    = "<a href='javascript:void(0)' onclick=\"getpopup('jamaah/edit','"+tokens+"','popupedit','"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-info btn-sm' title='Akses' ><i class='fa fa-pencil'></i></div></a>";    
//                    var link_hapus   = "<a href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"><div class='btn btn-danger btn-sm' title='Hapus' ><i class='fa fa-trash'></i></div></a>";
//                    var link_bayar   = "<a href='javascript:void(0)' onclick=\"hapus('"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Pembayaran' ><i class='fa fa-money'></i></div></a>";
//                    var link_dokumen = "<a href='javascript:void(0)' onclick=\"getpopup('jamaah/dokumen','"+tokens+"','popupedit','"+result[i].id+"','"+result[i].id_kloter+"');\"><div class='btn btn-primary btn-sm' title='Pembayaran' ><i class='fa fa-folder-open-o'></i></div></a>";;
////                    
//                   
//                    //var jmh = '<span style="color:#04ba93;">'+result[i].id+'</span><span class="tx-11 d-block">No.Paspor : '+result[i].paspor_no+'</span>';
//                    
//                    data.push([no,'a','b','v','c','c']);
//
//                }
//                $('#tabel_dokumen_upload').DataTable({
//                    data                : data,
//                    deferRender         : true,
//                    processing          : true,
//                    ordering            : true,
//                    retrieve            : false,
//                    paging              : true,
//                    deferLoading        : 57,
//                    bDestroy            : true,
//                    autoWidth           : false,
//                    bFilter             : true,
//                    iDisplayLength      : 10,
//                    responsive: true,
//                    language: {
//                      searchPlaceholder: 'Cari',
//                      sSearch: '',
//                      lengthMenu: '_MENU_',
//                    },
//                });
//               
//            },
//            beforeSend: function () {
//                loadingPannel.show();
//            },
//            complete: function () {
//                loadingPannel.hide();
//                $('#tabel_dokumen_upload').show();
//            }
//        });
//    }
//    data_dokumen_upload();
//    
//    
//    
//    
//    var data_dokumen_kirim = function(){
//        $('#tabel_dokumen_kirim').hide();
//        $.ajax({ 
//            url: base_url + 'jamaah/data_by_kloter',
//            type: "post",
//            data:{id_kloter:id_kloter,<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
//            dataType: "json",
//            async : 'false',
//            success: function(result)
//            {
//                var data = [];
//                for ( var i=0 ; i< 9 ; i++ ) {
//                    var no = i+1;
//                    
//                    data.push([no,i,i,i,i,i]);
//
//                }
//                $('#tabel_dokumen_kirim').DataTable({
//                    data                : data,
//                    deferRender         : true,
//                    processing          : true,
//                    ordering            : true,
//                    retrieve            : false,
//                    paging              : true,
//                    deferLoading        : 57,
//                    bDestroy            : true,
//                    autoWidth           : false,
//                    bFilter             : true,
//                    iDisplayLength      : 10,
//                    responsive: true,
//                    language: {
//                      searchPlaceholder: 'Cari',
//                      sSearch: '',
//                      lengthMenu: '_MENU_',
//                    },
//                });
//               
//            },
//            beforeSend: function () {
//                loadingPannel.show();
//            },
//            complete: function () {
//                loadingPannel.hide();
//                $('#tabel_dokumen_kirim').show();
//            }
//        });
//    }
//    data_dokumen_kirim();
//    
//  


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
            
<!--            DOKUMEN UPLOAD
            <hr>
            
-->            <table id="tabel_dokumen_upload" class="table table-responsive">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dokumen Upload</th>
                        <th>Tgl Upload</th>
                        <th>Verifikasi</th>
                        <th>Tgl Verifikasi</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>SURAT PERNYATAAN SIPATUH</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>PASPOR</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>KTP</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>KK</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
                        <td>XX</td>
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



