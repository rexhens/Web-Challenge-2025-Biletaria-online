<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$show_id = isset($_GET['show_id']) ? (int)$_GET['show_id'] : 0;
if (!$show_id) { die("Invalid show ID."); }

/* ────────── detajet e shfaqjes ────────── */
$stmt = $conn->prepare("SELECT s.title, s.time, s.price, sd.show_date, s.hall
                          FROM shows AS s
                          JOIN show_dates AS sd ON sd.show_id = s.id
                         WHERE s.id = ?
                         LIMIT 1");
$stmt->bind_param("i", $show_id);
$stmt->execute();
$stmt->bind_result($title,$time,$price,$show_date,$hall);
if(!$stmt->fetch()){ die("Show not found."); }
$stmt->close();

/* ────────── vendet e bllokuara ────────── */
$seatJson = file_get_contents(__DIR__.'/seats.json');
$seatData = json_decode($seatJson,true) ?: [];
$reserved=[];
foreach($seatData['seats']??[] as $s){
  if($s['status']==='unavailable' && preg_match('/(\d+)/',$s['id'],$m)){
    $reserved[]=(int)$m[1];
  }
}
$conn->close();

/* ────────── SVG i sallës ────────── */
$svg_markup = file_get_contents(__DIR__.'/'.basename($hall).'.svg');
?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Rezervimi i Vendeve – "<?=htmlspecialchars($title)?>"</title>

<style>
:root{
  --color-available:#000;
  --color-selected:#4caf50;
  --color-reserved:#e53935;
  --bg-body:#f7f7f7;
  --text-main:#000;
  --panel-bg:#fff;
  --panel-border:#ddd;
  --panel-heading:#000;
}
[data-theme='dark']{
  --bg-body:#121212;
  --text-main:#fff;
  --color-available:#fff;
  --panel-bg:#1e1e1e;
  --panel-border:#444;
  --panel-heading:#fff;
}
body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:1.5rem;
     display:flex;flex-direction:column;align-items:center;
     background:var(--bg-body);color:var(--text-main);}
h2{margin:0 0 1rem;}
/* karriget */
.seat path,.seat polygon{cursor:pointer;transition:fill .15s;
                         stroke:var(--color-available);fill:var(--color-available);}
.seat.selected path,.seat.selected polygon{stroke:var(--color-selected);fill:var(--color-selected);}
.seat.reserved  path,.seat.reserved  polygon{stroke:var(--color-reserved);fill:var(--color-reserved);cursor:not-allowed;}
.seat text{cursor:pointer;user-select:none;}
/* paneli */
.panel{margin-top:1.5rem;width:100%;max-width:800px;background:var(--panel-bg);
       border:1px solid var(--panel-border);border-radius:8px;padding:1rem;
       box-shadow:0 2px 6px rgba(0,0,0,.07);}
.panel h3{margin:0 0 .5rem;font-size:1rem;color:var(--panel-heading);}
.panel ul{list-style:none;padding-left:1.25rem;margin:0;}
#summary{display:flex;flex-wrap:wrap;gap:1.5rem;}
.sum-block{flex:1 1 200px;}
.legend{display:flex;gap:1.5rem;font-size:.9rem;margin-top:.5rem;}
.legend .box{width:20px;height:20px;border-radius:4px;display:inline-block;margin-right:4px;vertical-align:middle;}
button#checkout{margin-top:1rem;padding:.6rem 1.2rem;background:#4caf50;border:none;border-radius:4px;color:#fff;font-weight:600;cursor:pointer;}
button#checkout:disabled{background:#9e9e9e;cursor:not-allowed;}
</style>
</head>
<body>

<h2>Rezervim për "<?=htmlspecialchars($title)?>"</h2>

<?= $svg_markup ?>

<div class="panel" id="booking-panel">
  <div id="summary">
    <div class="sum-block">
      <h3>Të dhënat e shfaqjes</h3>
      <ul>
        <li><strong>Titulli:</strong> <?=htmlspecialchars($title)?></li>
        <li><strong>Koha:</strong> <?=date('F j, Y',strtotime($show_date)).', '.date('H:i',strtotime($time))?></li>
        <li><strong>Çmimi bilete:</strong> <?=$price?> lekë</li>
      </ul>
    </div>
    <div class="sum-block">
      <h3>Vendet e zgjedhura</h3>
      <ul id="selected-list"></ul>
    </div>
    <div class="sum-block">
      <h3>Përmbledhje</h3>
      <ul>
        <li>Numri i biletave: <span id="counter">0</span></li>
        <li>Totali: <strong><span id="total">0</span> lekë</strong></li>
      </ul>
    </div>
  </div>

  <!-- butonin mund ta aktivizosh kur të kesh pagesën -->
  <!-- <button id="checkout" disabled>Vazhdo tek pagesa</button> -->

  <div class="legend">
    <div><span class="box" style="background:var(--color-available);"></span> I lirë</div>
    <div><span class="box" style="background:var(--color-selected);"></span> I zgjedhur</div>
    <div><span class="box" style="background:var(--color-reserved);"></span> I zënë</div>
  </div>
</div>

<!-- form i fshehtë nëse do ta përdorësh me submit direkt -->
<form id="booking-form" action="process_booking.php" method="post" style="display:none;">
  <input type="hidden" name="show_id" value="<?=$show_id?>">
  <input type="hidden" name="selected_seats" id="selected-seats-input">
  <input type="hidden" name="total_price"   id="total-price-input" value="0">
</form>

<script>
(function(){
  const price     = <?=$price?>;
  const RESERVED  = <?=json_encode($reserved)?>.map(Number);

  const seats     = document.querySelectorAll('.seat');
  const listSel   = document.getElementById('selected-list');
  const counterEl = document.getElementById('counter');
  const totalEl   = document.getElementById('total');
  const inpSeats  = document.getElementById('selected-seats-input');
  const inpTotal  = document.getElementById('total-price-input');
  const checkoutBt= document.getElementById('checkout'); // mund të jetë null

  /* ngjyros vendet e zëna dhe lidh click‑un */
  seats.forEach(seat=>{
    const nr = +seat.dataset.seat;
    if(RESERVED.includes(nr)) seat.classList.add('reserved');

    seat.addEventListener('click',()=>{
      if(seat.classList.contains('reserved')) return;
      seat.classList.toggle('selected');
      render();
    });
  });

  if(checkoutBt){
    checkoutBt.addEventListener('click',()=>document.getElementById('booking-form').submit());
  }

  function render(){
    const selected = Array.from(document.querySelectorAll('.seat.selected'))
                           .map(s=>+s.dataset.seat).sort((a,b)=>a-b);

    /* lista vizuale */
    listSel.innerHTML='';
    selected.forEach(nr=>{
      const li=document.createElement('li');
      li.textContent='Karrikja '+nr;
      listSel.appendChild(li);
    });

    /* përmbledhja */
    counterEl.textContent = selected.length;
    const total = selected.length*price;
    totalEl.textContent   = total;
    inpSeats.value        = selected.join(',');
    inpTotal.value        = total;
    if(checkoutBt) checkoutBt.disabled = selected.length===0;

    /* ─── Dërgo tek prindi (reservation.php) ─── */
    parent.postMessage({
      type : 'seatSelection',
      hall : '<?=addslashes($hall)?>',
      seats: selected,           // array numrash
      total: total
    }, window.origin);
  }

  /* inicializo për rast se s'ka zgjedhje */
  render();
})();
</script>

<script>
/* sinkronizo temën me prindin */
(function syncTheme(){
  function apply(t){document.documentElement.setAttribute('data-theme',t||'light');}
  apply(localStorage.getItem('theme'));
  window.addEventListener('storage',e=>{
    if(e.key==='theme') apply(e.newValue);
  });
})();
</script>

</body>
</html>
