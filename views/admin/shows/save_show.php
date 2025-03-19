<?php
require_once '../../../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $hall = $_POST["hall"];
    $genre_id = $_POST["genre_id"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $description = $_POST["description"];

    // Check if a file was uploaded
    if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == 0) {
        $poster = file_get_contents($_FILES["poster"]["tmp_name"]); // Read file content
    } else {
        $poster = null; // No file uploaded
    }

    // Prepare SQL query
    $sql = "INSERT INTO shows (title, hall, genre_id, start_date, end_date, description, poster1) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssisssb", $title, $hall, $genre_id, $start_date, $end_date, $description, $poster);

        if ($stmt->execute()) {
            echo "<script>alert('Show added successfully!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error adding show!'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error!'); window.history.back();</script>";
    }

    $conn->close();
}
?>