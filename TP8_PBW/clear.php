<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'sistem_penerbangan');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Kosongkan tabel
if ($conn->query("TRUNCATE TABLE rute_penerbangan")) {
    echo "<div style='text-align:center;padding:20px;'>
            <h1>Data berhasil dihapus</h1>
            <a href='index.php' style='padding:10px 15px;background:#4CAF50;color:white;text-decoration:none;border-radius:4px;'>Kembali ke Form</a>
          </div>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>