
<link href="<?php echo base_url('assets/qrcode_scanner/css/style.css');?>" rel="stylesheet">


<script type="text/javascript" src="<?php echo base_url('assets/qrcode_scanner/js/filereader.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/qrcode_scanner/js/qrcodelib.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/qrcode_scanner/js/webcodecamjs.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/qrcode_scanner/js/main.js');?>"></script>

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Qr Scan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Qr Scan</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section id="initialization">

    <div class="row">

        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
              <h4 class="card-title">QR Scan</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content collapse show">
            <div class="card-body card-dashboard">

                <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="navbar-form navbar-right">
                        <select class="form-control" id="camera-select" style="display:none"></select>
                        <div class="form-group">
                            <button title="Decode Image" style="display:none" class="btn btn-default btn-lg" id="decode-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
                            <button title="Image shoot" style="display:none" class="btn btn-info btn-lg" id="grab-img" type="button" data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
                            <button title="Play" class="btn btn-success btn-lg" id="play" type="button" data-toggle="tooltip"><span class="la la-play"></span></button>
                            <button title="Pause" style="display:none" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="la la-pause"></span></button>
                            <button title="Stop streams" class="btn btn-danger btn-lg" id="stop" type="button" data-toggle="tooltip"><span class="la la-stop"></span></button>
                         </div>
                    </div>
                </div>
                <div class="panel-body text-center">
                    <div class="col-md-6">
                        <div class="well" style="position: relative;display: inline-block;">
                            <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                            <input id="zoom" onchange="Page.changeZoom();" type="hidden" min="10" max="30" value="20">
                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="thumbnail" id="result">
                            <div class="well" style="overflow: hidden;" style="display:none">
                                <img width="320" height="240" id="scanned-img" src="" style="display:none" >
                            </div>
                            <div class="caption">
                                <p id="scanned-QR"></p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

            </div>
            </div>
            </div>
        </div>
    </div>
</section>


    



    

