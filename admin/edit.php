<?php
// Include file header.php untuk bagian header
session_start();
// Memuat header.php
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    // Redirect pengguna ke halaman login jika belum login
    header('Location: login.php');
    exit; // Pastikan untuk keluar dari script setelah melakukan redirect
}

// Include file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Proses edit jika parameter id tersedia
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk mengambil data berdasarkan id
    $sql = "SELECT * FROM checkin WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Tampilkan form untuk edit data
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Edit Check-in Data</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #e0f7fa;
                    padding: 20px;
                }
                .main-content {
                    max-width: 600px;
                    margin: auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h2 {
                    color: #009688;
                }
                label {
                    display: block;
                    margin-bottom: 5px;
                    color: #333;
                }
                input[type="text"], input[type="number"], input[type="date"], button {
                    width: calc(100% - 22px);
                    padding: 10px;
                    margin: 5px 0;
                    box-sizing: border-box;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }
                button {
                    width: auto;
                    background-color: #009688;
                    color: white;
                    border: none;
                    cursor: pointer;
                }
                button:hover {
                    background-color: #00796b;
                }
            </style>
        </head>
        <body>
            <div class="main-content">
                <h2>Edit Check-in/check-out Data</h2>
                <form method="POST" action="update.php">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>">
                    <label>Check-in Date:</label>
                    <input type="date" name="checkin_date" value="<?php echo htmlspecialchars($row['checkin'], ENT_QUOTES); ?>" required><br>
                    <label>Check-out Date:</label>
                    <input type="date" name="checkout_date" value="<?php echo htmlspecialchars($row['checkout'], ENT_QUOTES); ?>" required><br>
                    <label>Jumlah Orang:</label>
                    <input type="number" name="jumlah_orang" value="<?php echo htmlspecialchars($row['dewasa'], ENT_QUOTES); ?>" required><br>
                    <label>Nama Pemesan:</label>
                    <input type="text" name="nama_pemesan" value="<?php echo htmlspecialchars($row['nama_users'], ENT_QUOTES); ?>" required><br>
                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Data not found.";
    }
    $conn->close();
    exit; // Keluar dari script setelah menampilkan form edit
}
?>
