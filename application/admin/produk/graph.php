<?php

require_once('../../config/db_conf.php');

$arr = array();
$h = $pdo->query("
select
                sum(m.jml_brgmsk) as bm,
                m.tgl_brgmsk as tm,
                sum(k.jml_brgklr) as bk,
                k.tgl_brgklr as tk
            from t_barang B
            left join t_brgmsk m on B.id_barang = m.id_barang
            left join t_brgklr k ON B.id_barang=k.id_barang
            group by m.tgl_brgmsk
");
while ($r = $h->fetch(PDO::FETCH_OBJ)) {
  $j1 = $r->bm;
  $t1 = $r->tm;
  $j2 = $r->bk;
  $t2 = $r->tk;
  $arr[] = array(
    'j1'=>$j1,
    't1'=>$t1,
    'j2'=>$j2,
    't2'=>$t2
  );
}
echo json_encode($arr, JSON_PRETTY_PRINT);

?>
