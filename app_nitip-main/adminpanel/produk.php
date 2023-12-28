<?php
require "session.php";
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahProduk = mysqli_num_rows($query);

$queryKategori = mysqli_query($con, "SELECT * FROM kategori");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/font-awesome.min.css">

</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }

    /* Gaya CSS untuk mengubah warna tombol */
    .custom-btn-primary {
        background-color: #212529;
        /* Ganti dengan warna yang diinginkan */
        border-color: #212529;
        /* Ganti dengan warna yang diinginkan */
    }

    /* Efek hover saat kursor diarahkan ke tombol */
    .custom-btn-primary:hover {
        background-color: #4c4b4b;
        /* Warna latar belakang saat hover */
        border-color: #4c4b4b;
        /* Warna garis batas saat hover */
    }

    form input,
    form select,
    form textarea {
        color: #000000;
        /* Warna teks */
        background-color: #f8f9fa;
        /* Warna latar belakang */
    }
</style>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house" style="color: #000000;"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fa-solid fa-box" style="color: #000000;"></i> Produk
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambahkan Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control mt-1 " autocomplete=off>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control  mt-1 ">
                        <option value="">Pilih Satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryKategori)) {
                        ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control mt-1" name="harga">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control mt-1">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="20" rows="10" class="form-control mt-1"></textarea>
                </div>
                <div>
                    <label for="keterediaan_stok">Ketersediaan Stok</label>
                    <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control mt-1">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary custom-btn-primary mt-1" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;



                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-dark mt-3" role="alert">
                        Nama, Kategori dan Harga Wajib Diisi
                    </div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 500000) {
                    ?>
                            <div class="alert alert-dark mt-3" role="alert">
                                File Tidak Boleh Lebih Dari 500 Kb
                            </div>
                            <?php
                        } else {
                            if ($imageFileType != 'jpg' && $imageFileType != 'png') {
                            ?>
                                <div class="alert alert-dark mt-3" role="alert">
                                    File Wajib JPG Atau PNG
                                </div>

                        <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }

                    // query insert to produk table
                    $queryTambah = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga' , '$new_name' , '$detail', '$ketersediaan_stok')");

                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-secondary mt-3" role="alert">
                            Produk Berhasil Disimpan
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan=5 class="text-center">Data Produk Tidak Tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                            ?>

                                <tr>
                                    <td><?php echo $jumlah; ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['nama_kategori'] ?></td>
                                    <td><?php echo $data['harga'] ?></td>
                                    <td><?php echo $data['ketersediaan_stok'] ?></td>
                                </tr>
                        <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>