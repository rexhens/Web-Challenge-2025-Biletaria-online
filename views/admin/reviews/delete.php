<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    if (is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: index.php?update=success");
            exit();
        } else {
            $message = "Një problem ndodhi me fshirjen e komentit!";
            $encodedMessage = urlencode($message);
            header('Location: index.php?update=error&message=' . $encodedMessage);
            exit();
        }

        $stmt->close();
    } else {
        $message = "Id e pavlefshme!";
        $encodedMessage = urlencode($message);
        header('Location: index.php?update=error&message=' . $encodedMessage);
        exit();
    }
} else {
    $message = "Të dhëna të pamjaftueshme për të fshirë!";
    $encodedMessage = urlencode($message);
    header('Location: index.php?update=error&message=' . $encodedMessage);
    exit();
}