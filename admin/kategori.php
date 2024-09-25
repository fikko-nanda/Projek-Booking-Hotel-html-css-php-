<?php session_start();
// Memuat header.php
require 'header.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
    // Redirect pengguna ke halaman login jika belum login
    header('Location: login.php');
    exit; // Pastikan untuk keluar dari script setelah melakukan redirect
} require 'footer.php'; ?>

<section class="home-section">
<?php
// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = isset($_GET['edit']) ? $_GET['edit'] : null;
$kategori = '';
$harga = '';
$gambar = '';

if ($id) {
    $sql = "SELECT * FROM rooms WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kategori = $row['category'];
        $harga = $row['price'];
        $gambar = $row['image'];
    }
}

// Menangani pembatalan edit
if (isset($_GET['cancel'])) {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Menangani pengiriman formulir
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar']['name'] ? $_FILES['gambar']['name'] : $gambar;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);

    if ($id) {
        // Mengupload file jika ada file baru
        if ($_FILES['gambar']['name']) {
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        }
        // Update data
        $sql = "UPDATE rooms SET category='$kategori', price='$harga', image='$gambar' WHERE id=$id";
    } else {
        // Mengupload file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO rooms (category, price, image) VALUES ('$kategori', '$harga', '$gambar')";
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menangani penghapusan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM rooms WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error saat menghapus data: " . $conn->error;
    }
}

// Mengambil data
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$conn->close();

function formatRupiah($number) {
    return 'Rp.' . number_format($number, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Kategori Kamar</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E4E9F7;
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }
        .form-container, .table-container {
            flex: 1;
            min-width: 300px;
            max-width: 48%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            color: #343a40;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #495057;
        }
        input[type="text"], input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button[type="reset"] {
            background-color: #6c757d;
        }
        button[type="button"] {
            background-color: #6c757d;
        }
        button:hover {
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #e9ecef;
            color: #495057;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            max-width: 100px;
            border-radius: 4px;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .actions a .delete-button {
            background-color: #dc3545; /* Warna merah untuk tombol "Hapus" */
            color: #fff; /* Warna teks putih untuk kontras */
            border: none; /* Menghilangkan border */
            padding: 5px 10px; /* Atur padding agar tombol lebih compact */
            border-radius: 4px; /* Membuat sudut tombol agak melengkung */
            cursor: pointer; /* Kursor menunjukkan bahwa tombol dapat diklik */
            transition: background-color 0.3s; /* Transisi warna latar belakang saat dihover */
        }

        .actions a .delete-button:hover {
            background-color: #c82333; /* Warna merah yang sedikit lebih gelap saat tombol "Hapus" dihover */
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: stretch;
            }
            .form-container, .table-container {
                max-width: 100%;
            }
            .actions a .delete-button, .actions a .edit-button {
                padding: 5px;
                font-size: 12px;
            }
            input[type="text"], input[type="file"], button {
                padding: 8px;
                font-size: 14px;
            }
            th, td {
                padding: 8px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            input[type="text"], input[type="file"], button {
                padding: 6px;
                font-size: 12px;
            }
            th, td {
                padding: 6px;
                font-size: 12px;
            }
            img {
                max-width: 80px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Form Kategori Kamar</h2>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?><?php echo $id ? '?edit=' . $id : ''; ?>">
            <label>Kategori</label>
            <input type="text" name="kategori" required value="<?php echo $kategori; ?>">
            <label>Harga</label>
            <input type="text" name="harga" required value="<?php echo $harga; ?>">
            <label>Gambar</label>
            <input type="file" name="gambar">
            <button type="submit">Simpan</button>
            <?php if ($id): ?>
                <a href="?cancel=<?php echo $id; ?>"><button type="button">Batal</button></a>
            <?php else: ?>
                <button type="reset">Batal</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Kamar</th>
                <th>Aksi</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $counter = 1; // Initialize counter variable
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>"; // Output counter value
                    echo "<td><img src='uploads/" . $row['image'] . "' width='100'></td>";
                    echo "<td>";
                    echo "Nama: " . $row['category'] . "<br>";
                    echo "Harga: " . formatRupiah($row['price']);
                    echo "</td>";
                    echo "<td class='actions'>";
                    echo "<a href='?edit=" . $row['id'] . "'><button class='edit-button'>Edit</button></a>";
                    echo "<a href='?delete=" . $row['id'] . "'><button class='delete-button'>Hapus</button></a>";
                    echo "</td>";
                    echo "</tr>";
                    $counter++; // Increment counter
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>

</section>
