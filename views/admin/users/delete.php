<?php
include_once '../../../config/db_connect.php';

if (isset($_POST['deleteUserSubmit'])) {
    $userId = $_POST['userId'];

    // make sure $conn is your db connection
    $stmt = $conn->prepare("UPDATE users SET status = 'not active' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: index.php?delete=success");
        exit;
    } else {
        echo "Gabim gjatë fshirjes: " . $stmt->error;
    }
}
?>