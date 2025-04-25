<?php
require_once '../../../config/db_connect.php';

// Check if the 'id' parameter is set in the URL
if (isset($_POST['id'])) {
    // Get the actor ID from the URL
    $actor_id = $_POST['id'];

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM actors WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the ID parameter to the query
    $stmt->bind_param("i", $actor_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the actors list page after successful deletion
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error: ID not specified.";
}
?>