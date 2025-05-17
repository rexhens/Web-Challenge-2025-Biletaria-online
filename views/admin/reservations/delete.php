<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        $message = "Një problem ndodhi! Rezervimi nuk u anullua!";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
    $stmt->close();
    header('Location: index.php?update=success');
    exit();
} else {
    $message = "Nuk ka informacion mbi të dhënat që duhen fshirë!";
    $encodedMessage = urlencode($message);
    header('Location: index.php?update=error&message=' . $encodedMessage);
    exit();
}