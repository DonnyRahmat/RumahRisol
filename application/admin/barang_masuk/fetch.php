<?php

session_start();
$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

$request=$_REQUEST;

$col =array(
    0   =>  'id_brgmsk',
    1   =>  'nama_barang',
    2   =>  'harga_brgmsk',
    3   =>  'jml_brgmsk',
    4   =>  'total_bayar',
    5   =>  'tgl_brg_msk',
    6   =>  'user'
);


$sql = "SELECT DB.id_brgmsk, B.nama_barang,
          format(DB.harga_brgmsk, 0) as harga_barang, DB.jml_brgmsk, format(DB.harga_brgmsk*DB.jml_brgmsk, 0) as total_bayar,
          date_format(DB.tgl_brgmsk, '%d %M %Y') as tgl_brg_msk, u.fullname as user
          FROM t_barang B inner join t_brgmsk DB on B.id_barang=DB.id_barang
          inner join t_user U on DB.id_user=U.id_user";
$query=mysqli_query($con,$sql);

// SELECT semua data;
$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;


$sql ="SELECT DB.id_brgmsk, B.nama_barang,
          format(DB.harga_brgmsk, 0) as harga_barang, DB.jml_brgmsk, format(DB.harga_brgmsk*DB.jml_brgmsk, 0) as total_bayar,
          DB.tgl_brgmsk as tgl_brg_msk, u.fullname as user
          FROM t_barang B inner join t_brgmsk DB on B.id_barang=DB.id_barang
          inner join t_user U on DB.id_user=U.id_user WHERE 1=1";

//fitur search
if(!empty($request['search']['value'])){
    $sql.=" AND (B.nama_barang Like '%".$request['search']['value']."%' ";
    $sql.=" OR DB.tgl_brgmsk Like '%".$request['search']['value']."%' ";
    $sql.=" OR u.fullname Like '%".$request['search']['value']."%' )";
}

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);

//filter tanggal
if (isset($request['filtered']) && isset($request['ket'])) {
  if ($request['filtered']=="yes") {
    if ($request['ket']=="all") {
      $sql .= " ";
    }elseif ($request['ket']=="hr") {
      $sql .= " and date(DB.tgl_brgmsk) = curdate()";
    }elseif ($request['ket']=="mg") {
      $sql .= " and DATE(tgl_brgmsk) > DATE_SUB(CURDATE(), INTERVAL 8 DAY)";
    }elseif ($request['ket']=="bln") {
      $sql .= " and month(DB.tgl_brgmsk) = MONTH(curdate())";
    }
  }
}

//Order
$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";

$query=mysqli_query($con,$sql);

$data=array();

while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$row[0];
    $subdata[]=$row[1];
    $subdata[]=$row[2];
    $subdata[]=$row[3];
    $subdata[]=$row[4];
    $subdata[]=$row[5];
    $subdata[]=$row[6];

    // event on click delete dan update
    //$row[0] = id
    if ($_SESSION['idrole'] == '1' || $_SESSION['idrole'] == '2') {
      $subdata[]='<button type="button" id="edit" class="button warning small" data-id="'.$row[0].'"><span class="mif-pencil"></span> Edit</button>
                  <button type="button" id="hapus_trans" onclick="hapus_data()" class="button alert small" data-id="'.$row[0].'"><span class="mif-bin"></span> Delete</button>';
    }else {
      $subdata[]='<b>EDIT</b> dan <b>DELETE</b> data hanya untuk admin';
    }

    $data[]=$subdata;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data, JSON_PRETTY_PRINT);

?>
