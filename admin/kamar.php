<?php
// Memasukkan file header dan footer
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

// Bagian utama dari halaman (section)
echo '<section class="home-section">';

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Menangani koneksi yang gagal
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani pengiriman formulir
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_tempat = $_POST['nama_tempat'];
    $galeri_foto = $_FILES['galeri_foto']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["galeri_foto"]["name"]);
    $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : null;

    if ($galeri_foto) {
        // Mengupload file
        if (move_uploaded_file($_FILES["galeri_foto"]["tmp_name"], $target_file)) {
            if ($edit_id) {
                $sql = "UPDATE galeri SET galeri_foto='$galeri_foto', nama_tempat='$nama_tempat' WHERE id=$edit_id";
            } else {
                $sql = "INSERT INTO galeri (galeri_foto, nama_tempat) VALUES ('$galeri_foto', '$nama_tempat')";
            }

            if ($conn->query($sql) === TRUE) {
                echo "Data berhasil disimpan";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengupload file.";
        }
    } else {
        if ($edit_id) {
            $sql = "UPDATE galeri SET nama_tempat='$nama_tempat' WHERE id=$edit_id";

            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Silakan pilih file gambar.";
        }
    }
}

// Menangani penghapusan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM galeri WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error saat menghapus data: " . $conn->error;
    }
}

// Menangani edit
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_sql = "SELECT * FROM galeri WHERE id=$edit_id";
    $edit_result = $conn->query($edit_sql);
    if ($edit_result->num_rows > 0) {
        $edit_row = $edit_result->fetch_assoc();
        $edit_nama_tempat = $edit_row['nama_tempat'];
    }
}

// Menangani pembatalan edit
if (isset($_GET['cancel'])) {
    unset($edit_id);
    unset($edit_nama_tempat);
}

// Mengambil data
$sql = "SELECT * FROM galeri";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Galeri Hotel</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            background: #E4E9F7;
           
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .form-container, .table-container {
            flex: 1 1 45%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        
        }
        .form-container{
            height: 320px;
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
            padding: 8px;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease;
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
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .actions a .delete-button:hover {
            background-color: #c82333;
        }

        /* Media queries for responsiveness */
        @media (max-width: 720px) {
            .form-container, .table-container {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Form Galeri Hotel</h2>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if (isset($edit_id)) : ?>
                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>
            <label>Nama Tempat</label>
            <input type="text" name="nama_tempat" required value="<?php echo isset($edit_nama_tempat) ? $edit_nama_tempat : ''; ?>">
            <label>Gambar</label>
            <input type="file" name="galeri_foto">
            <?php if (isset($edit_gambar)) : ?>
                <img src="uploads/<?php echo $edit_gambar; ?>" width="100">
            <?php endif; ?>
            <button type="submit">Simpan</button>
            <?php if (isset($edit_id)) : ?>
                <a href="?cancel=<?php echo $edit_id; ?>"><button type="button">Batal</button></a>
            <?php else : ?>
                <button type="reset">Batal</button>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Tempat</th>
                <th>Aksi</th>
            </tr>
            <?php
                if ($result->num_rows > 0) {
                    $counter = 1; // Initialize counter variable
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $counter . "</td>"; // Output counter value
                        echo "<td><img src='uploads/" . $row['galeri_foto'] . "' width='100'></td>";
                        echo "<td>";
                        echo $row['nama_tempat'];
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
