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
                  <span class="title">Input Produk Masuk</span>
              </div>
              <div class="window-content p-2">
                 <input type='button' value='Add more' id='addmore'>
                <form class="comment_form" name="crud_bahanbaku">
                    <div class="row">
                      <div class="cell-md-12">
                        <table class="table compact" style='border-collapse: collapse;'>
                          <thead>
                           <tr>
                            <th>Nama Produk</th>
                            <th>Stok</th>
                            <th>Harga Produk</th>
                            <th>Jumlah Masuk</th>
                            <th>Aksi</th>
                           </tr>
                          </thead>
                          <tbody class="aut">
                          <form id="ins" class="ins">
                           <tr class='tr_input'>
                            <td>
                              <input type='text' class='nmproduk' id='nmproduk_1' placeholder='Masukkan Nama produk' name="nmproduk[]" required>
                              <input type='number' class='idproduk' id='idproduk_1' name='idproduk[]' hidden>
                              <input type='text' class='id_prdmsk' id='id_prdmsk_1' hidden>
                              <!-- <input type='text' class='jml_awal' hidden> -->
                            </td>
                            <td>
                              <input type='text' class='stok' id='stok_1' readonly required>
                              <input type='text' class='stok_awal' id='stok_awal_1' readonly required hidden>
                            </td>
                            <td><input type='number' class='harga_beli' name='harga_beli[]' id='harga_beli_1' required></td>
                            <td><input type='number' class='jml_prdmsk'name='jml_prdmsk[]' id='jml_prdmsk_1'required>  </td>
                           </tr>
                           </form>
                          </tbody>
                         </table>
                      </div>
                    </div>
                    <div class="row">

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

  <div class="row">
    <div class="cell-md-12 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">List Produk Masuk</span>
              </div>
              <div class="window-content p-2">
                <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Produk Msk</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jml Produk Masuk</th>
                                <th>Nominal</th>
                                <th>Produk Msk Tgl</th>
                                <th>User</th>
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
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../../assets/js/metro.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../assets/js/crud_produkmasuk.js"></script>
<script type="text/javascript">
    $('#test').on('keydown keyup', function(e){
        if ($(this).val() > 105
            && e.keyCode !== 46 // keycode for delete
            && e.keyCode !== 8 // keycode for backspace
           ) {
           e.preventDefault();
           $(this).val(105);
        }
    });

</script>
</body>
</html>
