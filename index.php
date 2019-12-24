<?php
  session_start();
  require_once('application/config/db_conf.php');
  require_once('application/config/conf.php');
  if(isset($_SESSION['username'])) {
    header('location:application/admin/index.php');
    exit;
  }else{
    header('location:login.php');
    exit;
  }
  echo $_SESSION['username']
?>
