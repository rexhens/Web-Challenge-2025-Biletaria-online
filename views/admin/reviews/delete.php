<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    if (is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: index.php?update=success");
            exit();
        } else {
            showError("Një problem ndodhi me fshirjen e komentit");
        }

        $stmt->close();
    } else {
        showError("Id e pavlefshme");
    }
} else {
    showError("Të dhëna të pamjaftueshme për të fshirë!");
}