<?php

/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    if(!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
}

session_destroy();
setcookie("remember_me", "", time() - 3600, "/");

header("Location: ../index.php");
exit;