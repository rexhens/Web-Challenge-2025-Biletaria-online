<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";
redirectIfNotLoggedIn();
?>

<?php

$filter = $_POST['show_time_filter'] ?? 'available';
$now = date('Y-m-d');

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
} else {
    $query = "SELECT * FROM shows";
}

$stmt = $conn->prepare($query);
if ($filter !== 'all') {
    $stmt->bind_param("s", $now);
}
$stmt->execute();
$result = $stmt->get_result();

$genreQuery = "SELECT * FROM genres";
$genreResult = $conn->query($genreQuery);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <title>Metropol Ticketing | Shfaqjet</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/shows.css">
</head>

<body>
    <div class="shows-container">
        <header>
            <h1>Shfaqjet në teatër</h1>
            <?php
            if(checkAdmin($conn)) { ?>
                <button onclick="redirectTo('add-show.php')">Shto një shfaqje</button>
            <?php }
            ?>
        </header>

        <input class="search-bar" type="text" id="search" placeholder="Search for shows..." style="width:500px"
            onkeyup="searchShow()">

        <div class="filter-container">
            <select id="genreFilter" onchange="filterShows()">
                <option value="">Të gjithë zhanret</option>
                <?php while ($genre = $genreResult->fetch_assoc()) { ?>
                    <option value="<?php echo $genre['id']; ?>">
                        <?php echo htmlspecialchars($genre['genre_name']); ?>
                    </option>
                <?php } ?>
            </select>

            <select id="dateFilter">
                <option value="available">Në vazhdim</option>
                <option value="past">Të shkuarat</option>
                <option value="all">Të gjitha</option>
            </select>
        </div>

        <div class="shows-grid" id="showGrid">
            <?php if ($result->num_rows > 0) {
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

                    function groupDates($dates): array {
                        if (empty($dates)) return [];

                        $grouped = [];
                        $start = $end = new DateTime($dates[0]);

                        for ($i = 1; $i < count($dates); $i++) {
                            $current = new DateTime($dates[$i]);

                            $diff = (int)$end->diff($current)->format("%a");

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

                    function formatDateRange($start, $end): string {
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

                    function muajiNeShqip($muajiAnglisht): string {
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

                    $groupedDates = groupDates($dates);
                    ?>
                    <div class="show-card" style="background-image: url('<?php echo $posterUrl; ?>');"
                        data-genre="<?php echo htmlspecialchars($row['genre_id']); ?>"
                        data-start-date="<?php echo htmlspecialchars($row['start_date']); ?>"
                        data-end-date="<?php echo htmlspecialchars($row['end_date']); ?>">

                        <div class="show-overlay">
                            <h3>
                                <span>Titulli: </span>
                                <span id="paragraph"><?php echo htmlspecialchars($row['title']); ?></span>
                            </h3>
                            <p class="show-dates">
                                <span>Datat e shfaqjes: </span> <?php echo $dates; ?>
                            </p>
                            <p class="show-description">
                                <span>Pershkrim i shkurter: </span> <?php echo htmlspecialchars($row['description']); ?>
                            </p>
                            <div class="btn-group">
                                <a href="client/shows/show_details.php?id=<?php echo $row['id']; ?>" class="btn">Me shume info</a>
                                <a href="reserve.php?id=<?php echo $row['id']; ?>" class="btn reserve">Rezervo</a>
                            </div>
                        </div>
                    </div>

                <?php }
            } else {
                echo "<div class='errors show'>
                          <p>Aktualisht nuk ka shfaqje!</p>
                      </div>";
            } ?>
        </div>
    </div>

    <script>
        function searchShow() {
            let input = document.getElementById('search').value.toLowerCase();
            let shows = document.querySelectorAll('.show-card');

            shows.forEach(function (show) {
                let titleElement = show.querySelector('h3 span:last-child'); // Get the last span inside h3
                if (titleElement) {
                    let title = titleElement.textContent.toLowerCase();
                    console.log("Checking:", title);

                    if (title.includes(input)) {
                        show.style.display = ""; // Show the element
                    } else {
                        show.style.display = "none"; // Hide the element
                    }
                }
            });
        }

        function filterShows() {
            const genreFilter = document.getElementById("genreFilter").value;
            const shows = document.querySelectorAll(".show-card");

            shows.forEach(show => {
                const showGenre = show.getAttribute("data-genre");
                let showVisible = true;

                if (genreFilter && showGenre !== genreFilter) {
                    showVisible = false;
                }

                show.style.display = showVisible ? "" : "none";
            });
        }
    </script>
    <script>
        const cardContainer = document.getElementById('showGrid');
        const dateFilter = document.getElementById("dateFilter");

        async function fetchShows(filter) {
            try {
                const response = await fetch('shows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `show_time_filter=${encodeURIComponent(filter)}`,
                });

                cardContainer.innerHTML = await response.text();
            } catch (error) {
                console.error('Error fetching shows:', error);
                cardContainer.innerHTML = '<div class="errors show"><p>Një problem ndodhi! Provoni më vonë!</p></div>';
            }
        }

        dateFilter.addEventListener('change', () => {
            const filter = dateFilter.value;
            fetchShows(filter);
        }

        fetchShows('available');
    </script>
    <script src="../assets/js/functions.js"></script>
</body>
</html>