<?php
//include "config.php";

require_once('../../config/db_conf.php');

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "db_rumahrisol"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

$request = $_POST['request']; // request

if($request == 1){
 $search = "%".$_POST['search']."%";

 $sql = "SELECT * FROM t_barang WHERE nama_barang like :search";
 $stmt = $pdo->prepare($sql);
 $stmt->bindParam(':search', $search);
 $stmt->execute();

 while ($row = $stmt->fetch()) {
   $response[] = array("value"=>$row['id_barang'],
                       "label"=>$row['nama_barang']);
 }


 // $sql = "SELECT * FROM t_barang WHERE nama_barang like'%".$search."%'";
 // $result = mysqli_query($con,$sql);
 //
 // while($row = mysqli_fetch_array($result) ){
 //  $response[] = array("value"=>$row['id_barang'],"label"=>$row['nama_barang']);
 // }

 // encoding array to json format
 echo json_encode($response);
 exit;
}

// Get details
if($request == 2){
 $idb = $_POST['id_barang'];
 $sql = "SELECT * FROM t_barang WHERE id_barang=".$idb;

 $result = mysqli_query($con,$sql);

 $users_arr = array();

 while( $row = mysqli_fetch_array($result) ){
  $id_barang    = $row['id_barang'];
  $nama_barang  = $row['nama_barang'];
  $ukuran       = $row['ukuran']." ".$row['satuan'];
  $stok         = $row['stok'];
  $harga_beli   = $row['harga_beli'];

  $parse[] = array(
      "idb" => $id_barang,
      "nb"  => $nama_barang,
      "u"   => $ukuran,
      "s"   => $stok,
      "hb"   => $harga_beli);
 }

 // encoding array to json format
 echo json_encode($parse, JSON_PRETTY_PRINT);
 exit;
}
