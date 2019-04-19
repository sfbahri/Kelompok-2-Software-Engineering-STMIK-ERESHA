                    <table class="table table-striped" border="1">
                    <tr>
                      <td height="55" colspan="3" valign="top" align="center">PT. SHAILENDRA TSHAI INDONESIA</td>
                    </tr>
                    <tr>
                      <td colspan="3" valign="top">NO FAKTUR : <?php echo $nofaktur;?></td>
                    </tr>
                    <tr>
                      <td valign="top" bgcolor="#CCCCCC">Kode Produk</td>
                      <td valign="top" bgcolor="#CCCCCC">Qty</td>
                      <td valign="top" align="center" bgcolor="#CCCCCC">Harga</td>
                    </tr>
                    <?php 
                        foreach($trans_detail as $r){
                    ?>
                        <tr>
                        <td width="181" valign="top">&nbsp;<?php echo $r['kode_produk'];?></td>
                        <td width="6" valign="top">&nbsp;<?php echo $r['qty'];?></td>
                        <td width="178" valign="top">&nbsp;<?php echo $r['hargas'];?></td>
                      </tr>
                    <?php 
                        }
                    ?>
                      <tr>
                        <td>Total Belanja</td>
                        <td>:</td>
                        <td><div align="right"><?php echo $trans_header['total_pembelian'];?></div></td>
                      </tr>
                      <tr>
                        <td>Uang Bayar</td>
                        <td>:</td>
                        <td><div align="right"><?php echo $trans_header['uang_bayar'];?></div></td>
                      </tr>
                      <tr>
                        <td>Uang Kembali</td>
                        <td>:</td>
                        <td><div align="right"><?php echo $trans_header['uang_kembalian'];?></div></td>
                      </tr>
                      <tr>
                        <td colspan="3"><div align="center">Terima Kasih Telah Belanja Di Toko Kami</div></td>
                      </tr>
                      <tr>
                        <td colspan="3"><div align="center">www.babyneeds.co.id | 0219812871287 </div></td>
                      </tr>
                  </table>

<br> 

<button type="button" id="btn_submit" class="btn btn-success pull-left"> <i class="la la-print"></i> Cetak Struk </button>