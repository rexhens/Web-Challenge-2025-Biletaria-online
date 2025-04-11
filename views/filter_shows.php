<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

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
    $query = "SELECT s.* FROM shows s LIMIT 10";
}

if (!empty($genre_id)) {
    $query .= !str_contains($query, 'WHERE') ? " WHERE" : " AND";
    $query .= " s.genre_id = ?";
    $params[] = $genre_id;
    $types .= "i";
}

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($show = $result->fetch_assoc()) {
        $posterUrl = "get_image.php?show_id=" . $show['id'];

        $datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
        $datesQuery->bind_param("i", $show['id']);
        $datesQuery->execute();
        $datesResult = $datesQuery->get_result();
        $dates = [];
        while ($row = $datesResult->fetch_assoc()) {
            $dates[] = $row['show_date'];
        }

        $groupedDates = groupDates($dates);

        echo "<div class='show-card' style='background-image: url($posterUrl);' data-genre='" . htmlspecialchars($show['genre_id']) . "'>
        <div class='overlay'>
            <h3><span>Titulli: </span>" . htmlspecialchars($show['title']) . "</h3>
            <p class='show-dates'><span>Datat: </span>" . implode(', ', $groupedDates) . "</p>" .
            (checkAdmin($conn) ?
                "<div class='btn-group' style='margin-bottom: 10px;'>
                    <button onclick=\"redirectTo('edit-show.php?id=" . $show['id'] . "')\">Edito</button>
                    <button onclick=\"redirectTo('reservations?id=" . $show['id'] . "')\" class='black-btn'>Rezervime</button>
                </div>"
                :
                "<p class='show-description'><span>Përshkrim: </span>" . htmlspecialchars($show['description']) . "</p>"
            ) .
            "<div class='btn-group'>
                <button onclick=\"redirectTo('show_details.php?id=" . $show['id'] . "')\">Më shumë info</button>
                <button onclick=\"redirectTo('reserve.php?id=" . $show['id'] . "')\" class='black-btn'>Rezervo</button>
            </div>
        </div>
    </div>";
    }
} else {
    echo "<div class='errors show'>
             <p>Nuk ka shfaqje!</p>
          </div>";
}