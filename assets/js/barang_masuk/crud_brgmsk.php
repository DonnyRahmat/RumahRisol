<?php
//insert.php
session_start();
require_once('../../config/db_conf.php');

$connect = mysqli_connect("localhost", "root", "", "db_rumahrisol");
if(isset($_POST["idbarang"]))
{
 $idb = $_POST["idbarang"];
 $hrg = $_POST["harga_beli"];
 $jml = $_POST["jml_brgmsk"];
 $query = '';

 try {
   date_default_timezone_set('Asia/Jakarta');
   $tglM = date("Y-m-d H:i:s");
   $date = date("dmY");
   $m2 = "SELECT max(id_brgmsk) as idbm from t_brgmsk";
   $stmt3 = $pdo->prepare($m2);
   $stmt3->execute();
   $max = $stmt3->fetchObject();
   $stmt3 = null;

   if (is_null($max->idbm)) {
    $idet = 0;
   }else{
    $idet = $max->idbm;
   }

   $sql = $pdo->prepare("INSERT INTO t_brgmsk (id_brgmsk, id_barang, jml_brgmsk, harga_brgmsk, tgl_brgmsk, id_user) VALUES(:idbm, :idb, :jml, :hrg, :tgl, :u)");
   $index = 0; // Set index array awal dengan 0
   foreach($idb as $idbar){ // Kita buat perulangan berdasarkan nis sampai data terakhir
     $idt = ++$idet;
     $sql->bindParam(':idbm', $idt);
     $sql->bindParam(':idb', $idb[$index]); // Set data nis
     $sql->bindParam(':jml', $jml[$index]); // Ambil dan set data telepon sesuai index array dari $index
     $sql->bindParam(':hrg', $hrg[$index]); // Ambil dan set data alamat sesuai index array dari $index
     $sql->bindParam(':tgl', $tglM); // Ambil dan set data alamat sesuai index array dari $index
     $sql->bindParam(':u', $_SESSION['id_user']); // Ambil dan set data alamat sesuai index array dari $index
     $sql->execute(); // Eksekusi query insert

     $index++; // Tambah 1 setiap kali looping
   }

 } catch (\Exception $e) {
   echo $e->getMessage();
 }

}

if (isset($_POST["getUpd"])) {
   $con = mysqli_connect("localhost", "root", "", "db_rumahrisol");
   if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
   }
   $sql = "
   SELECT DB.id_brgmsk, B.id_barang, concat(b.ukuran, ' ', b.satuan) as uk, b.nama_barang, b.stok, db.harga_brgmsk, db.jml_brgmsk, DB.tgl_brgmsk, u.fullname as user
   FROM t_barang B
   inner join t_brgmsk DB on B.id_barang=DB.id_barang
   inner join t_user U on DB.id_user=u.id_user
   WHERE DB.id_brgmsk = '".$_POST["updId"]."'
   ";

   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);
   echo json_encode($row, JSON_PRETTY_PRINT);

  exit;
}
//
  if (isset($_POST['updateTrans'])) {
    try {
      $sql = "UPDATE t_brgmsk set id_barang=:idbar, harga_brgmsk=:hb, jml_brgmsk=:j where id_brgmsk=:updId";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':updId', $_POST['ibm']);
      $stmt->bindParam(':idbar', $_POST['idbar']);
      $stmt->bindParam(':hb', $_POST['hb']);
      $stmt->bindParam(':j', $_POST['j']);
      $stmt->execute();

      $fixStok = $_POST['s']-$_POST['ja']+$_POST['j'];
      $sql2 = "UPDATE t_barang set stok=:stok where id_barang=:idbar";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':stok', $fixStok);
      $stmt2->bindParam(':idbar', $_POST['idbar']);
      $stmt2->execute();

    } catch (\Exception $e) {
      echo $e->getMessage();
    }

  } //end func update

  if (isset($_GET['delete'])) {
    try {
      $q = "select id_barang from t_brgmsk where id_brgmsk = :idb";
      $stmt = $pdo->prepare($q);
      $stmt->bindParam(':idb', $_GET['delId']);
      $stmt->execute();
      $g = $stmt->fetchObject();
      $idbar = $g->id_barang;

      $sql = "update t_barang set stok=stok-(SELECT jml_brgmsk from t_brgmsk where id_brgmsk=:idb) where id_barang=:idbar";
      $stmt1 = $pdo->prepare($sql);
      $stmt1->bindParam(':idb', $_GET['delId']);
      $stmt1->bindParam(':idbar', $idbar);
      $stmt1->execute();
      //
      $sql1 = "DELETE FROM t_brgmsk WHERE id_brgmsk = :idb";
      $stmt2 = $pdo->prepare($sql1);
      $stmt2->bindParam(':idb', $_GET['delId']);
      $stmt2->execute();


    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  } //end func delete


?>
