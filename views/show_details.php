<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";
redirectIfNotLoggedIn();
?>

<?php
if (!isset($_GET['id'])) {
    showError("Nuk ka një shfaqje të vlefshme!");
}

$show_id = intval($_GET['id']);

$query = "SELECT s.*, g.genre_name
          FROM shows s
          JOIN genres g ON g.id = s.genre_id
          WHERE s.id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    showError("Një problem ndodhi! Provoni më vonë!");
}

$stmt->bind_param("i", $show_id);
$stmt->execute();
$result = $stmt->get_result();
$show = $result->fetch_assoc();

if (!$show) {
    showError("Nuk u gjet një shfaqje me id e kërkuar.");
}

$actorsResult = null;
$actorsQuery = "SELECT a.* FROM actors a 
                    JOIN show_actors sa ON a.id = sa.actor_id 
                    WHERE sa.show_id = ?";
$stmtActors = $conn->prepare($actorsQuery);

if ($stmtActors === false) {
    showError("Një problem ndodhi! Provoni më vonë!");
}

$stmtActors->bind_param("i", $show_id);
$stmtActors->execute();
$actorsResult = $stmtActors->get_result();

$datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
$datesQuery->bind_param("i", $show['id']);
$datesQuery->execute();
$datesResult = $datesQuery->get_result();
$dates = [];
while ($row = $datesResult->fetch_assoc()) {
    $dates[] = $row['show_date'];
}

$groupedDates = groupDates($dates);

?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <title>Metropol Ticketing | <?php echo htmlspecialchars($show['title']); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

    <div class="video-container">
        <?php
        parse_str(parse_url($show['trailer'], PHP_URL_QUERY), $queryParams);
        $videoId = $queryParams['v'] ?? '';
        ?>
        <div id="player"></div>
        <div id="cover"></div>
        <div class="overlay">
            <div class="show-poster">
                <img src="get_image.php?show_id=<?php echo $show['id']; ?>" alt="Poster">
            </div>
            <div class="show-reserve">
                <div>
                    <h3><?php echo htmlspecialchars($show['title']); ?></h3>
                    <p><span>Zhanri: </span><?php echo htmlspecialchars($show['genre_name']); ?></p>
                </div>
                <button onclick="redirectTo('reserve.php?id=<?php echo $show['id']; ?>">Rezervo</button>
            </div>
        </div>
    </div>

    <div class="show-container">
        <div class="show-info">
            <h3 class="hidden"><?php echo htmlspecialchars($show['title']); ?></h3>
            <p class="hidden"><span>Zhanri: </span><?php echo htmlspecialchars($show['genre_name']); ?></p>
            <p><span>Datat: </span><?php echo implode(', ', $groupedDates) ?></p>
            <p><span>Ora: </span><?php echo htmlspecialchars($show['time']); ?></p>
            <p><span>Salla: </span><?php echo htmlspecialchars($show['hall']); ?></p>
            <p><span>Çmimi: </span><?php echo htmlspecialchars($show['price']); ?></p>
        </div>
        <div class="show-content">
            <p><?php echo nl2br(htmlspecialchars($show['description'])); ?></p>
        </div>
        <button onclick="redirectTo('reserve.php?id=<?php echo $show['id']; ?>">Rezervo</button>
    </div>

    <h2>Aktorët:</h2>
    <div class="actors-list">
        <?php if ($actorsResult && $actorsResult->num_rows > 0): ?>
            <?php while ($actor = $actorsResult->fetch_assoc()): ?>
                <div class="actor-card">
                    <img src="get_image.php?id=<?php echo $actor['id']; ?>"
                        alt="<?php echo htmlspecialchars($actor['name']); ?>">
                    <h4><?php echo htmlspecialchars($actor['name']); ?></h4>
                    <p>I lindur me: <?php echo htmlspecialchars($actor['birthdate']); ?></p>
                    <p>Pak biografi: <?php echo htmlspecialchars($actor['biography']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nuk ka aktorë të listuar për këtë shfaqje.</p>
        <?php endif; ?>

    </div>
<!--
    <div class="info-container">
        <div class='errors' id="message" style='background-color: rgb(130, 152, 145, 0.5)'>
            <p id="info" style='color: #E4E4E4;'></p>
        </div>
    </div>
-->
    <script src="../assets/js/functions.js"></script>
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