<?php
/** @var mysqli $conn */
require_once '../config/db_connect.php';

if (isset($_GET['show_id'])) {
    $id = intval($_GET['show_id']);
    $query = "SELECT poster FROM shows WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();

    if ($poster) {
        header("Content-Type: image/jpeg");
        echo $poster;
    } else {
        header("Content-Type: image/png");
        readfile("../assets/img/show-icon.png");
    }
}

if (isset($_GET['actor_id'])) {
    $id = intval($_GET['actor_id']); // korrigjuar nga 'id'
    $sql = "SELECT photo FROM actors WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($photo);
    $stmt->fetch();
    $stmt->close();

    if ($photo) {
        header("Content-Type: image/jpeg");
        echo $photo;
    } else {
        header("Content-Type: image/png");
        readfile("../assets/img/actor-icon.png");
    }
}

$conn->close();