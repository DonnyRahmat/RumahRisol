<?php
  require_once('../../layout/header.php');
  // require_once('crud_bahanbaku.php');
?>

<style media="screen">
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: inner-spin-button !important;
    opacity: 1;
    margin-left: 5px;
}
</style>

<link rel="stylesheet" href="../../../assets/css/jquery-ui.min.css">
<div class="grid">
  <div class="row">
    <p class="h3">Transaksi Produk Masuk</p>
  </div>

  <div class="row">
    <div class="cell-md-12 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Data Transaksi</span>
              </div>
              <div class="window-content p-2">
                <table border="1">
                  <tr>
                    <td>No. Invoice</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><div>
                      <?php
                        $m2 = "SELECT max(id_jualprd) as idbm from t_jualprd";
                        $stmt3 = $pdo->prepare($m2);
                        $stmt3->execute();
                        $max = $stmt3->fetchObject();
                        $stmt3 = null;

                        if (is_null($max->idbm)) {
                         $idet = 1;
                        }else{
                         $idet = $max->idbm+1;
                        }
                      ?>
                      <input type="number" name="idj" id="idj" value="<?php echo $idet ?>" readonly>
                    </div>
                      <!-- <input type="text" name="idj" id="idj" value="1" readonly> </td> -->
                  </tr>
                  <tr>
                    <td>Tgl. Penjualan</td>
                    <td></td>
                    <td><div class=""><?php echo date("d-m-Y"); ?></div>
                      <!-- <input type="text" name="tj" id="tj" value="" readonly> </td> -->
                  </tr>
                </table>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->
  </div> <!--row -->
  <div class="row">
    <div class="cell-md-12 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Input Produk</span>
              </div>
              <div class="window-content p-2">
                 <input type='button' value='Tambah Produk' id='addmore'>
                <form class="comment_form" name="crud_bahanbaku">
                  <div class="grid">
                    <div class="row">
                      <div class="cell-md-12">
                        <table class="table compact" style='border-collapse: collapse;'>
                          <thead>
                           <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Diskon (Rp)</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                           </tr>
                          </thead>
                          <tbody class="aut">
                          <form id="ins" class="ins">
                           <tr class='tr_input'>
                            <td>
                              <input type='text' class='nmproduk' id='nmproduk_1' placeholder='Masukkan Nama produk' name="nmproduk[]" required>
                              <input type='number' class='idproduk' id='idproduk_1' name='idproduk[]' hidden>
                              <!-- <input type='text' class='jml_awal' hidden> -->
                            </td>
                            <td><input type='number' class='harga' name='harga[]' id='harga_1' readonly required></td>
                            <td><input type='number' class='diskon' id='diskon_1' required></td>
                            <td><input type='number' class='qty' name='qty[]' id='qty_1' required></td>
                            <td><input type='number' class='st' id='st_1' name='st[]' value='' readonly> </td>
                           </tr>
                           </form>
                          </tbody>
                         </table>
                         <hr>
                       </div>
                     </div>
                    </div>

                    <div class="row bg-orange">
                      <div class="cell">
                        <div id="hasil" style="font-weight: bold; text-decoration: none; font-size: 1em">
                          Total <input type="number" name="totalan" id="totalan" >
                        </div>
                      </div>
                      <div class="cell">
                        <div class="bayar" style="font-weight: bold; text-decoration: none; font-size: 1em">
                          Jumlah Bayar Bayar <input type="number" name="bayar" id="bayar" >
                        </div>
                      </div>
                      <div class="cell">
                          Kembalian <input type="number" name="kembalian" id="kembalian" value="">
                      </div>
                    </div>
                    <div class="row">
                      <div class="cell-md-12">
                          <button id="save" type="button" class="button success ">Proses</button>
                          <button type="button" id="reset" class="button info ">Reset Form</button>
                          <button type="button" id="update" class="button warning" style="display: none;">Update</button>
                          <button type="button" id="batal" class="button alert" style="display: none;">Batal</button>
                          <div class="hasil"></div>
                      </div>
                    </div>
                </form>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->
  </div> <!--row -->
</div> <!-- grid -->


<br />


</div>  <!-- tutup appbar -->
</div> <!-- tutup container -->
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../../assets/js/metro.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../assets/js/crud_penjualan.js"></script>
<script type="text/javascript">
    $('#bayar').on('keydown keyup', function(e){
        var kembalian = parseInt($('#bayar').val()) - parseInt($('#totalan').val());
        $('#kembalian').val(kembalian);
    });

</script>
</body>
</html>
