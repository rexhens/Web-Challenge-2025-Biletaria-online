<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

$show_id = isset($_GET['show_id']) ? (int)$_GET['show_id'] : 0;
if (!$show_id) {
    die("Invalid show ID.");
}

// ────────── Fetch show details ──────────
$stmt = $conn->prepare("SELECT s.title, s.time, s.price, sd.show_date
                          FROM shows AS s
                          JOIN show_dates AS sd ON sd.show_id = s.id
                         WHERE s.id = ?
                         LIMIT 1");
$stmt->bind_param("i", $show_id);
$stmt->execute();
$stmt->bind_result($title, $time, $price, $show_date);
if (!$stmt->fetch()) {
    die("Show not found.");
}
$stmt->close();

// ────────── Load static seat‑map JSON (structure: { "seats": [{"id":"a[1]", "status":"unavailable"}, …] }) ──────────
$seatJson = file_get_contents(__DIR__ . '/seats.json');
$seatData = json_decode($seatJson, true) ?: [];
$reserved = [];
foreach ($seatData['seats'] ?? [] as $seat) {
    if ($seat['status'] === 'unavailable' && preg_match('/(\d+)/', $seat['id'], $m)) {
        $reserved[] = (int)$m[1];
    }
}
$conn->close();

$displayDate = date('F j, Y', strtotime($show_date));
$displayTime = date('H:i', strtotime($time));


$svg_file_name = __DIR__ . '/salla1.svg';        // rruga deri te skeda
$svg_markup    = file_get_contents($svg_file_name); // lexo përmbajtjen

?>
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Rezervimi i Vendeve – "<?php echo htmlspecialchars($title); ?>"</title>
<style>
  :root {
    --color-available: black;
    --color-selected: #4caf50;
    --color-reserved: #e53935;
  }

  body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 0; padding: 1.5rem; background: #f7f7f7; display: flex; flex-direction: column; align-items: center;
  }

  h2 { margin: 0 0 1rem; }

  /* ───────── seat styling ───────── */
  .seat path, .seat polygon { cursor: pointer;  transition: fill .15s; }
  .seat.selected path, .seat.selected polygon { fill: var(--color-selected); stroke: var(--color-selected); }
  .seat.reserved path, .seat.reserved polygon { fill: var(--color-reserved); stroke: var(--color-reserved); cursor: not-allowed; }
  .seat text { cursor: pointer; user-select: none; }

  /* booking panel */
  .panel { margin-top: 1.5rem; width: 100%; max-width: 800px; background:#fff; border:1px solid #ddd; border-radius:8px; padding:1rem; box-shadow:0 2px 6px rgba(0,0,0,.07); }
  .panel h3 { margin:0 0 .5rem; font-size:1rem; }
  .panel ul { list-style: none; padding-left:1.25rem; margin:0; }
  .panel li { margin:.25rem 0; }
  #summary { display:flex; flex-wrap:wrap; gap:1.5rem; }
  .sum-block { flex:1 1 200px; }
  .legend { display:flex; gap:1.5rem; font-size:.9rem; margin-top:.5rem; }
  .legend .box { width:20px; height:20px; border-radius:4px; display:inline-block; margin-right:4px; vertical-align:middle; }

  button#checkout { margin-top:1rem; padding:.6rem 1.2rem; background:#4caf50; border:none; border-radius:4px; color:#fff; font-weight:600; cursor:pointer; }
  button#checkout:disabled { background:#9e9e9e; cursor:not-allowed; }
</style>
</head>
<body>
  <h2>Rezervim për "<?php echo htmlspecialchars($title); ?>"</h2>

  <?php echo $svg_markup; ?>

  <!-- ───────── Booking Summary ───────── -->
  <div class="panel" id="booking-panel">
    <div id="summary">
      <div class="sum-block">
        <h3>Të dhënat e shfaqjes</h3>
        <ul>
          <li><strong>Titulli:</strong> <?php echo htmlspecialchars($title); ?></li>
          <li><strong>Koha:</strong> <?php echo "$displayDate, $displayTime"; ?></li>
          <li><strong>Çmimi bilete:</strong> <?php echo $price; ?> lekë</li>
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
   <!-- <button id="checkout" disabled>Vazhdo tek pagesa</button>  -->

    <div class="legend">
      <div><span class="box" style="background:var(--color-available);"></span> I lirë</div>
      <div><span class="box" style="background:var(--color-selected);"></span> I zgjedhur</div>
      <div><span class="box" style="background:var(--color-reserved);"></span> I zënë</div>
    </div>
  </div>

  <!-- ───────── Hidden form që dërgohet me JS ───────── -->
  <form id="booking-form" action="process_booking.php" method="post" style="display:none;">
    <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">
    <input type="hidden" name="selected_seats" id="selected-seats-input">
    <input type="hidden" name="total_price" id="total-price-input" value="0">
  </form>

<script>
(function(){
  const price      = <?php echo $price; ?>;
  const RESERVED   = <?php echo json_encode($reserved); ?>.map(Number);

  const seats   = document.querySelectorAll('.seat');
  const listSel    = document.getElementById('selected-list');
  const counterEl  = document.getElementById('counter');
  const totalEl    = document.getElementById('total');
  const checkoutBt = document.getElementById('checkout');
  const inpSeats   = document.getElementById('selected-seats-input');
  const inpTotal   = document.getElementById('total-price-input');

  /* ───────── Mark reserved seats at load ───────── */
  seats.forEach(seat => {
    const nr = +seat.dataset.seat;
    if (RESERVED.includes(nr)) seat.classList.add('reserved');

    seat.addEventListener('click', () => {
      if (seat.classList.contains('reserved')) return;
      seat.classList.toggle('selected');
      render();
    });
  });

  checkoutBt.addEventListener('click', () => {
    document.getElementById('booking-form').submit();
  });

  function render(){
    const selected = Array.from(document.querySelectorAll('.seat.selected'))
                          .map(s => +s.dataset.seat)
                          .sort((a,b) => a-b);

    // lista vizuale
    listSel.innerHTML = '';
    selected.forEach(nr => {
      const li = document.createElement('li');
      li.textContent = 'Karrikja ' + nr;
      listSel.appendChild(li);
    });

    // numra dhe forma
    counterEl.textContent = selected.length;
    const total = selected.length * price;
    totalEl.textContent   = total;

    inpSeats.value = selected.join(',');
    inpTotal.value = total;

    checkoutBt.disabled = selected.length === 0;
  }
})();
</script>



</body>
</html>
