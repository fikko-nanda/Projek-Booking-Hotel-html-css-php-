<?php
session_start();
// Memuat header.php
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    // Redirect pengguna ke halaman login jika belum login
    header('Location: login.php');
    exit; // Pastikan untuk keluar dari script setelah melakukan redirect
} // Jika diperlukan
require 'footer.php'; // Jika diperlukan

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    
    // Query to retrieve the booking information
    $stmt = $conn->prepare("SELECT id, category, price, nama_users, email_users, no_kartus, no_atm, tanggal_kdl, cvv FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking</title>
    <style>
        body {
            background-color: #e0f7fa; /* Warna biru muda */
            font-family: Arial, sans-serif; /* Ganti font jika diinginkan */
            padding: 20px; /* Spasi untuk konten */
        }
        .main-content {
            max-width: 600px; /* Lebar maksimum konten */
            margin: auto; /* Pusatkan konten di tengah halaman */
            background-color: #fff; /* Warna latar belakang konten */
            padding: 20px; /* Spasi dalam konten */
            border-radius: 8px; /* Sudut bulat untuk konten */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Bayangan ringan */
        }
        h2 {
            color: #009688; /* Warna judul */
        }
        input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Warna border */
            border-radius: 4px; /* Sudut bulat untuk input */
        }
        button {
            background-color: #009688; /* Warna tombol */
            color: #fff; /* Warna teks tombol */
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #00796b; /* Warna saat tombol dihover */
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Edit Booking</h2>
        <form method="POST" action="update_booking.php">
            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
            <!-- Add input fields for editing -->
            Tipe Kamar: <input type="text" name="category" value="<?php echo $row['category']; ?>"><br>
            Harga: <input type="text" name="price" value="<?php echo $row['price']; ?>"><br>
            Nama: <input type="text" name="nama_users" value="<?php echo $row['nama_users']; ?>"><br>
            Email: <input type="text" name="email_users" value="<?php echo $row['email_users']; ?>"><br>
            No. Handphone: <input type="text" name="no_kartus" value="<?php echo $row['no_kartus']; ?>"><br>
            Nomor kartu: <input type="text" name="no_atm" value="<?php echo $row['no_atm']; ?>"><br>
            Tanggal Kadaluwarsa: <input type="text" name="tanggal_kdl" value="<?php echo $row['tanggal_kdl']; ?>"><br>
            CVV: <input type="text" name="cvv" value="<?php echo $row['cvv']; ?>"><br>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "Data booking tidak ditemukan.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Permintaan tidak valid.";
}
?>
