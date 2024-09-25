<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $price = $_POST['price'];
    $nama_users = $_POST['nama_users'];
    $email_users = $_POST['email_users'];
    $no_kartus = $_POST['no_kartus'];
    $no_atm = $_POST['no_atm'];
    $tanggal_kdl = $_POST['tanggal_kdl'];
    $cvv = $_POST['cvv'];

    $sql = "INSERT INTO bookings (category, price, nama_users, email_users, no_kartus, no_atm, tanggal_kdl, cvv)
    VALUES ('$category', '$price', '$nama_users', '$email_users', '$no_kartus', '$no_atm', '$tanggal_kdl', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        $response = array("success" => true);
    } else {
        $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
    }

    $conn->close();

    echo json_encode($response);
}
?>
