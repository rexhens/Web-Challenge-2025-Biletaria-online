<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
if (!isset($_GET['id'])) {
    showError("Nuk ka një event të vlefshëm!");
}

$event_id = intval($_GET['id']);

$query = "SELECT *
          FROM events
          WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    showError("Një problem ndodhi! Provoni më vonë!");
}

$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    showError("Nuk u gjet një event me id e kërkuar.");
}

$datesQuery = $conn->prepare("SELECT event_date FROM event_dates WHERE event_id = ? ORDER BY event_date ASC");
$datesQuery->bind_param("i", $event['id']);
$datesQuery->execute();
$datesResult = $datesQuery->get_result();
$dates = [];
while ($row = $datesResult->fetch_assoc()) {
    $dates[] = $row['event_date'];
}

$groupedDates = groupDates($dates);

?>

<?php
$pageTitle = htmlspecialchars($event['title']);
$pageStyles = [
    "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css",
    "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css",
    '/biletaria_online/assets/css/footer.css',
    '/biletaria_online/assets/css/styles.css',
    '/biletaria_online/assets/css/navbar.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        body {
            padding-top: 70px !important;
            overflow-x: hidden !important;
        }

        .footer-glass {
            width: calc(100% - 20px);
        }

        .footer-bottom {
            margin-left: -20px;
        }

        #reviews {;
            margin: auto;
        }

        .owl-carousel .owl-item {
            transition: transform 0.3s ease;
            opacity: 0.5;
            transform: scale(0.95);
        }

        .owl-carousel .owl-item.active.center {
            opacity: 1;
            transform: scale(1);
        }

        .review {
            background: rgba(228, 228, 228, 0.04);
            border: 1px solid var(--surface-color);
            border-radius: 16px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            padding: 20px;
            height: 100%;
        }

        .star-rating {
            color: var(--accent-color);
            font-size: 1.3em;
            margin-bottom: 8px;
        }

        .review strong {
            color: var(--accent2-color);
            font-size: 1.1em;
        }

        .review p {
            color: var(--surface-color);
            line-height: 1.6;
        }

        .comment-preview,
        .comment-full {
            position: relative;
        }

        .read-more, .read-less {
            color: var(--accent-color);
            cursor: pointer;
            margin-left: 5px;
            font-family: var(--nav-font);
        }

        .read-more:hover, .read-less:hover {
            text-decoration: underline;
        }

        .comment-full {
            display: none;
        }

        .owl-nav {
            text-align: center;
            margin-top: 20px;
        }

        .owl-nav button {
            background: var(--accent2-color) !important;
            color: white !important;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            margin: 0 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .owl-nav button:hover {
            background: var(--heading2-color) !important;
        }
    </style>
</head>

<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

<div class="video-container">
    <?php
    $videoId = '';
    $parsedUrl = parse_url($event['trailer']);
    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
        $videoId = $queryParams['v'] ?? '';
    } elseif (isset($parsedUrl['path'])) {
        $pathParts = explode('/', trim($parsedUrl['path'], '/'));
        $videoId = end($pathParts);
    }
    ?>
    <div id="player"></div>
    <div id="cover"></div>
    <div class="overlay">
        <div class="show-poster">
            <img src="/biletaria_online/includes/get_image.php?event_id=<?php echo $event['id']; ?>" alt="Poster">
        </div>
        <div class="show-reserve">
            <div>
                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
            </div>
            <button onclick="redirectTo('../reserve.php?id=<?php echo $event['id']; ?>')">Rezervo</button>
        </div>
    </div>
</div>

<div class="show-container">
    <div class="show-info">
        <h3 class="hidden"><?php echo htmlspecialchars($event['title']); ?></h3>
        <p><span>Datat: </span><?php echo implode(', ', $groupedDates) ?></p>
        <p><span>Ora: </span><?php echo date('H:i', strtotime($event['time'])); ?></p>
        <p><span>Salla: </span><?php echo htmlspecialchars($event['hall']); ?></p>
        <p><span>Çmimi: </span><?php echo htmlspecialchars($event['price']); ?> Lekë</p>
    </div>
    <div class="show-content">
        <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
    </div>
    <div class='btn-group'>
        <button onclick="redirectTo('../reserve.php?id=<?php echo $event['id']; ?>')">Rezervo</button>
        <?php if (checkAdmin($conn)): ?>
            <button onclick="redirectTo('reservations?id=<?= $event['id'] ?>')">Rezervime</button>
        <?php endif; ?>
    </div>
</div>

<h2>Vlerësime & Komente</h2>
<hr style="width: 100px; margin-top: -20px; margin-bottom: 20px; border: none; height: 2px; background-color: var(--accent2-color) !important;">
<section id="reviews" class="owl-carousel owl-theme">

    <?php
    $sql = "SELECT res.full_name, r.date, r.comment, r.rating
                FROM reviews r
                JOIN reservations res 
                    ON r.email = res.email AND r.event_id = res.event_id
                WHERE r.event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event['id']);
    if(!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
    $reviews = $stmt->get_result();
    if ($reviews->num_rows > 0) {
        while ($review = $reviews->fetch_assoc()) { ?>
            <div class="item review">
                <div class="star-rating">
                    <?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?>
                </div>
                <p><strong><?= htmlspecialchars($review['full_name']) ?></strong> | <?php
                    $date = new DateTime($review['date']);
                    $day = $date->format('d');
                    $month = muajiNeShqip($date->format('M'));
                    $year = $date->format('Y');
                    echo $day . " " . $month . " " . $year;
                    ?></p>
                <div class="comment">
                    <?php
                    $comment = trim($review['comment'] ?? '');
                    $hasComment = $comment !== '';
                    $needPreview = $hasComment && mb_strlen($comment) > 110;
                    ?>
                    <p class="comment-preview">
                        <?php
                        if ($hasComment) {
                            echo $needPreview
                                ? htmlspecialchars(mb_substr($comment, 0, 90)) . '...'
                                : htmlspecialchars($comment);
                        } else {
                            echo 'Nuk është dhënë një koment.';
                        }
                        ?>
                        <?php if ($needPreview): ?>
                            <span class="read-more" onclick="toggleFullComment(this)">Lexo më shumë</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($hasComment && $needPreview): ?>
                        <p class="comment-full">
                            <?= htmlspecialchars($comment) ?>
                            <span class="read-less" onclick="toggleFullComment(this)"> Lexo më pak</span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php }
    } else { ?>
        <div class="item review">
            <div class="star-rating">★★★★★</div>
            <p><strong>Teatri Metropol</strong></p>
            <div class="comment">
                <p class="comment-preview">
                    Nuk ka vlerësime apo komente për këtë event!...
                    <span class="read-more" onclick="toggleFullComment(this)">Lexo më shumë</span>
                </p>
                <p class="comment-full">
                    Nuk ka vlerësime apo komente për këtë event! Ndiqni eventin dhe bëhuni të parët për të dhënë një vlerësim apo koment. Ju garantojmë një eksperiencë të mrekullueshme!
                    <br>Shënim: Formulari i vlerësimit ju vjen automatikisht në email-in tuaj pas mbarimit të eventit që keni ndjekur.
                    <span class="read-less" onclick="toggleFullComment(this)"> Lexo më pak</span>
                </p>
            </div>
        </div>
    <?php }
    ?>
</section>

<div class="info-container">
    <div class='errors show' id="message" style='background-color: rgb(130, 152, 145) !important;'>
        <p id="info" style='color: #E4E4E4;'>Kliko mbi video për të aktivizuar ose çaktivizuar zërin!</p>
    </div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

<script src="/biletaria_online/assets/js/functions.js"></script>
<script>
    var player;
    var isMuted = true;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            videoId: <?php echo json_encode($videoId); ?>,
            playerVars: {
                autoplay: 1,
                controls: 0,
                disablekb: 1,
                modestbranding: 1,
                rel: 0,
                fs: 0,
                showinfo: 0,
                loop: 1,
                mute: 1,
                playlist: <?php echo json_encode($videoId); ?>
            },
            events: {
                'onReady': function(event) {
                    event.target.mute();
                    event.target.playVideo();
                },
                'onStateChange': function(event) {
                    if (event.data === YT.PlayerState.PAUSED) {
                        player.playVideo();
                    }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cover').addEventListener('click', function () {
            if (isMuted) {
                player.unMute();
                isMuted = false;
            } else {
                player.mute();
                isMuted = true;
            }
        });
    });

    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(tag);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(document).ready(function(){
        $("#reviews").owlCarousel({
            items: 1,
            responsiveClass: true,
            loop: false,
            nav: true,
            dots: false,
            center: true,
            stagePadding: 300,
            margin: 20,
            navText: ["←", "→"],
            responsive: {
                0: {
                    margin: 10,
                    stagePadding: 0,
                },
                390: {
                    margin: 10,
                    stagePadding: 40,
                },
                450: {
                    margin: 10,
                    stagePadding: 50,
                },
                490: {
                    margin: 10,
                    stagePadding: 75
                },
                550: {
                    stagePadding: 90
                },
                650: {
                    stagePadding: 140
                },
                1200: {
                    stagePadding: 300
                }
            }
        });
    });

    function toggleFullComment(btn) {
        const comment = btn.closest('.comment');
        const preview = comment.querySelector('.comment-preview');
        const full = comment.querySelector('.comment-full');

        if (full.style.display === 'none' || full.style.display === '') {
            full.style.display = 'block';
            preview.style.display = 'none';
        } else {
            full.style.display = 'none';
            preview.style.display = 'block';
        }
    }
</script>

<script>
    const elementsToHide = document.getElementsByClassName("show");
    setTimeout(() => {
        Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
    }, 4500);
</script>
</body>

</html>