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

/* ─── mblidh ID‑të nga query‑string ─── */
$ids = [];
if (isset($_GET['id'])) {
    $ids[] = (int)$_GET['id'];
} elseif (isset($_GET['ids'])) {
    $ids = array_map('intval', array_filter(explode(',', $_GET['ids'])));
}

/* ─── nëse s’kemi asnjë ID – kthe gabim ─── */
if (!$ids) {
    showError('Nuk u dërgua asnjë ID rezervimi!');
}

/* ─── përgatis SQL‑in “…WHERE id IN (?,?,...)” ─── */
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "UPDATE reservations SET paid = 1 WHERE id IN ($placeholders)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    showError('Gabim gjatë përgatitjes së kërkesës në databazë!');
}

/* ─── lidh parametrat dinamikisht ─── */
$types = str_repeat('i', count($ids));           // “iii…”
$stmt->bind_param($types, ...$ids);

/* ─── ekzekuto + verifiko ─── */
if (!$stmt->execute()) {
    $stmt->close();
    showError('Një problem ndodhi! Rezervimet nuk u përditësuan!');
}
$stmt->close();

/* ─── sukses – kthehu te lista ─── */
header('Location: index.php?update=success');
exit;
