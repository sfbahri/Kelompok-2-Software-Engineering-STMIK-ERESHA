<span style="font-size:20px;font-weight: bold">LAPORAN PENJUALAN - BABYNEEDS.CO.ID</span>
<br>
<span>Outlet : <?php echo $nama_outlet;?></span>
<br>
<span>Tanggal : <?php echo $tanggals;?></span>
<br>
<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color:  #e9eaeb;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 10px;
    padding-bottom: 10px;
    text-align: left;
    background-color:  #eeeff0;
    color: black</style>

                <table id="customers" class="table  table-responsive table-striped" >
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Nota</th>
                        <th>Nama Pelanggan</th>
                        <th>Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                    
                    <?php 
                    $nos = 0+1;
                    foreach ($detail_penjualan as $a) {?>
                    <tr>
                        <th><?php echo $nos;?></th>
                        <th><?php echo $a['no_nota'];?></th>
                        <th align="left"><?php echo 
                        
//                        $namas;
//                        if($a['nama'] == '- Pilih Nama Pelanggan -'){
//                            $namas = '';
//                        }else{
//                            $namas = $a['nama'];
//                        }
                        
                        $a['nama_dummy'].' / '.$a['nama']
                        
                        ;?></th>
                        <th align="left"><?php echo $a['nama_jenis_pembayaran'];?></th>
                        <th><?php echo $a['tgl_order'];?></th>
                        <th align="right"><span style="color:#0040ff;float:left">Rp. </span> <span style="color:#0040ff;float:right;"><?php echo $a['total'];?></span></th>
                    </tr>
                    <?php 
                    $nos++;
                    }
                    ?>

                    
                    
                    <tr>
                        <td style="background:#e9eaeb;" align="right" colspan="6">&nbsp; <span style="float:right;color:#0040ff"><strong>Total : Rp. <?php echo $total_penjualan['total'];?></strong></span> </td>
                    </tr>
                </thead>
                </table>  
               <div class="alert alert-success" role="alert">
                    <div class="d-flex align-items-center justify-content-start" style="font-size:15px;float:right">
                      <i class="icon ion-ios-wallet alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                      
                    </div><!-- d-flex -->
                    <br>
                    <br>
                </div>