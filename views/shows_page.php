<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/shows.css">
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
    <div class="shows-container" id="shows-container"></div>
</body>

</html>
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
    async function fetchFilteredShows() {
        const genre = "";
        const dateFilterValue = "available";

        try {
            const response = await fetch('../filter_shows.php', {
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
            console.error('Error fetching shows:', error);
            document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
        }
    }



    fetchFilteredShows();
</script>