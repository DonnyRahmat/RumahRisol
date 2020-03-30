<?php
  require_once('../../layout/header.php');
?>

<div class="grid">
  <div class="row">
    <div class="cell-md-12 sm-12">
      <h3>Laporan Transaksi</h3><br>
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Filter Laporan</span>
              </div>
              <div class="window-content p-2">
                 <form class="comment_form" name="crud_bahanbaku">
                     <div class="row">
                         <div class="cell-md-2">
                           <input type="radio" data-role="radio" data-caption="Semua Data" name="lap" classs="aopt" id="all">
                         </div>
                         <div class="cell-md-2">
                           <input type="radio" data-role="radio" data-caption="Hari Ini" name="lap" class="aopt" id="1hr">
                         </div>
                         <div class="cell-md-2">
                           <input type="radio" data-role="radio" data-caption="Minggu Ini" name="lap" class="aopt" id="1mg">
                         </div>
                         <div class="cell-md-2">
                           <input type="radio" data-role="radio" data-caption="Bulan Ini" name="lap" class="aopt" id="1bln">
                         </div>
                         <div class="cell-md-2">
                           <input type="radio" data-role="radio" data-caption="Custom" name="lap" id="cust">
                         </div>
                     </div>
                     <div class="row">
                       <div class="opt" style="display: none;">
                         <div class="cell-md-3">
                             <label>Dari</label>
                             <input data-role="datepicker" name="tgl1" id="tgl1">
                         </div>
                         <div class="cell-md-3">
                             <label>Sampai</label>
                             <input data-role="datepicker" name="tgl2" id="tgl2">
                         </div>
                         <br><br><br><br>
                       </div>
                     </div>
                     <div class="row">
                       <div class="cell-md-12">
                           <div class="c"></div>
                           <button type="button" id="submit_btn" class="button success ">Cari Data</button>
                           <button type="button" id="reset" class="button warning">Reset Table</button>
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
                  <span class="title">Hasil Search Laporan</span>
              </div>
              <div class="window-content p-2">
                <div class="fp" style="display:none">
                  <form action="printLap.php" method="post">
                      <input type="text" name="o" value="" id="o" style="display:none">
                      <input type="text" name="d1" value="" id="d1" style="display:none">
                      <input type="text" name="d2" value="" id="d2" style="display:none">
                      <input type="submit" name="" value="Print" class="button warning">
                  </form>
                </div>
                <div class="fp" style="display:none">
                  <form action="excelLap.php" method="post">
                      <input type="text" name="o" value="" id="ox" style="display:none">
                      <input type="text" name="d1" value="" id="d1x" style="display:none">
                      <input type="text" name="d2" value="" id="d2x" style="display:none">
                      <input type="submit" name="" value="Download Excel" class="button success">
                  </form>
                </div>
                <table id="getLap" class="table table-border cell-border">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tgl Transaksi</th>
                                <th>Total</th>
                                <th>Jml Bayar</th>
                                <th>Kembalian</th>
                                <th>Diskon</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
              </div> <!-- windows content -->
          </div> <!--windows -->
     </div> <!--cell   -->
  </div> <!--row -->

</div>


</div>  <!-- tutup appbar -->
</div> <!-- tutup container -->
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../../assets/js/metro.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script type="text/javascript" src="../../../assets/js/crud_report_trans.js"></script>
</body>
</html>
