<?php
  require_once('../../layout/header.php');
  $uri = $_SERVER['REQUEST_URI'];
  $u = substr($uri, 12);

  hak_akses($pdo, $_SESSION['idrole'], $u);

?>
<link rel="stylesheet" href="../../../assets/css/jquery-ui.min.css">
<div class="grid">
  <div class="row">
    <p class="h3">Control Panel</p>
  </div>
  <ul data-role="tabs" data-tabs-type="group" data-expand="true">
      <li><a href="#_target_1">User</a></li>
      <li><a href="#_target_2">Module</a></li>
      <li><a href="#_target_3">Akses</a></li>
  </ul>
  <div class="border bd-default no-border-top p-2">
      <div id="_target_1">
        <div class="row">
          <div class="cell-md-12 sm-12">
                <div class="window sm-12">
                    <div class="window-caption">
                        <span class="icon mif-windows"></span>
                        <span class="title">Register Pegawai & User Baru</span>
                    </div>
                    <div class="window-content p-2">
                      <form enctype="multipart/form-data" method="post" action="" id="reg_user">
                          <div class="row">
                              <div class="cell-md-3">
                                  <label>Nama Pegawai</label>
                                  <input type="text" id="nama_pegawai">
                                  <input type="text" id="iduser" hidden>
                              </div>
                              <div class="cell-md-2">
                                  <label>Username</label>
                                  <input type="text" id="username">
                              </div>
                              <div class="cell-md-2">
                                  <label>Password</label>
                                  <input type="password" id="password">
                                </div>
                              <div class="cell-md-3">
                                  <label>Alamat</label>
                                  <input type="text" id="alamat">
                              </div>
                              <div class="cell-md-2">
                                  <label>No. Telepon</label>
                                  <input type="text" id="no_telp">
                              </div>
                        </div>
                          <div class="row">
                              <div class="cell-md-3">
                                  <label>Tgl Lahir</label>
                                  <input data-role="datepicker" id="tgl_lahir">
                              </div>
                              <div class="cell-md-4">
                                  <label>KTP</label>
                                  <input type="file" data-role="file" id="file" name="file">
                              </div>
                              <div class="cell-md-3">
                                <label>Tgl Masuk</label>
                                <input data-role="datepicker" id="tgl_masuk">
                              </div>
                              <div class="cell-md-2">
                                <label>Akses</label>
                                <select class="" id="akses">
                                  <option value=""></option>
                                  <?php
                                    $k = "SELECT * from t_role";
                                    $stmt = $pdo->prepare($k);
                                    $stmt->execute();
                                    $hasil = $stmt->fetchAll();
                                    foreach ($hasil as $h) {
                                      echo "<option value='{$h['id_role']}'>{$h['rolename']}</option>";
                                    }
                                  ?>
                                </select>
                              </div>
                          </div>
                          <br><br><br><br>
                          <div class="row">
                            <div class="cell-md-12">
                                <button type="button" name="submit" id="simpanDataUser" class="button success">Proses</button>
                                <button type="button" name="update" id="updateDataUser" class="button info" style="display:none">Update</button>
                                <button type="button" id="resetDataUser" class="button warning">Reset</button>
                                <button type="button" id="batalDataUser" class="button alert" style="display:none">Batal</button>
                                <div class="hasil"></div>
                            </div>
                          </div>
                      </form>
                    </div>
                </div> <!--windows -->
           </div> <!--cell -->
        </div> <!--row -->

        <div class="row">
          <div class="cell-md-12 sm-12">
                <div class="window sm-12">
                    <div class="window-caption">
                        <span class="icon mif-windows"></span>
                        <span class="title">List User</span>
                    </div>
                    <div class="window-content p-2">
                      <table id="example" class="table" style="width:100%">
                              <thead>
                                  <tr>
                                      <th>ID User</th>
                                      <th>Nama Pegawai</th>
                                      <th>Akses</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                    </div>
                </div> <!--windows -->
           </div> <!--cell -->
        </div> <!--row -->
      </div> <!--target 1 -->

      <div id="_target_2">
        <div class="row">
          <div class="cell-md-12 sm-12">
                <div class="window sm-12">
                    <div class="window-caption">
                        <span class="icon mif-windows"></span>
                        <span class="title">Input Modul baru</span>
                    </div>
                    <div class="window-content p-2">
                      <form id="reg_modul">
                          <div class="row">
                              <div class="cell-md-4">
                                  <label>Nama Modul</label>
                                  <input type="text" id="nama_modul">
                                  <input type="text" id="idmod" hidden>
                              </div>
                              <div class="cell-md-4">
                                  <label>Link Modul</label>
                                  <input type="text" id="link_modul">
                              </div>
                              <div class="cell-md-4">
                                  <label>Icon</label>
                                  <input type="text" id="icon_modul">
                              </div>
                        </div>
                          <div class="row">
                            <div class="cell-md-12">
                                <button type="button" name="submit" id="simpanDataModul" class="button success">Proses</button>
                                <button type="button" name="update" id="updateDataModul" class="button info" style="display:none">Update</button>
                                <button type="button" id="resetDataModul" class="button warning">Reset</button>
                                <button type="button" id="batalDataModul" class="button alert" style="display:none">Batal</button>
                            </div>
                          </div>
                      </form>
                    </div>
                </div> <!--windows -->
           </div> <!--cell -->
        </div> <!--row -->
        <div class="row">
          <div class="cell-md-12 sm-12">
                <div class="window sm-12">
                    <div class="window-caption">
                        <span class="icon mif-windows"></span>
                        <span class="title">List Modul</span>
                    </div>
                    <div class="window-content p-2">
                      <table id="tabelModul" class="table" style="width:100%">
                              <thead>
                                  <tr>
                                      <th>ID Modul</th>
                                      <th>Nama Modul</th>
                                      <th>Link Modul</th>
                                      <th>Akses</th>
                                      <th>Icon</th>
                                      <th>Aksi</th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                          </table>
                    </div>
                </div> <!--windows -->
           </div> <!--cell -->
        </div> <!--row -->
      </div>
      <div id="_target_3">
        <div class="grid">
          <div class="row">
            <div class="cell-md-4 sm-12">
              <ul class="sidenav-simple sidenav-simple-expand-fs h-auto">
                    <?php
                      $_k = "SELECT * FROM t_role";
                      $_stmt = $pdo->prepare($_k);
                      $_stmt->execute();
                      $hasil = $_stmt->fetchAll();
                      foreach ($hasil as $h) {
                        echo "<li>
                                <a href='#' class='user' id=".$h['id_role'].">
                                  <span class='mif-user icon'></span>
                                  <span class='title'>".$h['rolename']."</span>
                                </a>
                              </li>";
                      }
                    ?>
              </ul>
            </div> <!-- cell -->
            <div class="cell-md-8 sm-12">
              <input type="number" id="idumod" readonly hidden>
                <table class="table compact" id="hasil">
                  <thead>
                    <th>Nama Modul</th>
                    <th>Akses</th>
                  </thead>
                  <form class="" action="" method="post">
                    <tbody>

                    </tbody>
                  </form>
                    <tfoot>
                      <tr>
                        <td colspan="3">
                          <button type="button" name="submit" id="simpanDataAksesModul" style="display:none" class="button success">Simpan Pengaturan</button>
                        </td>
                      </tr>
                    </tfoot>
                </table>
            </div> <!-- cell -->
          </div>

        </div>

      </div>
  </div>
</div> <!-- grid -->

<div id="dialog-confirm" title="Informasi" style="display: none">
  <p>
    <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
    Anda yakin akan menghapus data ini?
  </p>
</div>

<br />


</div>  <!-- tutup appbar -->
</div> <!-- tutup container -->
<script type="text/javascript" src="../../../assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../../../assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../assets/js/metro.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/r-2.2.3/datatables.min.js"></script>
<script type="text/javascript" src="../../../assets/js/cp.js"></script>
<script type="text/javascript">
  // $('a.user').click(function(e) {
  //   console.log(this.id);
  // });
</script>
</body>
</html>
