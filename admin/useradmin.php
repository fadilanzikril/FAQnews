<?php
if (!isset($_SESSION['loginadmin'])) {
  header('location: login.php');
  exit();
}
include '../fungsi/koneksi.php';

// Tambah user
if (isset($_POST['userinput'])) {

  $user = $_POST['username'];
  $pass = md5($_POST['password']);
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $sql_cek = "SELECT * FROM administrator WHERE username = '" . $user . "' OR email='" . $email . "'";
  $cek = mysqli_query($koneksi, $sql_cek);
  $cek_data = mysqli_num_rows($cek);
  // cek data sudah ada atau belu jika belum melakukan insert menggunakan queri
  if ($cek_data > 0) {
    $_SESSION['inpo'] = "Username dan email sudah tersedia silahkan gunakan yang berbeda!!!";
  } else {
    $query = "INSERT INTO administrator VALUES (' ','$nama','$user','$pass','$email') ";
    mysqli_query($koneksi, $query);
    $_SESSION['inpo2'] = "Tambah User berhasil!!!";
  }
}
// Edit
if (isset($_POST['edituser'])) {
  $user1 = $_POST['username'];
  $nama1 = $_POST['nama'];
  $email1 = $_POST['email'];
  $sql_update = "UPDATE administrator SET username = '" . $user1 . "', nama='" . $nama1 . "', email='" . $email1 . "' WHERE id='" . $_POST['userid'] . "'";
  mysqli_query($koneksi, $sql_update);
  $_SESSION['inpo2'] = "User Berhasil Di edit!!!";
}
error_reporting(E_ALL ^ E_WARNING || E_NOTICE);
if ($_GET['act'] && $_GET['act'] == 'edit') {
  $id = (int)$_GET['id'];
  $data_user = mysqli_query($koneksi, "SELECT * FROM administrator WHERE id ='$id'");
  $edituser = mysqli_fetch_array($data_user, MYSQLI_ASSOC);
}
if ($_GET['act'] && $_GET['act'] == 'hapus') {
  $id = (int)$_GET['id'];
  $data_user = mysqli_query($koneksi, "DELETE FROM administrator WHERE id ='$id'");
  $_SESSION['inpo3'] = "User Berhasil Di Hapus!!!";
}
?>
<?php
include 'header.php';
?>

<body class="formuser">
  <h2 class="alert alert-dark text-center text-dark">Tambah User</h2>
  <!-- Input user admin -->
  <form action="./?mod=useradmin" method="POST" class="p-4">
    <input type="hidden" name="userid" value="<?= $edituser['id'] ?>">
    <?php
    if (isset($_SESSION['inpo'])) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo']; ?></strong>
      </div>
    <?php
      unset($_SESSION['inpo']);
    } ?>
    <?php
    if (isset($_SESSION['inpo2'])) { ?>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo2']; ?></strong>
      </div>
    <?php
      unset($_SESSION['inpo2']);
    } ?>

    <div class="mb-3 col-6">
      <label for="exampleFormControlInput1" class="form-label">Nama:</label>
      <input type="text" name="nama" class="form-control border-secondary border border-2" id="exampleFormControlInput1" value="<?= $edituser['nama'] ?>">
    </div>
    <div class="mb-3 col-6">
      <label for="exampleFormControlInput2" class="form-label">Username:</label>
      <input type="text" name="username" class="form-control border-secondary border border-2" id="exampleFormControlInput2" value="<?= $edituser['username'] ?>">
    </div>
    <div class="mb-3 col-6">
      <label for="exampleInputPassword1" class="form-label">Password:</label>
      <input type="text" name="password" class="form-control border-secondary border border-2" id="exampleInputPassword1">
    </div>
    <div class="mb-3 col-6">
      <label for="exampleInputEmail1" class="form-label">Email:</label>
      <input type="email" name="email" class="form-control border-secondary border border-2" id="exampleInputEmail1" value="<?= $edituser['email'] ?>">
    </div>

    <input type="submit" class="btn btn-success" name="<?= ($edituser['id'] ? 'edituser' : 'userinput') ?>" class="btn btn-success" value="<?= ($edituser['id'] ? 'Edit' : 'Tambah') ?> "></input>
  </form>
  <!-- akhir -->

  <h2 class="alert alert-dark text-center text-dark">Tabel User</h2>
  <!-- Tabel user -->
  <?php
  if (isset($_SESSION['inpo3'])) { ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong><?php echo $_SESSION['inpo3']; ?></strong>
    </div>
  <?php
    unset($_SESSION['inpo3']);
  } ?>
  <?php
  $sql = mysqli_query($koneksi, "SELECT * FROM administrator");
  ?>
  <div class=" table-responsive p-4 ">

    <table class="table table-striped ">
      <thead class="table-dark">
        <tr class="text-center">
          <th scope="col">NO</th>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1;
        foreach ($sql as $dtuser) :
          // $dtuser['id'] = $ID;
        ?>
          <tr class="table-active text-center">
            <td><?= $i++; ?></td>
            <td><?= $dtuser['id']; ?></td>
            <td><?= $dtuser['nama']; ?></td>
            <td><?= $dtuser['username']; ?></td>
            <td><?= $dtuser['email']; ?></td>
            <td>
              <span>
                <a href="?mod=useradmin&act=edit&id=<?= $dtuser['id']; ?>" type="button" class="btn btn-primary">Edit</a>
              </span>
              <span>
                <a href="?mod=useradmin&act=hapus&id=<?= $dtuser['id']; ?>" type="button" class="btn btn-danger">Hapus</a>
              </span>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- akhir -->
  </div>
  <script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>