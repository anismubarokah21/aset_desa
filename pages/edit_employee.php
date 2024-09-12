<?php
include('../db.php');

// koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$employee = null;

// Pembaruan data
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $position = $conn->real_escape_string($_POST['position']);
    $address = $conn->real_escape_string($_POST['address']);
    $birth_details = $conn->real_escape_string($_POST['birth_details']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $sk_number = $conn->real_escape_string($_POST['sk_number']);
    $tmt = $conn->real_escape_string($_POST['tmt']);

    $sql = "UPDATE employees SET name='$name', position='$position', address='$address', birth_details='$birth_details', contact='$contact', sk_number='$sk_number', tmt='$tmt' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: employees.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data karyawan untuk ditampilkan di form
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM employees WHERE id = $id");
    
    if ($result && $result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Data karyawan tidak ditemukan untuk ID: $id";
        exit();
    }
} else {
    echo "ID tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan</title>
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
        <h1>Edit Karyawan</h1>
        <form action="edit_employee.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($employee['id']); ?>">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>

            <label for="position">Posisi:</label>
            <input type="text" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
            
            <label for="address">Alamat:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>" required>
            
            <label for="birth_details">Tempat, Tanggal Lahir:</label>
            <input type="text" id="birth_details" name="birth_details" value="<?php echo htmlspecialchars($employee['birth_details']); ?>" required>
            
            <label for="contact">Kontak:</label>
            <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($employee['contact']); ?>" required>
            
            <label for="sk_number">Nomor SK:</label>
            <input type="text" id="sk_number" name="sk_number" value="<?php echo htmlspecialchars($employee['sk_number']); ?>" required>
            
            <label for="tmt">TMT:</label>
            <input type="text" id="tmt" name="tmt" value="<?php echo htmlspecialchars($employee['tmt']); ?>" required>
            
            <button type="submit" name="update">Update Karyawan</button>
        </form>
    </div>
</body>
</html>