<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah form disubmit dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $edit_id = $_POST['edit_id'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $nama_users = $_POST['nama_users'];
    $email_users = $_POST['email_users'];
    $no_kartus = $_POST['no_kartus'];
    $no_atm = $_POST['no_atm'];
    $tanggal_kdl = $_POST['tanggal_kdl'];
    $cvv = $_POST['cvv'];

    // Query untuk melakukan update data booking
    $stmt = $conn->prepare("UPDATE bookings SET category=?, price=?, nama_users=?, email_users=?, no_kartus=?, no_atm=?, tanggal_kdl=?, cvv=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $category, $price, $nama_users, $email_users, $no_kartus, $no_atm, $tanggal_kdl, $cvv, $edit_id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika update berhasil, redirect ke booking.php
        header("Location: booking.php");
        exit();
    } else {
        echo "Gagal melakukan update data.";
    }

    // Menutup statement dan koneksi database
    $stmt->close();
    $conn->close();
} else {
    // Jika bukan metode POST, redirect ke halaman lain atau tampilkan pesan kesalahan
    echo "Permintaan tidak valid.";
}
?>
