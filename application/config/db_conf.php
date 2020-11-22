<?php
  $host = "localhost";
  $user = "root";
  $password = "";
  $dbname = "db_rumahrisol";
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ));


  function hak_akses(PDO $pdo, $role, $uri)
  {

    $arr = (array) null;
    $arr = array();
    $stmt = $pdo->prepare("SELECT link_modul from t_detil_role DR inner join t_rolemod R on DR.id_rolemod=R.id_rolemod where id_role=:role");
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $a) {
        array_push($arr, $a['link_modul']);
    }

    if (!in_array($uri, $arr)) {
      // echo "ada";
      header('Location:http://localhost/RumahRisol/application/admin/403.php');
    }
    // else{
    //   // echo "tidak ada";
    //   header('Location:http://localhost/RumahRisol/');
    // }

  }

?>
