<?php
/** @var mysqli $conn */
require "../../config/db_connect.php";
require "../../auth/auth.php";
require "../../includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ticket_json'])) {
    $data = json_decode($_POST['ticket_json'], true);

    // ─── Override customer info when logged in ──────────────────
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
    // ────────────────────────────────────────────────────────────

    if (isset($data['show_id'], $data['seats'], $data['customer'], $data['hall'])) {
        $stmt = $conn->prepare("
            INSERT INTO reservations
              (show_id, event_id, full_name, email, phone, hall, seat_id)
            VALUES
              (?, NULL, ?, ?, ?, ?, ?)
        ");
        foreach ($data['seats'] as $seat) {
            if (strtolower($data['hall']) === 'cehov') {
                $seat += 212;
            }
            $stmt->bind_param(
                "issssi",
                $data['show_id'],
                $data['customer']['fullname'],
                $data['customer']['email'],
                $data['customer']['phone'],
                $data['hall'],
                $seat
            );
            $stmt->execute();
        }
        $stmt->close();

        header('Content-Type: application/json');
        echo json_encode(['status'=>'ok']);
        exit;
    }

    header('HTTP/1.1 400 Bad Request');
    exit;
}
// ─

/* 1. merr ID‑në e shfaqjes ----------------------------------- */
$show_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$show_id) { die("ID shfaqjeje e pavlefshme."); }

/* 2. titulli + çmimi ----------------------------------------- */
$info = $conn->prepare("SELECT title, price FROM shows WHERE id = ? LIMIT 1");
$info->bind_param("i",$show_id);
$info->execute();
$info->bind_result($showTitle,$ticketPrice);
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
$dq = $conn->prepare("SELECT DISTINCT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
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

/* helper */
function seatRow(int $seat,int $perRow=20):string{ return chr(64+ceil($seat/$perRow)); }
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Rezervim Bilete</title>

<link rel="stylesheet" href="../../assets/css/style-starter.css">
<link rel="stylesheet" href="https://npmcdn.com/flickity@2/dist/flickity.css">
<link rel="stylesheet" href="../../assets/css/progress.css">
<link rel="stylesheet" href="../../assets/css/ticket-booking.css">
<link rel="stylesheet" href="../../assets/css/e-ticket.css">
<link rel="stylesheet" href="../../assets/css/payment.css">
<link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700" rel="stylesheet">
<style>
/* (stilet e pandryshuara) */
html{scroll-behavior:smooth;}
.form-group{margin-bottom:1rem;width:100%;}
.form-group label{display:block;margin-bottom:.25rem;font-weight:600;}
.form-group input{width:100%;padding:.6rem;border:1px solid #ccc;border-radius:4px;}
.carousel-cell{width:90px;margin-right:8px;border-radius:8px;background:#f3ebeb;padding:.5rem;cursor:pointer;text-align:center;user-select:none;}
.carousel-cell .date-numeric{font-size:1.5rem;font-weight:700;line-height:1;}
.carousel-cell .date-month{font-size:.9rem;text-transform:uppercase;}
.carousel-cell .date-day{font-size:.8rem;}
.seat-iframe{width:100%;max-width:770px;height:140vh;display:block;margin:auto;}
.ticket{max-width:420px;margin:auto;}
.ticket-body .poster img{max-width:100%;height:auto;display:block;}
.info-table{width:100%;}
@media(max-width:576px){
  html{font-size:15px;}
  .carousel-cell{width:70px;padding:.4rem;}
  .ticket{padding:1rem;}
  .screen-time{padding:.25rem .5rem;font-size:.8rem;}
  #progressbar{flex-wrap:wrap;gap:.25rem;}
  #progressbar li{flex:1 1 45%;font-size:.8rem;}
}
</style>
</head>
<body>
<header id="site-header" class="w3l-header fixed-top">
  <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
    <div class="container">
      <a class="navbar-brand logo-dark"  href="../../index.php"><img src="../../../biletaria_online/assets/images/metropol_icon.png"      style="height:35px;"></a>
      <a class="navbar-brand logo-light" href="../../index.php"><img src="../../../biletaria_online/assets/images/metropol_iconblack.png" style="height:35px;"></a>
      <a class="navbar-brand" href="../../index.php">Teatri <b style="color:#836e4f;">Metropol</b></a>

      <div class="collapse navbar-collapse"></div>

      <div class="Login_SignUp">
        <a class="nav-link" href="../../auth/login.php"><i class="fa fa-user-circle-o"></i></a>
      </div>

      <div class="mobile-position">
        <nav class="navigation">
          <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
              <input type="checkbox" id="checkbox">
              <div class="mode-container"><i class="gg-sun"></i><i class="gg-moon"></i></div>
            </label>
          </div>
        </nav>
      </div>
    </div>
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
           $label=$diff==0?'Sot':($diff==1?'Nesër':$d->format('l')); ?>
        <div class="carousel-cell"
             id="<?=$idx+1?>"
             data-date="<?=$d->format('Y-m-d')?>"
             onclick="selectDate(<?=$idx+1?>)">
          <div class="date-numeric"><?=$d->format('j')?></div>
          <div class="date-month"><?=$d->format('M')?></div>
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
  <input id="screen-next-btn" type="button" class="next-step btn btn-primary mt-3" value="Vazhdo" disabled>
</fieldset>

<!-- ───── STEP 2 – zgjedhja e vendeve ───── -->
<fieldset>
  <iframe id="seat-sel-iframe" class="seat-iframe" src="../../seat_selection/seat_sel.php?show_id=<?=$show_id?>" loading="lazy"></iframe><br>
  <input type="button" class="next-step" value="Vazhdo">
  <input type="button" class="previous-step" value="Mbrapa">
</fieldset>

<!-- ───── STEP 3 – Të dhënat tuaja ───── -->
<fieldset>
  <h2 class="h4">Të dhënat tuaja</h2>
  <div style="width:50%; margin:auto;">
    <div class="form-group">
      <label for="fullname">Emri i plotë</label>
      <input
        id="fullname"
        name="fullname"
        type="text"
        value="<?= htmlspecialchars($loggedName) ?>"
        <?= $loggedName ? 'readonly' : 'required' ?>
      >
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input
        id="email"
        name="email"
        type="email"
        value="<?= htmlspecialchars($loggedEmail) ?>"
        <?= $loggedEmail ? 'readonly' : 'required' ?>
      >
    </div>

    <div class="form-group">
      <label for="phone">Telefon</label>
      <input
        id="phone"
        name="phone"
        type="tel"
        value="<?= htmlspecialchars($loggedPhone) ?>"
        <?= $loggedPhone ? 'readonly' : 'required' ?>
      >
    </div>

    <div class="form-group">
      <label for="notes">Shënime (opsionale)</label>
      <input id="notes" name="notes" type="text">
    </div>
  </div>

  <input type="button" class="next-step" value="Rishiko Biletën">
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
        <p class="movie-title"><?=htmlspecialchars($showTitle)?></p>
      </div>

      <div class="poster">
        <img src="../../includes/get_image.php?show_id=<?=$show_id?>" alt="Poster">
      </div>

      <div class="info">
        <div class="table-responsive">
          <table id="seat-table" class="info-table ticket-table table">
            <tr><th>SALLA</th><th>RRËSHTI</th><th>VENDI</th></tr>
            <!-- <tr> …mbushet nga JS… </tr> -->
          </table>
        </div>

        <div class="table-responsive">
          <table class="info-table ticket-table table">
            <tr><th>ÇMIMI</th><th>DATA</th><th>ORA</th></tr>
            <tr>
              <td>ALL.<?=number_format($ticketPrice,2)?></td>
              <td id="td-date"></td>
              <td id="td-time"></td>
            </tr>
          </table>
        </div>
      </div>

      <div class="holes-lower"></div>

      <div class="serial d-flex flex-column align-items-center pt-2">
        <div class="qrcode" id="qr-main" style="width:120px;height:120px;"></div>
      </div>
    </div>
  </div>

  <div class="text-center mt-3">
    <button id="dl-ticket"  type="button" class="home-page-btn btn btn-outline-primary me-2">Shkarko Biletën</button>
    <button id="share-ticket" type="button" class="home-page-btn btn btn-outline-success" style="display:none">Ndaj Biletën</button>
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

<script defer>
document.addEventListener('DOMContentLoaded',()=>{
  new QRCode(document.getElementById('qr-main'),{
    text:window.location.href,width:120,height:120,
    colorDark:"#000",colorLight:"#fff",correctLevel:QRCode.CorrectLevel.H
  });
    /* Shkarkim / Sharing */
    const ticket=document.querySelector('.ticket');
    const fileName='bileta_<?=$show_id?>.png';
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
/* merr vendet nga iframe */
window.addEventListener('message',e=>{
  if(e.origin!==window.origin||e.data?.type!=='seatSelection') return;
  document.getElementById('chosen_seats').value=e.data.seats.join(',');
  if(e.data.hall) document.getElementById('chosen_hall').value=e.data.hall;
});
</script>

<script>
function gatherJSON(){
  const f=document.forms[0];
  const data={
    show_id:<?=$show_id?>,
    title:  <?=json_encode($showTitle)?>,
    chosen_date:f.chosen_date.value||'',
    chosen_time:f.chosen_time.value||'',
    hall:       f.chosen_hall.value||'',
    seats:(f.chosen_seats.value||'').split(',').filter(Boolean).map(Number),
    customer:{
      fullname:f.fullname.value,email:f.email.value,
      phone:f.phone.value,notes:f.notes.value
    }
  };
  document.getElementById('ticket-json').value=JSON.stringify(data);
  console.log(JSON.stringify(data,null,2));

  // ─── INSERT VIA AJAX ────────────────────────────
  fetch(window.location.pathname + '?id=<?=$show_id?>', {
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
}

document.querySelectorAll('.next-step')[2].addEventListener('click',gatherJSON);
</script>

</body>
</html>
