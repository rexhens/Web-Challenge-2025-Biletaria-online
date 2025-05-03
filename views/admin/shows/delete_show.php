<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-show'])) {
    $id = $_POST['showId'];

    $conn->begin_transaction();

    try {
        $sql = "DELETE FROM show_dates WHERE show_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception("Nuk u fshinë datat e shfaqjes!");
        }
        $stmt->close();

        if (!deletePoster($conn, "shows", $id)) {
            throw new Exception("Posteri nuk u fshi!");
        }

        $sql = "DELETE FROM shows WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Shfaqja nuk u fshi!");
        }
        $stmt->close();

        $conn->commit();

        header('Location: index.php?update=success');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        showError("Një problem ndodhi! " . $e->getMessage());
    }

} else {
    showError("Nuk ka informacion mbi të dhënat që duhen fshirë!");
}