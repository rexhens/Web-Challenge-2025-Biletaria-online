<?php
// Include DB configuration
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';

// Validate and get the ID
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (is_numeric($id)) {
        // Prepare delete statement
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Optional: redirect with success
            header("Location: index.php?status=deleted");
            exit();
        } else {
            echo "Error deleting review: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid ID.";
    }
} else {
    echo "No ID received.";
}

$conn->close();
?>