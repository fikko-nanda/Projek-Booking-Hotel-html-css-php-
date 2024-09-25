<?php

require 'koneksi.php'; // Assuming this file establishes $conn correctly

if(isset($_POST['masuk'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $username = $_POST['username'];

    if ($password !== $confirmPassword) {
        header('location:register.php?error=Password yang Anda masukkan tidak cocok');
        exit();
    }

    // Using prepared statement to insert data
    $stmt = $conn->prepare("INSERT INTO login (email, password, username) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $username);

    if ($stmt->execute()) {
        header('location:login.php?success=Registrasi berhasil, silakan login');
        exit();
    } else {
        header('location:register.php?error=Registrasi gagal, silakan coba lagi');
        exit();
    }

    $stmt->close();
    $conn->close();
} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-image: url('../user/image/logo.jpg'); 
            background-size: cover; 
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.8); 
        }
        h2 {
            text-align: center;
        }
        .message {
            text-align: center;
            margin-bottom: 10px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
        }
        .form-control {
            width: 95%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: border-color 0.3s; 
        }
        .form-control:focus {
            border-color: #007bff; 
        }
        .form-control.error {
            border-color: #ff0000; /* Color border merah saat ada kesalahan */
        }
        
        .btn-primary {
            width: 100%;
            max-width: 100px;
            padding: 10px 0; /* Adjusted padding */
            background-color: #006400; /* Green color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #218838; 
        }
    </style>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            if (password !== confirmPassword) {
                alert("Password yang Anda masukkan tidak cocok");
                return false; 
            }
            return true; 
        }

        // Function to add error class when input is focused
        function onFocus(element) {
            element.classList.remove("error");
        }

        // Function to add error class when input loses focus and it's empty
        function onBlur(element) {
            if (element.value === "") {
                element.classList.add("error");
            }
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Formulir Registrasi</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="message" style="color:red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        if (isset($_GET['success'])) {
            echo '<p class="message" style="color:green;">' . htmlspecialchars($_GET['success']) . '</p>';
        }
        ?>
        <form method="post" action="register.php" onsubmit="return validateForm()">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required 
                    onfocus="onFocus(this)" onblur="onBlur(this)">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input type="email" class="form-control" id="email" name="email" required
                    onfocus="onFocus(this)" onblur="onBlur(this)">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required
                    onfocus="onFocus(this)" onblur="onBlur(this)">
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required
                    onfocus="onFocus(this)" onblur="onBlur(this)">
            </div>
            <button type="submit" class="btn btn-primary" name="masuk">Daftar</button> 
        </form>
    </div>
</body>
</html>
