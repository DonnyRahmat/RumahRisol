<?php

$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

$request=$_REQUEST;

$col =array(
    0   =>  'id_rolemod',
    1   =>  'nama_modul',
    2   =>  'link_modul',
    3   =>  'access',
    4   =>  'icon'
);

// GET TOTAL ROW
$sql = "SELECT * from t_rolemod";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql ="SELECT * from t_rolemod WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (nama_modul Like '%".$request['search']['value']."%' ";
    $sql.=" OR link_modul Like '%".$request['search']['value']."%' ";
    $sql.=" OR access Like '%".$request['search']['value']."%' )";
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

    // event on click delete dan update
    //$row[0] = id
    $subdata[]='<button type="button" id="editModul" class="button warning small" data-id="'.$row[0].'"><span class="mif-pencil"></span> Edit</button>
                <button type="button" id="deleteModul" class="button alert small" data-id="'.$row[0].'"><span class="mif-bin"></span> Delete</button>';
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
