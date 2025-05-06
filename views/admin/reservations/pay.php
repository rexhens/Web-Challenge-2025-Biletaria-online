<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $id = $_POST['id'];

    $sql = "UPDATE reservations SET paid = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Rezervimi nuk u pagua!");
    }
    $stmt->close();
    header('Location: index.php?update=success');
    exit();
} else {
    showError("Nuk ka informacion mbi të dhënat që duhen përditësuar!");
}