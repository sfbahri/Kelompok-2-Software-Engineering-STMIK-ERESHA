<script type="text/javascript">
$(document).ready(function(){
    var id_modal    = '<?php echo $id_modal;?>';
    var kode_produksi = '<?php echo $id_row;?>';
    var status       = '<?php echo $id_row2;?>';
    var tokens   = '<?php echo $this->session->userdata('sess_token');?>';
    
    get_produksi_master = function(){
        $.ajax({
        url       : base_url + 'produksi/data_detail',
        type      : "post",
        dataType  : 'json',
        data      : {kode_produksi  : kode_produksi,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
        success: function (res) {
            $(".nav-link").removeClass("intro");
            $("#nama_produksi").val(res.nama);
            if(res.status == 1){
                $("#btn_selesai_cutting").remove();
                $("#base-tab11").addClass('active');
            }else if(res.status == 2){
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab12").addClass('active');
            }else if(res.status == 3){
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab13").addClass('active');
            }else if(res.status == 4){
                $("#btn_selesai_sewing").remove();
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab14").addClass('active');
            }else if(res.status == 5){
                $("#btn_selesai_finishing").remove();
                $("#btn_selesai_sewing").remove();
                $("#btn_selesai_aksesoris").remove();
                $("#btn_selesai_sablon").remove();
                $("#btn_selesai_cutting").remove();
                $("#base-tab15").addClass('active');
            }else{
                
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            Command: toastr["error"]("Ajax Error !!", "Error");
        }

        });
    }
    get_produksi_master();

    $('#tanggal').datepicker();
    
    

    $(".icons-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    
    
   
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

</style>
<div id="<?php echo $id_modal;?>" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detail Produksi | Kode Produksi : <b><?php echo $id_row;?></b></h4>
        </div>
        <div class="modal-body">
           
        <form action="#" class="icons-tab-steps wizard-circle">
                      <!-- Step 1 -->
                      <h6> Cutting </h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="firstName2">First Name :</label>
                              <input type="text" class="form-control" id="firstName2">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="lastName2">Last Name :</label>
                              <input type="text" class="form-control" id="lastName2">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="emailAddress3">Email Address :</label>
                              <input type="email" class="form-control" id="emailAddress3">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="location2">Select City :</label>
                              <select class="custom-select form-control" id="location2" name="location">
                                <option value="">Select City</option>
                                <option value="Amsterdam">Amsterdam</option>
                                <option value="Berlin">Berlin</option>
                                <option value="Frankfurt">Frankfurt</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber2">Phone Number :</label>
                              <input type="tel" class="form-control" id="phoneNumber2">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date2">Date of Birth :</label>
                              <input type="date" class="form-control" id="date2">
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      
                      
                      <!-- Step 2 -->
                      <h6>Sablon</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="proposalTitle2">Proposal Title :</label>
                              <input type="text" class="form-control" id="proposalTitle2">
                            </div>
                            <div class="form-group">
                              <label for="emailAddress4">Email Address :</label>
                              <input type="email" class="form-control" id="emailAddress4">
                            </div>
                            <div class="form-group">
                              <label for="videoUrl2">Video URL :</label>
                              <input type="url" class="form-control" id="videoUrl2">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="jobTitle3">Job Title :</label>
                              <input type="text" class="form-control" id="jobTitle3">
                            </div>
                            <div class="form-group">
                              <label for="shortDescription2">Short Description :</label>
                              <textarea name="shortDescription" id="shortDescription2" rows="4" class="form-control"></textarea>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      
                      <!-- Step 3 -->
                      <h6>Aksesoris</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="eventName2">Event Name :</label>
                              <input type="text" class="form-control" id="eventName2">
                            </div>
                            <div class="form-group">
                              <label for="eventType2">Event Type :</label>
                              <select class="custom-select form-control" id="eventType2" data-placeholder="Type to search cities"
                              name="eventType2">
                                <option value="Banquet">Banquet</option>
                                <option value="Fund Raiser">Fund Raiser</option>
                                <option value="Dinner Party">Dinner Party</option>
                                <option value="Wedding">Wedding</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="eventLocation2">Event Location :</label>
                              <select class="custom-select form-control" id="eventLocation2" name="location">
                                <option value="">Select City</option>
                                <option value="Amsterdam">Amsterdam</option>
                                <option value="Berlin">Berlin</option>
                                <option value="Frankfurt">Frankfurt</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Event Date - Time :</label>
                              <div class='input-group'>
                                <input type='text' class="form-control datetime" />
                                <span class="input-group-addon">
                                  <span class="ft-calendar"></span>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="eventStatus2">Event Status :</label>
                              <select class="custom-select form-control" id="eventStatus2" name="eventStatus">
                                <option value="Planning">Planning</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Finished">Finished</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Requirements :</label>
                              <div class="c-inputs-stacked">
                                <div class="d-inline-block custom-control custom-checkbox">
                                  <input type="checkbox" name="status2" class="custom-control-input" id="staffing2">
                                  <label class="custom-control-label" for="staffing2">Staffing</label>
                                </div>
                                <div class="d-inline-block custom-control custom-checkbox">
                                  <input type="checkbox" name="status2" class="custom-control-input" id="catering2">
                                  <label class="custom-control-label" for="catering2">Catering</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      
                      
                      <!-- Step 4 -->
                      <h6>Sewing</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="eventName2">Event Name :</label>
                              <input type="text" class="form-control" id="eventName2">
                            </div>
                            <div class="form-group">
                              <label for="eventType2">Event Type :</label>
                              <select class="custom-select form-control" id="eventType2" data-placeholder="Type to search cities"
                              name="eventType2">
                                <option value="Banquet">Banquet</option>
                                <option value="Fund Raiser">Fund Raiser</option>
                                <option value="Dinner Party">Dinner Party</option>
                                <option value="Wedding">Wedding</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="eventLocation2">Event Location :</label>
                              <select class="custom-select form-control" id="eventLocation2" name="location">
                                <option value="">Select City</option>
                                <option value="Amsterdam">Amsterdam</option>
                                <option value="Berlin">Berlin</option>
                                <option value="Frankfurt">Frankfurt</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Event Date - Time :</label>
                              <div class='input-group'>
                                <input type='text' class="form-control datetime" />
                                <span class="input-group-addon">
                                  <span class="ft-calendar"></span>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="eventStatus2">Event Status :</label>
                              <select class="custom-select form-control" id="eventStatus2" name="eventStatus">
                                <option value="Planning">Planning</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Finished">Finished</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Requirements :</label>
                              <div class="c-inputs-stacked">
                                <div class="d-inline-block custom-control custom-checkbox">
                                  <input type="checkbox" name="status2" class="custom-control-input" id="staffing2">
                                  <label class="custom-control-label" for="staffing2">Staffing</label>
                                </div>
                                <div class="d-inline-block custom-control custom-checkbox">
                                  <input type="checkbox" name="status2" class="custom-control-input" id="catering2">
                                  <label class="custom-control-label" for="catering2">Catering</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      
                      
                      
                      <!-- Step 5 -->
                      <h6>Finishing</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="meetingName2">Name of Meeting :</label>
                              <input type="text" class="form-control" id="meetingName2">
                            </div>
                            <div class="form-group">
                              <label for="meetingLocation2">Location :</label>
                              <input type="text" class="form-control" id="meetingLocation2">
                            </div>
                            <div class="form-group">
                              <label for="participants2">Names of Participants</label>
                              <textarea name="participants" id="participants2" rows="4" class="form-control"></textarea>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="decisions2">Decisions Reached</label>
                              <textarea name="decisions" id="decisions2" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                              <label>Agenda Items :</label>
                              <div class="c-inputs-stacked">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="agenda2" class="custom-control-input" id="item21">
                                  <label class="custom-control-label" for="item21">1st item</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="agenda2" class="custom-control-input" id="item22">
                                  <label class="custom-control-label" for="item22">2nd item</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="agenda2" class="custom-control-input" id="item23">
                                  <label class="custom-control-label" for="item23">3rd item</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="agenda2" class="custom-control-input" id="item24">
                                  <label class="custom-control-label" for="item24">4th item</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="agenda2" class="custom-control-input" id="item25">
                                  <label class="custom-control-label" for="item25">5th item</label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </form>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_simpan2" hidden=""><i class="ft-check"></i> Sudah Di Publish</button>
            <button type="button" class="btn btn-info" id="btn_publish" style="display:none"><i class="la la-check-square-o"></i> Publish Ke Produksi</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ft-refresh-cw"></i> Tutup</button>
        </div>
    </div>

  </div>
</div>


