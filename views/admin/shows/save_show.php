<?php
require_once '../../../config/db_connect.php';

header('Content-Type: application/json'); // Ensure the response is JSON

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
            $show_id = $conn->insert_id; // Get the last inserted ID

            // Return a JSON response with success and the inserted show ID
            echo json_encode([
                'success' => true,
                'show_id' => $show_id
            ]);
        } else {
            // Log error for debugging
            error_log("Error executing query: " . $stmt->error);

            // Return an error response if insertion fails
            echo json_encode([
                'success' => false,
                'message' => 'Error adding show!'
            ]);
        }
        $stmt->close();
    } else {
        // Log error for debugging
        error_log("Database error: " . $conn->error);

        // Return a database error response
        echo json_encode([
            'success' => false,
            'message' => 'Database error!'
        ]);
    }

    $conn->close();
}
?>