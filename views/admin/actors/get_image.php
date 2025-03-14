<?php
require_once '../config/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer
    $sql = "SELECT photo FROM actors WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($photo);
    $stmt->fetch();

    if ($photo) {
        header("Content-Type: image/jpeg"); // Adjust based on the image type (jpeg, png, etc.)
        echo $photo;
    } else {
        echo "No image found.";
    }
}
?>
