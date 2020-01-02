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
   $tot = "SELECT max(mid(id_brgmsk, 13)) as idm from t_brg_msk";
   $stmt1 = $pdo->prepare($tot);
   $stmt1->execute();
   $max = $stmt1->fetchObject();
   if (is_null($max->idm)){
     $idmax = "BM/".$date."/1";
   }elseif ($max->idm >= 1) {
     $val = $max->idm+1;
     $idmax = "BM/".$date."/".$val;
   }
   $stmt1 = null;

   $total = 0;
    foreach($hrg AS $k=>$v){
      $total += $v*$jml[$k];
    }
    $tott = $total;

   $sqlInput = "INSERT INTO t_brg_msk (id_brgmsk, tgl_brg_msk, total_bayar, id_user) values (:idb, :tgl, :total, :user)";
   $stmt2 = $pdo->prepare($sqlInput);
   $stmt2->bindParam(':idb', $idmax);
   $stmt2->bindParam(':tgl', $tglM);
   $stmt2->bindParam(':total', $tott);
   $stmt2->bindParam(':user', $_SESSION['id_user']);
   $stmt2->execute();
   $stmt2 = null;

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

   $sql = $pdo->prepare("INSERT INTO t_detil_brgmsk (id_barang, id_brgmsk, jml_brgmsk, harga_brgmsk) VALUES(:idb, :idm, :jml, :hrg)");
   $index = 0; // Set index array awal dengan 0
   foreach($idb as $idbar){ // Kita buat perulangan berdasarkan nis sampai data terakhir
     $sql->bindParam(':idb', $idbar); // Set data nis
     $sql->bindParam(':idm', $idmax); // Ambil dan set data nama sesuai index array dari $index
     $sql->bindParam(':jml', $jml[$index]); // Ambil dan set data telepon sesuai index array dari $index
     $sql->bindParam(':hrg', $hrg[$index]); // Ambil dan set data alamat sesuai index array dari $index
     $sql->execute(); // Eksekusi query insert

     $index++; // Tambah 1 setiap kali looping
   }

   echo "Input Tersimpan.";

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
   SELECT db.id_detil_brgmsk, concat(b.ukuran, ' ', b.satuan) as uk, b.id_barang, bm.id_brgmsk, b.nama_barang, b.stok, db.harga_brgmsk, db.jml_brgmsk, bm.total_bayar, bm.tgl_brg_msk, u.fullname as user FROM t_barang B
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
    // $updId = $_POST['updId'];
    // $idbar = $_POST['idbar'];
    // $nm = $_POST['nm'];
    // $s = $_POST['s'];
    // $u = $_POST['u'];
    // $hb = $_POST['hb'];
    // $j = $_POST['j'];

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

      $tot = $_POST['hb'] * $_POST['j'];
      $sql2 = "UPDATE t_brg_msk set total_bayar=:tot where id_brgmsk=:ibm";
      $stmt2 = $pdo->prepare($sql2);
      $stmt2->bindParam(':tot', $tot);
      $stmt2->bindParam(':ibm', $_POST['ibm']);
      $stmt2->execute();


    } catch (\Exception $e) {
      echo $e->getMessage();
    }


  }
?>
