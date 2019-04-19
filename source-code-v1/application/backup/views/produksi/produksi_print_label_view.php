 <!DOCTYPE html>
<html>

<head>
  <title>Page Title</title>
</head>

<body>
    <?php 
    $i = 0;
    $base_url = base_url();
    echo '<table border="1" id="customers" cellspacing="13"><tr>';
                foreach($labels as $item){
                    $i++;
                    echo '<td><img src="'.$base_url.'uploads/qrcode/'.$item['img_qrcode'].'" style="width:120px;height:120px"><br><b>'.$item['kode'].'</b><br></td>';
                    if($i == 4) { // three items in a row. Edit this to get more or less items on a row
                        echo '</tr><tr>';
                        $i = 0;
                    }
                }
    echo '</tr></table>';
    ?>
</body>

</html> 

