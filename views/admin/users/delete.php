<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

if (isset($_POST['deleteUserSubmit'])) {
    $userId = $_POST['userId'];

    if(empty($userId)) {
        $message = "Mungojnë të dhëna!";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET status = 'not active' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: index.php?update=success");
        exit;
    } else {
        $message = "Një problem ndodhi! Provoni më vonë!";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
} else {
    $message = "Nuk ka informacion mbi të dhënat që duhen update-uar!";
    $encodedMessage = urlencode($message);
    header('Location: index.php?update=error&message=' . $encodedMessage);
    exit();
}