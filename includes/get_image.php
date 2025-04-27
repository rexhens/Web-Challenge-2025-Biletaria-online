<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if (isset($_GET['show_id'])) {
    $id = intval($_GET['show_id']);
    $query = "SELECT poster FROM shows WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();

    if (!empty($poster)) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/shows/' . basename($poster); // secure the path
        if (file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            header("Content-Type: $mimeType");
            readfile($imagePath);
        } else {
            header("Content-Type: image/png");
            readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/show-icon.png');
        }
    } else {
        header("Content-Type: image/png");
        readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/show-icon.png');
    }

    $conn->close();
} else if (isset($_GET['actor_id'])) {
    $id = intval($_GET['actor_id']);
    $query = "SELECT poster FROM actors WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($photo);
    $stmt->fetch();
    $stmt->close();

    if (!empty($photo)) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/actors/' . basename($photo); // secure the path
        if (file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            header("Content-Type: $mimeType");
            readfile($imagePath);
        } else {
            header("Content-Type: image/png");
            readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/actor-icon.png');
        }
    } else {
        header("Content-Type: image/png");
        readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/actor-icon.png');
    }

    $conn->close();
} else if(isset($_GET['event_id'])) {
    $id = intval($_GET['event_id']);
    $query = "SELECT poster FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($poster);
    $stmt->fetch();
    $stmt->close();

    if (!empty($poster)) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/events/' . basename($poster);
        if (file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            header("Content-Type: $mimeType");
            readfile($imagePath);
        } else {
            header("Content-Type: image/png");
            readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/show-icon.png');
        }
    } else {
        header("Content-Type: image/png");
        readfile($_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/show-icon.png');
    }

    $conn->close();
} else {
    showError("Nuk ka një foto të vlefshme!");
}