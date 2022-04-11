 <!-- Berita Terbaru slider-->
 <?php
    function waktu_lalu($timestamp)
    {
        $selisih = time() - strtotime($timestamp);
        $detik = $selisih;
        $menit = round($selisih / 60);
        $jam = round($selisih / 3600);
        $hari = round($selisih / 86400);
        $minggu = round($selisih / 604800);
        $bulan = round($selisih / 2419200);
        $tahun = round($selisih / 29030400);
        if ($detik <= 60) {
            $waktu = $detik . ' detik yang lalu';
        } else if ($menit <= 60) {
            $waktu = $menit . ' menit yang lalu';
        } else if ($jam <= 24) {
            $waktu = $jam . ' jam yang lalu';
        } else if ($hari <= 7) {
            $waktu = $hari . ' hari yang lalu';
        } else if ($minggu <= 4) {
            $waktu = $minggu . ' minggu yang lalu';
        } else if ($bulan <= 12) {
            $waktu = $bulan . ' bulan yang lalu';
        } else {
            $waktu = $tahun . ' tahun yang lalu';
        }
        return $waktu;
    }
    $query = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 2");
    ?>
 <?php
    while ($data = mysqli_fetch_array($query)) :
        $pos = $data['tanggal'];
    ?>

     <div class="terkini">
         <div class="card">
             <a href="./?open=detail&id=<?= $data['id']; ?>"><img src="<?= $data['gambar'] ?>" class="card-img shadow-sm" alt="..."></a>
         </div>
     </div>
     <div class="container mb-2">
         <div class="row justify-content-center">
             <div class="col-lg-8 info-panel shadow-sm">
                 <div class="isi">
                     <h4><a href="./?open=detail&id=<?= $data['id']; ?>" class="text-decoration-none text-dark"><?= $data['judul'] ?></a></h4>
                     <small class="text-muted"><span class=" text-danger text-uppercase"><?= $data['kategori'] ?></span> | <?= waktu_lalu($pos); ?></small>
                 </div>
             </div>
         </div>
     </div>
 <?php endwhile; ?>

 <!-- konten -->
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
         <div class="pt-2">
             <ul class="list-group list-group-flush shadow-sm rounded">
                 <li class="list-group-item text-center fw-bold bgr">BERITA TERBARU</li>
             </ul>
         </div>
         <?php
            $sql = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1' ORDER BY id DESC LIMIT 0,30");
            ?>
         <?php
            foreach ($sql as $dtberita) : ?>

             <div class="card mt-2 mb-2 shadow-sm bg-body rounded">
                 <div class="row g-0">
                     <div class="col-md-4">
                         <a href="./?open=detail&id=<?= $dtberita['id'] ?>"><img src="<?= $dtberita['gambar'] ?>" class="img-fluid rounded-start" alt="..." style="max-width: 320px; height: 200px;"></a>
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

     </div>
 </div>