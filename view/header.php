<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="asset/image/logo1.png">
    <title>Berita</title>
    <!-- Boostrap CSS -->
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- animasi -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- link css -->
    <link rel="stylesheet" href="css/navbar1.css">
    <link rel="stylesheet" href="css/home10.css">
</head>

<body>
    <!-- navbar -->
    <div class="titel">
        <a class="navbar-brand" href="./"> <img src="asset/image/logo FAQ.png" alt="" width="120" height="30"></a>
        <!-- <a href="#">FAQ<span> NEWS</span></a> -->
    </div>
    <nav class="navbar navbar-expand-lg navbar-light px-3 py3">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="./"> <img src="" alt="" width="30" height="24"></a> -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto align-items-center">
                    <a class="nav-link me-lg-5" href="./">HOME</a>
                    <?php
                    $sql = mysqli_query($koneksi, "SELECT * FROM kategori WHERE terbit='1' ORDER BY id ASC LIMIT 0,10");
                    ?>
                    <?php
                    foreach ($sql as $dtkategori) : ?>
                        <a class="nav-link me-lg-5" href="./?open=cat&id=<?= $dtkategori['id'];  ?>"><?= $dtkategori['kategori'] ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="icon-home mt-2 mb-2 ">
                    <form method="GET" action="">
                        <div class="searchBox">
                            <div class="searchToggle">
                                <i class='fa-solid fa-xmark cancel'></i>
                                <i class='fa-solid fa-magnifying-glass search'></i>

                            </div>
                            <div class="search-field">
                                <input type="text" placeholder="Search..." name="key" autofocus autocomplete="off">
                                <input type="hidden" name="open" value="cari"><i class='fa-solid fa-magnifying-glass'></i>
                            </div>

                        </div>
                    </form>
                    <div class="usericon ms-auto">
                        <a href="admin/login.php"><i class="fa-solid fa-user "></i></a>
                    </div>
                </div>
            </div>
        </div>
    </nav>