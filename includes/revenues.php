<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection
$host = 'metropolticketing.marketingelite.eu';
$db = 'theater_db';
$user = 'marketingelite';
$pass = 'ndgcFAGTtnqW3Uz';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? 'monthly';

if ($action === 'yearly') {
    echo json_encode(getYearlyRevenue($pdo));
} else {
    echo json_encode(getMonthlyRevenue($pdo));
}

function getMonthlyRevenue($pdo): float
{
    $sql = "
        SELECT SUM(s.price) AS revenue
        FROM tickets t
        JOIN reservations r ON t.reservation_id = r.id
        JOIN shows s ON r.show_id = s.id
        WHERE MONTH(t.created_at) = MONTH(CURRENT_DATE())
          AND YEAR(t.created_at) = YEAR(CURRENT_DATE())
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (float) $stmt->fetchColumn();
}

function getYearlyRevenue($pdo): float
{
    $sql = "
        SELECT SUM(s.price) AS revenue
        FROM tickets t
        JOIN reservations r ON t.reservation_id = r.id
        JOIN shows s ON r.show_id = s.id
        WHERE YEAR(t.created_at) = YEAR(CURRENT_DATE())
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (float) $stmt->fetchColumn();
}
