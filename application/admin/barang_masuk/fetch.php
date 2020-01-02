<?php

// $con=mysqli_connect('localhost','root','','dbphpserverside')
//     or die("connection failed".mysqli_errno());

$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

// $host = "localhost";
// $user = "root";
// $password = "";
// $dbname = "db_rumahrisol";
// $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, array(
//       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
// ));

$request=$_REQUEST;
// $col =array(
//     0   =>  'id',
//     1   =>  'name',
//     2   =>  'salary',
//     3   =>  'age'
// );  //create column like table in database

$col =array(
    0   =>  'id_detil_brgmsk',
    1   =>  'id_brgmsk',
    2   =>  'nama_barang',
    3   =>  'harga_brgmsk',
    4   =>  'jml_brgmsk',
    5   =>  'total_bayar',
    6   =>  'tgl_brg_msk',
    7   =>  'fullname'
);

// $sql ="SELECT * FROM t_barang";
$sql = "SELECT db.id_detil_brgmsk, bm.id_brgmsk, b.nama_barang, db.harga_brgmsk, db.jml_brgmsk, bm.total_bayar, bm.tgl_brg_msk, u.fullname as user FROM t_barang B inner join t_detil_brgmsk DB on B.id_barang=DB.id_barang INNER JOIN t_brg_msk BM on DB.id_brgmsk=BM.id_brgmsk inner join t_user U on BM.id_user=u.id_user";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql ="SELECT db.id_detil_brgmsk, bm.id_brgmsk, b.nama_barang, db.harga_brgmsk, db.jml_brgmsk, bm.total_bayar, bm.tgl_brg_msk, u.fullname as user FROM t_barang B inner join t_detil_brgmsk DB on B.id_barang=DB.id_barang INNER JOIN t_brg_msk BM on DB.id_brgmsk=BM.id_brgmsk inner join t_user U on BM.id_user=u.id_user WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (bm.id_brgmsk Like '".$request['search']['value']."%' ";
    $sql.=" OR b.nama_barang Like '".$request['search']['value']."%' ";
    $sql.=" OR u.fullname Like '".$request['search']['value']."%' )";
}
$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);

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
    $subdata[]=$row[7];

    // event on click delete dan update
    //$row[0] = id
    $subdata[]='<button type="button" id="edit" class="btn btn-primary btn-xs" data-id="'.$row[0].'"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Edit</button>
                <button type="button" id="hapus"   class="btn btn-danger btn-xs" data-id="'.$row[0].'"><i class="glyphicon glyphicon-trash">&nbsp;</i>Delete</button>';
                //<a href="index.php?delete='.$row[0].'" onclick="return confirm(\'Are You Sure ?\')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash">&nbsp;</i>Delete</a>
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
