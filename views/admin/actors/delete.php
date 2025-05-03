<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

if (isset($_POST['id'])) {
    $actor_id = $_POST['id'];

    $sql = "DELETE FROM actors WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $actor_id);

    if (!deletePoster($conn, "actors", $actor_id)) {
        showError("Portreti nuk u fshi!");
    }

    if ($stmt->execute()) {
        header('Location: index.php?update=success');
        exit();
    } else {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
} else {
    showError("Nuk ka informacion mbi të dhënat që duhen fshirë!");
}