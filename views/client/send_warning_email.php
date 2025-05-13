<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$sql = "
SELECT 
    MIN(r.id) AS id,
    r.email,
    r.show_id,
    r.event_id,
    r.show_date,
    r.show_time,
    r.expires_at,
    COALESCE(s.title, e.title) AS title
FROM reservations r
LEFT JOIN shows s ON r.show_id = s.id
LEFT JOIN events e ON r.event_id = e.id
WHERE NOW() BETWEEN (r.expires_at - INTERVAL 2 DAY) AND (r.expires_at - INTERVAL 3 HOUR)
AND r.id NOT IN (
    SELECT n.reservation_id
    FROM notifications n
    WHERE type = 'warning'
)
AND r.paid = 0
GROUP BY 
    r.email,
    r.show_id,
    r.event_id,
    r.show_date,
    r.show_time
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    $subject = mb_encode_mimeheader('KUJTESË!');
    $type = $row['show_id'] ? 'shfaqjen' : 'eventin';
    $title = "Kujtesë rreth pagesës së biletës së rezervuar për $type \"{$row['title']}\"";
    $body = "Duke ju falenderuar qe zgjidhni Teatrin Metropol si oazin tuaj te argëtimit dhe artit, ju sjellim këtë email automatik, për t'ju njoftuar që keni kohë të bëni pagesën e rezervimit tuaj deri më " . date("d, m, Y H:i", strtotime($row['expires_at'])) . "<br>Kjo është një procedurë që ne e ndjekim për sigurinë e rezervimeve.<br>Faleminderit!";
    $email = $row['email'];
    $reservation_id = $row['id'];

    if(sendEmail($email, $subject, $title, $body, '')) {
        $insertSql = "INSERT INTO notifications (reservation_id, type) VALUES (?, 'warning')";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $reservation_id);
        $insertStmt->execute();
    }
}