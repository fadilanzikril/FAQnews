<?php
$id = (isset($_GET['id']) ? $_GET['id'] : '');
$sqldetail = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1'AND id = '" . $id . "' ");

$sqlview = mysqli_query($koneksi, "UPDATE berita SET view=view+1 WHERE id = '" . $id . "' ");
?>

<?php foreach ($sqldetail as $dtdetail) : ?>
    <div class="row">
        <!-- Berita Populer -->
        <div class="col-md-3 mt-2">
            <ul class="list-group list-group-flush shadow-sm bg-body rounded posisi">
                <li class="list-group-item bgr2 text-center text-light fw-bold">BERITA POPULER</li>
                <?php
                $pop = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1' 
            AND tanggal>='" . date(' Y-m-d H:i:s', strtotime('-7 days')) . "' ORDER BY view DESC LIMIT 0,10");
                ?>
                <?php
                $no = 0;
                foreach ($pop as $dtpop) : ?>
                    <?php while ($no <= 4) : ?>
                        <li class="list-group-item">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-3 g-0">
                                        <img src="<?= $dtpop['gambar'] ?>" class="img-fluid rounded-start" alt="..." style="max-width: 100px; height: 100px;">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <small class="text-muted"><?= substr($dtpop['tanggal'], 0, 10);  ?> | View:<?= $dtpop['view'];  ?></small>
                                            <p class="txtpop"><a href="./?open=detail&id=<?= $dtpop['id']; ?>" class=" text-decoration-none text-dark"><?= $dtpop['judul'];  ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    <?php $no++;
                        break;
                    endwhile ?>
                <?php
                    while ($no <= 6) {
                        break;
                    }
                    $no++;
                endforeach; ?>
            </ul>

        </div>

        <div class="mt-2 col-md-9">
            <div class="card">
                <img src="<?= $dtdetail['gambar'] ?>" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <h5 class="card-title dtext fw-bold fs-1"><?= $dtdetail['judul'] ?></h5>
                </div>
                <div class="card-body">
                    <small class="text-muted"><?= $dtdetail['tanggal']; ?> | Update by:<?= $dtdetail['author'];  ?></small>
                    <p class="card-text text-dark"><?= $dtdetail['isi']; ?><?= $dtdetail['teks']; ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>