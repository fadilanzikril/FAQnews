<?php
include 'fungsi/koneksi.php';
?>

<?php
include 'view/header.php';
?>
<!-- Akhir Header -->

<!-- Konten -->
<div class="container-fluid konten">
    <?php
    @$open = $_GET['open'];
    switch ($open) {
        case 'detail':
            include('view/detail.php');
            break;
        case 'cat':
            include('view/kategori.php');
            break;
        case 'cari':
            include('view/cari.php');
            break;
        default:
            include('view/coba.php');
            break;
    }
    ?>
</div>
<!-- Akhir Kategori -->

<!-- Footer -->

<?php
include 'view/footer.php';
?>