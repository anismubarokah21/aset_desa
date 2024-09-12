<?php
include '../db.php';


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $delete_id = $_GET['id'];

    // Query untuk menghapus data
    $sql = "DELETE FROM asset_usage WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $delete_id);

    if ($stmt->execute()) {

        header("Location: usage.php");
        exit;
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
} else {
    echo "Akses tidak sah.";
    exit;
}
?>