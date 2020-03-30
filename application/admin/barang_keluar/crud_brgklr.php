<?php
//insert.php
session_start();
require_once('../../config/db_conf.php');

$connect = mysqli_connect("localhost", "root", "", "db_rumahrisol");
if(isset($_POST["idbarang"]))
{
 $idb = $_POST["idbarang"];
 $hrg = $_POST["harga_jual"];
 $jml = $_POST["jml_brgklr"];
 $query = '';

 try {
   date_default_timezone_set('Asia/Jakarta');
   $tglM = date("Y-m-d H:i:s");
   $tot = "SELECT max(id_brgklr) as id_baru FROM t_brgklr";
   $stmt1 = $pdo->prepare($tot);
   $stmt1->execute();
   $max = $stmt1->fetchObject();
   $stmt1 = null;

   if (is_null($max->id_baru)) {
    $idet = 0;
   }else{
    $idet = $max->id_baru;
   }

   $sql = $pdo->prepare("INSERT INTO t_brgklr (id_brgklr, id_barang, jml_brgklr, harga_brgklr, tgl_brgklr, id_user) VALUES(:idbm ,:idb, :jml, :hrg, :tgl, :u)");
   $index = 0; // Set index array awal dengan 0
   foreach($idb as $idbar){
     $idt = ++$idet;
     $sql->bindParam(':idbm', $idt);
     $sql->bindParam(':idb', $idb[$index]);
     $sql->bindParam(':jml', $jml[$index]); // Ambil dan set data jml sesuai index array dari $index
     $sql->bindParam(':hrg', $hrg[$index]);
     $sql->bindParam(':tgl', $tglM); // Ambil dan set data alamat sesuai index array dari $index
     $sql->bindParam(':u', $_SESSION['id_user']); // Ambil dan set data alamat sesuai index array dari $index
     $sql->execute();

     $index++; // Tambah 1 setiap kali looping
   }

 } catch (\Exception $e) {
   echo $e->getMessage();
 }

}

// if(isset($_POST["updId"]))
// {
//  $query = "
//  SELECT bm.id_brgmsk, b.nama_barang, db.harga_brgmsk, db.jml_brgmsk, bm.total_bayar, bm.tgl_brg_msk, u.fullname as user FROM t_barang B
//  inner join t_detil_brgmsk DB on B.id_barang=DB.id_barang
//  INNER JOIN t_brg_msk BM on DB.id_brgmsk=BM.id_brgmsk
//  inner join t_user U on BM.id_user=u.id_user
//  WHERE DB.id_detil_brgmsk = '".$_POST["updId"]."'
//  ";
//  $statement = $connect->prepare($query);
//  $statement->execute();
//  while($row = $statement->fetch(PDO::FETCH_ASSOC))
//  {
//   $data[] = $row;
//  }
//  echo json_encode($data);
// }

if (isset($_POST["getUpd"])) {
   $con = mysqli_connect("localhost", "root", "", "db_rumahrisol");
   if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
   }
   $sql = "
   SELECT DB.id_brgklr, B.id_barang, concat(b.ukuran, ' ', b.satuan) as uk, b.nama_barang, b.stok, db.harga_brgklr, db.jml_brgklr, DB.tgl_brgklr, u.fullname as user
      FROM t_barang B
      inner join t_brgklr DB on B.id_barang=DB.id_barang
      inner join t_user U on DB.id_user=u.id_user
      WHERE DB.id_brgklr = '".$_POST["updId"]."'
   ";

   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);
   echo json_encode($row, JSON_PRETTY_PRINT);
  exit;
}
//
  if (isset($_POST['updateTrans'])) {
    try {
      $sql = "UPDATE t_brgklr set id_barang=:idbar, harga_brgklr=:hb, jml_brgklr=:j where id_brgklr=:updId";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':updId', $_POST['ibm']);
      $stmt->bindParam(':idbar', $_POST['idbar']);
      $stmt->bindParam(':hb', $_POST['hb']);
      $stmt->bindParam(':j', $_POST['j']);
      $stmt->execute();

      $fixStok = $_POST['s']+$_POST['ja']-$_POST['j'];
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

      $q = "select id_barang from t_brgklr where id_brgklr = :idb";
      $stmt = $pdo->prepare($q);
      $stmt->bindParam(':idb', $_GET['delId']);
      $stmt->execute();
      $g = $stmt->fetchObject();
      $idbar = $g->id_barang;

      $sql = "update t_barang set stok=stok+(SELECT jml_brgklr from t_brgklr where id_brgklr=:idb) where id_barang=:idbar";
      $stmt1 = $pdo->prepare($sql);
      $stmt1->bindParam(':idb', $_GET['delId']);
      $stmt1->bindParam(':idbar', $idbar);
      $stmt1->execute();

      $sql1 = "DELETE FROM t_brgklr WHERE id_brgklr = :idb";
      $stmt2 = $pdo->prepare($sql1);
      $stmt2->bindParam(':idb', $_GET['delId']);
      $stmt2->execute();
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  } //end func delete


?>
