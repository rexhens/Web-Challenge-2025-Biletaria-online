<?php
include_once '../../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actor_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $birthdate = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';

    echo "Actor ID: " . $actor_id . "<br>";
    echo "Name: " . $name . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Description: " . $description . "<br>";
    echo "Birthday: " . $birthdate . "<br>";

    try {
        if ($actor_id) {
            // Update existing actor
            $query = "UPDATE actors SET name = ?, email = ?, description = ?, birthday = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssi', $name, $email, $description, $birthdate, $actor_id);
        } else {
            // Insert new actor
            $query = "INSERT INTO actors (name, email, description, birthday) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssss', $name, $email, $description, $birthdate);
        }

        if ($stmt->execute()) {
            echo "Actor saved successfully.";
            header("Location: /biletaria_online/views/admin/actors/index.php");
            exit();
        } else {
            echo "Failed to save actor.";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>