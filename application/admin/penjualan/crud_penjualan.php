<?php
//insert.php
session_start();
require_once('../../config/db_conf.php');

$connect = mysqli_connect("localhost", "root", "", "db_rumahrisol");

if(isset($_POST["idproduk"]))
{
 $idp = $_POST["idproduk"];
 $hrg = $_POST["harga"];
 $qty = $_POST["qty"];
 $disk = $_POST["diskon"];
 $c = mysqli_real_escape_string($connect, $_POST["cash"]);
 $k = mysqli_real_escape_string($connect, $_POST["kembalian"]);
 $idj = mysqli_real_escape_string($connect, $_POST["idj"]);
 $u = $_SESSION['id_user'];

 // try {
   date_default_timezone_set('Asia/Jakarta');
   $tglM = date("Y-m-d H:i:s");

   $query = '';
   for($count = 0; $count<count($idp); $count++){
     $idpc = mysqli_real_escape_string($connect, $idp[$count]);
     $hrgc = mysqli_real_escape_string($connect, $hrg[$count]);
     $qtyc = mysqli_real_escape_string($connect, $qty[$count]);
     $diskc = mysqli_real_escape_string($connect, $disk[$count]);
     if($idpc != '' && $hrgc != '' && $qtyc != ''){
      $query .= '
      INSERT INTO t_detil_jualprd(id_jualprd, id_produk, jml, harga_jual, diskon)
      VALUES("'.$idj.'", "'.$idpc.'", "'.$qtyc.'", "'.$hrgc.'", "'.$diskc.'");
      ';
     }
    }

    if($c != '' && $k != ''){
     $query .= '
     INSERT INTO t_jualprd(id_jualprd, cash, kembalian, id_user)
     VALUES("'.$idj.'", "'.$c.'", "'.$k.'", "'.$u.'")
     ';
    }

    if($query != ''){
      // var_dump($q);
     if(mysqli_multi_query($connect, $query)){
      echo 'Transaksi Sukses';
     }else{
      echo mysqli_error($connect);
     }
    }else{
     echo 'Semua kolom harus diisi';
    }

}//end save func

if (isset($_POST["getUpd"])) {
  //  $con = mysqli_connect("localhost", "root", "", "db_rumahrisol");
  //  if (mysqli_connect_errno()) {
  //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
  //     exit();
  //  }
  //
  //  $sql = "
  //  SELECT DB.id_prdmsk, B.id_produk, B.stok, B.nama_produk, DB.harga_beli, DB.jml_prdmsk, DB.tgl_prdmsk, U.fullname as user
  //  FROM t_produk B
  //  inner join t_prdmsk DB on B.id_produk=DB.id_produk
  //  inner join t_user U on DB.id_user=u.id_user
  //  WHERE DB.id_prdmsk = '".$_POST["updId"]."'
  //  ";
  //
  //  $result = mysqli_query($con, $sql);
  //  $row = mysqli_fetch_array($result);
  //  echo json_encode($row, JSON_PRETTY_PRINT);
  //
  // exit;

  $stmt = $pdo->prepare("SELECT DB.id_prdmsk, B.id_produk, B.stok, B.nama_produk, DB.harga_beli, DB.jml_prdmsk, DB.tgl_prdmsk, U.fullname as user
  FROM t_produk B
  inner join t_prdmsk DB on B.id_produk=DB.id_produk
  inner join t_user U on DB.id_user=u.id_user
  WHERE DB.id_prdmsk = :upd");
  $stmt->bindParam(':upd', $_POST['updId']);
  $stmt->execute();
  $res = $stmt->fetch(PDO::FETCH_OBJ);
  echo json_encode($res, JSON_PRETTY_PRINT);
}// end update

  if (isset($_POST['updateTrans'])) {
    try {
      $sql = "UPDATE t_prdmsk set id_produk=:idprd, harga_beli=:hb, jml_prdmsk=:j where id_prdmsk=:updId";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':updId', $_POST['ipm']);
      $stmt->bindParam(':idprd', $_POST['idprd']);
      $stmt->bindParam(':hb', $_POST['hb']);
      $stmt->bindParam(':j', $_POST['j']);
      $stmt->execute();
      // $stmt->null;



      $fixStok = $_POST['s']-$_POST['ja']+$_POST['j'];
      $sql2 = "UPDATE t_produk set stok=:stok where id_produk=:idprd";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':stok', $fixStok);
      $stmt2->bindParam(':idprd', $_POST['idprd']);
      $stmt2->execute();

    } catch (\Exception $e) {
      echo $e->getMessage();
    }

  } //end func update

  if (isset($_GET['delete'])) {
    try {
      $q = "select id_produk from t_prdmsk where id_prdmsk = :idb";
      $stmt = $pdo->prepare($q);
      $stmt->bindParam(':idb', $_GET['delId']);
      $stmt->execute();
      $g = $stmt->fetchObject();
      $idprd = $g->id_produk;

      $sql = "update t_produk set stok=stok-(SELECT jml_prdmsk from t_prdmsk where id_prdmsk=:idb) where id_produk=:idprd";
      $stmt1 = $pdo->prepare($sql);
      $stmt1->bindParam(':idb', $_GET['delId']);
      $stmt1->bindParam(':idprd', $idprd);
      $stmt1->execute();
      //
      $sql1 = "DELETE FROM t_prdmsk WHERE id_prdmsk = :idb";
      $stmt2 = $pdo->prepare($sql1);
      $stmt2->bindParam(':idb', $_GET['delId']);
      $stmt2->execute();


    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  } //end func delete


?>
