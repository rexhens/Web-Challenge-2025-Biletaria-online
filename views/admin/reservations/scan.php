<?php
/** scan.php
 *  Shënon si të paguar çdo rezervim të marrë nga QR‑kodi
 *  dhe ridrejton te faqja e listës me mesazhin “update=success”.
 *
 *  Parametër pritës:
 *    • id  – një ID e vetme p.sh.  scan.php?id=27
 *    • ids – lista me ID, të ndara me presje p.sh.  scan.php?ids=27,28,29
 */

/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

$ids = [];
if (isset($_GET['ids'])) {
    $ids = array_map('intval', array_filter(explode(',', $_GET['ids'])));
}

if (!$ids) {
    showError('Nuk u dërgua asnjë ID rezervimi!');
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "UPDATE reservations SET paid = 1 WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    showError('Gabim gjatë përgatitjes së kërkesës në databazë!');
}

$types = str_repeat('i', count($ids));
$stmt->bind_param($types, ...$ids);

if (!$stmt->execute()) {
    $stmt->close();
    showError('Një problem ndodhi! Rezervimet nuk u përditësuan!');
}
$stmt->close();

header('Location: success.php');
exit;
