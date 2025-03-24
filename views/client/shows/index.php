<?php
require_once '../../../config/db_connect.php';

// Handle search and filter requests
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$filterGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
$filterDate = isset($_GET['date']) ? $_GET['date'] : '';

$query = "SELECT * FROM shows WHERE title LIKE ?";

// Apply genre filter if provided
if ($filterGenre) {
    $query .= " AND genre_id = ?";
}

// Apply date filter if provided
if ($filterDate) {
    $query .= " AND start_date >= ?";
}

$query .= " ORDER BY start_date DESC";

// Prepare statement and execute query
$stmt = $conn->prepare($query);
$searchTerm = "%$searchTerm%";
$stmt->bind_param("s", $searchTerm);
if ($filterGenre) {
    $stmt->bind_param("si", $searchTerm, $filterGenre);
}
if ($filterDate) {
    $stmt->bind_param("si", $searchTerm, $filterDate);
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch genres for the filter dropdown
$genreQuery = "SELECT * FROM genres";
$genreResult = $conn->query($genreQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shfaqjet</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;700&display=swap');

        :root {
            --default-font: "Quicksand", sans-serif;
            --heading-font: "Russo One", sans-serif;
            --nav-font: "Afacad Flux", sans-serif;
            --background-color: #1B1B1B;
            --default-color: #785E5B;
            --heading2-color: #836e4f;
            --heading-color: #7C8598;
            --accent2-color: rgb(130, 152, 145);
            --accent-color: #8f793f;
            --surface-color: #c8bbb3;
            --text-color: #E4E4E4;
            --error-color: #f44336;
            --success-color: rgba(131, 173, 68);
        }


        body {
            background: url('../../../assets/img/background-image.png') no-repeat center center/cover;
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: var(--default-font);
            margin: 0;
            padding: 20px;
            transition: background-color 0.5s ease-in-out;
        }

        .shows-container {
            max-width: 1200px;
            margin: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--heading-color);
            font-family: var(--heading-font);
            margin: 0;
        }

        .search-bar {
            padding: 15px;
            font-size: 18px;
            width: 1700px;
            max-width: 100%;
            border-radius: 5px;
            border: 2px solid var(--accent-color);
            margin: 0 auto 30px;
        }

        .search-bar::placeholder {
            color: var(--text-color);
        }

        .filter-container {
            margin-bottom: 30px;
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .filter-container select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 2px solid var(--accent-color);
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .shows-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 cards per row */
            gap: 30px;
        }

        .show-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.7);
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.5s ease-in-out forwards;
        }

        .show-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        .show-card:nth-child(odd) {
            animation-delay: 0.4s;
        }

        .show-card:hover {
            transform: scale(1.05);
        }

        .show-overlay {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            color: var(--text-color);
        }

        .show-overlay h3 {
            font-family: var(--heading-font);
            color: var(--heading2-color);
            margin: 0 0 10px;
            font-size: 1.8rem;
        }

        .show-dates {
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .show-description {
            font-size: 0.9rem;
            margin-bottom: 15px;
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-group {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
        }

        .btn {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s ease;
            padding: 10px;
            font-family: "Quicksand", sans-serif;
            font-size: 17px;
            color: var(--text-color);
            border: none;
            border-bottom: 2px solid rgb(143, 121, 63, 0.5);
            outline: none;
            background: none;
            background-color: #836e4f;
            font-weight: 300;
        }

        .btn.info {
            background: var(--accent-color);
            color: black;
        }

        .btn.reserve {
            background: black;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
        }

        .btn:hover {
            opacity: 0.9;
        }

        .no-shows {
            text-align: center;
            font-size: 1.2rem;
            color: var(--surface-color);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="shows-container">
        <header>
            <h1>Shfaqjet ne teater</h1>
        </header>

        <!-- Search Bar with Live Search functionality -->
        <input class="search-bar" type="text" id="search" placeholder="Search for shows..." style="width:500px"
            onkeyup="searchShow()">

        <form method=" GET" action="">
            <div class="filter-container">
                <select name="genre" onchange="this.form.submit()">
                    <option value="">All Genres</option>
                    <?php while ($genre = $genreResult->fetch_assoc()) { ?>
                        <option value="<?php echo $genre['id']; ?>" <?php echo $genre['id'] == $filterGenre ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($genre['genre_name']) . "                                      "; ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="date" onchange="this.form.submit()">
                    <option value="">All Dates</option>
                    <option value="upcoming" <?php echo $filterDate == 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                    <option value="past" <?php echo $filterDate == 'past' ? 'selected' : ''; ?>>Past</option>
                </select>
            </div>
        </form>

        <div class="shows-grid" id="showGrid">
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $posterUrl = "get_image.php?id=" . $row['id'];
                    $start_date = date('d M Y', strtotime($row['start_date']));
                    $end_date = date('d M Y', strtotime($row['end_date']));
                    $dates = $start_date === $end_date ? $start_date : "$start_date - $end_date";
                    ?>
                    <div class="show-card" style="background-image: url('<?php echo $posterUrl; ?>');">
                        <div class="show-overlay">
                            <h3><span>Titulli: </span> <span
                                    id="paragraph"><?php echo htmlspecialchars($row['title']); ?></span></h3>
                            <p class="show-dates"><span>Datat e shfaqjes: </span> <?php echo $dates; ?></p>
                            <p class="show-description"><span>Pershkrim i shkurter: </span>
                                <?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="btn-group">
                                <a href="show_details.php?id=<?php echo $row['id']; ?>" class="btn">Me shume info</a>
                                <a href="reserve.php?id=<?php echo $row['id']; ?>" class="btn reserve">Rezervo</a>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p class='no-shows'>No shows available at the moment.</p>";
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


    </script>
</body>

</html>