<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-show'])) {
    $id = $_POST['showId'];

    $sql = "DELETE FROM shows WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if(!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    if(!deletePoster($conn, "shows", $id)) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    $sql = "DELETE FROM show_dates WHERE show_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param('i', $id);

    if(!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    header('Location: admin-shows.php?update=success');
    exit();

} else {
    showError("Nuk ka informacion mbi të dhënat që duhen fshirë!");
}