<?php
session_start();
if (!isset($_SESSION['loginadmin'])) {
    header('location: login.php');
    exit();
}
?>
<?php
include 'header.php';
?>
<div class="sub">
    <h3>Halaman Admin</h3>

</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarText">
            <div class="navbar-nav">
                <a class="nav-link me-lg-5" href="./">HOME</a>
                <a class="nav-link me-lg-5" href="?mod=berita">BERITA</a>
                <a class="nav-link me-lg-5" href="?mod=kategori">KATEGORI</a>
                <a class="nav-link me-lg-5" href="?mod=useradmin">USER</a>

            </div>
            <span>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </span>
        </div>
    </div>
</nav>
<div class="container">
    <?php
    @$mod = $_GET['mod'];
    switch ($mod) {
        case 'berita':
            include('berita.php');
            break;
        case 'kategori':
            include('kategori.php');
            break;
        case 'useradmin':
            include('useradmin.php');
            break;
        default:
            echo "Selamat Datang " . $_SESSION['loginadmin'] . "";
            break;
    }
    ?>
</div>
<div class="card-footer bg-dark border-dark text-center text-light mt-5"><i class="fa fa-copyright" aria-hidden="true"></i> Tugas Kelompok E-Commerce</div>
<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>