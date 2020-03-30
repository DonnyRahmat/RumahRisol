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

 $sql = "SELECT * FROM t_produk WHERE nama_produk like :search";
 $stmt = $pdo->prepare($sql);
 $stmt->bindParam(':search', $search);
 $stmt->execute();

 while ($row = $stmt->fetch()) {
   $response[] = array("value"=>$row['id_produk'],
                       "label"=>$row['nama_produk']);
 }

 // encoding array to json format
 echo json_encode($response);
 exit;
}

// Get details
if($request == 2){
 $idb = $_POST['id_produk'];
 $sql = "SELECT * FROM t_produk WHERE id_produk=".$idb;

 $result = mysqli_query($con,$sql);

 $users_arr = array();

 while( $row = mysqli_fetch_array($result) ){
  $id_produk    = $row['id_produk'];
  $nama_produk  = $row['nama_produk'];
  $harga_jual   = $row['harga_jual'];
  $stok   = $row['stok'];

  $parse[] = array(
      "idp" => $id_produk,
      "np"  => $nama_produk,
      "s"  => $stok,
      "hj"  => $harga_jual);
 }

 // encoding array to json format
 echo json_encode($parse, JSON_PRETTY_PRINT);
 exit;
}
