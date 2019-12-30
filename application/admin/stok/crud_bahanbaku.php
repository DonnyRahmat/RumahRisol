<?php

  (!isset($_SESSION) ? session_start() : FALSE);

  $conn = mysqli_connect('localhost', 'root', '', 'db_rumahrisol');
  if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
  }

  require_once("../../config/db_conf.php");

  if (isset($_POST['save'])) {
    $sql = "INSERT INTO t_barang (
                  nama_barang,
                  satuan,
                  ukuran,
                  stok,
                  stok_min,
                  harga_beli,
                  id_user) VALUES (
                    :nb,
                    :s,
                    :u,
                    :st,
                    :stm,
                    :hb,
                    :iu)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nb', $_POST['nama_barang']);
  	$stmt->bindParam(':s', $_POST['satuan']);
    $stmt->bindParam(':u', $_POST['ukuran']);
    $stmt->bindParam(':st', $_POST['stok']);
    $stmt->bindParam(':stm', $_POST['stok_min']);
  	$stmt->bindParam(':hb', $_POST['harga_beli']);
    $stmt->bindParam(':iu', $_SESSION['id_user']);
    $stmt->execute();
  	exit();
  }

  // delete data
  if (isset($_GET['delete'])) {
    $sql = "DELETE FROM t_barang WHERE id_barang =  :idb";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idb', $_GET['id_barang']);
    $stmt->execute();
  	exit();
  }

  //update data
  if (isset($_POST['update'])) {
  	$eid = $_POST['eid'];

  	$nama_barang = $_POST['nama_barang'];
  	$satuan = $_POST['satuan'];
    $ukuran = $_POST['ukuran'];
  	$stok = $_POST['stok'];
    $stok_min = $_POST['stok_min'];
  	$harga_beli  = $_POST['harga_beli'];
  	$sql = "UPDATE t_barang SET
              nama_barang='{$nama_barang}',
              satuan='{$satuan}',
              ukuran='{$ukuran}',
              stok='{$stok}',
              stok_min='{$stok_min}',
              harga_beli='{$harga_beli}'
              WHERE id_barang=".$eid;
  	if (!mysqli_query($conn, $sql)) {
  	  echo "Error: ". mysqli_error($conn);
  	}
  	exit();
  }


  // $sql = "SELECT * FROM t_barang";
  // $result = mysqli_query($conn, $sql);
  // $comments = '<div id="display_area">';
  // while ($row = mysqli_fetch_array($result)) {
  // 	$comments .= '<div class="comment_box">
  // 		  <span class="delete" data-id="' . $row['id_barang'] . '" >delete</span>
  // 		  <span class="edit"   data-id="' . $row['id_barang'] . '">edit</span>
  //       <div class="id_barang">'. $row['id_barang'] .'</div>
  // 		  <div class="display_name">'. $row['nama_barang'] .'</div>
  // 		  <div class="comment_text">'. $row['satuan'] .'</div>
  // 	  </div>';
  // }
  // $comments .= '</div>';
?>
