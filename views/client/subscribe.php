<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();

header('Content-Type: application/json');

$userId = $_SESSION['user_id'];
$isSub = isSubscriber($conn, $userId);
$newStatus = $isSub ? 0 : 1;

$stmt = $conn->prepare("UPDATE users SET subscribe = ? WHERE id = ?");
$stmt->bind_param('ii', $newStatus, $userId);
$stmt->execute();

echo json_encode([
    'subscribed' => !$isSub
]);