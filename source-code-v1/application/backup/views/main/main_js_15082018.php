    
    <script src="<?php echo base_url('assets/lib/popper.js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/bootstrap/js/bootstrap.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/moment/moment.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/jquery-ui/jquery-ui.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/jquery-switchbutton/jquery.switchButton.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/peity/jquery.peity.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables/jquery.dataTables.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/datatables-responsive/dataTables.responsive.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/select2/js/select2.min.js');?>"></script>
    <script src="<?php echo base_url('assets/lib/toastr/toastr.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/sweetalert/sweetalert.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/maskmoney/jquery.maskMoney.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/jquery.steps/jquery.steps.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/bootstrap-datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/dropzone/form-dropzone.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/dropzone/dropzone.min.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/lib/chosen/chosen.jquery.min.js');?>"></script>
    
    <script src="<?php echo base_url('assets/js/bracket.js');?>"></script>  
    
    
   
    
<script type="text/javascript">
    var base_url    = "<?php echo base_url();?>";

    //ini untuk datatable menggunakan form-control
    $.fn.dataTable.ext.classes.sLengthSelect = 'form-control';

    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });

    getcontents('home','<?php echo $this->session->userdata('sess_token');?>');
    
    function getcontents(controller,tokens,id_rows,id_rows2,id_rows3){
            
            
            if(controller == '#' || controller == null || controller == '0' || controller == ''){
                loadErrorPage();
            }else{
//                document.getElementById('content-container').innerHTML = "";
//                $("#content-container").load(base_url + controller, {
//                    '<?php echo $this->security->get_csrf_token_name(); ?>': "<?php echo $this->security->get_csrf_hash();?>", 
//                    tokens:tokens,
//                    id_rows:id_rows,
//                    id_rows2:id_rows2,
//                    id_rows3:id_rows3
//                });

                
                var http    = new XMLHttpRequest();
                var url     = base_url + controller;
                var params  = '<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&tokens='+tokens+'&id_rows='+id_rows+'&id_rows2='+id_rows2+'&id_rows3='+id_rows3+'';
                http.open('POST', url, true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function() {//Call a function when the state changes.
                    if(http.readyState == 4 && http.status == 200) {
                        //$('#content-container').html("");
                        document.getElementById('content-container').innerHTML = "";
                        $('#content-container').html(http.responseText);
                        
                    }else{
                        //loadErrorPage();
                    }
                }
                http.send(params);
                
            }
			
    }
    
    function getpopup(controller,tokens,id_modal,id_row,id_row2){
          var base_url = '<?php echo base_url();?>';
//                document.getElementById('content-popup').innerHTML = "";
//                $("#content-popup").load(base_url + controller, {
//                    '<?php echo $this->security->get_csrf_token_name(); ?>': "<?php echo $this->security->get_csrf_hash();?>", 
//                    tokens:tokens,
//                    id_modal:id_modal,
//                    id_row:id_row,
//                    id_row2:id_row2
//                });
                
                var http    = new XMLHttpRequest();
                var url     = base_url + controller;
                var params  = '<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>&tokens='+tokens+'&id_modal='+id_modal+'&id_row='+id_row+'&id_row2='+id_row2+'';
                http.open('POST', url, true);
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.onreadystatechange = function() {//Call a function when the state changes.
                    if(http.readyState == 4 && http.status == 200) {
                        //$('#content-popup').html("");
                        document.getElementById('content-popup').innerHTML = "";
                        $('#content-popup').html(http.responseText);
                        $('#'+id_modal).modal({backdrop:'static',keyboard:true,show:true,refresh: true});
                    }else{
                        //loadErrorPage();
                    }
                }
                http.send(params);
    }
    
    function modals(id_modal){
        $('#'+id_modal).modal('show');
    }
    
    function loadErrorPage(){
        var base_url = "<?php echo base_url();?>";
        $.ajax({
            url: base_url + 'main/error_page',
            type: 'POST',
            success: function(result){
                $('#cmain').html("");
                $('#cmain').html(result);
            }
        });
    }
    
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            Command: toastr["error"]("Silahkan Masukan Angka, Tidak Boleh Huruf !", "Info");
            return false;
        }
        return true;
    }
    
    $('.br-sideleft-menu').on('click', 'li', function() {
        $('.br-sideleft-menu li.active').removeClass('active');
        $(this).addClass('with-sub active show-sub');
    });
   
    toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "swing",
          "showMethod": "slideDown",
          "hideMethod": "slideUp"
    }
    
    
    
    
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    
    function convertToRupiah(angka){
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+',';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }
    
    
</script>

<?php 
if($this->session->userdata('sess_login') == 1){
?>

<?php 
}
?>
<!--End of Tawk.to Script-->


