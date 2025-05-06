<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$filter = $_POST['show_time_filter'] ?? 'available';
$genre_id = $_POST['genre_id'] ?? '';
$now = date('Y-m-d');

$params = [];
$types = "";

if ($filter === 'available') {
    $query = "
        SELECT s.*
        FROM shows s
        JOIN (
            SELECT show_id
            FROM show_dates
            GROUP BY show_id
            HAVING MAX(show_date) >= ?
        ) sd ON s.id = sd.show_id
    ";
    $params[] = $now;
    $types .= "s";
} elseif ($filter === 'past') {
    $query = "
        SELECT s.*
        FROM shows s
        JOIN (
            SELECT show_id
            FROM show_dates
            GROUP BY show_id
            HAVING MAX(show_date) < ?
        ) sd ON s.id = sd.show_id
    ";
    $params[] = $now;
    $types .= "s";
} else {
    $query = "SELECT s.* FROM shows s";
}

if (!empty($genre_id)) {
    $query .= !str_contains($query, 'WHERE') ? " WHERE" : " AND";
    $query .= " s.genre_id = ?";
    $params[] = $genre_id;
    $types .= "i";
}

$query .= " ORDER BY s.id DESC";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($show = $result->fetch_assoc()) {
        $posterUrl = '/biletaria_online/includes/get_image.php?show_id=' . $show['id'];

        $datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
        $datesQuery->bind_param("i", $show['id']);
        $datesQuery->execute();
        $datesResult = $datesQuery->get_result();
        $dates = [];
        while ($row = $datesResult->fetch_assoc()) {
            $dates[] = $row['show_date'];
        }

        $groupedDates = groupDates($dates);

        echo "<div class='show-card item' style='background-image: url($posterUrl);' data-genre='" . htmlspecialchars($show['genre_id']) . "'>
        <div class='overlay'>
            <h3>" . htmlspecialchars($show['title']) . "</h3>
            <p class='show-dates'>" . implode(', ', $groupedDates) . "</p>" .
            "<p class='show-description'>" . htmlspecialchars($show['description']) . "</p>" .
            "<div class='btn-group'>
                <button onclick=\"redirectTo('/biletaria_online/views/client/shows/show_details.php?id=" . $show['id'] . "')\">Më shumë info</button>
                <button onclick=\"redirectTo('/biletaria_online/views/client/reserve.php?show_id=" . $show['id'] . "')\" class='black-btn'>Rezervo</button>
            </div>
        </div>
    </div>";
    }
} else {
    $posterUrl = "/biletaria_online/assets/img/background-image.png";
    echo "<div class='show-card item' style='background-image: url($posterUrl);'>
        <div class='overlay'>
            <h3>Teatri Metropol</h3>
            <p>Nuk ka shfaqje për momentin! Ju ftojmë të na ndiqni në vazhdim! Faleminderit!</p>
        </div>
    </div>";
}