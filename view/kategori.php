<?php $idget = (isset($_GET['id']) ? $_GET['id'] : ''); ?>

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

    <!-- Berita -->
    <div class=" col-md-9">
        <?php
        $tamp = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='" . $idget . "'");
        $tes = mysqli_fetch_array($tamp);
        ?>
        <div class="pt-2">
            <ul class="list-group list-group-flush shadow-sm rounded">
                <li class="list-group-item text-center fw-bold bgr text-uppercase">KATEGORI <?= $tes['kategori']; ?></li>
            </ul>
        </div>
        <?php
        $getalias = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='" . $idget . "'");
        foreach ($getalias as $al) :
            $sql = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1' AND kategori='" . $al['nama_lain'] . "' ORDER BY id DESC LIMIT 0,10");
        ?>
            <?php
            foreach ($sql as $dtberita) : ?>
                <div class="card mt-2 mb-2 shadow-sm bg-body rounded" data-aos="fade-left">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <a href="./?open=detail&id=<?= $dtberita['id'] ?>"> <img src="<?= $dtberita['gambar'] ?>" class="img-fluid rounded-start" alt="..." style="max-width: 320px; height: 200px;"></a>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title "><a href="./?open=detail&id=<?= $dtberita['id'] ?>" class="text-decoration-none text-dark"><?= $dtberita['judul'] ?></a></h5>
                                <p class="card-text"><?= $dtberita['isi'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>