<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'sistem_penerbangan');
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

// Ambil data dari form
$nama_penumpang = $conn->real_escape_string($_POST['nama_penumpang']);
$nama_maskapai = $conn->real_escape_string($_POST['nama_maskapai']);
$jumlah_tiket = (int)$_POST['jumlah_tiket'];
$bandara_asal = $conn->real_escape_string($_POST['bandara_asal']);
$bandara_tujuan = $conn->real_escape_string($_POST['bandara_tujuan']);
$harga_tiket = (int)$_POST['harga_tiket'];

// Ambil data pajak bandara
$pajak_asal = $conn->query("SELECT nama_bandara, pajak FROM pajak_bandara WHERE kode_bandara = '$bandara_asal'")->fetch_assoc();
$pajak_tujuan = $conn->query("SELECT nama_bandara, pajak FROM pajak_bandara WHERE kode_bandara = '$bandara_tujuan'")->fetch_assoc();

// Hitung total
$total_pajak = ($pajak_asal['pajak'] + $pajak_tujuan['pajak']) * $jumlah_tiket;
$total_harga = ($harga_tiket * $jumlah_tiket) + $total_pajak;

// Simpan ke database
$sql = "INSERT INTO rute_penerbangan (nama_penumpang, nama_maskapai, jumlah_tiket, bandara_asal, bandara_tujuan, harga_tiket, pajak, total_harga) 
        VALUES ('$nama_penumpang', '$nama_maskapai', $jumlah_tiket, '{$pajak_asal['nama_bandara']}', '{$pajak_tujuan['nama_bandara']}', $harga_tiket, $total_pajak, $total_harga)";

if ($conn->query($sql) === TRUE) {
    // Tampilkan hasil
    $tanggal = date('d-m-Y H:i:s');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hasil Pendaftaran</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 20px;
                background-color: #f5f5f5;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            h1, h2, h3 {
                color: #333;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #f2f2f2;
            }
            .action-buttons {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
            }
            .btn {
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                text-decoration: none;
                display: inline-block;
            }
            .btn-back {
                background-color: #4CAF50;
                color: white;
            }
            .btn-clear {
                background-color: #f44336;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Hasil Pendaftaran Rute Penerbangan</h1>
            <h2>Detail Penerbangan</h2>
            
            <h3>Atas Nama: <?php echo htmlspecialchars($nama_penumpang); ?></h3>
            
            <table>
                <tr>
                    <th>Nama Maskapai</th>
                    <td><?php echo htmlspecialchars($nama_maskapai); ?></td>
                </tr>
                <tr>
                    <th>Jumlah Tiket</th>
                    <td><?php echo $jumlah_tiket; ?></td>
                </tr>
                <tr>
                    <th>Asal Penerbangan</th>
                    <td><?php echo htmlspecialchars($pajak_asal['nama_bandara']); ?></td>
                </tr>
                <tr>
                    <th>Tujuan Penerbangan</th>
                    <td><?php echo htmlspecialchars($pajak_tujuan['nama_bandara']); ?></td>
                </tr>
                <tr>
                    <th>Harga Tiket (per tiket)</th>
                    <td>Rp <?php echo number_format($harga_tiket, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Total Harga Tiket</th>
                    <td>Rp <?php echo number_format($harga_tiket * $jumlah_tiket, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Total Pajak</th>
                    <td>Rp <?php echo number_format($total_pajak, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <th>Total Harga</th>
                    <td>Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                </tr>
            </table>
            
            <h2>Detail Pajak</h2>
            <table>
                <tr>
                    <th>Bandara</th>
                    <th>Pajak (per tiket)</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($pajak_asal['nama_bandara']); ?></td>
                    <td>Rp <?php echo number_format($pajak_asal['pajak'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($pajak_asal['pajak'] * $jumlah_tiket, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($pajak_tujuan['nama_bandara']); ?></td>
                    <td>Rp <?php echo number_format($pajak_tujuan['pajak'], 0, ',', '.'); ?></td>
                    <td>Rp <?php echo number_format($pajak_tujuan['pajak'] * $jumlah_tiket, 0, ',', '.'); ?></td>
                </tr>
            </table>
            
            <p>Tanggal pendaftaran: <?php echo $tanggal; ?></p>
            
            <hr>
            
            <div class="action-buttons">
                <a href="index.php" class="btn btn-back">Kembali ke Form Pendaftaran</a>
                <a href="clear.php" class="btn btn-clear">Bersihkan Data</a>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>