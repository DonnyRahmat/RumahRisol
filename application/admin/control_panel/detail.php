<?php
  require_once('../../layout/header.php');
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
    <div class="cell-md-12">
      <h3>Data Diri</h3>
    </div>
  </div>
  <div class="row">
    <div class="cell-md-4 sm-12">
          <div class="window sm-12">
              <div class="window-caption">
                  <span class="icon mif-windows"></span>
                  <span class="title">Data Singkat</span>
              </div>
              <div class="window-content p-2">
                <form class="comment_form" name="crud_bahanbaku">
                    <div class="row">
                        <div class="cell-md-12 sm-12">
                          <?php
                           $sql = "SELECT * FROM t_user U left join t_role R on U.role=R.id_role where id_user=:iduser";
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindParam(':iduser', $_GET['uid']);
                           $stmt->execute();
                           $h = $stmt->fetchObject();
                          ?>
                          <div class="img-container">
                            <?php if ($h->fc_ktp == ""): ?>
                                <img src="<?php echo base ?>assets/img/ktp/logo.png">
                            <?php else: ?>
                                <img src="<?php echo base ?>assets/img/ktp/<?php echo $h->fc_ktp ?>">
                            <?php endif; ?>
                          </div>
                          <p class="text-center h3"><?php echo $h->fullname; ?></p>
                          <center><div class="text-ultralight tally warning"><?php echo $h->rolename; ?></div></center>
                        </div>
                    </div>
                </form>
              </div>
          </div> <!--windows -->
     </div> <!--cell -->

     <div class="cell-md-8 sm-12">
       <div class="window sm-12">
           <div class="window-caption">
               <span class="icon mif-windows"></span>
               <span class="title">About Me</span>
           </div>
           <div class="window-content p-2">
             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-2">
                 <b>Nama Lengkap</b>
               </div>
               <div class="cell-md-2">
                 <?php echo $h->fullname; ?>
               </div>
               <div class="cell-md-2"></div>
               <div class="cell-md-2">
                 <b>Umur</b>
               </div>
               <div class="cell-md-2">
                 <?php
                   $lahir = new DateTime($h->tgl_lahir);
                   $ini = new DateTime('today');
                   $y = $ini->diff($lahir)->y;
                   $m = $ini->diff($lahir)->m;
                   $d = $ini->diff($lahir)->d;
                   if ($y < 2){
                      $tahun = "";
                    }else{
                      $tahun = $y." tahun";
                    }
                    echo $tahun;
                 ?>
               </div>
               <div class="cell-md-1"></div>
             </div> <!-- row 1 -->

             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-2">
                 <b>Alamat</b>
               </div>
               <div class="cell-md-2">
                 <?php echo $h->alamat ?>
               </div>
               <div class="cell-md-2"></div>
               <div class="cell-md-2">
                 <b>Tanggal Lahir</b>
               </div>
               <div class="cell-md-2">
                 <?php
                  $d = date_create($h->tgl_lahir);
                  echo date_format($d, 'd M Y');
                 ?>
               </div>
               <div class="cell-md-1"></div>
             </div> <!-- row 2 -->

             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-2">
                 <b>No. Telepon</b>
               </div>
               <div class="cell-md-2">
                 <?php echo $h->no_telp ?>
               </div>
               <div class="cell-md-2"></div>
               <div class="cell-md-2">
                 <b>Tanggal Masuk</b>
               </div>
               <div class="cell-md-2">
                 <?php
                 $d = date_create($h->tgl_masuk);
                 echo date_format($d, 'd M Y');
                 ?>
               </div>
               <div class="cell-md-1"></div>
             </div> <!-- row 3 -->

             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-2">
                 <b>Waktu Login Terakhir</b>
               </div>
               <div class="cell-md-2">
                 <?php echo $h->last_login ?>
               </div>
             </div> <!-- row 1 -->
             <hr>
             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-2"><b>Akses</b></div>
             </div>
             <div class="row">
               <div class="cell-md-1"></div>
               <div class="cell-md-10">
                 <table class="table table-border cell-border ">
                 <?php
                   $sql = "SELECT U.fullname, R.nama_modul, R.link_modul, R.access, R.icon from t_rolemod R left join t_detil_role DR on DR.id_rolemod=R.id_rolemod left join t_role RO on RO.id_role=DR.id_role left join t_user U on RO.id_role=U.role where U.role=:idrole group by DR.id_detil_role";
                   $stmt = $pdo->prepare($sql);
                   $stmt->bindParam(':idrole', $_SESSION['idrole']);
                   $stmt->execute();
                   $hasil = $stmt->fetchAll();
                   foreach ($hasil as $h) {
                     if ($h['access'] == 'RW') {
                       $acc = "<div class='text-ultralight tally success'>READ</div> ";
                       $acc .= "<div class='text-ultralight tally alert'>WRITE</div>";
                     }elseif ($h['access'] == 'R') {
                       $acc = "<div class='text-ultralight tally success'>READ</div> ";
                     }
                     echo "<tr>
                            <td>".$h['nama_modul']."</td>
                            <td>".$acc."</td>
                          </tr>";
                   }
                 ?>
               </table>
               </div>
             </div>

           </div>
       </div> <!--windows -->
     </div> <!--cell -->
  </div> <!--row -->
</div> <!-- grid -->

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
<script type="text/javascript" src="../../../assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../../../assets/js/metro.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-ui.min.js"></script>
</body>
</html>
