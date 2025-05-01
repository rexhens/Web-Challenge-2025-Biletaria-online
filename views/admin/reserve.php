<?php
/** @var mysqli $conn */
require "../../config/db_connect.php";
require "../../auth/auth.php";
require "../../includes/functions.php";

/* 1. get show id ------------------------------------------------- */
$show_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if (!$show_id) {
    die("Invalid show ID.");
}

/* 2. fetch title + price (used later on the ticket) -------------- */
$info = $conn->prepare("SELECT title, price FROM shows WHERE id = ? LIMIT 1");
$info->bind_param("i", $show_id);
$info->execute();
$info->bind_result($showTitle, $ticketPrice);
$info->fetch();
$info->close();

/* 3. fetch all distinct dates for this show --------------------- */
$dq = $conn->prepare(
    "SELECT DISTINCT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC"
);
$dq->bind_param("i", $show_id);
$dq->execute();
$res = $dq->get_result();
$dates = [];
while ($r = $res->fetch_assoc())
    $dates[] = $r['show_date'];   // yyyy-mm-dd
$dq->close();

$groupedDates = groupDates($dates);          // helper from includes/functions.php
$today = new DateTime('today');

/* 4. halls + times for this show -------------------------------- */
$hallTimes = [];
$ht = $conn->prepare("SELECT hall, time FROM shows WHERE id = ?");
$ht->bind_param("i", $show_id);
$ht->execute();
$ht->bind_result($hall, $rawTime);
while ($ht->fetch()) {
    $hallTimes[$hall][] = (new DateTime($rawTime))->format('g:i A');
}
$ht->close();
ksort($hallTimes);
foreach ($hallTimes as &$t)
    sort($t);
unset($t);

$conn->close();
/* --------------------------------------------------------------- */
function seatRow(int $seat, int $perRow = 20): string
{
    return chr(64 + (int) ceil($seat / $perRow));            // 1-20→A, 21-40→B, …
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket Booking</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/style-starter.css">
    <link rel="stylesheet" href="https://npmcdn.com/flickity@2/dist/flickity.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/progress.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/ticket-booking.css">

    <!-- ..............For progress-bar............... -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/e-ticket.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/payment.css" />
    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700" rel="stylesheet">

    <link rel="stylesheet" href="/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/biletaria_online/assets/css/sb-admin-2.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="/biletaria_online/assets/css/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">



</head>

<body>
    <header id="site-header" class="w3l-header fixed-top">

        <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>
    </header>

    <div class="container" id="progress-container-id">
        <div class="row">
            <div class="col">
                <div class="px-0 pt-4 pb-0 mt-3 mb-3">
                    <form id="form">
                        <ul id="progressbar" class="progressbar-class">
                            <li class="active" id="step1">Rezervimi i kohes</li>
                            <li id="step2" class="not_active">Rezervimi i vendeve</li>
                            <li id="step3" class="not_active">Informacioni i klientit</li>
                            <li id="step4" class="not_active">Bileta</li>
                        </ul>
                        <br>
                        <fieldset>
                            <?php
                            /* -----------------------------------------------------------------
                             *  SHOW-DATE CAROUSEL  +  SCREEN / TIME LIST
                             * -----------------------------------------------------------------*/
                            ?>
                            <div id="screen-select-div">
                                <h2>Show time Selection</h2>
                                <p><span>Datat: </span><?php echo implode(', ', $groupedDates); ?></p>

                                <!------ 1. DATE CAROUSEL ------------------------------------------------->
                                <div class="carousel carousel-nav"
                                    data-flickity='{"contain": true, "pageDots": false }'>
                                    <?php
                                    foreach ($dates as $idx => $dateStr) {
                                        $d = new DateTime($dateStr);
                                        $dayNum = $d->format('j');          // 1–31
                                        $month = $d->format('M');          // Jan, Feb …
                                        $weekday = $d->format('l');          // Monday …
                                        $diffDays = (int) $today->diff($d)->format('%r%a');

                                        $label = ($diffDays === 0)
                                            ? 'Today'
                                            : (($diffDays === 1) ? 'Tomorrow' : $weekday);

                                        $cellId = $idx + 1;                  // keep 1-based IDs for JS
                                        echo <<<HTML
      <div class="carousel-cell" id="$cellId" onclick="myFunction($cellId)">
        <div class="date-numeric">$dayNum</div>
        <div class="date-month">$month</div>
        <div class="date-day">$label</div>
      </div>
HTML;
                                    }
                                    ?>
                                </div>

                                <!------ 2. FETCH HALLS & TIMES FROM DATABASE -------------------------->

                                <!------ 3.  SCREEN / TIME LIST ----------------------------------------->
                                <ul class="time-ul">
                                    <?php foreach ($hallTimes as $hall => $times): ?>
                                    <li class="time-li">
                                        <div class="screens">Salla
                                            <?php echo htmlspecialchars($hall); ?>
                                        </div>
                                        <div class="time-btn">
                                            <?php foreach ($times as $t): ?>
                                            <button class="screen-time" onclick="timeFunction()">
                                                <?php echo $t; ?>
                                            </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <input id="screen-next-btn" type="button" name="next-step" class="next-step"
                                value="Continue Booking" disabled />
                        </fieldset>
                        <fieldset>

                            <div>
                                <iframe id="seat-sel-iframe"
                                    style="  box-shadow: 0 14px 12px 0 var(--theme-border), 0 10px 50px 0 var(--theme-border); width: 770px; height: 1200px; display: block; margin-left: auto; margin-right: auto;"
                                    src="../../seat_selection/seat_sel.php?show_id=<?php echo $show_id; ?>"></iframe>
                            </div>
                            <br>
                            <input type="button" name="next-step" class="next-step" value="Next" />
                            <input type="button" name="previous-step" class="previous-step" value="Back" />
                        </fieldset>
                        <fieldset>
                            <!-- Payment Page -->
                            <fieldset>
                                <h2>Enter your details</h2>
                                <div class="payment-row">
                                    <div class="col-50">
                                        <label for="fullname">Full name</label>
                                        <input id="fullname" name="fullname" type="text" required>
                                    </div>
                                    <div class="col-50">
                                        <label for="email">Email</label>
                                        <input id="email" name="email" type="email" required>
                                    </div>
                                </div>
                                <div class="payment-row">
                                    <div class="col-50">
                                        <label for="phone">Phone</label>
                                        <input id="phone" name="phone" type="tel" required>
                                    </div>
                                    <div class="col-50">
                                        <label for="notes">Notes (optional)</label>
                                        <input id="notes" name="notes" type="text">
                                    </div>
                                </div>

                                <input type="button" class="next-step" value="Review Ticket">
                                <input type="button" class="previous-step" value="Back">
                            </fieldset>

                            <fieldset>
                                <h2>Bileta</h2>
                                <div class="ticket-body">
                                    <div class="ticket">
                                        <div class="holes-top"></div>
                                        <div class="title">
                                            <p class="cinema">Teatri Metropol</p>
                                            <p class="movie-title"><?= htmlspecialchars($showTitle) ?></p>
                                        </div>
                                        <div class="poster">
                                            <img src="../../includes/get_image.php?show_id=<?php echo $show_id; ?>"
                                                alt="Poster">
                                        </div>
                                        <div class="info">
                                            <!-- SCREEN / ROW / SEAT -->
                                            <table class="info-table ticket-table">
                                                <tr>
                                                    <th>SCREEN</th>
                                                    <th>ROW</th>
                                                    <th>SEAT</th>
                                                </tr>
                                                <?php
                                                $seats = array_filter(array_map(
                                                    'intval',
                                                    explode(',', $_POST['chosen_seats'] ?? '')
                                                ));
                                                $hall = htmlspecialchars($_POST['chosen_hall'] ?? '');
                                                foreach ($seats as $s):
                                                    ?>
                                                    <tr>
                                                        <td class="bigger"><?= $hall ?></td>
                                                        <td class="bigger"><?= seatRow($s) ?></td>
                                                        <td class="bigger"><?= $s ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>

                                            <!-- PRICE / DATE / TIME -->
                                            <table class="info-table ticket-table">
                                                <tr>
                                                    <th>CMIMI</th>
                                                    <th>DATA</th>
                                                    <th>KOHA</th>
                                                </tr>
                                                <tr>
                                                    <td>ALL.<?= number_format($ticketPrice, 2) ?></td>
                                                    <td><?= date('d/m/y', strtotime($_POST['chosen_date'] ?? '')) ?>
                                                    </td>
                                                    <td><?= date('H:i', strtotime($_POST['chosen_time'] ?? '')) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="holes-lower"></div>

                                        <div class="serial">
                                            <table class="barcode ticket-table">
                                                <tr>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                    <td style="background-color:black;"></td>
                                                    <td style="background-color:white;"></td>
                                                </tr>
                                            </table>
                                            <table class="numbers ticket-table">
                                                <tr>
                                                    <td>9</td>
                                                    <td>1</td>
                                                    <td>7</td>
                                                    <td>3</td>
                                                    <td>7</td>
                                                    <td>5</td>
                                                    <td>4</td>
                                                    <td>4</td>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>4</td>
                                                    <td>1</td>
                                                    <td>4</td>
                                                    <td>7</td>
                                                    <td>8</td>
                                                    <td>7</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                    <td>1</td>
                                                    <td>4</td>
                                                    <td>5</td>
                                                    <td>2</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- download / share buttons -->
                                <div style="text-align:center; margin-top:1rem;">
                                    <button type="button" id="dl-ticket" class="home-page-btn">Shkarko Biletën</button>
                                    <button type="button" id="share-ticket" class="home-page-btn"
                                        style="display:none">Ndaj Biletën</button>
                                </div>

                                <input type="button" name="previous-step" class="home-page-btn"
                                    value="Shkoni tek Kryefaqja" onclick="location.href='../../index.php';" />
                            </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    let prevId = "1";

    window.onload = function () {
        document.getElementById("screen-next-btn").disabled = true;
    }

    function timeFunction() {
        document.getElementById("screen-next-btn").disabled = false;
    }

    function myFunction(id) {
        document.getElementById(prevId).style.background = "rgb(243, 235, 235)";
        document.getElementById(id).style.background = "#836e4f";
        prevId = id;
    }
</script>

<script src="https://npmcdn.com/flickity@2/dist/flickity.pkgd.js"></script>
<script type="text/javascript" src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'>
</script>
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="../../assets/js/theme-change.js"></script>

<script type="text/javascript" src="../../assets/js/ticket-booking.js"></script>

<!-- 1. bring in html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer" defer></script>

<!-- 2. after that (or in a separate .js file), your download/share code -->
<script defer>
    document.addEventListener('DOMContentLoaded', () => {
        const ticket = document.querySelector('.ticket');
        const fileName = 'bileta_<?= $show_id ?>.png';

        async function toPNG() {
            const canvas = await html2canvas(ticket, { scale: 2 });
            return canvas.toDataURL('image/png');
        }

        document.getElementById('dl-ticket').onclick = async () => {
            const url = await toPNG();
            const a = Object.assign(document.createElement('a'),
                { href: url, download: fileName });
            a.click();
        };

        const shareBtn = document.getElementById('share-ticket');
        if (navigator.canShare && navigator.canShare({ files: [] })) {
            shareBtn.style.display = '';
            shareBtn.onclick = async () => {
                const blob = await (await fetch(await toPNG())).blob();
                await navigator.share({
                    files: [new File([blob], fileName, { type: 'image/png' })],
                    title: 'Bileta ime'
                });
            };
        }
    });
</script>

</html>