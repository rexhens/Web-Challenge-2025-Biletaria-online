<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-show'])) {
    $id = $_POST['show_id'];
    $title = $_POST['title'];
    $hall = $_POST['hall'];
    $genre_id = $_POST['genre_id'];
    $dates = explode(",", $_POST['dates']);
    $time = $_POST['time'];
    $description = $_POST['description'];
    $trailer = $_POST['trailer'];
    $price = $_POST['price'];
    $posterPath = getPosterPath($conn, "shows", $id);

    if(empty($id) || empty($title) || empty($hall) || empty($genre_id) || empty($dates) || empty($time) || empty($description) || empty($trailer) || empty($price) || empty($posterPath)) {
        showError("Të dhënat mungojnë!");
    }

    $result = isHallAvailable($conn, $hall, $time, $dates, $id);
    if (!$result['available']) {
        showError("Salla është e zënë në: <br>" . implode('<br>', $result['conflict_info']));
    }

    if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
        if (!empty($_FILES['file-input']['name'])) {
            $check = getimagesize($_FILES['file-input']['tmp_name']);
            if ($check !== false) {
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/shows/';
                $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                $uniqueName = uniqid('poster_', true) . 'views.' . strtolower($ext);
                $targetPath = $targetDir . $uniqueName;

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                if (move_uploaded_file($_FILES['file-input']['tmp_name'], $targetPath)) {
                    $posterPath = $targetPath;
                    if (!deletePoster($conn, "shows", $id)) {
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

    try {
        $conn->begin_transaction();

        $sql = "UPDATE shows SET 
            title = ?, 
            hall = ?, 
            genre_id = ?, 
            time = ?, 
            description = ?, 
            trailer = ?, 
            price = ?,
            poster = ?
            WHERE id = ?"
        ;

        $stmt = mysqli_prepare($conn, $sql);
        $stmt->bind_param('ssisssisi', $title, $hall, $genre_id, $time, $description, $trailer, $price, $posterPath, $id);

        if (!$stmt->execute()) {
            throw new Exception("Nuk mund të përditësohej shfaqja.");
        }

        $sql = "DELETE FROM show_dates WHERE show_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        $stmt->bind_param('i', $id);

        if (!$stmt->execute()) {
            throw new Exception("Nuk mund të fshiheshin datat e shfaqjes.");
        }

        foreach ($dates as $date) {
            $stmt = $conn->prepare("INSERT INTO show_dates (show_id, show_date) VALUES (?, ?)");
            $stmt->bind_param("is", $id, $date);
            if (!$stmt->execute()) {
                throw new Exception("Nuk mund të shtoheshin datat e reja.");
            }
        }

        $conn->commit();

        header('Location: index.php?update=success');
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        showError("Një problem ndodhi! Provoni më vonë!");
    }

} else {
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}