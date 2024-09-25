<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edit_id = $_POST['edit_id'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $jml_bayar = $_POST['jml_bayar'];
    $tanggal_bayar = date('Y-m-d', strtotime($_POST['tanggal_bayar']));
    $metode_bayar = $_POST['metode_bayar'];
    $status_bayar = $_POST['status_bayar'];

    $sql_update = "UPDATE pembayaran SET nama_pemilik='$nama_pemilik', jml_bayar='$jml_bayar', tanggal_bayar='$tanggal_bayar', metode_bayar='$metode_bayar', status_bayar='$status_bayar' WHERE id=$edit_id";

    if ($conn->query($sql_update) === TRUE) {
        // Redirect or refresh to update the table
        header('Location: proses_bayar.php');
        exit;
    } else {
        echo "Kesalahan mengupdate data: " . $conn->error;
    }
}

$conn->close();
?>
