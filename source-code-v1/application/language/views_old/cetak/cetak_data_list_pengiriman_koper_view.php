<span style="font-size:20px;font-weight: bold">LIST PENGIRIMAN PERNAK-PERNIK JAMAAH UTM - <?php echo $kloter['nama'];?></span>

<style>
 table.blueTable {
  border: 1px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
  border-collapse: collapse;
}
table.blueTable td, table.blueTable th {
  border: 1px solid #AAAAAA;
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 13px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: black;
  border-left: 2px solid #D0E4F5;
}
table.blueTable thead th:first-child {
  border-left: none;
}

table.blueTable tfoot {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  background: #D0E4F5;
  background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
  border-top: 2px solid #444444;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
  display: inline-block;
  background: #1C6EA4;
  color: #FFFFFF;
  padding: 2px 8px;
  border-radius: 5px;
}


.dot_danger {
  height: 25px;
  width: 25px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
}

</style>

<br>
<br>
<table class="blueTable">
<thead>
    <tr>
<th width="20px">No</th>
<th>Nama Jamaah</th>
<th>Nomor HP/ Telp</th>
<th width="50px">STATUS</th>
<th width="200px">ALAMAT PENGIRIMAN</th>
</tr>
</thead>
<tbody>
<?php 
$nos = 0+1;
foreach($datajamaah as $a){
?>

<tr>
<td><?php echo $nos;?></td>
<td width="300px"><?php echo $a['nama'];?></td>
<td width="20px"><?php echo $a['no_telp'];?></td>
<?php if($a['koper'] == 0){
    echo "<td width='50px' style='background:red;color:white'>Belum Pilih</td>";
}else if($a['koper'] == 1){
    echo "<td width='50px' style='background:green;color:white'>Dikirim</td>";
}else if($a['koper'] == 2){
    echo "<td width='50px' style='background:gray;color:white'>Diambil di Rumah Om Ikhsan</td>";
}else if($a['koper'] == 3){
    echo "<td width='50px' style='background:orange;color:white'>Diambil di Manasik</td>";
}
?>


<?php if($a['koper'] == 0){
    echo "<td>-</td>";
}else if($a['koper'] == 1){
    echo "<td width='300px'>".$a['alamat_pengiriman_koper']."</td>";
}else if($a['koper'] == 2){
    echo "<td>-</td>";
}else if($a['koper'] == 3){
    echo "<td>-</td>";
}
?>

</tr>
<?php
$nos++;
}

?>
<tr>
</tbody>
</table>