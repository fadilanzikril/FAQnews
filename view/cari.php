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
        <?php $get_key = $_GET['key'];
        $key = explode(" ", $get_key);
        // var_dump($key)
        sort($key);
        $stradd = '';
        foreach ($key as $value) {
            if ($stradd != '') {
                $stradd .= "OR isi LIKE '%{$value}%' OR judul LIKE '%{$value}%' ";
            } else {
                $stradd .= "isi LIKE '%{$value}%' OR judul LIKE '%{$value}%' ";
            }
        }

        echo '<div class="pt-2">
        <ul class="list-group list-group-flush shadow-sm rounded">
            <li class="list-group-item fw-bold bgr text-uppercase">Hasil Pencarian : ' . str_replace('+', ' ', $get_key) . '</li>
        </ul>
        </div>';

        $sqll = mysqli_query($koneksi, "SELECT * FROM berita WHERE $stradd AND terbit= '1'  ORDER BY id DESC LIMIT 0,10");
        while ($a = mysqli_fetch_array($sqll)) :
            extract($a);
        ?>
            <div class="card mt-2 mb-2 shadow-sm bg-body rounded">
                <div class="row g-0">
                    <div class="col-md-4">
                        <a href="./?open=detail&id=<?= $a['id'] ?>"><img src="<?= $a['gambar'] ?>" class="img-fluid rounded-start" alt="..." style="max-width: 320px; height: 200px;"></a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title "><a href="./?open=detail&id=<?= $a['id'] ?>" class="text-decoration-none text-dark"><?= $a['judul'] ?></a></h5>
                            <p class="card-text"><?= $a['isi'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>



    </div>
</div>