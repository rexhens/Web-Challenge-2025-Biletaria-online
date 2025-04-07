<?php

/** @var mysqli $conn */
require "../config/db_connect.php";
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $rememberToken = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE remember_token = ?");
    $stmt->bind_param("s", $rememberToken);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
    }

    $stmt->close();
}