<?php

$con=mysqli_connect('localhost','root','','db_rumahrisol')
    or die("connection failed".mysqli_errno());

$request=$_REQUEST;

$col =array(
    0   =>  'id_user',
    1   =>  'fullname',
    2   =>  'rolename'
);

// GET TOTAL ROW
$sql = "SELECT U.id_user, U.fullname, R.rolename from t_user U left join t_role R on U.role=R.id_role";
$query=mysqli_query($con,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//fitur search
$sql ="SELECT U.id_user, U.fullname, R.rolename from t_user U left join t_role R on U.role=R.id_role WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (U.id_user Like '%".$request['search']['value']."%' ";
    $sql.=" OR U.fullname Like '%".$request['search']['value']."%' ";
    $sql.=" OR R.rolename Like '%".$request['search']['value']."%' )";
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

    // event on click delete dan update
    //$row[0] = id
    $subdata[]='<a class="button success small" href="detail.php?uid='.$row[0].'"><span class="mif-home"></span> Detail</a>
                <button type="button" id="editU" class="button warning small" data-id="'.$row[0].'"><span class="mif-pencil"></span> Edit</button>
                <button type="button" id="deleteU" onclick="hapus_data()" class="button alert small" data-id="'.$row[0].'"><span class="mif-bin"></span> Delete</button>';
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
