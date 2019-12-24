<?php

$conn = mysqli_connect('localhost', 'root', '', 'db_rumahrisol');

//require( 'ssp.class.php' );

$get = (object) $_GET;
$orderCols = $get->columns;
$start = $get->start;
$length = $get->length;
$search = $get->search["value"];
$search = isset($get->search["value"]) ? "WHERE nama_barang LIKE '%$search%' OR nama_barang LIKE '%$search%' OR satuan LIKE '%$search%' OR ukuran LIKE '%$search%'" : "";
$order = $orderCols[$get->order[0]["column"]]["name"];
$orderDir = $get->order[0]["dir"];
$orderBy = ($order != "") ? "ORDER BY $order $orderDir" : "";

$data["data"] = [];
$d = mysqli_query($conn, "SELECT * From t_barang $search $orderBy LIMIT $start, $length");
$f = mysqli_query($conn, "SELECT * From t_barang $search $orderBy");
$all = mysqli_query($conn, "SELECT * From t_barang");
while($r = mysqli_fetch_assoc($d)){
  $r["aksi"] = "<span class='delete' data-id='".$r['id_barang']."'>delete</span>";
  $data["data"][] = $r;
}

$data["draw"]=$get->draw;
$data["recordsTotal"] = mysqli_num_rows($all);
$data["recordsFiltered"] = ($get->search["value"] != "") ? mysqli_num_rows($f) : mysqli_num_rows($all);
header("Content-Type: application/json");
echo json_encode($data, JSON_PRETTY_PRINT);
return;
