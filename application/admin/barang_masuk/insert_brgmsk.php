<?php
//insert.php
session_start();
// $hb = $_POST['harga_beli'];
// $jml = $_POST['jml_brgmsk'];
// var_dump($hb,$jml);

// $connect = mysqli_connect("localhost", "root", "", "db_rumahrisol");
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
 require_once('../../config/db_conf.php');
 try {
   // $date = date("Y-m-d H:i:s");
   $tot = "SELECT max(id_brgmsk) as idm from t_brg_msk";
   $stmt1 = $pdo->prepare($tot);
   $stmt1->execute();
   $max = $stmt1->fetch(PDO::FETCH_OBJ);
   $idmax = $max->idm;
   if ($idmax == 0) {
     $idmax = 1;
   }elseif ($idmax >= 0) {
     $idmax = $max->idm+1;
   }
   //
   // $total = 0;
   //  foreach($hrg AS $k=>$v){
   //    $total += $v*$jml[$k];
   //  }
   //  $tott = $total;
   //
   // $sqlInput = "INSERT INTO t_brg_msk (id_brgmsk, tgl_brg_msk, total_bayar, id_user) values (:idb, :tgl, :total, :user)";
   // $stmt2 = $pdo->prepare($sqlInput);
   // $stmt2->bindParam(':idb', $idmax);
   // $stmt2->bindParam(':tgl', $date);
   // $stmt2->bindParam(':total', $tott);
   // $stmt2->bindParam(':user', $_SESSION['id_user']);
   // $stmt2->execute();
   // $stmt2 = null;
   //
   // // $idb = $_POST["idbarang"];
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

    $sql = $pdo->prepare("INSERT INTO t_detil_brgmsk (id_barang, id_brgmsk, jml_brgmsk, harga_brgmsk) VALUES(:,:nama,:telp,:alamat)");
    $index = 0; // Set index array awal dengan 0
    foreach($nis as $datanis){ // Kita buat perulangan berdasarkan nis sampai data terakhir
      $sql->bindParam(':nis', $datanis); // Set data nis
      $sql->bindParam(':nama', $nama[$index]); // Ambil dan set data nama sesuai index array dari $index
      $sql->bindParam(':telp', $telp[$index]); // Ambil dan set data telepon sesuai index array dari $index
      $sql->bindParam(':alamat', $alamat[$index]); // Ambil dan set data alamat sesuai index array dari $index
      $sql->execute(); // Eksekusi query insert

      $index++; // Tambah 1 setiap kali looping
    }

   var_dump($jml);

 } catch (\Exception $e) {
   echo $e->getMessage();
 }

}
?>
