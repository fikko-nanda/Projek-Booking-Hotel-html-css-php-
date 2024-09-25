<?php
require 'header.php';
require 'footer.php';

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

// Menangani permintaan POST untuk menghapus data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    $sql_delete = "DELETE FROM pembayaran WHERE id = $delete_id";

    if ($conn->query($sql_delete) === TRUE) {
        echo "";
    } else {
        echo "Kesalahan menghapus data: " . $conn->error;
    }
}

// Menangani permintaan POST untuk mengupdate status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    $update_id = $conn->real_escape_string($_POST['update_id']);
    $status_bayar = isset($_POST['status_bayar']) ? $_POST['status_bayar'] : 'belom Lunas';
    $sql_update = "UPDATE pembayaran SET status_bayar = '$status_bayar' WHERE id = $update_id";

    if ($conn->query($sql_update) === TRUE) {
        // Redirect or refresh to update the table
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Kesalahan mengupdate status: " . $conn->error;
    }
}

// Mengambil data dari tabel pembayaran dan mengurutkannya berdasarkan tanggal
$sql_select = "SELECT id, nama_pemilik, jml_bayar, tanggal_bayar, metode_bayar, status_bayar FROM pembayaran ORDER BY STR_TO_DATE(tanggal_bayar, '%d-%m-%Y')";
$result = $conn->query($sql_select);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pembayaran</title>
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
        select {
            padding: 5px;
            font-size: 12px;
        }
        .action-column {
            width: 150px; /* Lebar kolom untuk tombol aksi */
        }
        .action-column form {
            display: inline-block;
        }
        .edit-button, .delete-button {
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
            border: none;
            outline: none;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }
        .edit-button {
            background-color: #3498db;
            color: white;
        }
        .edit-button:hover {
            background-color: #2980b9;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
        /* CSS tambahan untuk mengatur tata letak tombol aksi */
        .action-buttons {
            white-space: nowrap; /* Mencegah pemisahan baris tombol aksi */
        }
    </style>
</head>
<body>
    <section class="home-section">
        <div class="text">Daftar Pembayaran</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama pengguna rekening</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th class="action-column">Aksi</th> <!-- Tambahkan kelas untuk kolom aksi -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi dan query sudah di atas

                if ($result->num_rows > 0) {
                    $counter = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $counter . "</td>
                                <td>" . htmlspecialchars($row['nama_pemilik'], ENT_QUOTES) . "</td>
                                <td>" . 'Rp ' . number_format($row['jml_bayar'], 0, ',', '.') . "</td>
                                <td>" . date('d-m-Y', strtotime($row['tanggal_bayar'])) . "</td>
                                <td>" . htmlspecialchars($row['metode_bayar'], ENT_QUOTES) . "</td>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='update_id' value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>
                                        <select name='status_bayar' onchange='this.form.submit()'>
                                            <option value='Lunas'" . ($row['status_bayar'] == 'Lunas' ? ' selected' : '') . ">Lunas</option>
                                            <option value='belom Lunas'" . ($row['status_bayar'] == 'belom Lunas' ? ' selected' : '') . ">Belum Lunas</option>
                                        </select>
                                    </form>
                                </td>
                                <td class='action-column'>
                                    <div class='action-buttons'>
                                        <form action='edit_pembayaran.php' method='GET'>
                                            <input type='hidden' name='edit_id' value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>
                                            <button type='submit' class='edit-button'>Edit</button>
                                        </form>
                                        <form method='POST' action='' onsubmit=\"return confirm('Apakah Anda Yakin?');\">
                                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "'>
                                            <button type='submit' class='delete-button'>Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data pembayaran</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>

<?php
$conn->close();
?>



