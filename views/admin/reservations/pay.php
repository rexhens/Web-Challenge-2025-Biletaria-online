<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'].'/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

/* ─── merre ID‑në nga POST ose GET ─── */
$id = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'], $_POST['id'])) {
    $id = (int) $_POST['id'];
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];        // ▼ kushti i ri me parametër GET
}

if ($id) {
    $stmt = $conn->prepare("UPDATE reservations SET paid = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        showError('Një problem ndodhi! Rezervimi nuk u pagua!');
    }
    $stmt->close();
    header('Location: index.php?update=success');
    exit();
}

/* nëse nuk u gjet ID – kthe gabim */
showError('Nuk ka informacion mbi rezervimin që duhet përditësuar!');
