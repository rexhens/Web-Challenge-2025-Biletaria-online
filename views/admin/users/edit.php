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
        showError("Të dhënat mungojnë!");
    }

    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $emri)) {
        showError("Emri nuk është i vlefshëm.");
    }
    if (!preg_match('/^[a-zA-ZëËçÇ ]+$/', $mbiemri)) {
        showError("Mbiemri nuk është i vlefshëm.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError("Email-i nuk është i vlefshëm.");
    }
    if (!preg_match('/^\+?[0-9\s\-\(\)]+$/', $telefon)) {
        showError("Numri i telefonit nuk është i vlefshëm.");
    }

    $sql = "UPDATE users SET name = ?, surname = ?, email = ?, phone = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $emri, $mbiemri, $email, $telefon, $roli, $userId);


    if ($stmt->execute()) {
        header("Location: index.php?update=success");
        exit;
    } else {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
} else {
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}