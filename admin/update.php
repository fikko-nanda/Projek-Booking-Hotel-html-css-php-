<?php
// Include file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $jumlah_orang = $_POST['jumlah_orang'];
    $nama_pemesan = $_POST['nama_pemesan'];
    
    // Query untuk melakukan update data
    $sql = "UPDATE checkin SET checkin='$checkin_date',checkout='$checkout_date', dewasa='$jumlah_orang', nama_users='$nama_pemesan' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect kembali ke halaman checkin.php setelah update berhasil
        header("Location: checkin.php");
        exit; // Pastikan untuk keluar dari script setelah header redirect
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}
?>
