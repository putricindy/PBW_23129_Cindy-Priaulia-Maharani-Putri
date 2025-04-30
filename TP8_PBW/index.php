<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Rute Penerbangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], 
        input[type="number"], 
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        hr {
            border: 0;
            height: 1px;
            background: #ddd;
            margin: 20px 0;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pendaftaran Rute Penerbangan</h1>
        
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="nama_penumpang">Nama Penumpang:</label>
                <input type="text" id="nama_penumpang" name="nama_penumpang" required>
            </div>
            
            <div class="form-group">
                <label for="nama_maskapai">Nama Maskapai:</label>
                <input type="text" id="nama_maskapai" name="nama_maskapai" required>
            </div>
            
            <div class="form-group">
                <label for="jumlah_tiket">Jumlah Tiket:</label>
                <input type="number" id="jumlah_tiket" name="jumlah_tiket" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="bandara_asal">Bandara Asal:</label>
                <select id="bandara_asal" name="bandara_asal" required>
                    <option value="">Pilih Bandara Asal</option>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'sistem_penerbangan');
                    if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
                    
                    $result = $conn->query("SELECT * FROM pajak_bandara");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['kode_bandara']}'>{$row['nama_bandara']}</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="bandara_tujuan">Bandara Tujuan:</label>
                <select id="bandara_tujuan" name="bandara_tujuan" required>
                    <option value="">Pilih Bandara Tujuan</option>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'sistem_penerbangan');
                    if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
                    
                    $result = $conn->query("SELECT * FROM pajak_bandara");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['kode_bandara']}'>{$row['nama_bandara']}</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="harga_tiket">Harga Tiket (Rp):</label>
                <input type="number" id="harga_tiket" name="harga_tiket" min="0" required>
            </div>
            
            <hr>
            
            <div class="form-group">
                <button type="submit">Proses Pendaftaran</button>
            </div>
        </form>
    </div>
</body>
</html>