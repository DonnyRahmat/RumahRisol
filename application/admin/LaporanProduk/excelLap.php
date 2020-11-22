<?php require_once('../../config/conf.php');?>
<!-- <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css"> -->

<center>
  <b>Laporan Stok Bahan Baku</b> <br>
  <b>Rekapitulasi</b>
  <b>
    <?php

    function weekNumberOfMonth($date) {
      $tgl=date_parse($date);
      $tanggal =  $tgl['day'];
      $bulan   =  $tgl['month'];
      $tahun   =  $tgl['year'];

      //tanggal 1 tiap bulan
      $tanggalAwalBulan = mktime(0, 0, 0, $bulan, 1, $tahun);
      $mingguAwalBulan = (int) date('W', $tanggalAwalBulan);

      //tanggal sekarang
      $tanggalYangDicari = mktime(0, 0, 0, $bulan, $tanggal, $tahun);
      $mingguTanggalYangDicari = (int) date('W', $tanggalYangDicari);
      $mingguKe = $mingguTanggalYangDicari - $mingguAwalBulan + 1;
      return $mingguKe;
    }

      if (isset($_POST['o']) && $_POST['o'] == "hr") {
        echo $t = "Tanggal ".date('j F Y');
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan $t.xls");
        // echo  "Minggu ke-".$bln;
        // $tanggal=date('d-m-Y');
      }elseif (isset($_POST['o']) && $_POST['o'] == "mg") {
        $tanggal=date('d-m-Y');
        $minggu_ke=weekNumberOfMonth($tanggal);
        echo $t = ("Bulan ".date('F')." Minggu Ke ".$minggu_ke."");
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan $t.xls");
      }elseif (isset($_POST['o']) && $_POST['o'] == "bln") {
        echo $t = "Bulan ".date('F');
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan $t.xls");
      }elseif (isset($_POST['o']) && $_POST['o'] == "cust") {
        $d1 = $_POST['d1'];
        $d2 = $_POST['d2'];
        echo $t = "Tanggal ".date("j F Y", strtotime($d1))." - ".date("j F Y", strtotime($d2));
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan $t.xls");
      }
    ?>
  </b>
</center>

<br>

<div class="container">

  <table border=3  class='table table-border cell-border'>
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Jml Brg Msk</th>
            <th bgcolor="#8FBC8F">Nominal Brg Masuk</th>
            <th>Jml Brg Klr</th>
            <th bgcolor="#8FBC8F">Nominal Brg Klr</th>
            <th>Stok Akhir</th>
            <th bgcolor="#E6E6FA">Nominal Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
<?php

require_once('../../config/db_conf.php');

function cmk($n){
  if ($n=='') {
    return "<th bgcolor='#8FBC8F'>Belum ada transaksi</th>";
  }else{
    $v = (int)$n;
    return "<th bgcolor='#8FBC8F'>".$n."</th>";
  }
}

function nor($n){
  if ($n=='') {
    return "<th>Belum ada transaksi</th>";
  }else{
    $v = (int)$n;
    return "<th>".number_format($n,0,",",".")."</th>";
  }
}

function s($n){
  if ($n=='') {
    return "<th bgcolor='#E6E6FA'>Belum ada transaksi</th>";
  }else{
    $v = (int)$n;
    return "<th bgcolor='#E6E6FA'>".$n."</th>";
  }
}

function t($n){
  if ($n=='') {
    return "<th bgcolor='yellow'>Belum ada transaksi</th>";
  }else{
    $v = (int)$n;
    return "<th bgcolor='yellow'>".$n."</th>";
  }
}

if (isset($_POST['o']) && $_POST['o'] == "hr") {
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
      echo "<tr>";
      echo "<td>".$nm_bar = $row->nama_barang."</td>";
      echo $brg_msk = nor($row->brgmsk);
      echo $hbm = cmk($row->hbm);
      echo $brg_klr = nor($row->brgklr);
      echo $hbk = cmk($row->hbk);
      echo $stok = nor($row->stok);
      echo $ns = s($row->ns);
      echo "</tr>";

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
        echo "<tr><td>Total</td>";
        echo nor($r2->tjm);
        echo t($r2->thm);
        echo nor($r2->tjk);
        echo t($r2->thk);
        echo nor($r2->ts);
        echo t($r2->tns);
        echo "</tr>";

}elseif (isset($_POST['o']) && $_POST['o'] == "mg") {

    //hari senin awal minggu, hapus "1" kalo mau mulai minggu dari hari minggu
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
        echo "<tr>";
        echo "<td>".$nm_bar = $row->nama_barang."</td>";
        echo $brg_msk = nor($row->brgmsk);
        echo $hbm = cmk($row->hbm);
        echo $brg_klr = nor($row->brgklr);
        echo $hbk = cmk($row->hbk);
        echo $stok = nor($row->stok);
        echo $ns = s($row->ns);
        echo "</tr>";
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
        echo "<tr><td>Total</td>";
        echo nor($r2->tjm);
        echo t($r2->thm);
        echo nor($r2->tjk);
        echo t($r2->thk);
        echo nor($r2->ts);
        echo t($r2->tns);
        echo "</tr>";


}elseif(isset($_POST['o']) && $_POST['o'] == "bln"){
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
                where month(tgl_brgmsk )= MONTH(curdate())
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hrg_bk
                from t_brgklr
                where month(tgl_brgklr)= MONTH(curdate())
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
            group by B.id_barang";
    $res = $pdo->query($q);
    while($row = $res->fetch(PDO::FETCH_OBJ)) {
      echo "<tr>";
      echo "<td>".$nm_bar = $row->nama_barang."</td>";
      echo $brg_msk = nor($row->brgmsk);
      echo $hbm = cmk($row->hbm);
      echo $brg_klr = nor($row->brgklr);
      echo $hbk = cmk($row->hbk);
      echo $stok = nor($row->stok);
      echo $ns = s($row->ns);
      echo "</tr>";
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
                where month(tgl_brgmsk)= MONTH(curdate())
                GROUP by id_barang
              ) m on B.id_barang = m.id_barang
            left join (
                select id_brgklr, id_barang, sum(jml_brgklr) as jk, sum(jml_brgklr*harga_brgklr) as hk
                from t_brgklr
                where month(tgl_brgklr)= MONTH(curdate())
                GROUP by id_barang
              ) k ON B.id_barang=k.id_barang
      ";
      $res = $pdo->query($q2);
      $r2 = $res->fetch(PDO::FETCH_OBJ);
      echo "<tr><td>Total</td>";
      echo nor($r2->tjm);
      echo t($r2->thm);
      echo nor($r2->tjk);
      echo t($r2->thk);
      echo nor($r2->ts);
      echo t($r2->tns);
      echo "</tr>";

}elseif (isset($_POST['o']) && $_POST['o'] == "cust") {
  $d1 = $_POST['d1'];
  $d2 = $_POST['d2'];
  $df1 = $d1." 00:00:00";
  $df2 = $d2." 23:59:59";

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
    echo "<tr>";
    echo "<td>".$nm_bar = $row->nama_barang."</td>";
    echo $brg_msk = nor($row->brgmsk);
    echo $hbm = cmk($row->hbm);
    echo $brg_klr = nor($row->brgklr);
    echo $hbk = cmk($row->hbk);
    echo $stok = nor($row->stok);
    echo $ns = s($row->ns);
    echo "</tr>";
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
      echo "<tr><td>Total</td>";
      echo nor($r2->tjm);
      echo t($r2->thm);
      echo nor($r2->tjk);
      echo t($r2->thk);
      echo nor($r2->ts);
      echo t($r2->tns);
      echo "</tr>";

}
?>
  </tbody>
  </table>
</div>
