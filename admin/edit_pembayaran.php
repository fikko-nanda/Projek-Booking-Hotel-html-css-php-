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
require 'footer.php';

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
    
    // Query untuk mendapatkan data pembayaran berdasarkan ID
    $stmt = $conn->prepare("SELECT id, nama_pemilik, jml_bayar, tanggal_bayar, metode_bayar, status_bayar FROM pembayaran WHERE id = ?");
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
    <title>Edit Pembayaran</title>
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
        input[type="text"], select, button {
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
        <h2>Edit Pembayaran</h2>
        <form method="POST" action="update_pembayaran.php">
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>">
            <label>Nama Pengguna Rekening:</label>
            <input type="text" name="nama_pemilik" value="<?php echo htmlspecialchars($row['nama_pemilik'], ENT_QUOTES); ?>" required>
            <label>Jumlah Pembayaran:</label>
            <input type="text" name="jml_bayar" value="<?php echo htmlspecialchars($row['jml_bayar'], ENT_QUOTES); ?>" required>
            <label>Tanggal Pembayaran:</label>
            <input type="text" name="tanggal_bayar" value="<?php echo date('d-m-Y', strtotime($row['tanggal_bayar'])); ?>" required>
            <label for="metode_bayar">Metode Pembayaran</label>
<select id="metode_bayar" name="metode_bayar" required>
    <option value="kartu_kredit" <?php if ($row['metode_bayar'] == 'kartu_kredit') echo 'selected'; ?>>Kartu Kredit</option>
    <option value="transfer_bank" <?php if ($row['metode_bayar'] == 'transfer_bank') echo 'selected'; ?>>Transfer Bank</option>
    <option value="paypal" <?php if ($row['metode_bayar'] == 'paypal') echo 'selected'; ?>>Paypal</option>
    <option value="kartu_debit" <?php if ($row['metode_bayar'] == 'kartu_debit') echo 'selected'; ?>>Kartu Debit</option>
    <option value="atm" <?php if ($row['metode_bayar'] == 'atm') echo 'selected'; ?>>ATM</option>
</select>
            <label>Status Pembayaran:</label>
            <select name="status_bayar">
                <option value="Lunas" <?php if ($row['status_bayar'] == 'Lunas') echo 'selected'; ?>>Lunas</option>
                <option value="belum Lunas" <?php if ($row['status_bayar'] == 'belum Lunas') echo 'selected'; ?>>Belum Lunas</option>
            </select>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
<?php
    } else {
        echo "Data pembayaran tidak ditemukan.";
    }
    $stmt->close();
} else {
    echo "Permintaan tidak valid.";
}

$conn->close();
?>
