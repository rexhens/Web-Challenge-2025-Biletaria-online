<?php
require_once '../../../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $show_id = intval($_POST['show_id']);
    $actor_ids = $_POST['actor_ids'] ?? [];

    if (!empty($actor_ids)) {
        $stmt = $conn->prepare("INSERT INTO show_actors (show_id, actor_id) VALUES (?, ?)");

        foreach ($actor_ids as $actor_id) {
            $stmt->bind_param("ii", $show_id, $actor_id);
            $stmt->execute();
        }
    }

    header("Location: index.php"); // Redirect to shows list or dashboard
    exit();
}
?>