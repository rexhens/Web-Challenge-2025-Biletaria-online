<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
$pageTitle = 'Evente';
$pageStyles = [
    '/biletaria_online/assets/css/footer.css',
    '/biletaria_online/assets/css/navbar.css',
    '/biletaria_online/assets/css/styles.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        body {
            padding: 0 30px;
            align-items: flex-start;
        }

        .footer-glass {
            margin-left: -30px;
            width: calc(100% + 28px);
        }

        .footer-bottom {
            margin-left: -20px;
        }
    </style>
</head>

<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

<header>
    <h1>Eventet në <span>Teatrin Metropol</span></h1>
</header>

<div class="search-container">
    <i class="fa fa-search"></i>
    <input class="search-bar" type="text" id="search" placeholder="Kërko event..." onkeyup="searchShow()">
</div>


<div class="filter-container">
    <select id="dateFilter" style="width: 100% !important;">
        <option value="available">Në vazhdim</option>
        <option value="past">Të kaluarat</option>
        <option value="all">Të gjitha</option>
    </select>
</div>

<div class="shows-container" id="shows-container"></div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

<script>
    const dateFilter = document.getElementById("dateFilter");

    async function fetchFilteredShows() {
        const dateFilterValue = dateFilter.value;
        const showsContainer = document.getElementById("shows-container");

        showsContainer.innerHTML = `
                                            <div class="loading-spinner-wrapper">
                                                <div class="loading-spinner"></div>
                                            </div>
                                        `;

        try {
            const response = await fetch('filter_events.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `event_time_filter=${encodeURIComponent(dateFilterValue)}`,
            });

            const html = await response.text();
            showsContainer.innerHTML = html;

            document.querySelectorAll('.show-card').forEach(card => {
                observer.observe(card);
            });

        } catch (error) {
            document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
        }
    }

    dateFilter.addEventListener('change', fetchFilteredShows);

    fetchFilteredShows();
</script>
<script src="/biletaria_online/assets/js/functions.js"></script>
<script src="/biletaria_online/assets/js/theme-change.js"></script>

</body>

</html>