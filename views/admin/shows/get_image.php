<?php
require_once '../../../config/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT poster FROM shows WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    header("Content-Type: image/jpeg");
    echo $poster;
}
?>
