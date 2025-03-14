<?php
require_once '../../../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $birthdate = $_POST['birthdate'];
    $biography = $_POST['biography'];

    // Check if file is uploaded
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] != 0) {
        die("Error: No file uploaded or file upload error.");
    }

    // Read the image as binary data
    $image = file_get_contents($_FILES['photo']['tmp_name']);

    // Fix the SQL query by correctly adding 4 values
    $sql = "INSERT INTO actors (name, birthdate, biography, photo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssb", $name, $birthdate, $biography, $null);
    $stmt->send_long_data(3, $image); // Send BLOB data

    if ($stmt->execute()) {
        header(header: 'Location: index.php'); // Redirect to actors list
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<form method="post" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Birthdate: <input type="date" name="birthdate" required><br>
    Biography: <textarea name="biography" required></textarea><br>
    Photo: <input type="file" name="photo" accept="image/*" required><br>
    <input type="submit" value="Add Actor">
</form>