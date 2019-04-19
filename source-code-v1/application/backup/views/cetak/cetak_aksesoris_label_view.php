<!DOCTYPE html>
<html>
<head>
<style>
    
    .huruf_header{
        font-size: 19px;
        font-weight: bold;
        font-family: 'Tahoma, Geneva, sans-serif';
    }
    
    .huruf_header2{
        font-size: 10px;
        font-family: 'Tahoma, Geneva, sans-serif';
    }
    
    .logo{
        margin:5px;
        width:130px;
    }
    
    /*NO PRODUKSI*/
    .no_produksi_header{
        margin-left: 10px;
        font-family: 'Tahoma, Geneva, sans-serif';
        font-size: 13px;
        font-weight: bold;
    }
    
    .table_utama{
        width:100%;
        margin:10px;
        font-size: 14px;
        font-family: 'Tahoma, Geneva, sans-serif';
    }
    
    .judul{
        font-size: 11px;
        font-family: 'Tahoma, Geneva, sans-serif';
        font-weight: bold;
        margin-left: 10px;
    }
    
</style>
</head>
<body>
    
    <table width="492">
        <tr>
            <td width="146" rowspan="2" align="center"><img class='logo' src='<?php echo base_url('/assets/img/logo_babyneeds.png');?>'/></td>
            <td colspan="2" align="left" class="huruf_header">BABYNEEDS.CO.ID</td>
        </tr>
        <tr>
            <td colspan="2" align="left" class="huruf_header2">Ruko Allogio Barat No.9, Medang,Pagedangan, Tangerang, Banten 15334, No.Telp (021) 22224730 www.babyneeds.co.id</td>
        </tr>
    </table>
    <hr>
    <div class="no_produksi_header">NO. AKSESORIS : <?php echo $no_produksi;?></div> 
    <div style='font-size:9px;margin-left: 9px'>PIC-USR : <b><?php echo $this->session->userdata('sess_nama');?></b> / CTK : <?php echo date("Y-m-d h:i");?></div>
    <hr>
    
    <div class='judul'><b>INFORMASI AKSESORIS :</b></div>

    <table class='table_utama' border="1" cellpadding="1" cellspacing="1">
        <tr><td width="40%">Nama Aksesoris</td><td width="83%">&nbsp;: <?php echo $nama;?></td></tr>
        <tr><td>Tgl Sampai</td><td>&nbsp;: <?php echo $tgl;?></td></tr>
        <tr><td>Stok Awal</td><td>&nbsp;: <?php echo $stok_awals;?> 
        <?php 
        if($satuan == 1){
            echo "Pcs";
        }else{
            echo "Kg";
        }
        ?>
        </td></tr>
        <tr><td colspan='2' align='center'><img class='qr' src='<?php echo base_url('uploads/qrcode/'.$img_qrcode);?>' style='width:120px;height:120px'/></td></tr>
    </table>
    
    
</body>
</html>
