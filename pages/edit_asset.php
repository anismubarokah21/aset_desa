<?php
include '../db.php';


if (isset($_POST['update']) && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $volume = $_POST['volume'];
    $ownership_proof = $_POST['ownership_proof'];
    $year_bought = $_POST['year_bought'];
    $acquisition_value = $_POST['acquisition_value'];
    $condition = $_POST['condition'];
    $responsible = $_POST['responsible'];
    $placement = $_POST['placement'];


$sql = "UPDATE asset_usage 
            SET code=?, name=?, brand=?, volume=?, ownership_proof=?, year_bought=?, acquisition_value=?, `condition`=?, responsible=?, placement=? 
            WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssi', $code, $name, $brand, $volume, $ownership_proof, $year_bought, $acquisition_value, $condition, $responsible, $placement, $edit_id);

    if ($stmt->execute()) {

        header("Location: usage.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $edit_id = $_GET['id'];


    $sql = "SELECT * FROM asset_usage WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $code = $row['code'];
        $name = $row['name'];
        $brand = $row['brand'];
        $volume = $row['volume'];
        $ownership_proof = $row['ownership_proof'];
        $year_bought = $row['year_bought'];
        $acquisition_value = $row['acquisition_value'];
        $condition = $row['condition'];
        $responsible = $row['responsible'];
        $placement = $row['placement'];
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "Akses tidak sah.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengadaan Aset</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Pengadaan Aset</h1>
        <form action="edit_asset.php" method="POST">
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($edit_id); ?>">
            
            <label for="code">Kode Aset:</label>
            <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($code); ?>" required>
            
            <label for="name">Nama Aset:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label for="brand">Merk:</label>
            <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($brand); ?>" required>
            
            <label for="volume">Volume:</label>
            <input type="text" id="volume" name="volume" value="<?php echo htmlspecialchars($volume); ?>" required>
            
            <label for="ownership_proof">Bukti Kepemilikan (No Kuitansi):</label>
            <input type="text" id="ownership_proof" name="ownership_proof" value="<?php echo htmlspecialchars($ownership_proof); ?>" required>
            
            <label for="year_bought">Tahun:</label>
            <input type="number" id="year_bought" name="year_bought" value="<?php echo htmlspecialchars($year_bought); ?>" min="1900" max="2100" required>
            
            <label for="acquisition_value">Nilai Perolehan (Harga):</label>
            <input type="number" id="acquisition_value" name="acquisition_value" value="<?php echo htmlspecialchars($acquisition_value); ?>" required>
            
            <label for="condition">Kondisi:</label>
            <select id="condition" name="condition" required>
                <option value="Baik" <?php if ($condition == 'Baik') echo 'selected'; ?>>Baik</option>
                <option value="RR" <?php if ($condition == 'RR') echo 'selected'; ?>>RR(Rusak Ringan)</option>
                <option value="RS" <?php if ($condition == 'RS') echo 'selected'; ?>>RS(Rusak Sedang)</option>
                <option value="RB" <?php if ($condition == 'RB') echo 'selected'; ?>>RB(Rusak Berat)</option>
            </select>
            
            <label for="responsible">Penanggung Jawab:</label>
            <input type="text" id="responsible" name="responsible" value="<?php echo htmlspecialchars($responsible); ?>" required>
            
            <label for="placement">Ruang Penempatan:</label>
            <input type="text" id="placement" name="placement" value="<?php echo htmlspecialchars($placement); ?>" required>
            
            <button type="submit" name="update">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>