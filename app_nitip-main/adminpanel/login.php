<?php
session_start();
require "../koneksi.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

</head>

<style>
    .main {
        height: 100vh;
    }

    body {
        background-color: #212529;
        /* Warna gelap untuk latar belakang */
        color: #fff;
        /* Warna terang untuk teks */
    }

    .btn-success {
        background-color: #28a745;
        /* Warna hijau untuk tombol login */
        border-color: #28a745;
        /* Warna border untuk tombol login */
        color: #fff;
        /* Warna terang untuk teks tombol */
    }

    .login-box {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        /* Shadow dengan efek transparan */
    }

    .alert {
        color: #fff;
        /* Warna terang untuk teks alert */
        background-color: #dc3545;
        /* Warna merah untuk latar belakang alert */
        border-color: #dc3545;
        /* Warna border untuk alert */
    }

    .login-box {
        background-color: #343a40;
        /* Warna gelap untuk kotak login */
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-white mb-4"><i class="fas fa-sign-in-alt"></i> LOGIN</h2>
        <div class="login-box p-5 shadow">

            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" autocomplete=off>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">Login</button>
                </div>
            </form>
        </div>
        <div class="mt-3" style="width: 500px;">
            <?php
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM users WHERE 
                username ='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);

                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: ../adminpanel');
                    } else {
            ?>
                        <div class="alert alert-warning" role="alert">
                            Password Salah
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-warning" role="alert">
                        Akun tidak tersedia
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>