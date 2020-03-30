<?php

// $con=mysqli_connect('localhost','root','','dbphpserverside')
//     or die("connection failed".mysqli_errno());

$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

$request=$_REQUEST;

$col =array(
    0   =>  'id_prdmsk',
    1   =>  'nama_produk',
    2   =>  'harga_beli',
    3   =>  'jml_prdmsk',
    4   =>  'nominal',
    5   =>  'tgl_brg_msk',
    6   =>  'fullname'
);

// $sql ="SELECT * FROM t_produk";
$sql = "SELECT DB.id_prdmsk, B.nama_produk, format(DB.harga_beli, 0), DB.jml_prdmsk, format(DB.harga_beli*DB.jml_prdmsk, 0) as total_bayar, date_format(DB.tgl_prdmsk, '%d %M %Y'), u.fullname as user
FROM t_produk B inner join t_prdmsk DB on B.id_produk=DB.id_produk
inner join t_user U on DB.id_user=U.id_user
GROUP BY DB.id_prdmsk";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql = "SELECT DB.id_prdmsk, B.nama_produk, format(DB.harga_beli, 0), DB.jml_prdmsk, format(DB.harga_beli*DB.jml_prdmsk, 0) as total_bayar, date_format(DB.tgl_prdmsk, '%d %M %Y'), u.fullname as user
FROM t_produk B inner join t_prdmsk DB on B.id_produk=DB.id_produk
inner join t_user U on DB.id_user=U.id_user
WHERE 1=1 ";
if(!empty($request['search']['value'])){
    $sql.=" AND (B.nama_produk Like '%".$request['search']['value']."%' ";
    $sql.=" OR date_format(DB.tgl_prdmsk, '%d %M %Y %T') Like '%".$request['search']['value']."%' ";
    $sql.=" OR u.fullname Like '%".$request['search']['value']."%' )";
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

    // event on click delete dan update
    //$row[0] = id
    $subdata[]='<button type="button" id="edit" class="button warning small" data-id="'.$row[0].'"><span class="mif-pencil"></span> Edit</button>
                <button type="button" id="hapus_trans" onclick="hapus_data()" class="button alert small" data-id="'.$row[0].'"><span class="mif-bin"></span> Delete</button>';
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
