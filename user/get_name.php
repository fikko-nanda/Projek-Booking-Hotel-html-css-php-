<?php
// Koneksi ke database (sesuaikan dengan pengaturan koneksi database Anda)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "hotel";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil nama dari database
$user_id = 123; // Ganti dengan ID pengguna yang sesuai
$sql = "SELECT nama_users FROM checkin WHERE nama_users = $nama_users"; // Sesuaikan dengan struktur tabel Anda

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];

    // Keluarkan sebagai JSON
    $response = array('success' => true, 'nama' => $nama);
    echo json_encode($response);
} else {
    // Jika data tidak ditemukan
    $response = array('success' => false);
    echo json_encode($response);
}

$conn->close();
?>
