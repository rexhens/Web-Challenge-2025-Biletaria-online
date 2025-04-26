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

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/links.php'; ?>
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="/biletaria_online/assets/img/metropol_icon.png">
    <title>Teatri Metropol | <?php echo htmlspecialchars($event['title']); ?></title>
    <link rel="stylesheet" href="/biletaria_online/assets/css/styles.css">
</head>

<body>

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

<!--
    <div class="info-container">
        <div class='errors' id="message" style='background-color: rgb(130, 152, 145, 0.5)'>
            <p id="info" style='color: #E4E4E4;'></p>
        </div>
    </div>
-->
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

    //let info = document.getElementById('info');

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cover').addEventListener('click', function () {
            if (isMuted) {
                player.unMute();
                isMuted = false;
                //info.textContent = "Çaktivizo zërin!";
            } else {
                player.mute();
                isMuted = true;
                //info.textContent = "Aktivizo zërin!";
            }
        });
    });
    /*
            document.getElementById('overlay').addEventListener('mouseover', function () {
                const message = document.getElementById('message');
                if (isMuted) {
                    info.textContent = "Aktivizo zërin!"
                    message.classList.add('show');
                } else {
                    info.textContent = "Çaktivizo zërin!"
                    message.classList.add('show');
                }
            });

            document.getElementById('overlay').addEventListener('mouseleave', function () {
                const message = document.getElementById('message');
                message.classList.remove('show');
            });
    */
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    document.head.appendChild(tag);
</script>
</body>

</html>