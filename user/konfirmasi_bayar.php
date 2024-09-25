<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form sudah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Siapkan dan ikat pernyataan SQL menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO pembayaran (nama_pemilik, jml_bayar, tanggal_bayar, metode_bayar, status_bayar) VALUES (?, ?, ?, ?, ?)");
    
    // Ikat parameter
    $stmt->bind_param("sdsss", $nama_pemilik, $jml_bayar, $tanggal_bayar, $metode_bayar, $status_bayar);
    
    // Ambil data form
    $nama_pemilik = $_POST['nama_pemilik'];
    $jml_bayar = $_POST['jml_bayar'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $metode_bayar = $_POST['metode_bayar'];
    // Status pembayaran default
    $status_bayar = 'Belum dikonfirmasi';
    
    // Jalankan pernyataan SQL
    if ($stmt->execute()) {
        $_SESSION['payment_success'] = true;
        header('Location: konfirmasi_bayar.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../user/image/home1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: auto;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 5px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #1b8dc3;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #1e81b1;
        }
        .instructions {
            margin-top: 20px;
            background-color: #e9f5e9;
            padding: 10px;
            border: 2px solid #c3e6c3;
        }
        .container .btn-back {
        width: 100%;
        padding: 10px;
        
        color: white;
        border: none;
        cursor: pointer;
        text-decoration:none;
    }
    .btn-back {
    width: 100%;
    padding: 10px;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
    margin-right: auto; /* Menjadikan tombol kembali melekat ke tepi kiri */
}
.btn-back i {
    font-size: 20px;
    color: black;
    transition: transform 0.3s ease; /* Efek transisi untuk perubahan ukuran */
}

.btn-back i:hover {
    transform: scale(1.5); /* Memperbesar ikon saat dihover */
}


    </style>
</head>
<body>
<div class="container">
<a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i></a>
    <h2>Konfirmasi Pembayaran</h2>
    <form method="POST" action="">
        <!-- Form Anda -->
        <div class="form-group">
            <label for="nama_pemilik">Nama Pemilik Rekening</label>
            <input type="text" id="nama_pemilik" name="nama_pemilik" required>
        </div>
        <div class="form-group">
            <label for="jml_bayar">Jumlah Pembayaran</label>
            <input type="number" id="jml_bayar" name="jml_bayar" required>
        </div>
        <div class="form-group">
            <label for="tanggal_bayar">Tanggal Pembayaran</label>
            <input type="date" id="tanggal_bayar" name="tanggal_bayar" required>
        </div>
        <div class="form-group">
            <label for="metode_bayar">Metode Pembayaran</label>
            <select id="metode_bayar" name="metode_bayar" required>
                <option value="kartu_kredit">Kartu Kredit</option>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="paypal">Paypal</option>
                <option value="kartu_debit">Kartu Debit</option>
                <option value="atm">ATM</option>
            </select>
        </div>
        <div class="instructions">
            <h3>Instruksi Pembayaran Melalui ATM</h3>
            <p>Silakan lakukan transfer ke rekening berikut:</p>
            <p><strong>Bank: Nama Bank</strong></p>
            <p><strong>Nomor Rekening: contoh (1234567890)</strong></p>
            <p><strong>Nama Pemilik Rekening: Nama Pemilik</strong></p>
            <p>Berikut adalah langkah-langkah melakukan transfer via ATM:</p>
            <ol>
                <li>Masukkan kartu ATM dan PIN Anda.</li>
                <li>Pilih menu "Transfer".</li>
                <li>Pilih tujuan bank "Nama Bank".</li>
                <li>Masukkan nomor rekening tujuan: <strong>1234567890</strong></li>
                <li>Masukkan jumlah pembayaran: <strong>Jumlah Pembayaran</strong></li>
                <li>Ikuti instruksi yang muncul di layar untuk menyelesaikan transaksi.</li>
            </ol>
            <p>Setelah melakukan transfer, harap simpan bukti transfer Anda dan upload ke form konfirmasi pembayaran di halaman ini atau kirim ke email: <strong>hotel@example.com</strong>.</p>
        </div>
        <br>
        <div class="form-group">
            <button type="submit">Konfirmasi Pembayaran</button>
        </div>
    </form>
</div>

</body>
</html>
