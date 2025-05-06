<?php
$pdo = new PDO('mysql:host=localhost;dbname=theater_db;charset=utf8', 'root', '');

$sql = "
SELECT 
  MONTH(created_at) AS month, 
  SUM(total_price) AS revenue
FROM reservations
WHERE paid = 1 AND YEAR(created_at) = YEAR(CURRENT_DATE())
GROUP BY MONTH(created_at)
ORDER BY month
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Fill all months with 0 revenue if missing
$revenues = array_fill(1, 12, 0);
foreach ($rows as $month => $revenue) {
    $revenues[(int) $month] = (float) $revenue;
}

echo json_encode(array_values($revenues));
