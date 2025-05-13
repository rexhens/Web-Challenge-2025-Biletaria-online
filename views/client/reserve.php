<?php
/** @var mysqli $conn */
require "../../config/db_connect.php";
require "../../auth/auth.php";
require "../../includes/functions.php";


/* 1. merr ID‑në e shfaqjes ----------------------------------- */

$show_id  = isset($_GET['show_id'])  ? (int)$_GET['show_id']  : 0;
$event_id = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$isEvent  = $event_id > 0 && $show_id === 0;
if (!$show_id && !$event_id) { showError("ID shfaqjeje e pavlefshme."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ticket_json'])) {
    $data = json_decode($_POST['ticket_json'], true);

    if (isset($_SESSION['user_id'])) {
        $ui = $conn->prepare("
            SELECT CONCAT(name,' ',surname), email, phone
              FROM users
             WHERE id = ?
           LIMIT 1
      ");
        $ui->bind_param("i", $_SESSION['user_id']);
        $ui->execute();
        $ui->bind_result($loggedName, $loggedEmail, $loggedPhone);
        if ($ui->fetch()) {
            $data['customer']['fullname'] = $loggedName;
            $data['customer']['email']    = $loggedEmail;
            $data['customer']['phone']    = $loggedPhone;
        }
        $ui->close();
    }
    $column = $isEvent ? 'event_id' : 'show_id';
$colShow = $isEvent ? 'NULL' : '?';
$colEvent = $isEvent ? '?' : 'NULL';
  if (isset(
      $data[$column],
      $data['seats'],
      $data['customer']['fullname'],
      $data['customer']['email'],
      $data['customer']['phone'],
      $data['hall'],
      $data['chosen_date'],
      $data['chosen_time']
  )) {
 /* ─── ruaj çdo vend ─── */
/* ─── ruaj çdo vend ─── */
/* ─── ruaj çdo vend ─── */
/* ─── ruaj çdo vend ─── */
        $insertedIds = [];

$resStmt = $conn->prepare("
            INSERT INTO reservations
                (show_id, event_id, full_name, email, phone, hall,
                 seat_id, ticket_code, expires_at, paid,
                 show_date, show_time, total_price)
             VALUES
        ($colShow, $colEvent, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?)
");

        foreach ($data['seats'] as $seat) {
            if (strtolower($data['hall']) === 'çehov') {
                $seat += 212;
            }

            $ticketCode = bin2hex(random_bytes(8));
            $expiresAt  = (new DateTime())->modify('+1 day')->format('Y-m-d H:i:s');

    $pricePerSeat = 0;
    if (!empty($data['seats']) && isset($data['total_price'])) {
        $pricePerSeat = (int) round($data['total_price'] / count($data['seats']));
    }

            $resStmt->bind_param(
                "issssissssi",
                $data[$column],
                $data['customer']['fullname'],
                $data['customer']['email'],
                $data['customer']['phone'],
                $data['hall'],
                $seat,
                $ticketCode,
                $expiresAt,
                $data['chosen_date'],
                date("H:i:s", strtotime($data['chosen_time'])),
                $pricePerSeat
            );
            $resStmt->execute();
    $insertedIds[] = $conn->insert_id;   // ▼ ID‑ja e sapo‑krijuar
        }
        $resStmt->close();

        header('Content-Type: application/json');
echo json_encode(['status' => 'ok', 'ids' => $insertedIds]);   // ▼ kthe edhe id‑të
        exit;

    }

    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Bad request']);
    exit;
}

// ─
if($isEvent){
/* 2. titulli + çmimi ----------------------------------------- */
$info = $conn->prepare("SELECT title, price FROM events WHERE id = ? LIMIT 1");
$info->bind_param("i",$event_id);
$info->execute();
$info->bind_result($title,$ticketPrice);
$info->fetch(); $info->close();

/* 2.1 – nëse përdoruesi është i loguar, nxirr emrin, email‑in, telefonin */
$loggedName = $loggedEmail = $loggedPhone = '';
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $u   = $conn->prepare("SELECT CONCAT(name,' ',surname) AS full_name,
                                  email, phone
                             FROM users
                            WHERE id = ?
                            LIMIT 1");
    $u->bind_param("i", $uid);
    $u->execute();
    $u->bind_result($loggedName, $loggedEmail, $loggedPhone);
    $u->fetch();
    $u->close();
}


/* 3. datat e shfaqjes ---------------------------------------- */
$dq = $conn->prepare("SELECT DISTINCT event_date FROM event_dates WHERE event_id = ? AND event_date >= CURRENT_DATE() ORDER BY event_date ASC");
$dq->bind_param("i",$event_id);
$dq->execute();
$res=$dq->get_result(); $dates=[];
while($r=$res->fetch_assoc()) $dates[]=$r['event_date'];
$dq->close(); $groupedDates=groupDates($dates);
$today=new DateTime('today');

/* 4. sallat + oraret ----------------------------------------- */
$hallTimes=[];
$ht=$conn->prepare("SELECT hall,time FROM events WHERE id=?");
$ht->bind_param("i",$event_id);
$ht->execute();
$ht->bind_result($hall,$rawTime);
while($ht->fetch()){ $hallTimes[$hall][]=(new DateTime($rawTime))->format('g:i A'); }
$ht->close(); ksort($hallTimes); foreach($hallTimes as &$t) sort($t); unset($t);
$conn->close();


}else{

/* 2. titulli + çmimi ----------------------------------------- */
$info = $conn->prepare("SELECT title, price FROM shows WHERE id = ? LIMIT 1");
$info->bind_param("i",$show_id);
$info->execute();
$info->bind_result($title,$ticketPrice);
$info->fetch(); $info->close();

/* 2.1 – nëse përdoruesi është i loguar, nxirr emrin, email‑in, telefonin */
$loggedName = $loggedEmail = $loggedPhone = '';
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $u   = $conn->prepare("SELECT CONCAT(name,' ',surname) AS full_name,
                                  email, phone
                             FROM users
                            WHERE id = ?
                            LIMIT 1");
    $u->bind_param("i", $uid);
    $u->execute();
    $u->bind_result($loggedName, $loggedEmail, $loggedPhone);
    $u->fetch();
    $u->close();
}


/* 3. datat e shfaqjes ---------------------------------------- */
$dq = $conn->prepare("SELECT DISTINCT show_date FROM show_dates WHERE show_id = ? AND show_date >= CURRENT_DATE() ORDER BY show_date ASC");
$dq->bind_param("i",$show_id);
$dq->execute();
$res=$dq->get_result(); $dates=[];
while($r=$res->fetch_assoc()) $dates[]=$r['show_date'];
$dq->close(); $groupedDates=groupDates($dates);
$today=new DateTime('today');

/* 4. sallat + oraret ----------------------------------------- */
$hallTimes=[];
$ht=$conn->prepare("SELECT hall,time FROM shows WHERE id=?");
$ht->bind_param("i",$show_id);
$ht->execute();
$ht->bind_result($hall,$rawTime);
while($ht->fetch()){ $hallTimes[$hall][]=(new DateTime($rawTime))->format('g:i A'); }
$ht->close(); ksort($hallTimes); foreach($hallTimes as &$t) sort($t); unset($t);
$conn->close();


}


/* helper */
function seatRow(int $seat,int $perRow=20):string{ return chr(64+ceil($seat/$perRow)); }
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <!--  ───────────────  META & SEO  ───────────────  -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" content="Teatri Metropol - Your theater experience in Albania / Eksperienca juaj teatrore në Shqipëri.">
    <meta name="description" content="Teatri Metropol - Your theater experience in Albania / Eksperienca juaj teatrore në Shqipëri.">
    <meta property="og:title" content="Teatri Metropol">
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <link rel="icon" href="/biletaria_online/assets/img/metropol_icon.png" type="image/x-icon">

    <title>Teatri Metropol | Rezervim Bilete</title>

    <!--  ───────────────  FONTS & ICONS  ───────────────  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!--  ───────────────  CORE STYLES  ───────────────  -->

    <link rel="stylesheet" href="../../assets/css/footer.css">

    <!--  ─────────────  PAGE‑SPECIFIC CSS  ─────────────  -->
    <link rel="stylesheet" href="../../assets/css/style-starter.css">
    <link rel="stylesheet" href="https://npmcdn.com/flickity@2/dist/flickity.css">
    <link rel="stylesheet" href="../../assets/css/progress.css">
    <link rel="stylesheet" href="../../assets/css/ticket-booking.css">
    <link rel="stylesheet" href="../../assets/css/e-ticket.css">
    <link rel="stylesheet" href="../../assets/css/payment.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700" rel="stylesheet">
    <style>
        html{scroll-behavior:smooth;}
.carousel-cell{width:90px;margin-right:8px;border-radius:8px;background:#f3ebeb;padding:.5rem;cursor:pointer;text-align:center;user-select:none;}
.carousel-cell .date-numeric{font-size:1.5rem;font-weight:700;line-height:1;}
.carousel-cell .date-month{font-size:.9rem;text-transform:uppercase;}
.carousel-cell .date-day{font-size:.8rem;}
        .seat-iframe{width:100%;max-width:770px;height:1100px;display:block;margin:auto;}
        .ticket{max-width:420px;margin:auto;}
.ticket-body .poster img{max-width:100%;height:auto;display:block;}
.info-table{width:100%;}
.next-step{
    color: var(--surface-color);
    padding: 10px;
    width: 140px;
    border: none;
    border-radius: 10px;
    background-image: linear-gradient(to bottom, var(--heading2-color), #947c3d);
    transition: transform 0.2s ease, background-color 0.2s ease;
    z-index: 100;
}
.next-step:hover{
    cursor: pointer;
    background-image: linear-gradient(to bottom, var(--heading2-color), #ad8d39);
}
.next-step:active{
    transform: scale(0.95);
}
.previous-step{
    color: var(--surface-color) !important;
    padding: 10px;
    width: 140px !important;
    border: none;
    border-radius: 10px !important;
    background-image: linear-gradient(to bottom, #363a42 , #363a42);
    transition: transform 0.2s ease, background-color 0.2s ease;
    z-index: 100;
}

.previous-step:hover {
    background-image: linear-gradient(to bottom, #363a42 , #3c475c);
}
.previous-step:active{
    transform: scale(0.95);
}
@media(max-width:576px){
  html{font-size:15px;}
  .carousel-cell{width:70px;padding:.4rem;}
  .ticket{padding:1rem;}
  .screen-time{padding:.25rem .5rem;font-size:.8rem;}
  #progressbar{flex-wrap:wrap;gap:.25rem;}
  #progressbar li{flex:1 1 45%;font-size:.8rem;}
}
/* vendose pas style‑starter.css ose tek style tag në fund të <head> */
@media (max-width:1080px){
  .navbar-links{
      display:none;
  }
  .navbar-links.active{
      display:flex !important;
  }
}

        .form-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 30px !important;
            background: rgba(228, 228, 228, 0.04) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            backdrop-filter: blur(5px) !important;
            color: var(--text-color) !important;
            padding: 45px 50px !important;
            box-sizing: revert !important;
            border-radius: 10px !important;
            box-shadow: 5px 5px 20px rgba(0, 0, 0) !important;
            width: 400px !important;
            margin: auto !important;
            animation: fadeIn 0.5s ease-in-out !important;
            transition: width 0.3s ease !important;
        }

        .form-container.light {
            box-shadow: 2px 2px 5px gray !important;
            background: rgba(200, 187, 179, 0.13) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            backdrop-filter: blur(5px) !important;
        }

        .form-group {
            display: flex !important;
            flex-direction: column !important;
            box-sizing: revert !important;
            margin-bottom: revert !important;
            position: relative !important;
            width: 320px !important;
        }

        .form-group input {
            padding: 10px !important;
            padding-left: 35px !important;
            font-family: var(--default-font) !important;
            font-size: 15px !important;
            color: var(--text-color) !important;
            margin-bottom: 0 !important;
            border: none !important;
            border-bottom: 2px solid rgb(143, 121, 63, 0.5) !important;
            outline: none !important;
            background: none !important;
            z-index: 1 !important;
        }

        .light .form-group input {
            color: var(--background-color) !important;
        }

        .form-group input:focus {
            border-color: var(--accent-color) !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            -webkit-text-fill-color: var(--text-color) !important;
            color: var(--text-color) !important;
            font-family: var(--default-font) !important;
            font-size: 15px !important;
            transition: background-color 9999s ease-in-out 0s !important;
        }

        .light input:-webkit-autofill,
        .light input:-webkit-autofill:focus,
        .light input:-webkit-autofill:hover,
        .light input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--background-color) !important;
            color: var(--background-color) !important;
        }

        .form-group label {
            position: absolute !important;
            top: 10px !important;
            left: 35px !important;
            font-size: 18px !important;
            transition: all 0.3s ease !important;
            pointer-events: none !important;
            padding: 0 5px !important;
            margin: 0 !important;
            color: var(--surface-color) !important;
        }

        .light .form-group label {
            color: #826008 !important;
            font-weight: 500 !important;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -17px !important;
            left: 10px !important;
            font-size: 14px !important;
            color: var(--surface-color) !important;
            font-weight: bold !important;
        }

        .light .form-group input:focus + label,
        .light .form-group input:not(:placeholder-shown) + label {
            color: #826008 !important;
        }

.form-icon{
  position:absolute;left:1rem;top:50%;transform:translateY(-50%);
  font-size:1rem;color:#836e4f;pointer-events:none;
}

        @media (max-width: 945px) {
            .form-container {
                padding: 30px 20px !important;
                max-width: 80% !important;
            }

            .form-group {
                width: 70% !important;
            }
        }
/* gentle pulse when focused */
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(131,110,79,.4);}70%{box-shadow:0 0 0 10px rgba(131,110,79,0);}100%{box-shadow:0 0 0 0 rgba(131,110,79,0);}}
.floating-group input:focus{animation:pulse 1s;}


    </style>
</head>
<body>

<!--  ───────────────────────────  NAVBAR  ───────────────────────────  -->
<nav class="navbar">
    <div class="navbar-logo" onclick="location.href='/biletaria_online/index.php'">
        <img src="/biletaria_online/assets/img/metropol_icon.png" alt="Teatri Metropol Logo" class="logo-img">
    </div>

    <div class="navbar-title" onclick="location.href='/biletaria_online/index.php'">
        <h1>Teatri <span class="metropol">Metropol</span></h1>
    </div>

    <ul class="navbar-links">
        <li><a href="/biletaria_online/index.php"
               class="<?= $_SERVER['SCRIPT_NAME'] == '/biletaria_online/index.php' ? 'active' : '' ?>">Kreu</a></li>
        <li><a href="/biletaria_online/views/client/shows/index.php"
               class="<?= $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/shows/index.php' ? 'active' : '' ?>">Shfaqje</a></li>
        <li><a href="/biletaria_online/views/client/events/index.php"
               class="<?= $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/events/index.php' ? 'active' : '' ?>">Evente</a></li>
        <li><a href="/biletaria_online/views/client/about.php"
               class="<?= $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/about.php' ? 'active' : '' ?>">Rreth&nbsp;nesh</a></li>
        <li><a href="/biletaria_online/views/client/apply_form.php"
               class="<?= $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/applications.php' ? 'active' : '' ?>">Aplikime</a></li>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a href="/biletaria_online/auth/login.php" class="profile-icon"><i class="fas fa-user-circle"></i></a></li>
        <?php else: ?>
            <li><a href="/biletaria_online/auth/logout.php" class="profile-icon"><i class="fa-solid fa-right-from-bracket"></i></a></li>
        <?php endif; ?>

        <!--  Dark / light  -->
        <li>
            <label class="theme-switch" for="checkbox">
              <input type="checkbox" id="checkbox">
              <div class="mode-container"><i style="color: white;" class="gg-moon"></i><i class="gg-sun"></i></div>
            </label>
        </li>
    </ul>

    <div id="mobile-menu" class="navbar-toggle"><i class="fas fa-bars"></i></div>
</nav>
</header>


<div class="container" id="progress-container-id">
<div class="row"><div class="col-12 col-lg-10 mx-auto">
<div class="px-0 pt-4 pb-0 mt-3 mb-3">
<form id="form">

<!-- inputet e fshehura -->
<input type="hidden" id="chosen_seats" name="chosen_seats">
<input type="hidden" id="chosen_hall"  name="chosen_hall">
<input type="hidden" id="chosen_date"  name="chosen_date">
<input type="hidden" id="chosen_time"  name="chosen_time">
<input type="hidden" id="total_price" name="total_price">
<input type="hidden" id="ticket-json"  name="ticket_json">

<!-- PROGRESSBAR -->
<ul id="progressbar" class="progressbar-class">
  <li class="active" id="step1">Koha</li>
  <li id="step2" class="not_active">Vendet</li>
  <li id="step3" class="not_active">Të dhënat</li>
  <li id="step4" class="not_active">Bileta</li>
</ul><br>

<!-- ───── STEP 1 – zgjedhja e kohës ───── -->
<fieldset>
  <div id="screen-select-div">
    <h2>Përzgjedhja e orarit</h2>
    <p><span>Datat: </span><?=implode(', ',$groupedDates)?></p>

    <div class="carousel carousel-nav" data-flickity='{"contain":true,"pageDots":false}'>
      <?php foreach($dates as $idx=>$dateStr):
           $d=new DateTime($dateStr);
           $diff=$today->diff($d)->format('%r%a');
           $label=$diff==0?'Sot':($diff==1?'Nesër':ditaNeShqip($d->format('l'))); ?>
        <div class="carousel-cell"
             id="<?=$idx+1?>"
             data-date="<?=$d->format('Y-m-d')?>"
             onclick="selectDate(<?=$idx+1?>)">
          <div class="date-numeric"><?=$d->format('j')?></div>
          <div class="date-month"><?=muajiNeShqip($d->format('M'))?></div>
          <div class="date-day"><?=$label?></div>
        </div>
      <?php endforeach;?>
    </div>

    <ul class="time-ul">
      <?php foreach($hallTimes as $h=>$times):?>
        <li class="time-li">
          <div class="screens">Salla <?=htmlspecialchars($h)?></div>
          <div class="time-btn">
            <?php foreach($times as $t):?>
              <button class="screen-time"
                      data-time="<?=$t?>"
                      data-hall="<?=htmlspecialchars($h)?>"
                      onclick="enableNext(event)"><?=$t?></button>
            <?php endforeach;?>
          </div>
        </li>
      <?php endforeach;?>
    </ul>
  </div>
  <input id="screen-next-btn" type="button" class="next-step" value="Vazhdo" disabled>
</fieldset>



<!-- ───── STEP 2 – zgjedhja e vendeve ───── -->
<fieldset>
<iframe
  id="seat-sel-iframe"
  class="seat-iframe"
  src=""
  loading="lazy"
></iframe>
<br>
  <input type="button" class="next-step" value="Vazhdo">
  <input type="button" class="previous-step" value="Mbrapa">
</fieldset>

<!-- ───── STEP 3 – Të dhënat tuaja (modern version) ───── -->
<fieldset>
  <h2 class="h4 mb-4 text-center">Të dhënat tuaja</h2>

  <div class="form-container">
    <div class="form-group">
      <input id="fullname" name="fullname" type="text"
             value="<?php echo htmlspecialchars($loggedName ?? '') ?>" placeholder=" " required/>
      <label for="fullname">Emri i plotë</label>
        <span><i class="fa-solid fa-user form-icon"></i></span>
    </div>

    <div class="form-group">
      <input id="email" name="email" type="email"
             value="<?php echo htmlspecialchars($loggedEmail ?? '') ?>" placeholder=" " required/>
      <label for="email">Email</label>
        <i class="fa-solid fa-envelope form-icon"></i>
    </div>

    <div class="form-group">
      <input id="phone" name="phone" type="tel"
             value="<?php echo htmlspecialchars($loggedPhone ?? '') ?>" placeholder=" " required/>
      <label for="phone">Telefon</label>
        <i class="fa-solid fa-phone form-icon"></i>
    </div>
  </div>
    <br>
  <input type="button" class="next-step" value="Rishiko Biletën">
  <input type="button" class="previous-step" value="Mbrapa">
</fieldset>


<!-- ───── STEP 4 – BILETA ───── -->
<fieldset>
  <h2 class="h4">Biletat e tua</h2><br>

  <!-- tabelë statike me header, do mbushet me JS -->
  <div class="ticket-body mb-4">
    <div class="ticket">
      <div class="holes-top"></div>

      <div class="title">
        <p class="cinema">Teatri Metropol</p>
        <p class="movie-title"><?=htmlspecialchars($title)?></p>
      </div>

      <div class="poster">
      <img src="../../includes/get_image.php?<?= $isEvent
         ? 'event_id=' . $event_id
         : 'show_id='  . $show_id ?>"
         alt="Poster for <?= htmlspecialchars($title) ?>">
      </div>

      <div class="info">
        <div class="table-responsive">
          <table id="seat-table" class="info-table ticket-table table">
            <tr><th>SALLA</th><th>RRESHTI</th><th>VENDI</th></tr>
            <!-- <tr> …mbushet nga JS… </tr> -->
          </table>
        </div>

        <div class="table-responsive">
          <table class="info-table ticket-table table">
            <tr><th>ÇMIMI</th><th>DATA</th><th>ORA</th></tr>
            <tr>
            <td id="td-price"></td>
              <td id="td-date"></td>
              <td id="td-time"></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="holes-lower"></div>

      <div class="serial d-flex flex-column align-items-center pt-2">
        <div class="qrcode" id="qr-main" style="width:120px;height:120px;"></div>
        <div id="expiration-date" class="mt-2" style="font-size:0.9rem; color:#555;"></div>
      </div>
    </div>
  </div>

  <div class="text-center mt-3">
      <input id="dl-ticket" type="button" class="next-step" value="Shkarko Biletën">

  </div>
</fieldset>

</form>
</div></div></div>
</div>

<script>
/* ─── logjika për zgjedhjen e datës/orës ─── */
let prevId="1", selectedDate='';
function selectDate(id){
  document.getElementById(prevId).style.background="#f3ebeb";
  document.getElementById(id).style.background="#836e4f";
  prevId=id;
  selectedDate=document.getElementById(id).dataset.date;
}
function enableNext(e){ 
  e.preventDefault();
  document.getElementById('chosen_date').value=selectedDate;
  document.getElementById('chosen_time').value=e.target.dataset.time;
  document.getElementById('chosen_hall').value=e.target.dataset.hall;
  document.getElementById('screen-next-btn').disabled=false;
  // point the iframe at the date/time
  const iframe = document.getElementById('seat-sel-iframe');
  iframe.src = `../../seat_selection/seat_sel.php?<?= $isEvent
         ? 'event_id=' . $event_id
         : 'show_id='  . $show_id ?>`
             + `&date=${encodeURIComponent(selectedDate)}`
             + `&hall=${encodeURIComponent(e.target.dataset.hall)}`
             + `&time=${encodeURIComponent(e.target.dataset.time)}`;

  // now enable the Next button
  document.getElementById('screen-next-btn').disabled = false;
}
</script>

<script src="https://npmcdn.com/flickity@2/dist/flickity.pkgd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/theme-change.js"></script>
<script src="../../assets/js/ticket-booking.js"></script>

<!-- QRCode & html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>



<script>
// ─── Step 2 “Vazhdo” gating based on iframe seat selection ───

// 1. grab the “Vazhdo” button on Step 2 (it's the second .next-step)
const step2NextBtn = document.querySelectorAll('.next-step')[1];

// 2. disable it by default
step2NextBtn.disabled = true;

// 3. listen for your iframe’s seatSelection message
window.addEventListener('message', e => {
  if (e.origin !== window.origin || e.data?.type !== 'seatSelection') return;

  // populate your hidden inputs as before
  document.getElementById('chosen_seats').value = e.data.seats.join(',');
  if (e.data.hall)  document.getElementById('chosen_hall').value = e.data.hall;
  document.getElementById('total_price').value  = e.data.total;

  // enable the button only if at least one seat was selected
  const hasSeats = Array.isArray(e.data.seats) && e.data.seats.length > 0;
  step2NextBtn.disabled = !hasSeats;
});

// 4. extra double-check on click: block progression if no seats
step2NextBtn.addEventListener('click', ev => {
  if (!document.getElementById('chosen_seats').value) {
    alert('Ju lutem, zgjidhni të paktën një vend për të vazhduar.');
    ev.preventDefault();
  }
});
</script>


<script>
function gatherJSON(){
  const f=document.forms[0];

  const key   = <?= $isEvent ? "'event_id'" : "'show_id'" ?>;
  const value = <?= $isEvent ? $event_id : $show_id ?>;

  const data = {
    [key]:        value,                       // ← computed prop
    title:        <?= json_encode($title) ?>,
    chosen_date:  f.chosen_date.value  || '',
    chosen_time:  f.chosen_time.value  || '',
    hall:         f.chosen_hall.value  || '',
    seats:        (f.chosen_seats.value || '')
                    .split(',').filter(Boolean).map(Number),
    total_price:  +f.total_price.value || 0,
    customer: {
      fullname: f.fullname.value,
      email:    f.email.value,
      phone:    f.phone.value
    }
};

  document.getElementById('ticket-json').value=JSON.stringify(data);
  console.log(JSON.stringify(data,null,2));

  // ─── INSERT VIA AJAX ────────────────────────────
  fetch(window.location.pathname + '?<?= $isEvent ? 'event_id' : 'show_id' ?>=<?= $isEvent ? $event_id : $show_id ?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ ticket_json: JSON.stringify(data) })
  })
  .then(r => r.json())
  .then(res => {
    if (res.status !== 'ok') console.error('Insert failed', res);
  })
  .catch(err => console.error('AJAX error', err));
  // ────────────────────────────────────────────────


  /* ► MBUSH TABELËN E VENDEVE º */
  const tbody=document.querySelector('#seat-table');
  [...tbody.querySelectorAll('tr')].slice(1).forEach(r=>r.remove());
  data.seats.forEach(nr=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`<td>${data.hall}</td><td>X</td><td>${nr}</td>`;
    tbody.appendChild(tr);
  });
  /* rifresko datën & orën në tabelën tjetër */
  document.getElementById('td-date').textContent=data.chosen_date.split('-').reverse().join('/');
  document.getElementById('td-time').textContent=data.chosen_time;

const total = data.total_price || (data.seats.length * <?=$ticketPrice?>);
qty = data.seats.length;
unitPrice = <?=$ticketPrice?>;
document.getElementById('td-price').textContent =
  `${qty} × ALL.${unitPrice.toFixed(0)} = ALL.${total.toFixed(0)}`;

  const exp = new Date(data.chosen_date);
exp.setDate(exp.getDate() - 2);
const day   = String(exp.getDate()).padStart(2,'0');
const month = String(exp.getMonth()+1).padStart(2,'0');
const year  = exp.getFullYear();
document.getElementById('expiration-date').textContent = `Data e skadimit: ${day}/${month}/${year}`;
}

document.querySelectorAll('.next-step')[2].addEventListener('click',gatherJSON);
</script>
<script>
// find the “Rishiko Biletën” button on step 3:
const reviewBtn = document.querySelectorAll('.next-step')[2];
// the three inputs to watch:
const fullEl  = document.getElementById('fullname');
const emailEl = document.getElementById('email');
const phoneEl = document.getElementById('phone');

// validation function
function validateStep3() {
  const full  = fullEl.value.trim();
  const email = emailEl.value.trim();
  const phone = phoneEl.value.trim();
  // simple email check
  const emailOK = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  // require non‐empty full name, valid email, non‐empty phone
  if (full && emailOK && phone) {
    reviewBtn.disabled = false;
  } else {
    reviewBtn.disabled = true;
  }
}

// wire up on input:
[ fullEl, emailEl, phoneEl ].forEach(el => {
  el.addEventListener('input', validateStep3);
});

// run once on load (in case fields are pre-filled)
validateStep3();
</script>


<script defer>

const base = window.location.origin;   
console.log(data.seats.length) ;      
const payURL  = `${base}/biletaria_online/views/admin/reservations/scan.php?ids=`;

document.addEventListener('DOMContentLoaded',()=>{
  new QRCode(document.getElementById('qr-main'),{
    text:payURL,width:120,height:120,
    colorDark:"#000",colorLight:"#fff",correctLevel:QRCode.CorrectLevel.H
  });
    /* Shkarkim / Sharing */
    const ticket=document.querySelector('.ticket');
    const fileName='bileta_<?= $isEvent ? $event_id : $show_id ?>.png';
    async function toPNG(){ const c=await html2canvas(ticket,{scale:2}); return c.toDataURL('image/png'); }
    document.getElementById('dl-ticket').onclick=async()=>{const url=await toPNG(); Object.assign(document.createElement('a'),{href:url,download:fileName}).click();};
    const shareBtn=document.getElementById('share-ticket');
    if(navigator.canShare && navigator.canShare({files:[]})){
      shareBtn.style.display='';
      shareBtn.onclick=async()=>{const blob=await(await fetch(await toPNG())).blob();
        await navigator.share({files:[new File([blob],fileName,{type:'image/png'})],title:'Bileta ime'});}
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  /* ─── MOBILE MENU ─── */
  const mobileMenu  = document.getElementById('mobile-menu');
  const navLinks    = document.querySelector('.navbar-links');
  const menuIcon    = mobileMenu?.querySelector('i');

  if (mobileMenu && navLinks && menuIcon) {
    mobileMenu.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      menuIcon.classList.toggle('fa-bars');
      menuIcon.classList.toggle('fa-times');
    });
  }


});
</script>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

</body>

</html>
