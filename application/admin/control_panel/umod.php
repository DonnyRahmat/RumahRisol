<?php

require_once('../../config/conf.php');
require_once('../../config/db_conf.php');

if (isset($_POST['umod'])) {
// $json = array();
  // $json['msg'] = $_POST['umod'];
  $_k = "SELECT R.id_rolemod, R.nama_modul, R.access, RO.rolename FROM t_rolemod R
            left join t_detil_role DR
	          left join t_role RO
              on RO.id_role=DR.id_role
              on DR.id_rolemod = R.id_rolemod and DR.id_role=:umod
            group by R.id_rolemod";
  // $_k1 = "SELECT DR.id_rolemod, R.nama_modul, R.access
  //         FROM t_detil_role DR left join t_rolemod R
	//            on DR.id_rolemod = R.id_rolemod
  //         WHERE DR.id_role=:umod";
$_stmt = $pdo->prepare($_k);
$_stmt->bindParam(':umod', $_POST['umod']);
$_stmt->execute();
// $hasil = $_stmt->fetch(PDO::FETCH_ASSOC);
while($h = $_stmt->fetch(PDO::FETCH_OBJ)){
  if ($h->access=="RW") {
    $acc = "<div class='text-ultralight tally success'>READ</div> ";
    $acc .= "<div class='text-ultralight tally alert'>WRITE</div>";
  }elseif ($h->access=='R') {
    $acc = "<div class='text-ultralight tally success'>READ</div> ";
  }
  if (empty($h->rolename)) {
    $opt = "";
  }else{
    $opt = "checked";
  }
    $json[] =  "<tr><td>".$acc." - ".$h->nama_modul."</td><td><input type='checkbox' id=role_".$h->id_rolemod." data-role='switch' ".$opt." data-material='true'></td></tr>";
}

  echo json_encode($json, JSON_PRETTY_PRINT);
}

?>
