<?php
//insert.php
session_start();
require_once('../../config/db_conf.php');
// $hb = $_POST['harga_beli'];
// $jml = $_POST['jml_brgmsk'];
// var_dump($hb,$jml);

$connect = mysqli_connect("localhost", "root", "", "db_rumahrisol");
if(isset($_POST["idbarang"]))
{
 $idb = $_POST["idbarang"];
 $hrg = $_POST["harga_beli"];
 $jml = $_POST["jml_brgmsk"];
 $query = '';

 // for($count = 0; $count<count($idb); $count++)
 // {
 //  // $idb_clean = mysqli_real_escape_string($connect, $idb[$count]);
 //  $hrg_clean = mysqli_real_escape_string($connect, $hrg[$count]);
 //  $jml_clean = mysqli_real_escape_string($connect, $jml[$count]);
 //  $date = date("Y-m-d H:i:s");
 //  $user = $_SESSION['id_user'];
 //  if($hrg_clean != '' && $jml_clean != '')
 //  {
   // $query .= '
   // INSERT INTO t_brg_msk(tgl_brg_msk, id_user, hrg_brgmsk, jml_brgmsk)
   // VALUES("'.$date.'", "'.$user.'", "'.$hrg_clean.'", "'.$jml_clean.'");
   // ';
 //  }
 // }

 // if($query != '')
 // {
 //  if(mysqli_multi_query($connect, $query))
 //  {
 //   echo 'Item Data Inserted';
 //  }
 //  else
 //  {
 //  echo("Error description: " . $mysqli -> error);
 //  }
 // }
 // else
 // {
 //  echo 'All Fields are Required';
 // }

 try {
   date_default_timezone_set('Asia/Jakarta');
   $tglM = date("Y-m-d H:i:s");
   $date = date("dmY");
   // $m1 = "SELECT max(mid(id_brgmsk, 3)) as idm from t_brg_msk";
   // $stmt1 = $pdo->prepare($m1);
   // $stmt1->execute();
   // $max = $stmt1->fetchObject();
   // if (is_null($max->idm)){
   //   $idmax = "M-1";
   // }elseif ($max->idm >= 1) {
   //   $val = $max->idm+1;
   //   $idmax = "M-".$val;
   // }
   // $stmt1 = null;

   // untuk insert total_bayar
   // $total = 0;
   //  foreach($hrg AS $k=>$v){
   //    $total += $v*$jml[$k];
   //  }
   //  $tott = $total;
   // echo count($idb)." ";
   // $sqlInput = "INSERT INTO t_brg_msk (id_brgmsk, tgl_brg_msk, id_user) values (:idb, :tgl, :user)";
   // $stmt2 = $pdo->prepare($sqlInput);
   // $stmt2->bindParam(':idb', $idmax);
   // $stmt2->bindParam(':tgl', $tglM);
   // // $stmt2->bindParam(':total', $tott);
   // $stmt2->bindParam(':user', $_SESSION['id_user']);
   // $stmt2->execute();
   // $stmt2 = null;

   // $idb = $_POST["idbarang"];
   // $query = "INSERT INTO t_detil_brgmsk (id_barang, id_brgmsk, jml_brgmsk, harga_brgmsk)
   //            VALUES  (:id2, :idm2, :jml, :hrg)";
   //
   // $stmt = $pdo->prepare($query);
   // // $stmt3->bindParam(':idm2', $idmax);
   // for($count = 0; $count<count($idb); $count++) {
   //    $stmt->execute(array(
   //      ':id2' => $idb,
   //      ':idm2'=> $idmax,
   //      ':jml' => $jml,
   //      ':hrg' => $hrg
   //  ));
   // }
   // $stmt3 = null;

   // $m2 = "SELECT max(id_detil_brgmsk) as idbm from t_detil_brgmsk";
   // $stmt3 = $pdo->prepare($m2);
   // $stmt3->execute();
   // $max = $stmt3->fetchObject();
   //
   // if (is_null($max->idbm)) {
   //  $idet = 0;
   // }else{
   //  $idet = $max->idbm;
   // }

   // $sql = $pdo->prepare("INSERT INTO t_detil_brgmsk (id_detil_brgmsk, id_barang, id_brgmsk, jml_brgmsk, harga_brgmsk) VALUES(:idbm, :idb, :idm, :jml, :hrg)");
   // $index = 0; // Set index array awal dengan 0
   // foreach($idb as $idbar){ // Kita buat perulangan berdasarkan nis sampai data terakhir
   //   $idt = ++$idet;
   //   $sql->bindParam(':idbm', $idt);
   //   $sql->bindParam(':idb', $idbar); // Set data nis
   //   $sql->bindParam(':idm', $idmax); // Ambil dan set data nama sesuai index array dari $index
   //   $sql->bindParam(':jml', $jml[$index]); // Ambil dan set data telepon sesuai index array dari $index
   //   $sql->bindParam(':hrg', $hrg[$index]); // Ambil dan set data alamat sesuai index array dari $index
   //   $sql->execute(); // Eksekusi query insert
   //
   //   $index++; // Tambah 1 setiap kali looping
   // }

   $m2 = "SELECT max(id_brgmsk) as idbm from t_tmp_brgmsk";
   $stmt3 = $pdo->prepare($m2);
   $stmt3->execute();
   $max = $stmt3->fetchObject();

   if (is_null($max->idbm)) {
    $idet = 0;
   }else{
    $idet = $max->idbm;
   }

   $sql = $pdo->prepare("INSERT INTO t_tmp_brgmsk (id_brgmsk, id_barang, jml_brgmsk, harga_brgmsk, tgl_brgmsk, id_user) VALUES(:idbm, :idb, :jml, :hrg, :tgl, :u)");
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

   // echo "Input Tersimpan.";

   // var_dump($jml);

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
   SELECT db.id_detil_brgmsk, concat(b.ukuran, ' ', b.satuan) as uk, b.id_barang, bm.id_brgmsk, b.nama_barang, b.stok, db.harga_brgmsk, db.jml_brgmsk, bm.tgl_brg_msk, u.fullname as user FROM t_barang B
   inner join t_detil_brgmsk DB on B.id_barang=DB.id_barang
   INNER JOIN t_brg_msk BM on DB.id_brgmsk=BM.id_brgmsk
   inner join t_user U on BM.id_user=u.id_user
   WHERE DB.id_detil_brgmsk = '".$_POST["updId"]."'
   ";

   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result);
   echo json_encode($row, JSON_PRETTY_PRINT);

  // $result = mysqli_query($con,$sql);

  // $users_arr = array();
  //
  // while( $row = mysqli_fetch_array($result) ){
  //  $id_detil_brgmsk = $row['id_detil_brgmsk'];
  //  $id_barang       = $row['id_barang'];
  //  $nama_barang     = $row['nama_barang'];
  //  $stok            = $row['stok'];
  //  $ukuran          = $row['ukuran']." ".$row['satuan'];
  //  $harga_brgmsk    = $row['harga_brgmsk'];
  //
  //  $parse[] = array(
  //      "idb" => $id_detil_brgmsk,
  //      "ib"  => $id_barang,
  //      "nb"  => $nama_barang,
  //      "s"   => $stok,
  //      "u"   => $ukuran,
  //      "hb"  => $harga_brgmsk);
  // }

  // encoding array to json format
  // echo json_encode($parse, JSON_PRETTY_PRINT);
  exit;
}
//
  if (isset($_POST['updateTrans'])) {
    // echo $updId = $_POST['updId'];
    // echo "<br>";
    // echo $idbar = $_POST['idbar'];
    // echo "<br>";
    // echo $nm = $_POST['nm'];
    // echo "<br>";
    // echo $s = $_POST['s'];
    // echo "<br>";
    // echo $u = $_POST['u'];
    // echo "<br>";
    // echo $hb = $_POST['hb'];
    // echo "<br>";
    // echo $j = $_POST['j'];
    // echo "<br>";
    echo "Jumlah awal : ".$ja = $_POST['ja'];

    // echo $updId;
      // $sql = "UPDATE t_detil_brgmsk set id_barang={$idbar}, harga_brgmsk={$hb}, jml_brgmsk={$j} where id_detil_brgmsk={$updId}";
      // if (!mysqli_query($connect, $sql)) {
      //   echo "Error: ". mysqli_error($conn);
      // }
      // exit();
    try {
      $sql = "UPDATE t_detil_brgmsk set id_barang=:idbar, harga_brgmsk=:hb, jml_brgmsk=:j where id_detil_brgmsk=:updId";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':updId', $_POST['updId']);
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
      $q = "select id_barang from t_detil_brgmsk where id_detil_brgmsk = :idb";
      $stmt = $pdo->prepare($q);
      $stmt->bindParam(':idb', $_GET['delId']);
      $stmt->execute();
      $g = $stmt->fetchObject();
      $idbar = $g->id_barang;

      $sql = "update t_barang set stok=stok-(SELECT jml_brgmsk from t_detil_brgmsk where id_detil_brgmsk=:idb) where id_barang=:idbar";
      $stmt1 = $pdo->prepare($sql);
      $stmt1->bindParam(':idb', $_GET['delId']);
      $stmt1->bindParam(':idbar', $idbar);
      $stmt1->execute();
      //
      $sql1 = "DELETE FROM t_detil_brgmsk WHERE id_detil_brgmsk = :idb";
      $stmt2 = $pdo->prepare($sql1);
      $stmt2->bindParam(':idb', $_GET['delId']);
      $stmt2->execute();


    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  } //end func delete


?>
