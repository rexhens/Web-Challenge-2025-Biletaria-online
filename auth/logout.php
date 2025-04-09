<?php

/** @var mysqli $conn */
require "../config/db_connect.php";
session_start();

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE users SET remember_token = NULL WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

session_destroy();
setcookie("remember_me", "", time() - 3600, "/");

header("Location: ../index.php");
exit;