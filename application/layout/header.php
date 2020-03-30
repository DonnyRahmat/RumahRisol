<?php
require_once('../../config/db_conf.php');
require_once('../../config/conf.php');
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
    <link rel="stylesheet" type="text/css" href="<?php echo base ?>assets/css/metro-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base ?>assets/css/datatables.min.css"/>
  </head>
  <body>
    <aside class="sidebar pos-absolute z-2"
           data-role="sidebar"
           data-toggle="#sidebar-toggle-3"
           id="sb3"
           data-shift=".shifted-content">
        <div class="sidebar-header image-overlay" data-image="">
            <div class="avatar">
                <img data-role="gravatar" data-email="sergey@pimenov.com.ua" >
            </div>
            <span class="title fg-orange">Metro 4 Components Library</span>
            <span class="subtitle fg-orange"> 2018 © Sergey Pimenov</span>
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
                echo "<li><a href=".base."".$h['link_modul']."><span class=".$h['icon']."></span>".$h['nama_modul']." <span class='badge inline bg-red fg-white'>".$h['access']."</span></a></li>";
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
