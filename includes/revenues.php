<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'theater_db';
$user = 'root';
$pass = 'toor1';

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
    SELECT SUM(total_price) AS revenue
    FROM reservations
    WHERE paid = 1
      AND MONTH(created_at) = MONTH(CURRENT_DATE())
      AND YEAR(created_at) = YEAR(CURRENT_DATE())
";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (float) $stmt->fetchColumn();
}

function getYearlyRevenue($pdo): float
{
    $sql = "
    SELECT SUM(total_price) AS revenue
    FROM reservations
    WHERE paid = 1
      AND YEAR(created_at) = YEAR(CURRENT_DATE())
";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (float) $stmt->fetchColumn();
}
