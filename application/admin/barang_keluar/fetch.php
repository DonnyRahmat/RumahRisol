<?php
session_start();
$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

$request=$_REQUEST;

$col =array(
    0   =>  'id_brgklr',
    1   =>  'nama_barang',
    2   =>  'harga_brgklr',
    3   =>  'jml_brgklr',
    4   =>  'nominal',
    5   =>  'tgl_brg_klr',
    6   =>  'fullname'
);

// GET TOTAL ROW
$sql = "SELECT DB.id_brgklr, B.nama_barang,
          format(DB.harga_brgklr, 0), DB.jml_brgklr, format(DB.harga_brgklr*DB.jml_brgklr, 0) as total_bayar,
          date_format(DB.tgl_brgklr, '%d %M %Y'), u.fullname as user
          FROM t_barang B inner join t_brgklr DB on B.id_barang=DB.id_barang
          inner join t_user U on DB.id_user=U.id_user";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql ="SELECT DB.id_brgklr, B.nama_barang,
          format(DB.harga_brgklr, 0), DB.jml_brgklr, format(DB.harga_brgklr*DB.jml_brgklr, 0) as total_bayar,
          date_format(DB.tgl_brgklr, '%d %M %Y'), u.fullname as user
          FROM t_barang B inner join t_brgklr DB on B.id_barang=DB.id_barang
          inner join t_user U on DB.id_user=U.id_user WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (B.nama_barang Like '%".$request['search']['value']."%' ";
    $sql.=" OR date_format(DB.tgl_brgklr, '%d %M %Y %T') Like '%".$request['search']['value']."%' ";
    $sql.=" OR U.fullname Like '%".$request['search']['value']."%' )";
}

$query=mysqli_query($con,$sql);
$totalData=mysqli_num_rows($query);

//filter tanggal
if (isset($request['filtered']) && isset($request['ket'])) {
  if ($request['filtered']=="yes") {
    if ($request['ket']=="all") {
      $sql .= "";
    }elseif ($request['ket']=="hr") {
      $sql .= " and date(DB.tgl_brgklr) = curdate()";
    }elseif ($request['ket']=="mg") {
      $sql .= " and DATE(tgl_brgklr) > DATE_SUB(CURDATE(), INTERVAL 8 DAY)";
    }elseif ($request['ket']=="bln") {
      $sql .= " and month(DB.tgl_brgklr) = MONTH(curdate())";
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
    // $subdata[]='<button type="button" id="edit" class="button warning small" data-id="'.$row[0].'"><span class="mif-pencil"></span> Edit</button>
    //             <button type="button" id="hapus_trans" onclick="hapus_data()" class="button alert small" data-id="'.$row[0].'"><span class="mif-bin"></span> Delete</button>';
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
