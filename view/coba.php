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
    $query = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
    ?>

 <!-- Slide foto -->
 <div class=" pt-2 pb-2">
     <div class="slider_foto shadow">
         <?php
            while ($data = mysqli_fetch_array($query)) :
                $pos = $data['tanggal'];
            ?>
             <div class="myslider pudar" style="display: block;">
                 <div class="teks container">
                     <div class="row justify-content-center">
                         <div class="col-lg-10 info-panel shadow-sm">
                             <div class="isi">
                                 <h4><a href="./?open=detail&id=<?= $data['id']; ?>" class="text-decoration-none text-dark"><?= $data['judul'] ?></a></h4>
                                 <small class="text-muted"><span class=" text-danger text-uppercase"><?= $data['kategori'] ?></span> | <?= waktu_lalu($pos); ?></small>
                             </div>
                         </div>
                     </div>

                 </div>
                 <a href="./?open=detail&id=<?= $data['id']; ?>">
                     <img class="image" src="<?= $data['gambar'] ?>" alt="kopi" style="width:100%; height:100%;">
                 </a>
             </div>
         <?php endwhile; ?>
         <a class="kembali" onclick="plusSlides(-1)">&#60;</a>
         <a class="lanjut" onclick="plusSlides(1)">&#62;</a>
         <div class="dbox" style="text-align: center;">
             <span class="dot" onclick="currentSlide(1)"></span>
             <span class="dot" onclick="currentSlide(2)"></span>
             <span class="dot" onclick="currentSlide(3)"></span>
         </div>
     </div>
 </div>
 <!-- Akhir slide foto -->
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
            $sql = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1' ORDER BY id DESC LIMIT 50");
            ?>
         <?php
            // $video_id = '';
            foreach ($sql as $dtberita) : ?>

             <div class="card mt-2 mb-2 shadow-sm bg-body rounded" data-aos="fade-left">
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

         <?php
            endforeach; ?>
         <div class="remove_more">
             <button type="button" name="btn_more" id="btn_more" class="btn btn-success form-control">Lihat Lainya</button>
         </div>

     </div>
 </div>
 <script>
     // slide foto
     const myslide = document.querySelectorAll('.myslider');
     dot = document.querySelectorAll('.dot');

     let counter = 1;
     slidefun(counter);

     let timer = setInterval(autoslide, 8000);

     function autoslide() {
         counter += 1;
         slidefun(counter);
     }

     function plusSlides(n) {
         counter += n;
         slidefun(counter);
         resetTimer();
     }

     function currentSlide(n) {
         counter = n;
         slidefun(counter);
         resetTimer();
     }

     function resetTimer() {
         clearInterval(timer);
         timer = setInterval(autoslide, 8000);
     }

     function slidefun(n) {
         let i;
         for (i = 0; i < myslide.length; i++) {
             myslide[i].style.display = "none";
         }
         for (i = 0; i < dot.length; i++) {
             dot[i].classList.remove('active');
         }
         if (n > myslide.length) {
             counter = 1;
         }
         if (n < 1) {
             counter = myslide.length;
         }
         myslide[counter - 1].style.display = "block";
         dot[counter - 1].classList.add('active');
     }
     //  load more
     //  $(document).ready(function() {
     //      $(document).on('click', '#btn_more', function() {
     //          var last_video_id = $(this).data("vid");
     //          $('#btn_more').html("Loading...");
     //          $.ajax({
     //              url: "view/load_data.php",
     //              method: "POST",
     //              data: {
     //                  last_video_id: last_video_id
     //              },
     //              dataType: "text",
     //              success: function(data) {
     //                  if (data != '') {
     //                      $('#remove_row').remove();
     //                      $('#load_data_table').append(data);
     //                  } else {
     //                      $('#btn_more').html("No Data");
     //                  }
     //              }
     //          });
     //      });
     //  });
 </script>