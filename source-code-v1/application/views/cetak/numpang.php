<!DOCTYPE html>
<html>
<head>
    <style>
    table, th, td {
      border: 1px solid black;
    }
    table.blueTable{
        float:left;
    }
    </style>
</head>
<body>

<?php
foreach($datajamaah as $a){
$okes;    
if($a['img_foto'] == '' || $a['img_foto'] == null){
    $okes = '<img src="'.base_url('assets/no-image-available.png').'" style="height:250px">';
    }else{
    $okes = '<img src="'.base_url('uploads/files/kloter_'.$idkloters.'/'.$a['img_foto'].'').'" style="height:250px">'; 
    }
?>
    <div style='float: left; width:190px;margin-left: 10px;padding-top:10px'>
        <div style="height:250px;border: 1px solid black;"><?php echo $okes;?></div>
        <div style="font-weight:bold;height:50px;border: 1px solid black;text-align:center;"><?php echo $a['nama'];?></div>
    </div>

<?php
}
?>

</body>
</html>
