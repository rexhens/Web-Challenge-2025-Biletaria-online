<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
$pageStyles = [
    'assets/css/footer.css',
    'assets/css/style-starter.css',
    'assets/css/shows.css',
    'assets/css/navbar.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        .map-section {
            padding: 40px 0;
        }

        .map-container {
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        .map-container iframe {
            filter: invert(90%) hue-rotate(180deg);
        }
    </style>
</head>

<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

    <section class="w3l-main-slider position-relative" id="home" style="margin-top: -65px;">
        <div class="companies20-content">
            <div class="owl-one owl-carousel owl-theme">
                <?php
                $now = $now = date('Y-m-d');
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
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $now);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {

                    while ($show = $result->fetch_assoc()) {
                        $datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
                        $datesQuery->bind_param("i", $show['id']);
                        $datesQuery->execute();
                        $datesResult = $datesQuery->get_result();
                        $dates = [];
                        while ($row = $datesResult->fetch_assoc()) {
                            $dates[] = $row['show_date'];
                        }

                        $groupedDates = groupDates($dates);

                        $videoId = '';
                        $parsedUrl = parse_url($show['trailer']);
                        if (isset($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $queryParams);
                            $videoId = $queryParams['v'] ?? '';
                        } elseif (isset($parsedUrl['path'])) {
                            $pathParts = explode('/', trim($parsedUrl['path'], '/'));
                            $videoId = end($pathParts);
                        }

                        $popupId = 'small-show-dialog' . $show['id'];

                        $bg_image = "https://img.youtube.com/vi/$videoId/maxresdefault.jpg";

                        ?>
                        <div class="item">
                            <li>
                                <div class="slider-info banner-view bg bg2"
                                    style="background: url('<?php echo $bg_image; ?>') no-repeat center; background-size: cover;">
                                    <div class="banner-info">
                                        <h3><?php echo htmlspecialchars($show['title']); ?></h3>
                                        <p><?php echo implode(', ', $groupedDates); ?></p>
                                        <p class='show-description' style="margin-top: -20px;">
                                            <?php echo nl2br(htmlspecialchars($show['description'])); ?>
                                        </p>
                                        <p style="margin-top: -20px; margin-bottom: 0;"><a
                                                href="views/client/shows/show_details.php?id=<?php echo $show['id']; ?>"
                                                style="color: white; text-decoration: underline;">Më shumë info</a></p>
                                        <p style="margin-top: 0;"><a
                                                href="views/client/reserve.php?id=<?php echo $show['id']; ?>"
                                                style="color: white; text-decoration: underline">Rezervo</a></p>
                                        <a href="#<?php echo $popupId; ?>" class="popup-with-zoom-anim play-view1">
                                            <span class="video-play-icon">
                                                <span class="fa fa-play"></span>
                                            </span>
                                            <h6>Shiko Trailerin</h6>
                                        </a>
                                        <div id="<?php echo $popupId; ?>" class="zoom-anim-dialog mfp-hide small-dialog">
                                            <iframe src="https://www.youtube.com/embed/<?php echo $videoId; ?>"
                                                allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    <?php }
                } else { ?>
                    <div class="item">
                        <li>
                            <div class="slider-info banner-view bg bg2"
                                style="background: url('assets/img/background-image.png') no-repeat center; background-size: cover;">
                                <div class="banner-info">
                                    <h3>Teatri Metropol</h3>
                                    <p>Nuk ka shfaqje për momentin! Ju ftojmë të na ndiqni në vazhdim! Faleminderit!</p>
                                </div>
                            </div>
                        </li>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </section>

    <section class="w3l-grids">
        <div class="grids-main py-5">
            <div class="container py-lg-3">
                <div class="headerhny-title" style="margin-bottom: -20px;">
                    <div class="w3l-title-grids">
                        <div class="headerhny-left">
                            <h3 class="hny-title">Rreth nesh</h3>
                        </div>
                        <div class="headerhny-right text-lg-right">
                            <h4><a class="show-title" href="views/client/about.php">Më shumë</a></h4>
                        </div>
                    </div>
                </div>
                <!-- About Teatri Metropol Section -->
                <div class="about-section mt-2" style="padding-top: 50px;">
                    <div class="about-container"
                        style="display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">

                        <!-- Text Content -->
                        <div class="about-text" style="flex: 1 1 50%; min-width: 300px;">
                            <div class="single-event-content" display="flex"
                                style=" display: flex; flex-direction: column; align-items: center; justify-content: center;;">
                                <p><strong style="color: #8f793f;">Teatri Metropol</strong>
                                    është një qendër dinamike
                                    kulturore që synon të sjellë për publikun shqiptar dhe ndërkombëtar vepra teatrore
                                    me nivel të lartë artistik. I udhëhequr nga vlerat e gjithëpërfshirjes, dialogut
                                    konstruktiv dhe humanizmit universal, Metropoli është një hapësirë ku arti takon
                                    komunitetin dhe frymëzon reflektim, bashkëbisedim dhe rritje.</p>
                                <br>
                                <p><strong style="color: #8f793f;">Misioni ynë</strong> është të realizojmë shfaqje
                                    cilësore – shqiptare dhe botërore – që flasin me ndershmëri dhe forcë artistike për
                                    realitetin dhe shpirtin njerëzor. Vizioni ynë është të ndërtojmë një standard të ri
                                    në cilësinë e prodhimit artistik dhe trajnimit profesional të talenteve të reja,
                                    duke i shërbyer një audience të gjerë: fëmijë, të rinj dhe të rritur...</p>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="about-image" style="flex: 1 1 30%; min-width: 300px;">
                            <img src="/biletaria_online/assets/img/about/1.jpg" alt="Teatri Metropol Tirane"
                                style="width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        </div>

                    </div>
                </div>

            </div>
        </div>
        </div>
    </section>
    <section class="w3l-grids">
        <div class="grids-main py-5">
            <div class="container py-lg-3">
                <div class="headerhny-title" style="margin-bottom: -20px;">
                    <div class="w3l-title-grids">
                        <div class="headerhny-left">
                            <h3 class="hny-title">Sezoni i Ri</h3>
                        </div>
                        <div class="headerhny-right text-lg-right">
                            <h4><a class="show-title" href="views/client/shows/index.php">Më shumë</a></h4>
                        </div>
                    </div>
                </div>
                <div class="loading-spinner-wrapper" id="shows-loader">
                    <div class="loading-spinner"></div>
                </div>
                <div class="owl-three owl-carousel owl-theme shows-container" id="shows-container"></div>
            </div>
        </div>
    </section>
    <!--grids-sec2-->
    <!--mid-slider -->
    <section class="w3l-mid-slider position-relative">
        <div class="companies20-content">
            <div class="grids-main py-5" style="margin-bottom: -110px; margin-top: -60px;">
                <div class="container py-lg-3">
                    <div class="headerhny-title">
                        <div class="w3l-title-grids">
                            <div class="headerhny-left">
                                <h3 class="hny-title">Evente të tjera</h3>
                            </div>
                            <div class="headerhny-right text-lg-right">
                                <h4><a class="show-title" href="views/client/events/index.php">Më shumë</a></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="owl-mid owl-carousel owl-theme">
                <?php
                $now = date('Y-m-d');
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
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $now);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {

                    while ($event = $result->fetch_assoc()) {
                        $posterUrl = "includes/get_image.php?event_id=" . $event['id'];

                        $datesQuery = $conn->prepare("SELECT event_date FROM event_dates WHERE event_id = ? ORDER BY event_date ASC");
                        $datesQuery->bind_param("i", $event['id']);
                        $datesQuery->execute();
                        $datesResult = $datesQuery->get_result();
                        $dates = [];
                        while ($row = $datesResult->fetch_assoc()) {
                            $dates[] = $row['event_date'];
                        }

                        $groupedDates = groupDates($dates);

                        $videoId = '';
                        $parsedUrl = parse_url($event['trailer']);
                        if (isset($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $queryParams);
                            $videoId = $queryParams['v'] ?? '';
                        } elseif (isset($parsedUrl['path'])) {
                            $pathParts = explode('/', trim($parsedUrl['path'], '/'));
                            $videoId = end($pathParts);
                        }

                        $popupId = 'small-event-dialog' . $event['id'];

                        $bg_image = "https://img.youtube.com/vi/$videoId/maxresdefault.jpg";

                        ?>
                        <div class="item">
                            <li>
                                <div class="slider-info mid-view bg bg2"
                                    style="background: url('<?php echo $bg_image; ?>') no-repeat center; background-size: cover; height: 480px;">
                                    <div class="container">
                                        <div class="movie-card">
                                            <img src="<?php echo htmlspecialchars($posterUrl) ?>" alt="Poster"
                                                class="movie-poster">
                                            <div class="mid-info">
                                                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                                                <p><?php echo implode(', ', $groupedDates); ?></p>
                                                <p class='show-description' style="margin-top: -20px;">
                                                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                                                </p>
                                                <p style="margin-top: -10px; margin-bottom: 0;"><a
                                                        href="views/client/events/event_details.php?id=<?php echo $event['id']; ?>"
                                                        style="color: white; text-decoration: underline">Më shumë info</a></p>
                                                <p style="margin-top: 0;"><a
                                                        href="views/client/reserve.php?id=<?php echo $event['id']; ?>"
                                                        style="color: white; text-decoration: underline">Rezervo</a></p>
                                                <a class="watch popup-with-zoom-anim play-view1"
                                                    href="#<?php echo $popupId; ?>"><span class="fa fa-play"
                                                        aria-hidden="true"></span> Shiko Trailerin</a>
                                                <div id="<?php echo $popupId; ?>"
                                                    class="zoom-anim-dialog mfp-hide small-dialog">
                                                    <iframe src="https://www.youtube.com/embed/<?php echo $videoId; ?>"
                                                        allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    <?php }
                } else { ?>
                    <div class="item">
                        <li>
                            <div class="slider-info mid-view mid-top2 bg bg2"
                                style="background: url('assets/img/background-image.png') no-repeat center; background-size: cover; height: 480px;">
                                <div class="container">
                                    <div class="movie-card">
                                        <img src="assets/img/metropol_icon.png" alt="Poster" class="movie-poster">
                                        <div class="mid-info">
                                            <h3>Teatri Metropol</h3>
                                            <p>Nuk ka evente të tjera për momentin! Ju ftojmë të na ndiqni në vazhdim!
                                                Faleminderit!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </section>
    <!-- Map Section -->
    <div class="map-section">
        <div class="grids-main py-5" style="margin-bottom: -70px; margin-top: -60px;">
            <div class="container py-lg-3">
                <div class="headerhny-title">
                    <div class="w3l-title-grids">
                        <div class="headerhny-left">
                            <h3 class="hny-title">Vendodhja</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="map-container">
            <iframe style="border:0; width: 100%;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.015758069152!2d19.81454687450071!3d41.33027069953852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1350310e4a33be71%3A0x41ea934fda84bd6d!2sMetropol%20Theater!5e0!3m2!1sen!2s!4v1746394063143!5m2!1sen!2s"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>


    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>
    <!-- responsive tabs -->
    <script src="assets/js/jquery-1.9.1.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/easyResponsiveTabs.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Horizontal Tab
            $('#parentHorizontalTab').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                tabidentify: 'hor_1', // The tab groups identifier
                activate: function (event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#nested-tabInfo');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });
        });
    </script>
    <!--/theme-change-->
    <script src="assets/js/theme-change.js"></script>
    <script src="assets/js/owl.carousel.js"></script>
    <!-- script for banner slider-->

    <script>
        $(document).ready(function () {
            $('.owl-one').owlCarousel({
                stagePadding: 280,
                loop: true,
                margin: 20,
                nav: true,
                responsiveClass: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                autoplayHoverPause: false,
                responsive: {
                    0: {
                        items: 1,
                        stagePadding: 40,
                        nav: false
                    },
                    480: {
                        items: 1,
                        stagePadding: 60,
                        nav: true
                    },
                    667: {
                        items: 1,
                        stagePadding: 80,
                        nav: true
                    },
                    1000: {
                        items: 1,
                        nav: true
                    }
                }
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            $('.owl-mid').owlCarousel({
                loop: true,
                margin: 0,
                nav: false,
                responsiveClass: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                autoplayHoverPause: false,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    480: {
                        items: 1,
                        nav: false
                    },
                    667: {
                        items: 1,
                        nav: true
                    },
                    1000: {
                        items: 1,
                        nav: true
                    }
                }
            })
        })
    </script>
    <!-- script for owlcarousel -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Magnific Popup for the first time (this will initialize the first 2)
            $('.popup-with-zoom-anim').magnificPopup({
                type: 'inline',
                fixedContentPos: true,
                fixedBgPos: true,
                overflowY: 'auto',
                closeBtnInside: true,
                preloader: false,
                midClick: true,
                removalDelay: 300,
                mainClass: 'my-mfp-zoom-in'
            });
        });
    </script>
    <!-- disable body scroll which navbar is in active -->
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });
    </script>
    <!-- disable body scroll which navbar is in active -->

    <!--/MENU-JS-->
    <script>
        $(window).on("scroll", function () {
            var scroll = $(window).scrollTop();

            if (scroll >= 80) {
                $("#site-header").addClass("nav-fixed");
            } else {
                $("#site-header").removeClass("nav-fixed");
            }
        });

        //Main navigation Active Class Add Remove
        $(".navbar-toggler").on("click", function () {
            $("header").toggleClass("active");
        });
        $(document).on("ready", function () {
            if ($(window).width() > 991) {
                $("header").removeClass("active");
            }
            $(window).on("resize", function () {
                if ($(window).width() > 991) {
                    $("header").removeClass("active");
                }
            });
        });
    </script>

    <script>
        async function fetchFilteredShows() {
            const genre = "";
            const dateFilterValue = "available";
            const showsContainer = document.getElementById("shows-container");

            try {
                const response = await fetch('views/client/shows/filter_shows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `show_time_filter=${encodeURIComponent(dateFilterValue)}&genre_id=${encodeURIComponent(genre)}`
                });

                const html = await response.text();
                document.getElementById('shows-loader').style.display = 'none';

                showsContainer.innerHTML = html;

                setTimeout(() => {
                    if ($('.owl-three').hasClass('owl-loaded')) {
                        $('.owl-three').trigger('destroy.owl.carousel');
                    }

                    $('.owl-three').owlCarousel({
                        stagePadding: 0,
                        loop: true,
                        margin: 20,
                        nav: true,
                        responsiveClass: true,
                        autoplay: true,
                        autoplayTimeout: 5000,
                        autoplaySpeed: 1000,
                        autoplayHoverPause: false,
                        responsive: {
                            0: {
                                items: 1,
                                nav: false,
                                stagePadding: 0,
                            },
                            390: {
                                items: 1,
                                nav: false,
                                stagePadding: 30,
                            },
                            450: {
                                items: 1,
                                nav: false,
                                stagePadding: 40,
                            },
                            490: {
                                items: 1,
                                nav: true,
                                stagePadding: 75
                            },
                            550: {
                                items: 1,
                                nav: true,
                                stagePadding: 90
                            },
                            650: {
                                items: 1,
                                nav: true,
                                stagePadding: 140
                            },
                            750: {
                                items: 2,
                                nav: true,
                                stagePadding: 30
                            },
                            800: {
                                items: 2,
                                nav: true,
                                stagePadding: 40
                            },
                            940: {
                                items: 2,
                                nav: true,
                                stagePadding: 120
                            },
                            1080: {
                                items: 3,
                                nav: true,
                                stagePadding: 40
                            }
                        }
                    });
                }, 100);
            } catch (error) {
                document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
            }
        }

        fetchFilteredShows();
    </script>

    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>