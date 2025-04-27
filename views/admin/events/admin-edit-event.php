<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit-event'])) {
    $id = $_POST['event_id'];
    $title = $_POST['title'];
    $hall = $_POST['hall'];
    $dates = explode(",", $_POST['dates']);
    $time = $_POST['time'];
    $description = $_POST['description'];
    $trailer = $_POST['trailer'];
    $price = $_POST['price'];
    $posterPath = getPosterPath($conn, "events", $id);

    if(empty($id) || empty($title) || empty($hall) || empty($dates) || empty($time) || empty($description) || empty($trailer) || empty($price) || empty($posterPath)) {
        showError("Të dhënat mungojnë!");
    }

    $result = isHallAvailable($conn, $hall, $time, $dates, $id);
    if (!$result['available']) {
        showError("Salla është e zënë në: <br>" . implode('<br>', $result['conflict_info']));
    }

    $conn->begin_transaction();

    try {
        if (isset($_FILES['file-input']) && is_uploaded_file($_FILES['file-input']['tmp_name'])) {
            if (!empty($_FILES['file-input']['name'])) {
                $check = getimagesize($_FILES['file-input']['tmp_name']);
                if ($check !== false) {
                    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/assets/img/events/';
                    $ext = pathinfo($_FILES['file-input']['name'], PATHINFO_EXTENSION);
                    $uniqueName = uniqid('poster_', true) . 'views.' . strtolower($ext);
                    $targetPath = $targetDir . $uniqueName;

                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }

                    if (move_uploaded_file($_FILES['file-input']['tmp_name'], $targetPath)) {
                        if (!deletePoster($conn, "events", $id)) {
                            throw new Exception("Nuk mund të fshihej posteri i vjetër!");
                        }
                        $posterPath = $targetPath;
                    } else {
                        throw new Exception("Nuk mund të ngarkohej imazhi.");
                    }
                } else {
                    throw new Exception("Skedari nuk është një imazh i vlefshëm.");
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
            WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssisi', $title, $hall, $time, $description, $trailer, $price, $posterPath, $id);
        if (!$stmt->execute()) {
            throw new Exception("Nuk mund të përditësohej eventi!");
        }
        $stmt->close();

        $sql = "DELETE FROM event_dates WHERE event_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception("Nuk mund të fshiheshin datat e vjetra!");
        }
        $stmt->close();

        $sql = "INSERT INTO event_dates (event_id, event_date) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        foreach ($dates as $date) {
            $stmt->bind_param("is", $id, $date);
            if (!$stmt->execute()) {
                throw new Exception("Nuk mund të ruheshin datat e reja!");
            }
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
    showError("Nuk ka informacion mbi të dhënat që duhen update-uar!");
}