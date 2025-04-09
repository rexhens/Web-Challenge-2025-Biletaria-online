<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
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
} elseif ($filter === 'admin') {
    $query = "SELECT * FROM shows LIMIT 5";
} else {
    $query = "SELECT s.* FROM shows s";
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
        $posterUrl = "/biletaria_online/views/get_image.php?show_id=" . $show['id'];

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
    <div class='show-overlay'>
        <h3><span>Titulli: </span>" . htmlspecialchars($show['title']) . "</h3>
        <p class='show-dates'><span>Datat: </span>" . implode(', ', $groupedDates) . "</p>
        <p class='show-description'><span>Përshkrim: </span>" . htmlspecialchars($show['description']) . "</p>
        <div class='btn-group'>";

        if ($filter === "admin") {
            echo "<button id='reservationBtn' onclick=\"window.location.href='view_reservations.php?show_id=" . $show['id'] . "'\">Shiko Rezervimet</button>";
        } else {
            echo "<button onclick=\"redirectTo('show_details.php?id=" . $show['id'] . "')\">Më shumë info</button>
          <button onclick=\"redirectTo('reserve.php?id=" . $show['id'] . "')\" class='black-btn'>Rezervo</button>";
        }

        echo "</div>
    </div>
</div>";

            <div class='overlay'>
                <h3><span>Titulli: </span>" . htmlspecialchars($show['title']) . "</h3>
                <p class='show-dates'><span>Datat: </span>" . implode(', ', $groupedDates) . "</p>
                <p class='show-description'><span>Përshkrim: </span>" . htmlspecialchars($show['description']) . "</p>
                <div class='btn-group'>
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

function groupDates($dates): array
{
    if (empty($dates))
        return [];

    $grouped = [];
    $start = $end = new DateTime($dates[0]);

    for ($i = 1; $i < count($dates); $i++) {
        $current = new DateTime($dates[$i]);
        $diff = (int) $end->diff($current)->format("%a");

        if ($diff === 1) {
            $end = $current;
        } else {
            $grouped[] = formatDateRange($start, $end);
            $start = $end = $current;
        }
    }

    $grouped[] = formatDateRange($start, $end);
    return $grouped;
}

function formatDateRange($start, $end): string
{
    $muajiStart = muajiNeShqip($start->format('M'));
    $muajiEnd = muajiNeShqip($end->format('M'));

    if ($start == $end) {
        return $start->format('j') . " " . $muajiStart;
    } elseif ($muajiStart === $muajiEnd) {
        return $start->format('j') . "-" . $end->format('j') . " " . $muajiStart;
    } else {
        return $start->format('j') . " " . $muajiStart . " - " . $end->format('j') . " " . $muajiEnd;
    }
}

function muajiNeShqip($muajiAnglisht): string
{
    $muajt = [
        'Jan' => 'Janar',
        'Feb' => 'Shkurt',
        'Mar' => 'Mars',
        'Apr' => 'Prill',
        'May' => 'Maj',
        'Jun' => 'Qershor',
        'Jul' => 'Korrik',
        'Aug' => 'Gusht',
        'Sep' => 'Shtator',
        'Oct' => 'Tetor',
        'Nov' => 'Nëntor',
        'Dec' => 'Dhjetor'
    ];
    return $muajt[$muajiAnglisht] ?? $muajiAnglisht;
}

