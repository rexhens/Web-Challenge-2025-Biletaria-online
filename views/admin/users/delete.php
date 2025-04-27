<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if (isset($_POST['deleteUserSubmit'])) {
    $userId = $_POST['userId'];

    if(empty($userId)) {
        showError("Mungojnë të dhëna!");
    }

    $stmt = $conn->prepare("UPDATE users SET status = 'not active' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: index.php?update=success");
        exit;
    } else {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
} else {
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}