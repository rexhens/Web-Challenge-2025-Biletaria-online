<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

?>

<?php
$genreQuery = "SELECT * FROM genres";
$genreResult = $conn->query($genreQuery);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Metropol Ticketing | Shfaqjet</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            padding: 0 127px;
            align-items: flex-start;
        }

        @media (max-width: 1300px) {
            body {
                padding: 0 30px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1><span>Shfaqjet në teatër</span></h1>
        <?php
        if (checkAdmin($conn)) { ?>
            <button onclick="redirectTo('add-show.php')">Shto një shfaqje</button>
        <?php }
        ?>
    </header>

    <div class="search-container">
        <i class="fa fa-search"></i>
        <input class="search-bar" type="text" id="search" placeholder="Search for shows..." onkeyup="searchShow()">
    </div>


    <div class="filter-container">
        <select id="genreFilter">
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

    <div class="shows-container" id="shows-container"></div>

    <script>
        function searchShow() {
            let input = document.getElementById('search').value.toLowerCase();
            let shows = document.querySelectorAll('.show-card');

            shows.forEach(function (show) {
                let h3 = show.querySelector('h3');
                if (h3) {
                    let title = Array.from(h3.childNodes)
                        .filter(node => node.nodeType === Node.TEXT_NODE)
                        .map(node => node.textContent.trim())
                        .join('')
                        .toLowerCase();

                    if (title.includes(input)) {
                        show.style.display = "";
                    } else {
                        show.style.display = "none";
                    }
                }
            });
        }
    </script>
    <script>
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
    </script>
    <script>
        const genreFilter = document.getElementById("genreFilter");
        const dateFilter = document.getElementById("dateFilter");

        async function fetchFilteredShows() {
            const genre = genreFilter.value;
            const dateFilterValue = dateFilter.value;

            try {
                const response = await fetch('filter_shows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `show_time_filter=${encodeURIComponent(dateFilterValue)}&genre_id=${encodeURIComponent(genre)}`,
                });

                const html = await response.text();
                const showsContainer = document.getElementById("shows-container");
                showsContainer.innerHTML = html;

                document.querySelectorAll('.show-card').forEach(card => {
                    observer.observe(card);
                });

            } catch (error) {
                document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
            }
        }

        genreFilter.addEventListener('change', fetchFilteredShows);
        dateFilter.addEventListener('change', fetchFilteredShows);

        fetchFilteredShows();
    </script>
    <script src="../assets/js/functions.js"></script>
</body>

</html>