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
    <p class="h3">Transaksi Barang Masuk</p>
  </div>
  <div class="row">
    <div class="cell-md-12 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Input Barang Masuk</span>
              </div>
              <div class="window-content p-2">
                 <input type='button' value='Add more' id='addmore'>
                <form class="comment_form" name="crud_bahanbaku">
                    <div class="row">
                      <div class="cell-md-12">
                        <table class="table compact" style='border-collapse: collapse;'>
                          <thead>
                           <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Ukuran</th>
                            <th>Harga Barang</th>
                            <th>Jumlah Masuk</th>
                            <th>Aksi</th>
                           </tr>
                          </thead>
                          <tbody class="aut">
                           <tr class='tr_input'>
                            <td>
                              <input type='text' class='nmbarang' id='nmbarang_1' placeholder='Masukkan Nama Barang'>
                              <input type='number' class='idbarang' id='idbarang_1' name='idbarang[]' hidden>
                              <input type='text' class='id_detil_brgmsk' id='id_detil_brgmsk_1' hidden>
                              <input type='text' class='id_brgmsk' id='id_brgmsk_1' hidden>
                            </td>
                            <td><input type='text' class='stok' id='stok_1' readonly></td>
                            <td><input type='text' class='ukuran' id='ukuran_1' readonly></td>
                            <td><input type='number' class='harga_beli' name='harga_beli[]' id='harga_beli_1' ></td>
                            <td><input type='number' class='jml_brgmsk'name='jml_brgmsk[]'>  </td>
                            <td><input type='button' value='Delete' class='delete'></td>
                           </tr>
                          </tbody>
                         </table>
                      </div>
                      <!-- <div class="cell-md-12">
                        <button type="button" id="tambah_input" class="button info ">Tambah Inputan</button>
                      </div>
                    </div>
                    <div class="tambahan">
                      <div class="row">
                        <div class="cell-md-2">
                              <label for="autocomplete">Cari Bahan </label> <br />
                              <input id="autocomplete" type="text" data-role="input">
                        </div>
                        <div class="cell-md-1">
                            <label>ID</label> <br />
                            <input type='text' id='selectuser_id' />
                        </div>
                        <div class="cell-md-2">
                          <label>Satuan</label> <br />
                          <input id="satuan" type="text" data-role="input" readonly/>
                        </div>
                        <div class="cell-md-2">
                          <label>Ukuran</label> <br />
                          <input id="ukuran" type="text" data-role="input" readonly/>
                        </div>
                      </div>
                    </div> -->
                    </div>
                    <div class="row">

                    </div>
                    <div class="row">
                      <div class="cell-md-12">
                          <!-- <input type="submit" name="submit" value="Proses" class="button warning large w-100"> -->
                          <button type="button" id="save" class="button success ">Proses</button>
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
                  <span class="title">List Bahan Baku</span>
              </div>
              <div class="window-content p-2">
                <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Barang Masuk</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jml Brg Masuk</th>
                                <th>Nominal</th>
                                <th>Brg Msk Tgl</th>
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
<script type="text/javascript" src="../../../assets/js/crud_barangmasuk.js"></script>
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
