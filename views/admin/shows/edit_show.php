<?php
include_once '../../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['show_id'];
    $title = $_POST['title'];
    $hall = $_POST['hall'];
    $genre_id = $_POST['genre_id'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $trailer = $_POST['trailer'];
    $price = $_POST['price'];

    // Optional poster upload
    $posterUpdated = false;
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $posterTmp = $_FILES['poster']['tmp_name'];
        $posterName = basename($_FILES['poster']['name']);
        $posterPath = 'uploads/' . uniqid() . '_' . $posterName;
        move_uploaded_file($posterTmp, $posterPath);
        $posterUpdated = true;
    }

    // Update query
    $sql = "UPDATE shows SET 
        title = ?, 
        hall = ?, 
        genre_id = ?, 
        time = ?, 
        description = ?, 
        trailer = ?, 
        price = ?";

    if ($posterUpdated) {
        $sql .= ", poster = ?";
    }

    $sql .= " WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($posterUpdated) {
        mysqli_stmt_bind_param($stmt, 'ssisssssi', $title, $hall, $genre_id, $time, $description, $trailer, $price, $posterPath, $id);
    } else {
        mysqli_stmt_bind_param($stmt, 'ssissssi', $title, $hall, $genre_id, $time, $description, $trailer, $price, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?update=success');
        exit();
    } else {
        echo "Gabim gjatë përditësimit: " . mysqli_error($conn);
    }
}
?>