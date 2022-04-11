<?php

if (!isset($_SESSION['loginadmin'])) {
    header('location: login.php');
    exit();
}
include '../fungsi/koneksi.php';
if (isset($_POST['tambahkategori'])) {
    $kategori = $_POST['kategori'];
    $nama_lain = $_POST['nama_lain'];
    $tampil = $_POST['terbit'];

    $hasil = mysqli_query($koneksi, "INSERT INTO kategori VALUES (' ','$kategori','$nama_lain','$tampil')");
    $_SESSION['inpo4'] = "Kategori Berhasil Di Tambah!!!";
}

// Edit
if (isset($_POST['editkategori'])) {
    $kateg = $_POST['kategori'];
    $namalain = $_POST['nama_lain'];
    $terbit = $_POST['terbit'];
    $sql_update = "UPDATE kategori SET kategori = '" . $kateg . "', nama_lain='" . $namalain . "', terbit='" . $terbit . "' WHERE id = '" . $_POST['id'] . "'";
    mysqli_query($koneksi, $sql_update);
    $_SESSION['inpo5'] = "Kategori Berhasil Di Edit!!!";
}

error_reporting(E_ALL ^ E_WARNING || E_NOTICE);
if ($_GET['act'] && $_GET['act'] == 'edit') {
    $id = (int)$_GET['id'];
    $data_kategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id ='$id'");
    $editkategori = mysqli_fetch_array($data_kategori, MYSQLI_ASSOC);
}

if ($_GET['act'] && $_GET['act'] == 'hapus') {
    $id = (int)$_GET['id'];
    $data_user = mysqli_query($koneksi, "DELETE FROM kategori WHERE id ='$id'");
    $_SESSION['inpo6'] = "Kategori Berhasil Di Hapus!!!";
}
?>
<?php
include 'header.php';
?>
<h2 class="alert alert-dark text-center text-dark">Tambah Kategori</h2>
<?php
if (isset($_SESSION['inpo4'])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo4']; ?></strong>
    </div>
    <?php
    unset($_SESSION['inpo4']);
} ?><?php
    if (isset($_SESSION['inpo5'])) { ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo5']; ?></strong>
    </div>
    <?php
        unset($_SESSION['inpo5']);
    } ?><?php
        if (isset($_SESSION['inpo6'])) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo6']; ?></strong>
    </div>
<?php
            unset($_SESSION['inpo6']);
        } ?>

<!-- Input kategori -->
<form action="./?mod=kategori" method="POST" class="p-4">
    <input type="hidden" name="id" value="<?= $editkategori['id'] ?>">
    <div class="mb-3 col-6">
        <label for="exampleFormControlInput1" class="form-label">Kategori:</label>
        <input type="text" name="kategori" class="form-control border-secondary border border-2" id="exampleFormControlInput1" placeholder="Nama Kategori" value="<?= $editkategori['kategori'] ?>">
    </div>
    <div class=" mb-3 col-6">
        <label for="exampleFormControlInput2" class="form-label">Nama Lain:</label>
        <input type="text" name="nama_lain" class="form-control border-secondary border border-2" id="exampleFormControlInput2" placeholder="Nama Lain" value="<?= $editkategori['nama_lain'] ?>">
    </div>

    <div class=" mb-3 col-1">
        <label for="exampleInputEmail1" class="form-label">Tampilkan:</label>
        <select class="form-select border-secondary border border-2" aria-label="Default select example" name="terbit">
            <option value="1" <?= (($editkategori['terbit'] == 1) ? 'selected' : ''); ?>>Yes</option>
            <option value="0" <?= (($editkategori['terbit'] == 0) ? 'selected' : ''); ?>>No</option>
        </select>
    </div>
    <input type="submit" class="btn btn-success" name="<?= ($editkategori['id'] ? 'editkategori' : 'tambahkategori') ?>" class="btn btn-success" value="<?= ($editkategori['id'] ? 'Edit' : 'Tambah') ?> "></input>
</form>
<!-- akhir -->

<h2 class="alert alert-dark text-center text-dark">Tabel Kategori</h2>
<!-- Tabel kategori -->

<?php
$sql = mysqli_query($koneksi, "SELECT * FROM kategori");
?>
<div class=" table-responsive p-4 ">

    <table class="table table-striped ">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">NO</th>
                <th scope="col">ID</th>
                <th scope="col">kategori</th>
                <th scope="col">Nama lain</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($sql as $dtkategori) :
                // $dtkategori['id'] = $ID;
            ?>
                <tr class="table-active text-center">
                    <td><?= $i++; ?></td>
                    <td><?= $dtkategori['id']; ?></td>
                    <td><?= $dtkategori['kategori']; ?></td>
                    <td><?= $dtkategori['nama_lain']; ?></td>
                    <td>
                        <span>
                            <a href="?mod=kategori&act=edit&id=<?= $dtkategori['id']; ?>" type="button" class="btn btn-primary">Edit</a>
                        </span>
                        <span>
                            <a href="?mod=kategori&act=hapus&id=<?= $dtkategori['id']; ?>" type="button" class="btn btn-danger">Hapus</a>
                        </span>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- akhir -->

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>