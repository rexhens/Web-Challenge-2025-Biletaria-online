<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$sql = "
SELECT r.*,
       COALESCE(s.title, e.title) AS title
FROM reservations r
LEFT JOIN shows s ON r.show_id = s.id
LEFT JOIN events e ON r.event_id = e.id
WHERE CONCAT(r.show_date, ' ', r.show_time) < (NOW() - INTERVAL 3 HOUR)
AND r.id NOT IN (
    SELECT n.reservation_id
    FROM notifications n
);
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    $subject = 'Jepni opinionin tuaj!';
    $type = $row['show_id'] ? 'shfaqjen' : 'eventin';
    $body = "<h2>Na tregoni mendimin tuaj për $type \"{$row['title']}\"</h2>
             <p>Për të bërë një vlerësim dhe për të lënë komentin tuaj mund te plotesoni formularin që gjendet në linkun e mëposhtëm</p>
             <br>";
    $email = $row['email'];
    if(!empty($row['show_id'])) {
        $show_id = $row['show_id'];
        $reservation_id = $row['id'];
        $body .= "<a href='http://localhost/biletaria_online/views/client/reviews/index.php?show_id=$show_id&res=$reservation_id'>Kliko këtu</a>";
    } else if(!empty($row['event_id'])) {
        $event_id = $row['event_id'];
        $body .= "<a href='http://localhost/biletaria_online/views/client/reviews/index.php?event_id=$event_id&res=$reservation_id'>Kliko këtu</a>";
    }

    if(sendEmail($email, $subject, $body)) {
        $insertSql = "INSERT INTO notifications (reservation_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $reservation_id);
        $insertStmt->execute();
    }
}