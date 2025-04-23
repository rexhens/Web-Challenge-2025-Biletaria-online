<?php
include_once '../../../config/db_connect.php';

if (isset($_POST['activateUserSubmit'])) {
    $userId = $_POST['userId'];

    // make sure $conn is your db connection
    $stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: index.php?activate=success");
        exit;
    } else {
        echo "Gabim gjatë fshirjes: " . $stmt->error;
    }
}
?>