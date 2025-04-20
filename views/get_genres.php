<?php
/** @var mysqli $conn */
require_once '../config/db_connect.php';

header('Content-Type: application/json');

$sql = "SELECT id, genre_name FROM genres";
$result = $conn->query($sql);

$genres = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }
}

echo json_encode($genres);
$conn->close();