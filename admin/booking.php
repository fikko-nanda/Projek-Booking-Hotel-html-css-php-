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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    
    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Kesalahan menghapus data: " . $stmt->error;
    }
    $stmt->close();
}

$sql_select = "SELECT id, category, price, nama_users, email_users, no_kartus, no_atm, tanggal_kdl, cvv FROM bookings";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E4E9F7;
            margin: 20px;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        .action-buttons {
            white-space: nowrap; /* agar tombol-tombol tetap dalam satu baris */
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
            margin-right: 5px; /* jarak antar tombol */
        }
        button:hover {
            background-color: #c0392b;
        }
        .edit-button {
            background-color: #3498db;
        }
        .edit-button:hover {
            background-color: #2980b9;
        }
        .delete-button {
            background-color: #f44336;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
        @media screen and (max-width: 768px) {
            table {
                font-size: 12px;
            }
            table th, table td {
                padding: 8px;
            }
            .text {
                font-size: 18px;
            }
            button {
                padding: 4px 8px;
            }
        }
    </style>
</head>
<body>
<section class="home-section">
    <div class="text">Daftar Booking</div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipe Kamar</th>
                    <th>Harga</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Handphone</th>
                    <th>Nomor kartu</th>
                    <th>Tanggal Kadaluwarsa</th>
                    <th>CVV</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $counter . "</td>
                                <td>" . $row['category'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['nama_users'] . "</td>
                                <td>" . $row['email_users'] . "</td>
                                <td>" . $row['no_kartus'] . "</td>
                                <td>" . $row['no_atm'] . "</td>
                                <td>" . $row['tanggal_kdl'] . "</td>
                                <td>" . $row['cvv'] . "</td>
                                <td class='action-buttons'>
                                    <form action='edit_booking.php' method='GET' style='display: inline-block;'>
                                        <input type='hidden' name='edit_id' value='" . $row['id'] . "'>
                                        <button type='submit' class='edit-button'>Edit</button>
                                    </form> 
                                    <form method='POST' action='' style='display: inline-block; margin-left: 5px;'>
                                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                        <button type='submit' onclick=\"return confirm('Apakah Anda Yakin?')\" class='delete-button'>Hapus</button>
                                    </form>
                                </td>
                            </tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='10'>Tidak ada data booking</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>
