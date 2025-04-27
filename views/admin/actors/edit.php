<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-actor'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $birthdate = isset($_POST['birthday']) ? trim($_POST['birthday']) : '';
    $posterPath = getPosterPath($conn, "actors", $id);

    if(empty($id) || empty($name) || empty($email) || empty($description) || empty($birthdate) || empty($posterPath)) {
        showError("Të dhënat mungojnë!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        showError("Email-i nuk është i vlefshëm.");
    }

    if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
        if (!empty($_FILES['file-input']['name'])) {
            $check = getimagesize($_FILES['file-input']['tmp_name']);
            if ($check !== false) {
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/actors/';
                $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                $uniqueName = uniqid('poster_', true) . 'views.' . strtolower($ext);
                $targetPath = $targetDir . $uniqueName;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['file-input']['tmp_name'], $targetPath)) {
                    if (!deletePoster($conn, "actors", $id)) {
                        showError("Nuk mund të fshihej porteti i vjetër!");
                    }
                    $posterPath = $targetPath;
                } else {
                    showError("Nuk mund të ngarkohej imazhi.");
                }
            } else {
                showError("Skedari nuk është një imazh i vlefshëm.");
            }
        }
    }

    $sql = "UPDATE actors SET name = ?, email = ?, birthday = ?, description = ?, poster = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $birthdate, $description, $posterPath, $id);
    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }

    header("Location: index.php?update=success");
    exit;

} else {
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}