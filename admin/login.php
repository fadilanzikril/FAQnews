<?php
session_start();
include '../fungsi/koneksi.php';

if (isset($_POST['login'])) {
  $user = $_POST['user'];
  $pass = md5($_POST['pass']);
  $data_user = mysqli_query($koneksi, "SELECT * FROM administrator WHERE username = '$user' AND password = '$pass'");
  $baca_array = mysqli_fetch_array($data_user);
  $level = $baca_array['nama'];
  if ($user == $baca_array['username'] && $pass == $baca_array['password']) {
    if ($level > 0) {
      $_SESSION['loginadmin'] = $level;
      header('location:index.php');
    } else {
      header('location: login.php?error=' . 'Salah!!!');
    }
  } else {
    $_SESSION['login_eror'] = "Username dan Password Salah !!!";
    header('location: login.php?error=' . 'Username dan Password Salah!!!');
    exit();
  }
}
?>


<!-- Boostrap CSS -->
<link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
<link rel="shortcut icon" href="../asset/image/logo1.png">
<!-- Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="../css/login1.css">
<title>Login</title>

<body class="bgron_login">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4  text-white text-uppercase mb-4">Administrator</h1>
                  </div>

                  <?php
                  if (isset($_SESSION['login_eror'])) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong><?php echo $_SESSION['login_eror']; ?></strong>
                    </div>
                  <?php
                    unset($_SESSION['login_eror']);
                  } ?>

                  <form method="POST" action="">
                    <div class="form-group mb-4">
                      <input type="text" class="form-control form-control-user shadow-lg" name="user" placeholder="Username">
                    </div>
                    <div class="form-group mb-4">
                      <input type="password" class="form-control form-control-user shadow-lg" name="pass" placeholder="Password">
                    </div>
                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block shadow-lg">
                      <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>