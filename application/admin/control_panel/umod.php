<?php

require_once('../../config/conf.php');
require_once('../../config/db_conf.php');

if (isset($_POST['umod'])) {
// $json = array();
  // $j = $_POST['umod'];
  $_k = "SELECT R.id_rolemod, R.nama_modul, R.access, RO.rolename FROM t_rolemod R
            left join t_detil_role DR
	          left join t_role RO
              on RO.id_role=DR.id_role
              on DR.id_rolemod = R.id_rolemod and DR.id_role=:umod
            group by R.id_rolemod";
$_stmt = $pdo->prepare($_k);
$_stmt->bindParam(':umod', $_POST['umod']);
$_stmt->execute();
// $hasil = $_stmt->fetch(PDO::FETCH_ASSOC);
while($h = $_stmt->fetch(PDO::FETCH_OBJ)){
  if (empty($h->rolename)) {
    $opt = "";
  }else{
    $opt = "checked";
  }
    $json[] =  "<tr><td>".$h->nama_modul."</td><td><input class='rmod' value=".$h->id_rolemod." type='checkbox' id=".$h->id_rolemod." data-role='switch' ".$opt." data-material='true'></td></tr>";
}

  echo json_encode($json, JSON_PRETTY_PRINT);
}

?>
