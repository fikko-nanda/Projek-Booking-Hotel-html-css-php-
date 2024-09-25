<?php
// Include header.php untuk bagian header
session_start();
// Memuat header.php
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    // Redirect pengguna ke halaman login jika belum login
    header('Location: login.php');
    exit; // Pastikan untuk keluar dari script setelah melakukan redirect
}

// Include koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Proses delete jika parameter id tersedia
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data berdasarkan id
    $sql = "DELETE FROM checkin WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Query untuk menampilkan data checkin
$sql = "SELECT * FROM checkin";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Check-in Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E4E9F7;
            margin: 20px;
        }
        section {
            font-size: 16px;
            margin-bottom: 20px;
            overflow-x: auto;
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
        form {
            margin: 0;
            padding: 0;
            display: inline-block; /* Menampilkan form dalam satu baris */
        }
        button {
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
            border: none;
            outline: none;
            text-decoration: none;
            display: inline-block;
            vertical-align: middle; /* Selaraskan tombol secara vertikal */
        }
        .edit-button, .delete-button {
            margin-right: 5px; /* Berikan margin kanan agar tidak menempel */
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
        @media screen and (max-width: 600px) {
            table {
                font-size: 14px; /* Mengurangi ukuran font pada layar kecil */
            }
            .edit-button, .delete-button {
                margin-right: 0; /* Hilangkan margin kanan pada layar kecil */
                margin-bottom: 5px; /* Tambahkan margin bottom untuk pemisahan tombol */
                display: block; /* Ubah tampilan tombol menjadi blok */
                width: 100%; /* Tombol mengisi seluruh lebar */
            }
        }
    </style>
</head>
<body>
<section class="home-section">
    <div class="text">Check-in Data</div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Check-in Date</th>
                <th>Jumlah Orang</th>
                <th>Nama Pemesan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    // Format tanggal dari YYYY-MM-DD menjadi DD Month YYYY
                    $formatted_date = date('d F Y', strtotime($row["checkin"]));
                    
                    echo "<tr>
                        <td>" . $counter . "</td>
                        <td>" . $formatted_date . "</td>
                        <td>" . $row["dewasa"] . "</td>
                        <td>" . $row["nama_users"] . "</td>
                        <td>
                            <form method='GET' action='edit.php'>
                                <input type='hidden' name='action' value='edit'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <button type='submit' class='edit-button'>Edit</button>
                            </form>
                            <form method='GET' action=''>
                                <input type='hidden' name='action' value='delete'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <button type='submit' class='delete-button' onclick=\"return confirm('Apakah Anda Yakin?')\">Hapus</button>
                            </form>
                        </td>
                    </tr>";
                    
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</section>
</body>
</html>

<?php
// Include footer.php untuk bagian footer
require 'footer.php';
?>
