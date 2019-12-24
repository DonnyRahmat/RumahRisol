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
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.css"/>
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
            <li>
              <a><span class="mif-home icon"></span>Home</a>
            </li>
            <li>
              <a href="<?php echo base."application/admin/stok" ?>"><span class="mif-books icon"></span>Stok</a>
            </li>
            <li>
              <a href="<?php echo base."application/admin/barang_masuk" ?>"><span class="mif-files-empty icon"></span>Barang Masuk</a>
            </li>
            <li class="divider"></li>
            <li><a><span class="mif-images icon"></span>Icons</a></li>
        </ul>
    </aside>
    <div class="shifted-content h-100 p-ab">
        <div class="app-bar pos-absolute bg-orange z-1" data-role="appbar">
            <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
                <span class="mif-menu fg-white"></span>
            </button>
            <img src="<?php echo base ?>assets/img/logo.png" alt="" width="50px" height="5%">
        </div>

    <div class="container-fluid">
