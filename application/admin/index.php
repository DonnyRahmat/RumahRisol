<?php
require_once('../config/db_conf.php');
require_once('../config/conf.php');
session_start();
if(!isset($_SESSION['username']))
{
  unset($_SESSION['id_user']);
  unset($_SESSION['username']);
  unset($_SESSION['fname']);
  session_destroy();
  header('location:http://localhost/RumahRisol/index.php');
  exit;
  echo "gaada data";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Rumah Risol</title>
    <link rel="stylesheet" href="<?php echo base ?>assets/css/metro-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base ?>assets/css/datatables.min.css"/>
  </head>
  <body>
    <aside class="sidebar pos-absolute z-2"
           data-role="sidebar"
           data-toggle="#sidebar-toggle-3"
           id="sb3"
           data-shift=".shifted-content">
        <div class="sidebar-header image-overlay" data-image="">
          <div style="position:absolute;height:64px;width:64px;background:#fff;color:#fff;border-radius:50%;top:16px;left:16px;overflow:hidden;text-align:center;border:2px solid #fff">
              <img src="<?php echo base; ?>assets/img/ktp/<?php echo ($_SESSION['ktp']=="" ? "logo.png" : $_SESSION['ktp']); ?>" style="height:64px; width:64px;">
          </div>
            <span class="title fg-orange">Rumah Risol d'rizzie</span>
            <span class="subtitle fg-orange"><?php echo $_SESSION['fname'] ?></span>
        </div>
        <ul class="sidebar-menu">
            <ul class="v-menu">
              <li class="menu-title">Access Menu</li>
              <li><a href="<?php echo base ?>application/admin"><span class=""></span> Home</a></li>
              <?php
                $sql = "SELECT U.fullname, R.nama_modul, R.link_modul, R.access, R.icon from t_rolemod R left join t_detil_role DR on DR.id_rolemod=R.id_rolemod left join t_role RO on RO.id_role=DR.id_role left join t_user U on RO.id_role=U.role where U.role=:idrole group by DR.id_detil_role";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':idrole', $_SESSION['idrole']);
                $stmt->execute();
                $hasil = $stmt->fetchAll();
                foreach ($hasil as $h) {
                  echo "<li><a href=".base."".$h['link_modul']."><span class=".$h['icon']."></span>".$h['nama_modul']."</a></li>";
                }
              ?>
              <li class="menu-title">Akun</li>
                  <li><a href="<?php echo base."application/admin/user/index.php" ?>">Data Diri</a></li>
                  <li><a href="<?php echo base."logout.php" ?>">Logout</a></li>
            </ul> <!-- v menu -->
        </ul> <!-- sidebar menu -->
    </aside>
    <div class="shifted-content h-100 p-ab">
        <div class="app-bar pos-absolute bg-orange z-1" data-role="appbar">
            <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
                <span class="mif-menu fg-white"></span>
            </button>
            <img src="<?php echo base ?>assets/img/logo.png" alt="" width="50px" height="5%">
        </div>


    <div class="container-fluid">
        <div class="h-100 p-4">

              <?php
              // date_default_timezone_set('Asia/Jakarta');
              // echo $log = date('Y-m-d H:i:s');
              ?>
            <p class="h1">Halo, <?php echo $_SESSION['fname'] ?></p>
            <br>
            <div class="row">
              <div class="cell-md-4 sm-12">
                <div id="dbm">
                  <div class="more-info-box bg-olive fg-white">
                      <div class="content">
                          <h2 class="text-bold mb-0">
                            <?php
                              $k = "SELECT sum(jml_brgmsk) as cid FROM t_brgmsk where date(tgl_brgmsk) = curdate()";
                              $p = $pdo->query($k);
                              $h = $p->fetch(PDO::FETCH_OBJ);
                              echo $h->cid;
                            ?>
                          </h2>
                          <div>Jumlah Bahan Baku Masuk Hari ini</div>
                      </div>
                      <div class="icon">
                          <span class="mif-download"></span>
                      </div>
                  </div>
                </div>
              </div>
              <div class="cell-md-4 sm-12">
                  <div class="more-info-box bg-amber fg-white" id="dbk">
                      <div class="content">
                          <h2 class="text-bold mb-0">
                            <?php
                              $k = "SELECT sum(jml_brgklr) as cid FROM t_brgklr where date(tgl_brgklr) = curdate()";
                              $p = $pdo->query($k);
                              $h = $p->fetch(PDO::FETCH_OBJ);
                              echo $h->cid;
                            ?>
                          </h2>
                          <div>Jumlah Bahan Baku Keluar Hari ini</div>
                      </div>
                      <div class="icon">
                          <span class="mif-upload"></span>
                      </div>
                  </div>
              </div>
              <div class="cell-md-4 sm-12">
                <div class="more-info-box bg-steel fg-white">
                    <div class="content">
                        <h2 class="text-bold mb-0">
                          <?php
                            $k = "SELECT sum(jml_prdmsk) as cid FROM t_prdmsk where date(tgl_prdmsk) = curdate()";
                            $p = $pdo->query($k);
                            $h = $p->fetch(PDO::FETCH_OBJ);
                            echo $h->cid;
                          ?>
                        </h2>
                        <div>Jumlah Produk Masuk Hari ini</div>
                    </div>
                    <div class="icon">
                        <span class="mif-cart"></span>
                    </div>
                </div>
              </div>
            </div>
            <div class="grid">
              <div class="row">
                <div class="cell-md-12 sm-12">
                  <table id="tabel_bm" class="table table-border" style="display: none">
                    <thead>
                        <tr>
                          <th colspan="8" style="text-align:center">Detail Bahan Baku Masuk</th>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jml Brg Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $bm = $pdo->prepare('SELECT nama_barang, jml_brgmsk FROM t_brgmsk B left join t_barang BRG on BRG.id_barang=B.id_barang WHERE tgl_brgmsk=curdate()');
                        $bm->execute();
                        while ($h = $bm->fetch(PDO::FETCH_OBJ)) {
                        ?>
                      <tr>
                        <td><?php echo $h->nama_barang ?></td>
                        <td><?php echo $h->jml_brgmsk ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <table id="tabel_bk" class="table table-border" style="display: none">
              <thead>
                  <tr>
                    <th colspan="8" style="text-align:center">Detail Bahan Baku Keluar</th>
                  </tr>
                  <tr>
                      <th>Nama Barang</th>
                      <th>Jml Brg Klr</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $bk = $pdo->prepare('SELECT nama_barang, jml_brgklr FROM t_brgklr B left join t_barang BRG on BRG.id_barang=B.id_barang WHERE tgl_brgklr=curdate()');
                  $bk->execute();
                  while ($h = $bk->fetch(PDO::FETCH_OBJ)) {
                  ?>
                <tr>
                  <td><?php echo $h->nama_barang ?></td>
                  <td><?php echo $h->jml_brgklr ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="row">
              <div class="cell-md-6 sm-12">
                <h4>Bahan Baku Hampir Habis</h4>
                <table class="table striped row-hover" data-role="table" data-rows="5" data-rows-steps="-1, 5, 10, 25, 50, 100" data-show-search="true">
                  <thead>
                    <th>No</th>
                    <th class="">Nama Bahan Baku</th>
                    <th class="">Stok</th>
                  </thead>
                  <tbody>
                    <?php
                      // $q = "SELECT nama_barang, stok FROM `t_barang` WHERE stok<=stok_min limit 5";
                      $q = "SELECT nama_barang, stok FROM `t_barang` WHERE stok<=stok_min";
                      $stmt = $pdo->prepare($q);
                      $stmt->execute();
                      $b=1;
                      while ($a = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo "<tr>
                                <td>$b</td>
                                <td>$a->nama_barang</td>
                                <td>$a->stok</td>
                              </tr>";
                              $b++;
                      }
                    ?>
                  </tbody>
                </table>
              </div>

              <div class="cell-md-6 sm-12">
                <h4>Produk Hampir Habis</h4>
                <table class="table striped row-hover" data-role="table" data-rows="5" data-rows-steps="-1, 5, 10, 25, 50, 100" data-show-search="true">
                  <thead>
                    <th>No</th>
                    <th class="">Nama produk</th>
                    <th class="">Stok</th>
                  </thead>
                  <tbody>
                    <?php
                      // $q = "SELECT nama_barang, stok FROM `t_barang` WHERE stok<=stok_min limit 5";
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
            </div> <!-- row -->
            <button type="button" name="button" id="hide">Hide</button>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

var tabel_bm = $('#tabel_bm');
var tabel_bk = $('#tabel_bk');

  $('#dbm').click(function(){
    if (tabel_bm.is(':visible')) {
      tabel_bm.fadeOut('slow');
      tabel_bm.show();
    }else{

      tabel_bm.fadeIn('slow');
      tabel_bm.show();
    }
  });

  $('#dbk').click(function(){
    if (tabel_bk.is(':visible')) {
      tabel_bk.show();
      tabel_bk.fadeOut('slow');
    }else{
      tabel_bk.show();
      tabel_bk.fadeIn('slow');
    }
  });

</script>
<?php require_once('../layout/footer.php'); ?>
