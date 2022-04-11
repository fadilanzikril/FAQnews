<?php

include "../fungsi/koneksi.php";
$output = '';
$id = '';
$video_id = '';
sleep(1);
$query = mysqli_query($koneksi, "SELECT * FROM berita WHERE terbit='1' ORDER BY id > " . $_POST['last_video_id'] . " DESC LIMIT 5");
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_array($query)) {
        $video_id = $row['id'];
        $output .= '
        <div class="card mt-2 mb-2 shadow-sm bg-body rounded" data-aos="fade-left">
                 <div class="row g-0">
                     <div class="col-md-4">
                         <a href="./?open=detail&id=' . $row['id'] . '"><img src="' . $row['gambar'] . '" class="img-fluid rounded-start" alt="..." style="max-width: 320px; height: 200px;"></a>
                     </div>
                     <div class="col-md-8">
                         <div class="card-body">
                             <h5 class="card-title "><a href="./?open=detail&id=' . $row['id'] . '" class="text-decoration-none text-dark"><?= ' . $row['judul'] . '</a></h5>
                             <p class="card-text">' . $row['isi'] . '</p>
                         </div>
                     </div>
                 </div>
             </div>
        ';
    }
    $output .= '
    <div id="remove_row">
             <button type="button" name="btn_more" data-vid="' . $video_id . '" id="btn_more" class="btn btn-success form-control">more</button>
         </div>
    ';
    echo $output;
}
