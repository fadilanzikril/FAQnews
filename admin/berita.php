<?php

if (!isset($_SESSION['loginadmin'])) {
    header('location: login.php');
    exit();
}

include '../fungsi/koneksi.php';

if (isset($_POST['add'])) {

    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $kategori = $_POST['kategori'];
    $teks = $_POST['teks'];
    $tanggal = date("Y-m-d H:i:s");
    $author =  $_SESSION['loginadmin'];
    $terbit = $_POST['terbit'];

    if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] !== 4) {
        $gambarfile = $_FILES['gambar']['tmp_name'];
        $gambarfile_name = $_FILES['gambar']['name'];
        $filetype = $_FILES['gambar']['type'];
        $allowtype = array('image/png', 'image/jpg', 'image/jpeg');
        if (!in_array($filetype, $allowtype)) {
            echo "File eror";
            exit;
        }
        $path = 'asset/photo/';
        if ($gambarfile && $gambarfile_name) {
            $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['judul']);
            $dest1 = '../' . $path . $gambarbaru . '.jpg';
            $dest2 =  $path . $gambarbaru . '.jpg';
            copy($_FILES['gambar']['tmp_name'], $dest1);
            $gambar = $dest2;
        } else {
            $gambar = $_POST['gambar'];
        }
    }
    if ($_POST['aksi'] == 'tambah') {

        $simpan = mysqli_query($koneksi, "INSERT INTO 
                                          berita 
                                          VALUES ('', '$judul', '$isi', '$kategori', '$gambar', '$teks', '$tanggal', '0', '$author', 'berita', '$terbit')");
        $_SESSION['inpo3'] = "Tambah Berita berhasil!!!";
    }
    if ($_POST['aksi'] == 'editgambar') {

        $sql_update = "UPDATE berita SET judul = '" . $judul . "', isi='" . $isi . "', kategori='" . $kategori . "', gambar='$gambar', teks='" . $teks . "', terbit='" . $terbit . "' WHERE id='" . $_POST['id'] . "'";
        mysqli_query($koneksi, $sql_update);
        $_SESSION['inpo4'] = "Edit Berita berhasil!!!";
    }
}

error_reporting(E_ALL ^ E_WARNING || E_NOTICE);
if ($_GET['act'] && $_GET['act'] == 'edit') {
    $id = (int)$_GET['id'];
    $data_berita = mysqli_query($koneksi, "SELECT * FROM berita WHERE id ='$id'");
    $editberita = mysqli_fetch_array($data_berita, MYSQLI_ASSOC);
    $kateg = $editberita['kategori'];
    $gambar = $editberita['gambar'];
    if (isset($_GET['hapusgambar']) && $_GET['hapusgambar'] == 'yes') {
        unlink('../' . $gambar);
        $data_update = mysqli_query($koneksi, "UPDATE berita SET gambar='' WHERE id ='$id'");
        echo '<meta http-equiv="REFRESH" content="0; url=./?mod=berita&act=edit&id=' . $id . '"/>';
    }
}
if ($_GET['act'] && $_GET['act'] == 'hapus') {
    $id = (int)$_GET['id'];
    $sql = mysqli_query($koneksi, "SELECT * FROM berita WHERE id ='$id'");
    while ($ed = mysqli_fetch_array($sql)) {
        $gbr = $ed['gambar'];
        unlink('../' . $gbr);
    }
    $data_berita = mysqli_query($koneksi, "DELETE FROM berita WHERE id ='$id'");
    $_SESSION['inpo5'] = "Hapus Berita berhasil!!!";
}

?>
<?php
include 'header.php';
?>
<h2 class="alert alert-dark text-center text-dark">Tambah Berita</h2>
<?php
if (isset($_SESSION['inpo3'])) { ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo3']; ?></strong>
    </div>
<?php
    unset($_SESSION['inpo3']);
} ?>
<?php
if (isset($_SESSION['inpo4'])) { ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo4']; ?></strong>
    </div>
<?php
    unset($_SESSION['inpo4']);
} ?>
<!-- Input berita -->
<form action="./?mod=berita" method="POST" class="p-4" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $editberita['id'] ?>">
    <input type="hidden" name="aksi" value="<?= ($editberita['id'] ? 'editgambar' : 'tambah'); ?>">
    <div class="mb-3 col-6">
        <label for="exampleFormControlInput1" class="form-label">Judul:</label>
        <input type="text" name="judul" class="form-control border-secondary border border-2" id="exampleFormControlInput1" placeholder="Judul Berita" value="<?= $editberita['judul'] ?>">
    </div>
    <div class=" mb-3 col-4">
        <?php
        $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
        ?>
        <label for="exampleInputEmail1" class="form-label">Kategori:</label>
        <select class="form-select border-secondary border border-2" aria-label="Default select example" name="kategori">
            <option>Pilih Kategori</option>
            <?php
            foreach ($sql as $dt) : ?>
                <option value="<?= $dt['nama_lain'] ?>" <?= ($kateg == $dt['nama_lain'] ? 'selected' : '') ?>><?= $dt['kategori'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3 col-8">
        <label for="editor" class="form-label">Isi Berita:</label>
        <textarea class="form-control border-secondary border border-2" id="editor" rows="3" name="isi"><?= $editberita['isi'] ?></textarea>
    </div>
    <div class="mb-3 col-6">
        <label for="formFile" class="form-label">Gambar:</label> <br>
        <?php
        if ($gambar && $editberita['id']) {
            echo ' <input type="hidden" name="gambar" value="$gambar">
                 <img src="http://localhost/E-commerce/' . $gambar . '" width="150" style="margin-bottom: 20px;">
                 <a href="./?mod=berita&act=edit&hapusgambar=yes&id=' . $editberita['id'] . '" class="btn btn-danger ms-2" value="Hapus">Hapus</a>
                 ';
        } else {
            echo " <input class='form-control border-secondary border border-2' type='file' id='formFile' name='gambar'>";
        }
        ?>


    </div>
    <div class="mb-3 col-8">
        <label for="editor" class="form-label">Teks:</label>
        <textarea class="form-control border-secondary border border-2" id="editor1" rows="3" name="teks"><?= $editberita['teks'] ?></textarea>
    </div>

    <div class=" mb-3 col-1">
        <label for="exampleInputEmail1" class="form-label">Tampilkan:</label>
        <select class="form-select border-secondary border border-2" aria-label="Default select example" name="terbit">
            <option value="1" <?= (($editberita['terbit'] == 1) ? 'selected' : ''); ?>>Yes</option>
            <option value="0" <?= (($editberita['terbit'] == 0) ? 'selected' : ''); ?>>No</option>
        </select>
    </div>
    <input type="submit" class="btn btn-success" name="add" class="btn btn-success" value="<?= ($editberita['id'] ? 'Edit' : 'Tambah') ?> "></input>

</form>
<!-- akhir -->

<h2 class="alert alert-dark text-center text-dark">Tabel Berita</h2>


<!-- Tabel berita -->
<?php
$sql = mysqli_query($koneksi, "SELECT * FROM berita");
?>
<?php
if (isset($_SESSION['inpo5'])) { ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong><?php echo $_SESSION['inpo5']; ?></strong>
    </div>
<?php
    unset($_SESSION['inpo5']);
} ?>
<div class=" table-responsive p-4 ">

    <table class="table table-striped ">
        <thead class="table-dark">
            <tr class="text-center">
                <th scope="col">NO</th>
                <th scope="col">ID</th>
                <th scope="col">Judul</th>
                <th scope="col">kategori</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($sql as $dtberita) :
                // $dtberita['id'] = $ID;
            ?>
                <tr class="table-active text-center">
                    <td><?= $i++; ?></td>
                    <td><?= $dtberita['id']; ?></td>
                    <td><?= $dtberita['judul']; ?></td>
                    <td><?= $dtberita['kategori']; ?></td>
                    <td><?= $dtberita['tanggal']; ?></td>
                    <td>
                        <span>
                            <a href="?mod=berita&act=edit&id=<?= $dtberita['id']; ?>" type="button" class="btn btn-primary">Edit</a>
                        </span>
                        <span>
                            <a href="?mod=berita&act=hapus&id=<?= $dtberita['id']; ?>" type="button" class="btn btn-danger">Hapus</a>
                        </span>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- akhir -->

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/ckeditor5-build-classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
    ClassicEditor
        .create(document.querySelector('#editor1'))
        .catch(error => {
            console.error(error);
        });
</script>
</body>

</html>