<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-user'])) {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $telefon = $_POST['telefoni'];
    $roli = $_POST['roli'];

    $userId = $_POST['userId'];

    if(empty($emri) || empty($mbiemri) || empty($email) || empty($telefon) || empty($roli) || empty($userId)) {
        $message = "Të dhënat mungojnë!";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }

    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $emri)) {
        $message = "Emri nuk është i vlefshëm.";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $mbiemri)) {
        $message = "Mbiemri nuk është i vlefshëm.";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email-i nuk është i vlefshëm.";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
    if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $telefon)) {
        $message = "Numri i telefonit nuk është i vlefshëm.";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }

    $sql = "UPDATE users SET name = ?, surname = ?, email = ?, phone = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $emri, $mbiemri, $email, $telefon, $roli, $userId);


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