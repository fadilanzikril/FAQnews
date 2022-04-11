<?php 


 //ekstensi file yang boleh di upload
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $gambar = $_FILES['gambar']['name']; // untuk mendapatkan nama file yang diupload
    //nama_file.jpg
    $x = explode('.', $gambar);
    $ekstensi = strtolower(end($x));
    $ukuran = $_FILES['gambar']['size']; //untuk mendapatkan ukuran file yang akan di upload
    $file_tmp = $_FILES['gambar']['tmp_name']; //untuk mendapatkan temporary file yang akan di upload (tmp)
    $error = $_FILES['gambar']['error'];
    $gambarbaru = $_FILES['gambarbaru']['name'];

    //uji jika ekstensi file yang diupload sesuai
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        //boleh upload file
        //uji jika ukuran file dibawah 1mb
        if ($ukuran < 10044070) {
            //jika ukuran sesuai
            //PINDAHKAN FILE YANG DI UPLOAD KE FOLDER FILE aplikasi
            move_uploaded_file($file_tmp, '../asset/image/' . $gambar);

            //simpan data ke dalam database
            if ($_POST['aksi'] == 'tambah') {

                $simpan = mysqli_query($koneksi, "INSERT INTO 
												  berita 
												  VALUES ('', '$judul', '$isi', '$kategori', '$gambar', '$teks', '$tanggal', '0', '$author', 'berita', '$terbit')");
                if ($simpan) {
                    echo "<script>alert('FILE BERHASIL DI UPLOAD'); document.location='index.php'</script>";
                } else {
                    echo "<script>alert('GAGAL MENGUPLOAD FILE'); document.location='index.php'</script>";
                }
            }
            if ($_POST['aksi'] == 'edit') {

                $sql_update = "UPDATE berita SET judul = '" . $judul . "', isi='" . $isi . "', kategori='" . $kategori . "', gambar='" . $gambarbaru . "', teks='" . $teks . "', terbit='" . $terbit . "' WHERE id='" . $_POST['id'] . "'";
                mysqli_query($koneksi, $sql_update);
                $_SESSION['inpo2'] = "User Berhasil Di edit!!!";
            }
        } else {
            //ukuran tidak sesuai
            echo "<script>alert('UKURAN FILE TERLALU BESAR, MAX. 1MB'); document.location='index.php'</script>";
        }
    } else {
        //ektensi file yang di upload tidak sesuai

        echo "<script>alert('EKSTENSI FILE YANG DI UPLOAD TIDAK DIPERBOLEHKAN'); document.location='index.php'</script>";
    }
