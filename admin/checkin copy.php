<?php
// Include file header.php untuk bagian header
require 'header.php';

// Include file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Proses delete jika parameter id tersedia
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data berdasarkan id
    $sql = "DELETE FROM checkin WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Query untuk menampilkan data checkin
$sql = "SELECT * FROM checkin";
$result = $conn->query($sql);
?>
<section class="home-section">
    <div class="text">Check-in Data</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Check-in Date</th>
            <th>Adults</th>
            <th>Children</th>
            <th>Action</th> <!-- Kolom untuk action delete -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $counter = 1;
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Format the date from YYYY-MM-DD to DD Month YYYY
                $formatted_date = date('d F Y', strtotime($row["checkin"]));
                
                echo "<tr>
                        <td>" . $counter . "</td>
                        <td>" . $formatted_date . "</td>
                        <td>" . $row["dewasa"] . "</td>
                        <td>" . $row["anak"] . "</td>
                        <td><a href='?action=delete&id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda Yakin?\")'>Delete</a></td>
                    </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</section>

<?php
// Include file footer.php untuk bagian footer
require 'footer.php';
?>

<style>
    table {
        max-width: 800px;
        width: 100%;
        border-collapse: collapse;
        margin-left: 40px;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
