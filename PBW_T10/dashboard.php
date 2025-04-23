<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Fungsi CRUD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        $kode = $_POST['kode_barang'];
        $nama = $_POST['nama_barang'];
        $alamat = $_POST['alamat'];
        
        $stmt = $conn->prepare("INSERT INTO barang (kode_barang, nama_barang, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $kode, $nama, $alamat);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $kode = $_POST['kode_barang'];
        $nama = $_POST['nama_barang'];
        $alamat = $_POST['alamat'];
        
        $stmt = $conn->prepare("UPDATE barang SET kode_barang=?, nama_barang=?, alamat=? WHERE id=?");
        $stmt->bind_param("sssi", $kode, $nama, $alamat, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        
        $stmt = $conn->prepare("DELETE FROM barang WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

// Ambil data barang
$barang = $conn->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">

</head>


<body>
    <h1>Data Barang</h1>
    <p>Selamat datang, <?php echo $_SESSION['username']; ?>! <a href="logout.php">Logout</a></p>
    
    <div class="form-container">
        <h2>Input Data Barang</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" id="id">
            <label for="kode_barang">Kode Barang:</label>
            <input type="text" id="kode_barang" name="kode_barang" required>
            
            <label for="nama_barang">Nama Barang:</label>
            <input type="text" id="nama_barang" name="nama_barang" required>
            
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" required>
            
            <div class="action-buttons">
                <button type="submit" name="insert">Insert</button>
                <button type="submit" name="update">Update</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>
    
    <div class="table-container">
        <h2>Daftar Barang</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $barang->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['kode_barang']; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="kode_barang" value="<?php echo $row['kode_barang']; ?>">
                            <input type="hidden" name="nama_barang" value="<?php echo $row['nama_barang']; ?>">
                            <input type="hidden" name="alamat" value="<?php echo $row['alamat']; ?>">
                            <button type="submit" name="edit">Edit</button>
                            <button type="submit" name="delete" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk mengisi form saat tombol edit diklik
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form[method="POST"]');
            forms.forEach(form => {
                if (form.querySelector('button[name="edit"]')) {
                    form.querySelector('button[name="edit"]').addEventListener('click', function(e) {
                        e.preventDefault();
                        const formData = new FormData(form);
                        
                        document.getElementById('id').value = formData.get('id');
                        document.getElementById('kode_barang').value = formData.get('kode_barang');
                        document.getElementById('nama_barang').value = formData.get('nama_barang');
                        document.getElementById('alamat').value = formData.get('alamat');
                    });
                }
            });
        });
    </script>
</body>
</html>