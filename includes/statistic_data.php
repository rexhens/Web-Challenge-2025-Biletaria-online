<?php
$pdo = new PDO('mysql:host=metropolticketing.marketingelite.eu;dbname=theater_db;charset=utf8', 'marketingelite', 'ndgcFAGTtnqW3Uz');

$sql = "
SELECT 
  MONTH(t.created_at) AS month, 
  SUM(s.price) AS revenue
FROM tickets t
JOIN reservations r ON t.reservation_id = r.id
JOIN shows s ON r.show_id = s.id
GROUP BY MONTH(t.created_at)
ORDER BY month
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // [month => revenue]

// Fill all months with 0 revenue if missing
$revenues = array_fill(1, 12, 0);
foreach ($rows as $month => $revenue) {
    $revenues[(int) $month] = (float) $revenue;
}

echo json_encode(array_values($revenues));
