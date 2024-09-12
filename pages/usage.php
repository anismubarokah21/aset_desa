<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Ambil data dari form dan sanitasi
    $code = mysqli_real_escape_string($conn, $_POST['code']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $volume = mysqli_real_escape_string($conn, $_POST['volume']);
    $ownership_proof = mysqli_real_escape_string($conn, $_POST['ownership_proof']);
    $year_bought = mysqli_real_escape_string($conn, $_POST['year_bought']);
    $acquisition_value = mysqli_real_escape_string($conn, $_POST['acquisition_value']);
    $condition = mysqli_real_escape_string($conn, $_POST['condition']);
    $responsible = mysqli_real_escape_string($conn, $_POST['responsible']);
    $placement = mysqli_real_escape_string($conn, $_POST['placement']);

    // Query untuk memasukkan data ke dalam tabel asset_usage
    $sql = "INSERT INTO asset_usage (code, name, brand, volume, ownership_proof, year_bought, acquisition_value, `condition`, responsible, placement) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssss', $code, $name, $brand, $volume, $ownership_proof, $year_bought, $acquisition_value, $condition, $responsible, $placement);

    if ($stmt->execute()) {
        echo "Penggunaan aset berhasil dicatat.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengadaan Aset</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="usage.php">Pengadaan Aset</a></li>
            <li><a href="employees.php">Karyawan</a></li>
        </ul>
    </nav>
    <div class="container">
        <h1>Pengadaan Aset</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="code">Kode Aset:</label>
            <input type="text" id="code" name="code" required>
            
            <label for="name">Nama Aset:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="brand">Merk:</label>
            <input type="text" id="brand" name="brand" required>
            
            <label for="volume">Volume:</label>
            <input type="text" id="volume" name="volume" required>
            
            <label for="ownership_proof">Bukti Kepemilikan (No Kuitansi):</label>
            <input type="text" id="ownership_proof" name="ownership_proof" required>
            
            <label for="year_bought">Tahun:</label>
            <input type="number" id="year_bought" name="year_bought" min="1900" max="2100" required>
            
            <label for="acquisition_value">Nilai Perolehan (Harga):</label>
            <input type="number" id="acquisition_value" name="acquisition_value" required>
            
            <label for="condition">Kondisi:</label>
            <select id="condition" name="condition" required>
                <option value="Baik">Baik</option>
                <option value="RR">RR (Rusak Ringan)</option>
                <option value="RS">RS (Rusak Sedang)</option>
                <option value="RB">RB (Rusak Berat)</option>
            </select>
            
            <label for="responsible">Penanggung Jawab:</label>
            <input type="text" id="responsible" name="responsible" required>
            
            <label for="placement">Ruang Penempatan:</label>
            <input type="text" id="placement" name="placement" required>
            
            <button type="submit" name="submit">Catat Pengadaan Asset</button>
        </form>

        <!-- Tombol untuk mengunduh PDF -->
        <form action="../pages/generate_pdf.php" method="POST">
            <input type="submit" value="Unduh PDF Asset">
        </form>

        <?php
        // Query untuk mengambil data dari tabel asset_usage
        $sql = "SELECT * FROM asset_usage";
        $result = $conn->query($sql);

        // Jika ada data, tampilkan dalam tabel
        if ($result->num_rows > 0) {
            echo "<h2>Data Pengadaan Aset:</h2>";
            echo "<table>";
            echo "<tr>
                    <th>Kode Aset</th>
                    <th>Nama Aset</th>
                    <th>Merk</th>
                    <th>Volume</th>
                    <th>Bukti Kepemilikan</th>
                    <th>Tahun</th>
                    <th>Harga</th>
                    <th>Kondisi</th>
                    <th>Penanggung Jawab</th>
                    <th>Ruang Penempatan</th>
                    <th>Aksi</th>
                  </tr>";
            
            // Output data dari setiap baris
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['code']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                echo "<td>" . htmlspecialchars($row['volume']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ownership_proof']) . "</td>";
                echo "<td>" . htmlspecialchars($row['year_bought']) . "</td>";
                echo "<td>" . htmlspecialchars($row['acquisition_value']) . "</td>";
                echo "<td>" . htmlspecialchars($row['condition']) . "</td>";
                echo "<td>" . htmlspecialchars($row['responsible']) . "</td>";
                echo "<td>" . htmlspecialchars($row['placement']) . "</td>";
                echo "<td>
                        <a href='edit_asset.php?id=" . htmlspecialchars($row['id']) . "'>Edit</a> |
                        <a href='delete_asset.php?id=" . htmlspecialchars($row['id']) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    </td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Belum ada data pengadaan aset.";
        }
        ?>
    </div>
    <script src="../js/scripts.js"></script>
</body>
</html>