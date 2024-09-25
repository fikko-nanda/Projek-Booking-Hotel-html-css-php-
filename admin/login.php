<?php
session_start();
require 'koneksi.php';

// Cek apakah pengguna sudah login, jika ya redirect ke beranda.php
if (isset($_SESSION['log']) && $_SESSION['log'] === true) {
    header('Location: beranda.php');
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $input = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$input' AND password='$password'");
    } else {
        $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE username='$input' AND password='$password'");
    }

    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = true;
        header('Location: beranda.php');
        exit;
    } else {
        $error = 'Email/Username atau password salah!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('../user/image/home4.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        .card-header, .card-body {
            background: transparent;
        }
        .form-floating .form-control {
            padding-left: 2.5rem;
            transition: all 0.3s ease;
        }
        .form-floating .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }
        .form-floating .form-control ~ label {
            left: 1.5rem;
            transition: all 0.3s ease;
        }
        .form-floating .form-control:focus ~ label {
            color: #007bff;
        }
        .btn-login {
            width: 120px;
        }
        .link-container {
            text-align: center;
            margin-top: 20px;
        }
        .link-container a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .link-container a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-floating mb-3 position-relative">
                                <input class="form-control" name="email" id="inputEmail" type="text" placeholder="Enter email or username" />
                                <label for="inputEmail"><i class="fa-regular fa-user"></i> Email or Username</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Enter Password" />
                                <label for="inputPassword"><i class="fa-solid fa-lock"></i> Password</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success btn-login" name="login"><i class="fa-solid fa-arrow-right-from-bracket"></i> Login</button>
                            </div>
                        </form>
                        <div class="link-container">
                            <p>Belum punya akun? <a href="register.php">Registrasi di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
