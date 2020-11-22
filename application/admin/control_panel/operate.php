<?php

require_once('../../config/conf.php');
require_once('../../config/db_conf.php');

if (isset($_POST['saveDat']) && $_POST['saveDat']==1) {
  if(empty(trim($_POST['np']))) {
      $json['error']['np'] = 'Tolong isi nama pegawai';
  }

  if(empty(trim($_POST['alamat']))) {
      $json['error']['alamat'] = 'Tolong isi alamat pegawai';
  }

  if(empty(trim($_POST['telp']))) {
      $json['error']['telp'] = 'Tolong isi telp pegawai';
  }

  // if(!empty($_FILES["ktp"]["type"])){
  if(isset($_FILES["ktp"]["type"])){
      // $fileName = time().'_'.$_FILES['ktp']['name'];
      $valid_extensions = array("jpeg", "jpg", "png");
      $temporary = explode(".", $_FILES["ktp"]["name"]);
      $file_extension = end($temporary);
      $fileName = $_FILES["ktp"]["name"];
      if((($_FILES["ktp"]["type"] == "image/png") || ($_FILES["ktp"]["type"] == "image/jpg") || ($_FILES["ktp"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
          $sourceUPLPath = $_FILES['ktp']['tmp_name'];
          $targetUPLPath = "C:/xampp/htdocs/RumahRisol/assets/img/ktp/".$fileName;
          if(move_uploaded_file($sourceUPLPath,$targetUPLPath)) {
              $uploadedFileName = $fileName;
          } else {
              $uploadedFileName = '';
          }
      } else {
          $json['error']['file'] = 'Hanya bisa upload KTP dengan format jpeg, jpg, png';
      }
  }


  if(empty($json['error'])) {
      $_q = "INSERT INTO t_user (username, fullname, password, alamat, no_telp, tgl_lahir, fc_ktp, tgl_masuk, role) values (:u, :f, :p, :a, :nt, :tl, :ktp, :tm, :role)";
      $_stmt = $pdo->prepare($_q);
      $_stmt->bindParam(':u', $_POST['u']);
      $_stmt->bindParam(':f', $_POST['np']);
      $_stmt->bindValue(':p', password_hash($_POST["pass"], PASSWORD_DEFAULT));
      $_stmt->bindParam(':a', $_POST['alamat']);
      $_stmt->bindParam(':nt', $_POST['telp']);
      $_stmt->bindParam(':tl', $_POST['tl']);
      $_stmt->bindParam(':ktp', $fileName);
      $_stmt->bindParam(':tm', $_POST['tm']);
      $_stmt->bindParam(':role', $_POST['akses']);
      $_stmt->execute();
      $_stmt = null;
      $json['msg'] = 'Input Data Sukses';
  }
} //end save func

if (isset($_POST['getUpd'])) {
  $json = array();
  // $iduser = $_POST['updId'];
  $_k = "SELECT * FROM t_user U left join t_role R on U.role=R.id_role where U.id_user=:iduser";
  $_stmt = $pdo->prepare($_k);
  $_stmt->bindParam(':iduser', $_POST['updId']);
  $_stmt->execute();
  $j = $_stmt->fetchObject();

   $json[] = array(
       "id" => $j->id_user,
       "fullname"  => $j->fullname,
       "user"   => $j->username,
       "pass"   => $j->password,
       "alamat"   => $j->alamat,
       "telp"   => $j->no_telp,
       "tl"   => $j->tgl_lahir,
       "ktp"   => $j->fc_ktp,
       "tm"   => $j->tgl_masuk,
       "role"   => $j->role
     );

}

if (isset($_POST['updateDat']) && $_POST['updateDat']==1) {
  if(empty(trim($_POST['np']))) {
      $json['error']['np'] = 'Tolong isi nama pegawai';
  }

  if(empty(trim($_POST['alamat']))) {
      $json['error']['alamat'] = 'Tolong isi alamat pegawai';
  }

  if(empty(trim($_POST['telp']))) {
      $json['error']['telp'] = 'Tolong isi telp pegawai';
  }

  // if(!empty($_FILES["ktp"]["type"])){
  if(isset($_FILES["ktp"]["type"])){
      // $fileName = time().'_'.$_FILES['ktp']['name'];
      $valid_extensions = array("jpeg", "jpg", "png");
      $temporary = explode(".", $_FILES["ktp"]["name"]);
      $file_extension = end($temporary);
      $fileName = $_FILES["ktp"]["name"];
      $targetUPLPath = "C:/xampp/htdocs/RumahRisol/assets/img/ktp/".$fileName;
      if (file_exists($targetUPLPath)) {
        $json['msg'] = "Foto KTP sudah ada, foto baru tidak akan diupload";
      }else{
        if((($_FILES["ktp"]["type"] == "image/png") || ($_FILES["ktp"]["type"] == "image/jpg") || ($_FILES["ktp"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)) {
            $sourceUPLPath = $_FILES['ktp']['tmp_name'];
            $targetUPLPath = "C:/xampp/htdocs/RumahRisol/assets/img/ktp/".$fileName;
            if(move_uploaded_file($sourceUPLPath,$targetUPLPath)) {
                $uploadedFileName = $fileName;
            } else {
                $uploadedFileName = '';
            }
        } else {
            $json['error']['file'] = 'Hanya bisa upload KTP dengan format jpeg, jpg, png';
        }
      }
  }


  if(empty($json['error'])) {
    if (empty($_FILES['ktp']['tmp_name'])) {
      $_q = "UPDATE t_user SET
                fullname=:f,
                username=:u,
                password=:p,
                alamat=:a,
                no_telp=:telp,
                tgl_lahir=:tl,
                tgl_masuk=:tm,
                role=:role
              WHERE id_user=:iduser";
    }else{
      $_q = "UPDATE t_user SET
                fullname=:f,
                username=:u,
                password=:p,
                alamat=:a,
                fc_ktp=:ktp,
                no_telp=:telp,
                tgl_lahir=:tl,
                tgl_masuk=:tm,
                role=:role
              WHERE id_user=:iduser";
    }

      $_stmt = $pdo->prepare($_q);
      $_stmt->bindParam(':iduser', $_POST['iduser']);
      $_stmt->bindParam(':u', $_POST['u']);
      $_stmt->bindParam(':p', $_POST['pass'], PASSWORD_DEFAULT);
      $_stmt->bindParam(':f', $_POST['np']);
      $_stmt->bindParam(':a', $_POST['alamat']);
      $_stmt->bindParam(':telp', $_POST['telp']);
      $_stmt->bindParam(':tl', $_POST['tl']);
      if (!empty($_FILES['ktp']['tmp_name'])) {
        $_stmt->bindParam(':ktp', $fileName);
      }
      $_stmt->bindParam(':tm', $_POST['tm']);
      $_stmt->bindParam(':role', $_POST['akses']);
      $_stmt->execute();
      $_stmt = null;
      // $json['msg'] = $_q;
      $json['msg'] = 'Update Data Sukses';
  }
} //end update func

if (isset($_POST['saveMod'])) {
  if(empty(trim($_POST['nm']))) {
      $json['error']['nm'] = 'Tolong isi nama modul';
  }
  if(empty(trim($_POST['link']))) {
      $json['error']['link'] = 'Tolong isi link modul';
  }

  if(empty($json['error'])) {
      $_q = "INSERT INTO t_rolemod (nama_modul, link_modul, icon) values (:nm, :lm, :i)";
      $_stmt = $pdo->prepare($_q);
      $_stmt->bindParam(':nm', $_POST['nm']);
      $_stmt->bindParam(':lm', $_POST['link']);
      $_stmt->bindParam(':i', $_POST['icon']);
      $_stmt->execute();
      $_stmt = null;
      // $json['msg'] = $_q;
      $json['msg'] = 'Simpan Data Sukses';
  }
} //end savemod

if (isset($_POST['getUpdModul'])) {
  $json = array();
  // $iduser = $_POST['updId'];
  $_k = "SELECT * FROM t_rolemod where id_rolemod=:idmod";
  $_stmt = $pdo->prepare($_k);
  $_stmt->bindParam(':idmod', $_POST['updMod']);
  $_stmt->execute();
  $j = $_stmt->fetchObject();

   $json[] = array(
       "id" => $j->id_rolemod,
       "nm"  => $j->nama_modul,
       "lm"   => $j->link_modul,
       "i"   => $j->icon
     );
} //end getupdMod

if (isset($_POST['saveUpdModul']) && $_POST['saveUpdModul']==1) {
  if(empty(trim($_POST['nama_modul']))) {
      $json['error']['nm'] = 'Tolong isi nama modul';
  }
  if(empty(trim($_POST['link_modul']))) {
      $json['error']['link'] = 'Tolong isi link modul';
  }

  if(empty($json['error'])) {
      $k = "UPDATE t_rolemod set nama_modul=:nm, link_modul=:lm, icon=:i where id_rolemod=:irm";
      $stmt = $pdo->prepare($k);
      $stmt->bindParam(':irm', $_POST['idUpdMod']);
      $stmt->bindParam(':nm', $_POST['nama_modul']);
      $stmt->bindParam(':lm', $_POST['link_modul']);
      $stmt->bindParam(':i', $_POST['icon']);
      $stmt->execute();
      $_stmt = null;
      // $json['msg'] = $k;
      $json['msg'] = 'Update Data Sukses';

  }
} //end upd mod

if (isset($_POST['delModul']) && $_POST['delModul']==1) {
      $k = "DELETE FROM t_rolemod where id_rolemod=:irm";
      $stmt = $pdo->prepare($k);
      $stmt->bindParam(':irm', $_POST['delIdModul']);
      $stmt->execute();
      $_stmt = null;
      $json['msg'] = 'Delete Data Sukses';
} //end del mod

if (isset($_POST['idumod'])) {
  if(empty(trim($_POST['idumod']))) {
      $json['error']['idumod'] = 'Piilh user yang ingin diupdate hak aksesnya';
  }

  if(empty($_POST['roleUpd'])) {
      $json['error']['roleUpd'] = 'User harus memiliki hak akses';
  }

  if(empty($json['error'])) {
    $_d = "DELETE FROM t_detil_role where id_role=:idrole";
    $_stmt = $pdo->prepare($_d);
    $_stmt->bindParam(':idrole', $_POST['idumod']);
    $_stmt->execute();
    $_stmt = null;

      $_stmt = $pdo->prepare("SELECT max(id_detil_role) as id from t_detil_role");
      $_stmt->execute();
      $h = $_stmt->fetchObject();
      if ($h->id == "") {
          $id = 1;
      }else{
          $id = $h->id+1;
      }
      $_stmt = null;

      $data = $_POST['roleUpd'];

      $stmt = $pdo->prepare("INSERT INTO t_detil_role (id_detil_role, id_role, id_rolemod) values (:idr, :id, :ir)");
      $stmt->bindParam(':id', $_POST['idumod']);
      for ($i=0; $i < count($data); $i++) {
        $_id = $id++;
        $stmt->bindParam(':idr', $_id);
        $stmt->bindParam(':ir', $data[$i]);
        $stmt->execute();
      }
      $stmt = null;
      $json['msg'] = "Update Hak Akses Sukses";
  }
} //end upd mod

echo json_encode($json, JSON_PRETTY_PRINT);

?>
