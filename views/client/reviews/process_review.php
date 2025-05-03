<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    $show_id = $_POST['show_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comment = trim($_POST['comment']);
    $date = date('Y-m-d H:i:s');

    if ($user_id && $show_id && $rating && $comment) {
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, show_id, rating, comment, date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $show_id, $rating, $comment, $date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Vlerësimi u dërgua me sukses.";
        } else {
            echo "Dështoi ruajtja e vlerësimit.";
        }

        $stmt->close();
    } else {
        echo "Të gjitha fushat janë të detyrueshme.";
    }

    $conn->close();
}
?>