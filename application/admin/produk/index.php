<?php
  require_once('../../layout/header.php');
  require_once('crud_produk.php');
?>
<link rel="stylesheet" href="../../../assets/css/jquery-ui.min.css">
<div class="grid">
  <div class="row">
    <p class="h3">Master Produk</p>
  </div>
  <div class="row">
    <div class="cell-md-6 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Input Produk</span>
              </div>
              <div class="window-content p-2">
                <form class="comment_form" name="crud_produk">
                    <div class="row">
                        <div class="cell-md-6">
                            <label>Nama Produk</label>
                            <input type="text" id="nama_produk">
                        </div>
                        <div class="cell-md-6">
                            <label>Harga Beli</label>
                            <input type="text" id="harga_beli">
                        </div>
                    </div>
                    <div class="row">
                        <div class="cell-md-6">
                            <label>Harga Jual</label>
                            <input type="number" id="harga_jual">
                        </div>
                        <div class="cell-md-3">
                            <label>Stok</label>
                            <input type="number" id="stok">
                        </div>
                        <div class="cell-md-3">
                            <label>Stok Min</label>
                            <input type="number" id="stok_min">
                        </div>
                    </div>
                    <div class="row">
                      <div class="cell-md-12">
                          <!-- <input type="submit" name="submit" value="Proses" class="button warning large w-100"> -->
                          <button type="button" id="submit_btn" class="button success ">POST</button>
                          <button type="button" id="update" class="button success" style="display: none;">UPDATE</button>
                          <button type="button" id="reset" class="button warning">RESET FORM</button>
                          <div class="hasil"></div>
                      </div>
                    </div>
                </form>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->

     <div class="cell-md-6 sm-12">
       <div class="window sm-12">
           <div class="window-caption">
               <span class="icon mif-windows"></span>
               <span class="title">Produk - produk yang hampir habis</span>
           </div>
           <div class="window-content p-2">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama barang</th>
                    <th>Stok</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $q = "SELECT nama_produk, stok FROM `t_produk` WHERE stok<=stok_min";
                    $stmt = $pdo->prepare($q);
                    $stmt->execute();
                    $b=1;
                    while ($a = $stmt->fetch(PDO::FETCH_OBJ)) {
                      echo "<tr>
                              <td>$b</td>
                              <td>$a->nama_produk</td>
                              <td>$a->stok</td>
                            </tr>";
                            $b++;
                    }
                  ?>
                </tbody>
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
                  <span class="title">List Produk</span>
              </div>
              <div class="window-content p-2">
                <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Min Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->
  </div> <!--row -->
</div>

<div id="dialog-confirm" title="Informasi" style="display: none">
  <p>
    <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
    Anda yakin akan menghapus data transaksi ini?
  </p>
</div>

<br />

</div>  <!-- tutup appbar -->
</div> <!-- tutup container -->
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script src="../../../assets/js/crud_produk.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-ui.min.js"></script>
</body>
</html>
