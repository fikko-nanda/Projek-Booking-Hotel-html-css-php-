<?php
session_start();
// Memuat header.php
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    // Redirect pengguna ke halaman login jika belum login
    header('Location: login.php');
    exit; // Pastikan untuk keluar dari script setelah melakukan redirect
}

// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk menghitung jumlah baris dalam tabel bookings
$query_bookings = "SELECT COUNT(*) as total FROM bookings";
$result_bookings = $conn->query($query_bookings);
$jumlah_bookings = ($result_bookings) ? $result_bookings->fetch_assoc()['total'] : 0;

// Query untuk menghitung jumlah baris dalam tabel galeri
$query_galeri = "SELECT COUNT(*) as total FROM galeri";
$result_galeri = $conn->query($query_galeri);
$jumlah_galeri = ($result_galeri) ? $result_galeri->fetch_assoc()['total'] : 0;

// Query untuk menghitung jumlah baris dalam tabel rooms
$query_rooms = "SELECT COUNT(*) as total FROM rooms";
$result_rooms = $conn->query($query_rooms);
$jumlah_rooms = ($result_rooms) ? $result_rooms->fetch_assoc()['total'] : 0;

// Menutup koneksi
$conn->close();

// Memuat footer.php
require 'footer.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Hotel</title>
        <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #E4E9F7;
        margin: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    table th, table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    table th {
        background-color: #f2f2f2;
    }
    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tr:hover {
        background-color: #e9e9e9;
    }
    .jumlah {
       background-color: #e9e9e9; /* Mengubah warna teks menjadi hijau */
    }
    button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        cursor: pointer;
    }
    button:hover {
        background-color: #c0392b;
    }
   
    .dashboard-section, .dashboard-coba, .dashboard-test, .dashboard-coh {
    text-align: center;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: calc(30% - 10px); /* Lebar setiap bagian */
    margin: 20px;
    display: inline-block; /* Mengatur agar child element (table-container) sejajar */
    vertical-align: top; /* Mengatur agar bagian-bagian sejajar di bagian atas */
    box-sizing: border-box;
    margin-top: 20px;
    max-height: 250px; /* Batasi tinggi tabel */
    overflow-y: auto; /* Tampilkan scrollbar jika lebih dari maksimum tinggi */
    transition: transform 0.2s, box-shadow 0.2s; /* Tambahkan transisi untuk efek halus */
}

.dashboard-section:hover, .dashboard-coba:hover, .dashboard-test:hover, .dashboard-coh:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); 
}
.dashboard-coh:hover {
    background-color: #1976D2;
}
.dashboard-test:hover{
    background-color:#FBC02D;
}
.dashboard-coba:hover{
    background-color:#2E7D32;
}

/* Specific background colors for each class */
.dashboard-coba {
    background-color: #4CAF50;
}

.dashboard-test {
    background-color:#FFC107;
}

.dashboard-coh {
    background-color: #3498db;
}

    @media (max-width: 768px) {
            .dashboard-section {
                width: calc(100% - 40px); /* Sesuaikan lebar bagian pada layar kecil */
                margin: 10px auto; /* Jarak antara bagian-bagian */
                display: block; /* Ubah tata letak menjadi satu kolom */
                max-height: none; /* Hilangkan batasan tinggi */
                overflow-y: visible; /* Hilangkan scrollbar */
            }
            .dashboard-coh {
                width: calc(100% - 40px); /* Sesuaikan lebar bagian pada layar kecil */
                margin: 10px auto; /* Jarak antara bagian-bagian */
                display: block; /* Ubah tata letak menjadi satu kolom */
                max-height: none; /* Hilangkan batasan tinggi */
                overflow-y: visible; /* Hilangkan scrollbar */
            }
            .dashboard-coba {
                width: calc(100% - 40px); /* Sesuaikan lebar bagian pada layar kecil */
                margin: 10px auto; /* Jarak antara bagian-bagian */
                display: block; /* Ubah tata letak menjadi satu kolom */
                max-height: none; /* Hilangkan batasan tinggi */
                overflow-y: visible; /* Hilangkan scrollbar */
            }
            .dashboard-test {
                width: calc(100% - 40px); /* Sesuaikan lebar bagian pada layar kecil */
                margin: 10px auto; /* Jarak antara bagian-bagian */
                display: block; /* Ubah tata letak menjadi satu kolom */
                max-height: none; /* Hilangkan batasan tinggi */
                overflow-y: visible; /* Hilangkan scrollbar */
            }
        }
</style>

</head>
<body>
<section class="home-section">
    <div class="dashboard-section">
        <div class="table-container">
            <a href="booking.php" style="text-decoration: none; color: inherit;"><h2>DATA PELANGGAN</h2></a>
            <table>
                <tr>
                    <th>Jumlah pelanggan</th>
                </tr>
                <tr>
                    <td class="jumlah"><?php echo $jumlah_bookings; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="dashboard-section">
        <div class="table-container">
            <a href="kamar.php" style="text-decoration: none; color: inherit;"><h2>GALERI</h2></a>
            <table>
                <tr>
                    <th>Jumlah galeri</th>
                </tr>
                <tr>
                    <td class="jumlah"><?php echo $jumlah_galeri; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="dashboard-section">
        <div class="table-container">
            <a href="kategori.php" style="text-decoration: none; color: inherit;"><h2>KAMAR</h2></a>
            <table>
                <tr>
                    <th>Jumlah kamar</th>
                </tr>
                <tr>
                    <td class="jumlah"><?php echo $jumlah_rooms; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="table-container">
    <div class="table-container">
    <table>
        <tr>
            <td class="dashboard-coba">
                <a href="checkin.php" style="text-decoration: none; color: inherit; display: block;">
                    <h2>CHECK-IN</h2>
                </a>
            </td>
            <td class="dashboard-test">
                <a href="proses_bayar.php" style="text-decoration: none; color: inherit; display: block;">
                    <h2>PEMBAYARAN</h2>
                </a>
            </td>
            <td class="dashboard-coh">
                <a href="../user/index.php" style="text-decoration: none; color: inherit; display: block;">
                    <h2>USER</h2>
                </a>
            </td>
        </tr>
    </table>
</div>

</div>

</section>
</body>
</html>
