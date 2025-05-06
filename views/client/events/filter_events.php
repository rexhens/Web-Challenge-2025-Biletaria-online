<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$filter = $_POST['event_time_filter'] ?? 'available';
$now = date('Y-m-d');

$params = [];
$types = "";

if ($filter === 'available') {
    $query = "
        SELECT e.*
        FROM events e
        JOIN (
            SELECT event_id
            FROM event_dates
            GROUP BY event_id
            HAVING MAX(event_date) >= ?
        ) ed ON e.id = ed.event_id
    ";
    $params[] = $now;
    $types .= "s";
} elseif ($filter === 'past') {
    $query = "
        SELECT e.*
        FROM events e
        JOIN (
            SELECT event_id
            FROM event_dates
            GROUP BY event_id
            HAVING MAX(event_date) < ?
        ) ed ON e.id = ed.event_id
    ";
    $params[] = $now;
    $types .= "s";
} else {
    $query = "SELECT e.* FROM events e";
}

$query .= " ORDER BY e.id DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        $posterUrl = '/biletaria_online/includes/get_image.php?event_id=' . $event['id'];

        $datesQuery = $conn->prepare("SELECT event_date FROM event_dates WHERE event_id = ? ORDER BY event_date ASC");
        $datesQuery->bind_param("i", $event['id']);
        $datesQuery->execute();
        $datesResult = $datesQuery->get_result();
        $dates = [];
        while ($row = $datesResult->fetch_assoc()) {
            $dates[] = $row['event_date'];
        }

        $groupedDates = groupDates($dates);

        echo "<div class='show-card item' style='background-image: url($posterUrl);'>
        <div class='overlay'>
            <h3>" . htmlspecialchars($event['title']) . "</h3>
            <p class='show-dates'>" . implode(', ', $groupedDates) . "</p>" .
            "<p class='show-description'>" . htmlspecialchars($event['description']) . "</p>" .
            "<div class='btn-group'>
                <button onclick=\"redirectTo('event_details.php?id=" . $event['id'] . "')\">Më shumë info</button>
                <button onclick=\"redirectTo('../reserve.php?event_id=" . $event['id'] . "')\" class='black-btn'>Rezervo</button>
            </div>
        </div>
    </div>";
    }
} else {
    $posterUrl = "/biletaria_online/assets/img/background-image.png";
    echo "<div class='show-card item' style='background-image: url($posterUrl);'>
        <div class='overlay'>
            <h3>Teatri Metropol</h3>
            <p>Nuk ka evente për momentin! Ju ftojmë të na ndiqni në vazhdim! Faleminderit!</p>
        </div>
    </div>";
}