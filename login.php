<?php
   session_start();
   if(isset($_SESSION['username']))
   {
     header('location:index.php');
     exit;
   }
   require_once('application/config/db_conf.php');
   require_once('application/config/conf.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Rumah Risol</title>
    <link rel="stylesheet" href="<?php echo base; ?>assets/css/metro-all.min.css">

  </head>
  <body>
    <div class="container">
      <div class="grid">
        <div class="row">
            <div class="cell">
              <div class="pos-fixed pos-center">
                <div data-role="panel"
                data-title-caption="Selamat datang di Rumah Risol"
                data-collapsible="true"
                data-cls-title="bg-orange fg-white"
                data-title-icon="<span class='mif-display'></span>"
                >

                  <form class="box" action="" action="" method="post" onSubmit="return validasi()">
                    <?php
                    // echo password_hash("123", PASSWORD_DEFAULT);
                    ?>
                    <div class="form-group">
                        <span class='mif-user'></span>
                        <label>Username</label>
                        <input type="text" name="username" value=""id="username" required>
                    </div>
                    <div class="form-group">
                        <span class='mif-key'></span>
                        <label>Password</label>
                        <input type="password" name="password" value="" id="password" required>
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submit" value="Login" id="cekkk" class="button warning">
                    </div>
                  </form>

                  <?php
                  if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $pass = $_POST["password"];
                    $stmt = $pdo->prepare("SELECT * FROM t_user WHERE username=:uname");
                    $stmt->bindParam(':uname', $_POST['username']);
                    $stmt->execute();
                    $user = $stmt->fetch();

                    if($stmt->rowCount() == 0) {
                      echo "Username tidak ditemukan";
                    }else{
                      if(!password_verify($pass, $user['password'])) {
                        echo "Password salah";
                      }else{
                        $_SESSION['id_user'] = $user['id_user'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['fname'] = $user['fullname'];
                        $_SESSION['idrole'] = $user['role'];
                        $_SESSION['ktp'] = $user['fc_ktp'];

                        date_default_timezone_set('Asia/Jakarta');
                        $log = date('Y-m-d H:i:s');
                        $k = "UPDATE t_user set last_login=:log where id_user=:iduser";
                        $stmt = $pdo->prepare($k);
                        $stmt->bindParam(':log', $log);
                        $stmt->bindParam(':iduser', $_SESSION['id_user']);
                        $stmt->execute();
                        $stmt = null;

                        header('Location: index.php');
                        exit;
                      }
                    }
                  }
                  ?>

                </div>
              </div>
            </div>
        </div>
      </div>
    </div>

    <script src="<?php echo base; ?>assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="<?php echo base; ?>assets/js/metro.min.js"></script>
    <script type="text/javascript">

    function validasi() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      if (username != "" && password!="") {
        return true;
      }else{

        return false;
      }
    }
    </script>
  </body>
</html>
