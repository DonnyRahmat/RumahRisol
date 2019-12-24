<?php
  $conn = mysqli_connect('localhost', 'root', '', 'db_rumahrisol');
  if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
  }

  if (isset($_POST['save'])) {
    $nb = $_POST['nama_barang'];
  	$stn = $_POST['satuan'];
    $u = $_POST['ukuran']." ".$_POST['satuan'];
  	$s = $_POST['stok'];
    $sm = $_POST['stok_min'];
  	$hb  = $_POST['harga_beli'];
    $sql = "INSERT INTO t_barang (nama_barang, satuan, ukuran, stok, stok_min, harga_beli) VALUES ('{$nb}', '{$stn}', '{$u}', '{$s}', '{$sm}', '{$hb}')";
  	if (mysqli_query($conn, $sql)) {
  	  $id = mysqli_insert_id($conn);
  	}else {
  	  echo "Error: ". mysqli_error($conn);
  	}
  	exit();
  }

  // delete data
  if (isset($_GET['delete'])) {
  	$id_barang = $_GET['idb'];
  	$sql = "DELETE FROM t_barang WHERE id_barang=" . $id_barang;
  	mysqli_query($conn, $sql);
  	exit();
  }

  //update data
  if (isset($_POST['update'])) {
  	$eid = $_POST['eid'];
  	$nama_barang = $_POST['nama_barang'];
  	$satuan = $_POST['satuan'];
    $ukuran = $_POST['ukuran']." ".$_POST['satuan'];
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
