<?php
header('Content-Type: application/json');

// Include database connection
$conn = new mysqli("localhost", "username", "password", "database");
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

function countOnlineReservations(mysqli $conn): int
{
    $sql = "
        SELECT COUNT(*) AS total
        FROM reservations r
        JOIN users u ON r.email = u.email
        WHERE r.paid != 0
        AND u.role NOT IN ('admin', 'ticketOffice')
    ";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return (int) $row['total'];
    } else {
        return 0;
    }
}

echo json_encode(['count' => countOnlineReservations($conn)]);
$conn->close();
