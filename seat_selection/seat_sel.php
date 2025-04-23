<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";

$show_id = isset($_GET['show_id']) ? (int)$_GET['show_id'] : 0;
if (!$show_id) { die("Invalid show ID."); }

// ────────── Fetch show details ──────────
$stmt = $conn->prepare("SELECT s.title, s.time, s.price, sd.show_date
                          FROM shows AS s
                          JOIN show_dates AS sd ON sd.show_id = s.id
                         WHERE s.id = ?
                         LIMIT 1");
$stmt->bind_param("i", $show_id);
$stmt->execute();
$stmt->bind_result($title, $time, $price, $show_date);
if (!$stmt->fetch()) { die("Show not found."); }
$stmt->close();

// ────────── Load static seat map json ──────────
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Seat Selection for "<?php echo htmlspecialchars($title); ?>"</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/jquery.seat-charts.js"></script>
<style>
.demo{display:flex;flex-direction:column;gap:30px}
#seat-map{width:100%;margin-bottom:30px;padding:20px 0;border-bottom:2px solid #ddd}
.booking-details{display:flex;justify-content:space-between;gap:20px;padding:20px;background:#f8f8f8;border-radius:8px}
.booking-column{flex:1;max-width:30%}.scrollbar{height:150px;overflow-y:auto;list-style:none;padding-left:0;margin:0}
.scrollbar li{margin-bottom:4px}
</style>
</head>
<body>
<div class="content">
  <h2>Rezervo per shfaqjen "<?php echo htmlspecialchars($title); ?>"</h2>
  <div class="demo">
    <div id="seat-map" style="min-width:740px"><div class="front">SCREEN</div></div>
    <div class="booking-details">
      <div class="booking-column">
        <ul class="book-left"><li>Shfaqja</li><li>Koha</li><li>Bileta</li><li>Numri</li><li>Totali</li></ul>
        <ul class="book-right">
          <li>: <?php echo htmlspecialchars($title); ?></li>
          <li>: <?php echo "$displayDate, $displayTime"; ?></li>
          <li>: <span id="counter">0</span></li>
          <li>: <b><i>Leke.</i><span id="total">0</span></b></li>
        </ul>
      </div>
      <div class="booking-column"><p style="margin-bottom:15px;font-weight:bold">Karrigja e zgjedhur:</p><ul id="selected-seats" class="scrollbar"></ul></div>
      <div class="booking-column"><div id="legend" style="padding:10px;background:#f5f5f5;border-radius:5px"></div></div>
    </div>
  </div>
  <form id="booking-form" method="post" action="process_booking.php">
    <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">
    <input type="hidden" name="selected_seats" id="selected-seats-input">
    <input type="hidden" name="total_price" id="total-price-input" value="0">
  </form>
</div>
<script>
$(function(){
  const price     = <?php echo $price; ?>;
  const reserved  = <?php echo json_encode($reserved); ?>;
  const $cart     = $('#selected-seats');
  const $counter  = $('#counter');
  const $total    = $('#total');
  const $selInp   = $('#selected-seats-input');
  const $totInp   = $('#total-price-input');

  const sc = $('#seat-map').seatCharts({
    map:[
      '__]a[100]a[99]a[98]a[97]a[96]a[95]a[94]a[93]a[92]a[91]a[90]a[89]a[88]a[87]a[86]a[85]',
      'a[84]a[83]a[82]a[81]_a[80]a[79]a[78]a[77]a[76]a[75]a[74]a[73]a[72]_a[71]a[70]a[69]a[68]a[67]',
      '__a[66]a[65]a[64]_a[63]a[62]a[61]a[60]a[59]a[58]a[57]a[56]a[55]_a[54]a[53]a[52]a[51]',
      '__a[50]a[49]a[48]_a[47]a[46]a[45]a[44]a[43]a[42]a[41]a[40]a[39]_a[38]a[37]a[36]a[35]',
      '_a[34]a[33]a[32]a[31]_a[30]a[29]a[28]a[27]a[26]a[25]a[24]a[23]a[22]_a[21]a[20]a[19]a[18]',
      '_a[17]a[16]a[15]a[14]_a[13]a[12]a[11]a[10]a[9]a[8]a[7]a[6]a[5]_a[4]a[3]a[2]a[1]'
    ],
    naming:{top:false,getLabel:(c,r,col)=>col},
    legend:{node:$('#legend'),items:[['a','available','Available'],['a','unavailable','Sold'],['a','selected','Selected']]},
    click:function(){
      const seatId = this.settings.id;
      if(this.status()==='available'){
        $('<li>R-'+(this.settings.row+1)+' S-'+this.settings.label+'</li>')
          .attr('id','cart-item-'+seatId)
          .data('seatId', seatId)
          .appendTo($cart);
        update(1);
        return 'selected';
      }
      if(this.status()==='selected'){
        $('#cart-item-'+seatId).remove();
        update(-1);
        return 'available';
      }
      return this.style();
    }
  });

  reserved.forEach(id => sc.get(id.toString()).status('unavailable'));

  function update(delta){
    const count = (+$counter.text()) + delta;
    const total = (+$total.text())   + (price * delta);
    $counter.text(count);
    $total.text(total);

    const selected = $cart.find('li').map(function(){return $(this).data('seatId');}).get().join(',');
    $selInp.val(selected);
    $totInp.val(total);
  }
});
</script>
<script src="js/theme-change-seat-sel.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
