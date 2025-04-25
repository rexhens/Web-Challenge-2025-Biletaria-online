<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['event_id'];
    $title = $_POST['title'];
    $hall = $_POST['hall'];
    $dates = explode(",", $_POST['dates']);
    $time = $_POST['time'];
    $description = $_POST['description'];
    $trailer = $_POST['trailer'];
    $price = $_POST['price'];
    $posterPath = getPosterPath($conn, "events", $id);

    $result = isHallAvailable($conn, $hall, $time, $dates, $id);
    if (!$result['available']) {
        showError("Salla është e zënë në: <br>" . implode('<br>', $result['conflict_info']));
    }

    if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
        if (!empty($_FILES['file-input']['name'])) {
            $check = getimagesize($_FILES['file-input']['tmp_name']);
            if ($check !== false) {
                $targetDir = '../assets/img/events/';
                $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                $uniqueName = uniqid('poster_', true) . '.' . strtolower($ext);
                $targetPath = $targetDir . $uniqueName;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['file-input']['tmp_name'], $targetPath)) {
                    $posterPath = $targetPath;
                    if (!deletePoster($conn, "events", $id)) {
                        showError("Një problem ndodhi! Provoni më vonë!");
                    }
                } else {
                    showError("Nuk mund të ngarkohej imazhi.");
                }
            } else {
                showError("Skedari nuk është një imazh i vlefshëm.");
            }
        }
    }

    $sql = "UPDATE events SET 
        title = ?, 
        hall = ?, 
        time = ?, 
        description = ?, 
        trailer = ?, 
        price = ?,
        poster = ?
        WHERE id = ?"
    ;

    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param('sssssisi', $title, $hall, $time, $description, $trailer, $price, $posterPath, $id);

    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    $sql = "DELETE FROM event_dates WHERE event_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $stmt->bind_param('i', $id);

    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    foreach ($dates as $date) {
        $stmt = $conn->prepare("INSERT INTO event_dates (event_id, event_date) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $date);
        if (!$stmt->execute()) {
            showError("Një problem ndodhi! Provoni më vonë!");
        }
    }

    header('Location: admin-events.php?update=success');
    exit();
} else {
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}