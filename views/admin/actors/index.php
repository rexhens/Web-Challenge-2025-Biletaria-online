<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">

    <link rel="stylesheet" href='../../../assets/css/actors.css'>
    <title>Actors Page</title>
</head>

<body>

    <section id="team" class="team section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Actors Page</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <!-- Search Bar -->
        <div class="container">
            <input type="text" id="search" class="form-control" placeholder="Search actors..."
                onkeyup="searchActors()" />
        </div>

        <div class="container">
            <div class="big-container">
                <?php
                require_once '../../../config/db_connect.php';
                $result = $conn->query('SELECT * FROM actors');
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                            <div class="member">
                                <img src="get_image.php?id=<?php echo $row['id']; ?>" class="img-fluid" alt="">
                                <div class="member-content">
                                    <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                    <span><?php echo "I lindur me: " . htmlspecialchars($row['birthdate']); ?></span>
                                    <p><?php echo htmlspecialchars($row['biography']); ?></p>
                                    <div class="social">
                                        <a href=""><i class="bi bi-twitter-x"></i></a>
                                        <a href=""><i class="bi bi-facebook"></i></a>
                                        <a href=""><i class="bi bi-instagram"></i></a>
                                        <a href=""><i class="bi bi-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Team Member -->
                        <?php
                    }
                } else {
                    echo "No actors found.";
                }
                ?>
            </div>
        </div><!-- End container -->
    </section><!-- /Team Section -->

    <script>
        function searchActors() {
            let input = document.getElementById('search').value.toLowerCase();
            let actors = document.querySelectorAll('.team .member');

            actors.forEach(function (actor) {
                let name = actor.querySelector('h4').textContent.toLowerCase();
                if (name.indexOf(input) > -1) {
                    actor.style.position = "relative"; // Actor takes space in layout
                    actor.style.visibility = "visible"; // Make actor visible
                    actor.style.display = "block"; // Show actor
                } else {
                    actor.style.position = "absolute"; // Remove actor from layout
                    actor.style.visibility = "hidden"; // Hide actor visually
                    actor.style.display = "none"; // Hide actor completely (so it won't take space)
                }
            });
        }


    </script>

</body>

</html>