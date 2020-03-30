<?php

  (!isset($_SESSION) ? session_start() : FALSE);

  $conn = mysqli_connect('localhost', 'root', '', 'db_rumahrisol');
  if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
  }

  require_once("../../config/db_conf.php");

  if (isset($_POST['save'])) {
    $sql = "INSERT INTO t_produk (
                  nama_produk,
                  stok,
                  stok_min,
                  harga_beli,
                  harga_jual,
                  id_user) VALUES (
                    :np,
                    :s,
                    :stm,
                    :hb,
                    :hj,
                    :iu)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':np', $_POST['nama_produk']);
    $stmt->bindParam(':s', $_POST['stok']);
    $stmt->bindParam(':stm', $_POST['stok_min']);
  	$stmt->bindParam(':hb', $_POST['harga_beli']);
  	$stmt->bindParam(':hj', $_POST['harga_jual']);
    $stmt->bindParam(':iu', $_SESSION['id_user']);
    $stmt->execute();
  	exit();
  }

  // delete data
  if (isset($_GET['delete'])) {
    $sql = "DELETE FROM t_produk WHERE id_produk=:idb";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idb', $_GET['id_produk']);
    $stmt->execute();
  	exit();
  }

  //update data
  if (isset($_POST['update'])) {
  	$eid = $_POST['eid'];

  	$nama_produk = $_POST['nama_produk'];
  	$stok = $_POST['stok'];
    $stok_min = $_POST['stok_min'];
  	$harga_beli  = str_replace(".","",$_POST['harga_beli']);
    $harga_jual  = str_replace(".","",$_POST['harga_jual']);
  	$sql = "UPDATE t_produk SET
              nama_produk='{$nama_produk}',
              stok='{$stok}',
              stok_min='{$stok_min}',
              harga_beli='{$harga_beli}',
              harga_jual='{$harga_jual}'
              WHERE id_produk=".$eid;
  	if (!mysqli_query($conn, $sql)) {
  	  echo "Error: ". mysqli_error($conn);
  	}
  	exit();
  }

?>
