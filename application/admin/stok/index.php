<?php
  require_once('../../layout/header.php');
  require_once('crud_bahanbaku.php');
?>
<div class="grid">
  <div class="row">
    <p class="h3">Master Bahan Baku</p>
  </div>
  <div class="row">
    <div class="cell-md-6 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Input Bahan Baku</span>
              </div>
              <div class="window-content p-2">
                <form class="comment_form" name="crud_bahanbaku">
                    <div class="row">
                        <div class="cell-md-6">
                            <label>Nama Barang</label>
                            <input type="text" id="nama_barang">
                        </div>
                        <div class="cell-md-6">
                            <label>Satuan</label>
                            <select data-role="select" id="satuan">
                              <option value="Kg">Kilogram</option>
                              <option value="Pcs">Pieces</option>
                              <option value="Gram">Gram</option>
                              <option value="Roll">Roll</option>
                              <option value="Pak">Pak</option>
                              <option value="Buah">Buah</option>
                              <option value="Liter">Liter</option>
                              <option value="Sachet">Sachet</option>
                              <option value="Ml">Mililiter</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                      <div class="cell-md-3">
                          <label>Ukuran</label>
                          <input type="text" id="ukuran">
                      </div>
                        <div class="cell-md-3">
                            <label>Stok</label>
                            <input type="number" id="stok">
                        </div>
                        <div class="cell-md-3">
                            <label>Min Stok</label>
                            <input type="number" id="stok_min">
                        </div>
                        <div class="cell-md-3">
                            <label>Harga</label>
                            <input type="number" id="harga_beli">
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
               <span class="title">Bahan Baku Paling Sedikit</span>
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
                  <tr>
                    <td>1</td>
                    <td>Risol</td>
                    <td>99</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Risol</td>
                    <td>99</td>
                  </tr>
                  <tr>
                    <td>1</td>
                    <td>Risol</td>
                    <td>99</td>
                  </tr>
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
                  <span class="title">List Bahan Baku</span>
              </div>
              <div class="window-content p-2">
                <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                                <th>Min Stok</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->
  </div> <!--row -->
</div>

<br />



</div>  <!-- tutup appbar -->
</div> <!-- tutup container -->
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script src="../../../assets/js/crud_bahanbaku.js"></script>
</body>
</html>
