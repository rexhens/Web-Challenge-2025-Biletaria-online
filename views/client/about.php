<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
$pageTitle = "Rreth nesh";
$pageStyles = [
    "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css",
    '/biletaria_online/assets/css/style-starter.css',
    '/biletaria_online/assets/css/navbar.css',
    '/biletaria_online/assets/css/footer.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>

    <style>
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

        .section-spacing {
            padding-top: 60px;
            padding-bottom: 40px;
        }


        body {
            background-color: #111;
            font-family: var(--default-font);
            color: var(--text-color);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }


        .carousel-width {
            width: 100%;
            margin: 0 auto;
            overflow: hidden;
            box-sizing: border-box;
        }

        .owl-carousel .item {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-img {
            width: 100%;
            height: auto;
            max-width: 100%;
            display: block;
            border-radius: 4px;
            transition: transform 0.3s ease;
        }

        .carousel-img:hover {
            transform: scale(1.02);
        }

        #lightbox-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.9);
            display: none;
            /* Hidden by default */
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        #lightbox-overlay.show {
            display: flex;
            /* Only display when needed */
        }

        #lightbox-overlay img {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
        }

        #lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 2rem;
            color: #fff;
            cursor: pointer;
            z-index: 10001;
        }


        .hny-title {
            color: var(--text-color);
            font-family: var(--heading-font);
            margin-bottom: 20px;
        }

        .map-container iframe {
            filter: invert(90%) hue-rotate(180deg);
            width: 100%;
            border: 0;
        }

        .map-container {
            overflow: hidden;
            width: 100%;
        }
    </style>

</head>

<body class="w3l-ab-grids py-5">

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

    <div class="container py-lg-4" style="margin-top: 60px;">
        <div class="row ab-grids-sec align-items-center">
            <div class="col-lg-12 ab-left pl-lg-4 mt-lg-1 mt-1">
                <h3 class="hny-title" style="color:#836e4f;">Mirë se vini në Teatrin Metropol – Shtëpia e Artit dhe
                    Dialogut</h3>

                <div class="column mt-2">
                    <div class="single-event-content">
                        <p style="color: white;"><strong style="color:#836e4f;">Teatri Metropol</strong> është një
                            qendër dinamike kulturore
                            që synon të sjellë për
                            publikun shqiptar dhe ndërkombëtar vepra teatrore me nivel të lartë artistik. I udhëhequr
                            nga vlerat e gjithëpërfshirjes, dialogut konstruktiv dhe humanizmit universal, Metropoli
                            është një hapësirë ku arti takon komunitetin dhe frymëzon reflektim, bashkëbisedim dhe
                            rritje.</p>

                        <p style="color: white;"><strong style="color:#836e4f;">Misioni ynë</strong> është të realizojmë
                            shfaqje cilësore –
                            shqiptare dhe botërore –
                            që flasin me ndershmëri dhe forcë artistike për realitetin dhe shpirtin njerëzor. Vizioni
                            ynë është të ndërtojmë një standard të ri në cilësinë e prodhimit artistik dhe trajnimit
                            profesional të talenteve të reja, duke i shërbyer një audience të gjerë: fëmijë, të rinj dhe
                            të rritur.</p>

                        <h6 style="margin-top: 12px; margin-bottom: 2px; color:#836e4f;">Platforma jonë
                            artistike është e ndarë në tre
                            shtylla:</h6>
                        <ul>
                            <li style="color: white;"><strong style="color:#836e4f;">Teatri i të Rriturve:</strong> 6
                                premiera çdo vit, me
                                produksione origjinale dhe
                                bashkëpunime me artistë të jashtëm. Dy prej tyre janë të lëvizshme dhe çdo shfaqje jepet
                                deri në 15 herë.</li>
                            <li style="color: white;"><strong style="color:#836e4f;">Teatri i Fëmijëve:</strong> 4
                                premiera në vit, të
                                krijuara me dashuri për
                                publikun më të vogël, nga të cilat dy janë të lëvizshme dhe secila shfaqet deri në 20
                                herë.</li>
                            <li style="color: white;"><strong style="color:#836e4f;">Teatri i të Rinjve:</strong> 2
                                premiera në vit të
                                dedikuara moshës 14-18 vjeç,
                                me një fokus të veçantë tek temat bashkëkohore dhe përfshirja aktive e të rinjve në
                                botën e teatrit.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <section class="w3l-theatre" id="theatre">
        <div class="container py-lg-4">
            <div class="text-center mb-4">
                <h2 style="color:#836e4f; font-weight: 700;">Pamje nga Teatri</h2>
            </div>
            <div class="carousel-width">
                <div class="owl-theatre owl-carousel owl-theme mb-lg-5">
                    <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/1.jpg"
                            alt="Theatre Image 1"></div>
                    <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/2.jpg"
                            alt="Theatre Image 2"></div>
                    <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/3.jpg"
                            alt="Theatre Image 3"></div>
                    <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/4.jpg"
                            alt="Theatre Image 4"></div>

                    <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/6.jpg"
                            alt="Theatre Image 6"></div>
                </div>
            </div>
        </div>
    </section>

    <div id="lightbox-overlay">
        <span id="lightbox-close">&times;</span>
        <img id="lightbox-img" src="" alt="Full Screen Image">
    </div>

    <div class="map-section">
        <div class="grids-main py-5" style="margin-bottom: -70px; margin-top: -100px;">
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

    <script src="../../assets/js/jquery-3.3.1.min.js"></script>
    <!--/theme-change-->
    <script src="../../assets/js/owl.carousel.js"></script>

    <script>
        $(document).ready(function () {
            $('.owl-theatre').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplaySpeed: 1000,
                autoHeight: true,
                responsive: {
                    0: { items: 1 },
                    600: { items: 2 },
                    1000: { items: 3 }
                }
            });

            $('.carousel-img').on('click', function () {
                $('#lightbox-img').attr('src', $(this).attr('src'))
                $('#lightbox-overlay').addClass('show')
            })

            $('#lightbox-close, #lightbox-overlay').on('click', function (e) {
                if (e.target.id === 'lightbox-overlay' || e.target.id === 'lightbox-close') {
                    $('#lightbox-overlay').removeClass('show')
                }
            })

        });
    </script>

</body>

</html>