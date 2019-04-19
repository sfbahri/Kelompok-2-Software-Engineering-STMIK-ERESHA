<script type="text/javascript">
$(document).ready(function(){
    
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    
    
//    $(".timepickers").timepicker({
//    use24hours: true,
//        format: 'HH:mm'
//    });
    
    var data_kloter = function(){
        $('#tabel_kloter').hide();
        $.ajax({ 
            url: base_url + 'kloter/data_rute_penerbangan',
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
                    
                   
                    
                    var link_edit = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"getpopup('kloter/edit','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-info btn-sm' title='Akses' ><i class='fa fa-pencil'></i></div></a></div>";    
                    var link_hapus = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"simpan_pnr('"+result[i].id+"');\"><div class='btn btn-primary btn-sm' title='Hapus' ><i class='fa fa-save'></i></div></a></div>";
                    var link_rute = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"simpan('kloter/rute','"+tokens+"','popupedit','"+result[i].id+"');\"><div class='btn btn-success btn-sm' title='Rute' ><i class='fa fa-plane'></i></div></a></div>";
                    var link_jamaah = "<div style='text-align:center'><a href='javascript:void(0)' onclick=\"getcontents('jamaah/by_kloter','"+tokens+"','"+result[i].id+"');\"><div class='btn btn-primary btn-sm' title='Jamaah' ><i class='fa fa-users'></i></div></a></div>";
                    //,result[i].tgl_berangkat,result[i].tgl_pulang
                    
                    var rute = ''+result[i].dari+' <span><i class="fa fa-plane"></i></span> '+result[i].ke+'';
                    var maskapai = '<div style="text-align:center"><input onkeyup="myFunction(this,'+result[i].id+')" type="text" id="maskapai_'+result[i].id+'" class="form-control uppercase" style="width:200px;margin:0px;"></div>';
                    var kode_pnr = '<div style="text-align:center"><input type="text" id="kode_pnr_'+result[i].id+'" onkeyup="myFunction(this,'+result[i].id+')" class="form-control uppercase" style="width:70px;margin:0px"></div>';
                    var flight = '<div style="text-align:center"><input type="text" onkeyup="myFunction(this,'+result[i].id+')" id="flight_'+result[i].id+'" class="form-control uppercase" style="width:70px;margin:0px"></div>';
                    var waktu_start = '<div style="text-align:center"><input type="text" id="waktu_start_'+result[i].id+'" class="form-control timepickers" style="width:50px;margin:0px" placeholder="00:00"></div>';
                    var waktu_end   = '<div style="text-align:center"><input type="text" id="waktu_end_'+result[i].id+'" onkeyup=show_time('+result[i].id+') class="form-control timepickers" style="width:50px;margin:0px" placeholder="00:00"></div>';
                    
                    
                    data.push([no,rute,maskapai,kode_pnr,flight,waktu_start,waktu_end,link_hapus]);

                }
                $('#tabel_kloter').DataTable({
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
                $('#tabel_kloter').show();
            }
        });
    }
    data_kloter();
    
    show_time = function(id){
        $('#waktu_end_'+id).timepicker({
            pickDate: false,  
                minuteStepping:5, 
                allowInputToggle: true,
            timeFormat: "HH:mm",
            time_24hr: false,
            interval: 5
        });
    }
    
    
    myFunction = function(e,c){
        $('.uppercase').keyup(function(event){
            this.value = this.value.toUpperCase();
        });
    }
    
    
    simpan_pnr = function (id_rute){
        
        var post_1 = $("#maskapai_"+id_rute).val();
        var post_2 = $("#kode_pnr_"+id_rute).val();
        var post_3 = $("#flight_"+id_rute).val();
        var post_4 = $("#waktu_start_"+id_rute).val();
        var post_5 = $("#waktu_end_"+id_rute).val();
        
        
        $.ajax({
                url       : base_url + 'kloter/simpan_kodepnr',
                type      : "post",
                dataType  : 'json',
                data      : {id_rute : id_rute,post_1:post_1,post_2:post_2,post_3:post_3,post_4:post_4,post_5:post_5, <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function (response) {
                    if(response == true){
                        swal.close();
                        Command: toastr["success"]("Kloter berhasil dihapus", "Berhasil");
                        data_kloter();
                    }else{
                        Command: toastr["error"]("Response Ajax Error !!", "Error");
                    }  
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Command: toastr["error"]("Ajax Error !!", "Error");
                }
            });
        
    }
    
    
    
    
    
});    
</script>
    <input type="text" id="waktu_end" class="form-control timepickers" placeholder="00:00">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="javascript:void(0)"><i class="icon fa fa-home"></i> Home</a>
          <span class="breadcrumb-item active">Data Jadwal Penerbangan</span>
        </nav>
    </div><!-- br-pageheader -->
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-clock"></i>
        <div>
          <h4>Data Jadwal Penerbangan</h4>
          <p class="mg-b-0">Halaman data jadwal penerbangan.</p>
        </div>
    </div>
    
      
        <!-- start content -->
    <div class="br-pagebody">
        <div class="br-section-wrapper">
            
            <div class="table-wrapper table-responsive">
            <table id="tabel_kloter" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th width="100px">Rute Penerbangan</th>
                        <th>Maskapai</th>
                        <th>Kode Booking (PNR)</th>
                        <th>Flight</th>
                        <th width="200px">Departure</th>
                        <th width="200px">Arrival</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table> 
            </div>
            
        </div>
    </div>