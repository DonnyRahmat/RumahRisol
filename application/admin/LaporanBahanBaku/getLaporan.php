<?php

require_once('../../config/db_conf.php');

function nf($n)
{

  if ($n=='') {
    return "Belum ada transaksi";
  }else{
    $v = (int)$n;
    return number_format($n,0,",",".");
  }

}

if (isset($_POST['hr'])) {
  $ret_arr=array();
  $q = "select 	B.id_barang,
            		B.nama_barang,
            		sum(m.jm) as brgmsk,
                m.hrg_bm as hbm,
                sum(k.jk) as brgklr,
                k.hrg_bk as hbk,
                SUM(b.stok) as stok,
                SUM(b.stok*b.harga_beli) as ns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hrg_bm
                from t_brgmsk
                where date(tgl_brgmsk) = curdate()
                GROUP by id_barang
            	) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hrg_bk
                from t_brgklr
                where date(tgl_brgklr) = curdate()
                GROUP by id_barang
            	) k ON B.id_barang=k.id_barang
            group by B.id_barang";
    $res = $pdo->query($q);
    while($row = $res->fetch(PDO::FETCH_OBJ)) {
      $nm_bar = $row->nama_barang;
      $brg_msk = nf($row->brgmsk);
      $hbm = nf($row->hbm);
      $brg_klr = nf($row->brgklr);
      $hbk = nf($row->hbk);
      $stok = nf($row->stok);
      $ns = nf($row->ns);
      $ret_arr[] = array(
                  'nm_bar' => $nm_bar,
                  'brg_msk' => $brg_msk,
                  'hbm' => $hbm,
                  'brg_klr' => $brg_klr,
                  'hbk' => $hbk,
                  'stok' => $stok,
                  'ns' => $ns,

      );
    }

    $q2 = "select 	B.id_barang,
		                sum(m.jm) as tjm,
                    sum(m.hm) as thm,
		                sum(k.jk) as tjk,
                    sum(k.hk) as thk,
                    SUM(b.stok) as ts,
                    SUM(b.stok*b.harga_beli) as tns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hm
                from t_brgmsk
                where date(tgl_brgmsk) = curdate()
                GROUP by id_barang
            	) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hk
                from t_brgklr
                where date(tgl_brgklr) = curdate()
                GROUP by id_barang
            	) k ON B.id_barang=k.id_barang
      ";
      $res = $pdo->query($q2);
      $r2 = $res->fetch(PDO::FETCH_OBJ);
      $arrr = array();
      $arrr[] = array(
        'tjm' => $r2->tjm,
        'thm' => nf($r2->thm),
        'tjk' => $r2->tjk,
        'thk' => nf($r2->thk),
        'ts' => $r2->ts,
        'tns' => nf($r2->tns)

      );
      $narr=array_merge($ret_arr,$arrr);

    echo json_encode($narr, JSON_PRETTY_PRINT);

}elseif (isset($_POST['mg'])) {

    $ret_arr=array();
    $q = "select 	B.id_barang,
              		B.nama_barang,
              		sum(m.jm) as brgmsk,
                  m.hrg_bm as hbm,
                  sum(k.jk) as brgklr,
                  k.hrg_bk as hbk,
                  SUM(b.stok) as stok,
                  SUM(b.stok*b.harga_beli) as ns
              from t_barang B
              left join (
                  select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hrg_bm
                  from t_brgmsk
                  where YEARWEEK(tgl_brgmsk, 1) = YEARWEEK(NOW(), 1)
                  GROUP by id_barang
              	) m on B.id_barang = m.id_barang
              left join (
                  select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hrg_bk
                  from t_brgklr
                  where YEARWEEK(tgl_brgklr, 1) = YEARWEEK(NOW(), 1)
                  GROUP by id_barang
              	) k ON B.id_barang=k.id_barang
              group by B.id_barang";
      $res = $pdo->query($q);
      while($row = $res->fetch(PDO::FETCH_OBJ)) {
        $nm_bar = $row->nama_barang;
        $brg_msk = nf($row->brgmsk);
        $hbm = nf($row->hbm);
        $brg_klr = nf($row->brgklr);
        $hbk = nf($row->hbk);
        $stok = nf($row->stok);
        $ns = nf($row->ns);
        $ret_arr[] = array(
                    'nm_bar' => $nm_bar,
                    'brg_msk' => $brg_msk,
                    'hbm' => $hbm,
                    'brg_klr' => $brg_klr,
                    'hbk' => $hbk,
                    'stok' => $stok,
                    'ns' => $ns,

        );
      }

      $q2 = "select 	B.id_barang,
  		                sum(m.jm) as tjm,
                      sum(m.hm) as thm,
  		                sum(k.jk) as tjk,
                      sum(k.hk) as thk,
                      SUM(b.stok) as ts,
                      SUM(b.stok*b.harga_beli) as tns
              from t_barang B
              left join (
                  select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hm
                  from t_brgmsk
                  where YEARWEEK(tgl_brgmsk, 1) = YEARWEEK(NOW(), 1)
                  GROUP by id_barang
              	) m on B.id_barang = m.id_barang
              left join (
                  select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hk
                  from t_brgklr
                  where YEARWEEK(tgl_brgklr, 1) = YEARWEEK(NOW(), 1)
                  GROUP by id_barang
              	) k ON B.id_barang=k.id_barang
        ";
        $res = $pdo->query($q2);
        $r2 = $res->fetch(PDO::FETCH_OBJ);
        $arrr = array();
        $arrr[] = array(
          'tjm' => $r2->tjm,
          'thm' => nf($r2->thm),
          'tjk' => $r2->tjk,
          'thk' => nf($r2->thk),
          'ts' => $r2->ts,
          'tns' => nf($r2->tns)

        );
        $narr=array_merge($ret_arr,$arrr);

      echo json_encode($narr, JSON_PRETTY_PRINT);

}elseif(isset($_POST['bln'])){
  $ret_arr=array();
  $q = "select 	B.id_barang,
                B.nama_barang,
                sum(m.jm) as brgmsk,
                m.hrg_bm as hbm,
                sum(k.jk) as brgklr,
                k.hrg_bk as hbk,
                SUM(b.stok) as stok,
                SUM(b.stok*b.harga_beli) as ns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hrg_bm
                from t_brgmsk
                where month(tgl_brgmsk) = MONTH(curdate())
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hrg_bk
                from t_brgklr
                where month(tgl_brgklr) = MONTH(curdate())
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
            group by B.id_barang";
    $res = $pdo->query($q);
    while($row = $res->fetch(PDO::FETCH_OBJ)) {
      $nm_bar = $row->nama_barang;
      $brg_msk = nf($row->brgmsk);
      $hbm = nf($row->hbm);
      $brg_klr = nf($row->brgklr);
      $hbk = nf($row->hbk);
      $stok = nf($row->stok);
      $ns = nf($row->ns);
      $ret_arr[] = array(
                  'nm_bar' => $nm_bar,
                  'brg_msk' => $brg_msk,
                  'hbm' => $hbm,
                  'brg_klr' => $brg_klr,
                  'hbk' => $hbk,
                  'stok' => $stok,
                  'ns' => $ns,

      );
    }

    $q2 = "select 	B.id_barang,
                    sum(m.jm) as tjm,
                    sum(m.hm) as thm,
                    sum(k.jk) as tjk,
                    sum(k.hk) as thk,
                    SUM(b.stok) as ts,
                    SUM(b.stok*b.harga_beli) as tns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hm
                from t_brgmsk
                where month(tgl_brgmsk) = MONTH(curdate())
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hk
                from t_brgklr
                where month(tgl_brgklr) = MONTH(curdate())
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
      ";
      $res = $pdo->query($q2);
      $r2 = $res->fetch(PDO::FETCH_OBJ);
      $arrr = array();
      $arrr[] = array(
        'tjm' => $r2->tjm,
        'thm' => nf($r2->thm),
        'tjk' => $r2->tjk,
        'thk' => nf($r2->thk),
        'ts' => $r2->ts,
        'tns' => nf($r2->tns)

      );
      $narr=array_merge($ret_arr,$arrr);

    echo json_encode($narr, JSON_PRETTY_PRINT);

}elseif (isset($_POST['cust_tgl'])) {
  $d1 = $_POST['tgl1'];
  $d2 = $_POST['tgl2'];
  $df1 = $d1." 00:00:00";
  $df2 = $d2." 23:59:59";

  $ret_arr=array();
  $q = "select 	B.id_barang,
                B.nama_barang,
                sum(m.jm) as brgmsk,
                m.hrg_bm as hbm,
                sum(k.jk) as brgklr,
                k.hrg_bk as hbk,
                SUM(b.stok) as stok,
                SUM(b.stok*b.harga_beli) as ns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hrg_bm
                from t_brgmsk
                where date(tgl_brgmsk) BETWEEN '$df1' and '$df2'
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hrg_bk
                from t_brgklr
                where date(tgl_brgklr) BETWEEN '$df1' and '$df2'
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
            group by B.id_barang";
    $res = $pdo->query($q);
    while($row = $res->fetch(PDO::FETCH_OBJ)) {
      $nm_bar = $row->nama_barang;
      $brg_msk = nf($row->brgmsk);
      $hbm = nf($row->hbm);
      $brg_klr = nf($row->brgklr);
      $hbk = nf($row->hbk);
      $stok = nf($row->stok);
      $ns = nf($row->ns);
      $ret_arr[] = array(
                  'nm_bar' => $nm_bar,
                  'brg_msk' => $brg_msk,
                  'hbm' => $hbm,
                  'brg_klr' => $brg_klr,
                  'hbk' => $hbk,
                  'stok' => $stok,
                  'ns' => $ns,

      );
    }

    $q2 = "select 	B.id_barang,
                    sum(m.jm) as tjm,
                    sum(m.hm) as thm,
                    sum(k.jk) as tjk,
                    sum(k.hk) as thk,
                    SUM(b.stok) as ts,
                    SUM(b.stok*b.harga_beli) as tns
            from t_barang B
            left join (
                select id_brgmsk, id_barang, sum(jml_brgmsk) as jm, sum(jml_brgmsk*harga_brgmsk) as hm
                from t_brgmsk
                where date(tgl_brgmsk) BETWEEN '$df1' and '$df2'
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hk
                from t_brgklr
                where date(tgl_brgklr) BETWEEN '$df1' and '$df2'
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
      ";
      $res = $pdo->query($q2);
      $r2 = $res->fetch(PDO::FETCH_OBJ);
      $arrr = array();
      $arrr[] = array(
        'tjm' => $r2->tjm,
        'thm' => nf($r2->thm),
        'tjk' => $r2->tjk,
        'thk' => nf($r2->thk),
        'ts' => $r2->ts,
        'tns' => nf($r2->tns)

      );
      $narr=array_merge($ret_arr,$arrr);

    echo json_encode($narr, JSON_PRETTY_PRINT);

}


?>
