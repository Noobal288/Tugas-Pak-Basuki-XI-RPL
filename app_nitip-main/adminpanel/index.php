<?php
require "session.php";
require "../koneksi.php";

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);

$queryProduk = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($queryProduk)

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/font-awesome.min.css">
</head>

<style>
    .summary-kategori {
        background-color: #212529;
        border-radius: 13px;
    }

    .summary-produk {
        background-color: #212529;
        border-radius: 13px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-solid fa-house" style="color: #000000;"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Halo <?php echo $_SESSION['username']; ?></h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="summary-kategori p-4">
                        <div class="row">
                            <div class="col-5">
                                <i class="fa-solid fa-list fa-7x" style="color: #ffffff;"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-3">Kategori</h3>
                                <p class="fs-5"><?php echo $jumlahKategori; ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="summary-produk p-4">
                        <div class="row">
                            <div class="col-5 ">
                                <i class="fa-solid fa-box fa-8x" style="color: #ffffff;"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-3">Produk</h3>
                                <p class="fs-5"><?php echo $jumlahProduk; ?> Produk</p>
                                <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>