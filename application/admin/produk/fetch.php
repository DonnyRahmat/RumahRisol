<?php

$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

function n_form($v)
{
  return number_format($v,0,",",".");
}

$request=$_REQUEST;

$col =array(
    0   =>  'id_produk',
    1   =>  'nama_produk',
    2   =>  'stok',
    3   =>  'stok_min',
    4   =>  'harga_beli',
    5   =>  'harga_jual'
);

$sql ="SELECT * FROM t_produk";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql ="SELECT * FROM t_produk WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (id_produk Like '%".$request['search']['value']."%' ";
    $sql.=" OR satuan Like '%".$request['search']['value']."%' )";
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
    $subdata[]=n_form($row[2]);
    $subdata[]=n_form($row[3]);
    $subdata[]=$row[4];
    $subdata[]=$row[5];

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
