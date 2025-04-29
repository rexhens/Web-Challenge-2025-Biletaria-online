<?php
/** @var mysqli $conn */
require "../../config/db_connect.php";
require "../../auth/auth.php";
require "../../includes/functions.php";

// --------------------------------------------------
// 1) grab show id from URL
$show_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$show_id) {
    die("Invalid show ID.");
}

// fetch all dates for the chosen show
$datesQuery = $conn->prepare(
    "SELECT show_date 
       FROM show_dates 
      WHERE show_id = ? 
   ORDER BY show_date ASC"
);
$datesQuery->bind_param("i", $show_id);
$datesQuery->execute();
$datesResult = $datesQuery->get_result();
$dates = [];
while ($row = $datesResult->fetch_assoc()) {
    $dates[] = $row['show_date'];          // yyyy-mm-dd
}

$groupedDates = groupDates($dates);        // helper defined in includes/functions.php
$today        = new DateTime('today');





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
</head>

<body>
  <header id="site-header" class="w3l-header fixed-top">

    <!--/nav-->
    <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
      <div class="container">
       
				
      <a class="navbar-brand" href="../../../biletaria_online/index.php">
                    <img src="../../../biletaria_online/assets/images/metropol_icon.png" alt="metropol" title="metropol" style="height:35px;" />
                </a>

                <a class="navbar-brand" href="../../biletaria_online/index.php">
                    Teatri <b style="color: #836e4f;">Metropol</b>
                </a>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        </div>

        <div class="Login_SignUp" id="login_s">
          <!-- style="font-size: 2rem ; display: inline-block; position: relative;" -->
          <!-- <li class="nav-item"> -->
          <a class="nav-link" href="sign_in.html"><i class="fa fa-user-circle-o"></i></a>
          <!-- </li> -->
        </div>
        <!-- toggle switch for light and dark theme -->
        <div class="mobile-position">
          <nav class="navigation">
            <div class="theme-switch-wrapper">
              <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox">
                <div class="mode-container">
                  <i class="gg-sun"></i>
                  <i class="gg-moon"></i>
                </div>
              </label>
            </div>
          </nav>
        </div>
      </div>
    </nav>
  </header>

  <div class="container" id="progress-container-id">
    <div class="row">
      <div class="col">
        <div class="px-0 pt-4 pb-0 mt-3 mb-3">
          <form id="form">
          <ul id="progressbar" class="progressbar-class">
  <li class="active" id="step1">Rezervimi i kohes</li>
  <li id="step2" class="not_active">Rezervimi i vendeve</li>
  <li id="step3" class="not_active">Informacioni juaj</li>
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
        $d        = new DateTime($dateStr);
        $dayNum   = $d->format('j');          // 1–31
        $month    = $d->format('M');          // Jan, Feb …
        $weekday  = $d->format('l');          // Monday …
        $diffDays = (int)$today->diff($d)->format('%r%a');

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
  <?php
  /* The shows table has one or more rows for this $show_id.
     Each row contains a hall (e.g. 1, 2, “Blue Hall”) and a time
     (TIME or DATETIME).  Collect them into $hallTimes[hall][] = time */
  $hallTimes = [];

  $hallStmt = $conn->prepare(
      "SELECT hall, time
         FROM shows
        WHERE id = ?"
  );
  $hallStmt->bind_param("i", $show_id);
  $hallStmt->execute();
  $hallStmt->bind_result($hall, $rawTime);

  while ($hallStmt->fetch()) {
      // normalise the time to “h:mm AM/PM”
      $fmtTime = (new DateTime($rawTime))->format('g:i A');
      $hallTimes[$hall][] = $fmtTime;
  }
  $hallStmt->close();

  // sort halls and their times for a neat display
  ksort($hallTimes);                   // sort halls (1,2,3…)
  foreach ($hallTimes as &$tArr) {
      sort($tArr);                     // sort times within each hall
  }
  unset($tArr);
  ?>

  <!------ 3.  SCREEN / TIME LIST ----------------------------------------->
  <ul class="time-ul">
    <?php foreach ($hallTimes as $hall => $times): ?>
      <li class="time-li">
        <div class="screens">Salla <?php echo htmlspecialchars($hall); ?></div>
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

              <input id="screen-next-btn" type="button" name="next-step" class="next-step" value="Continue Booking"
                disabled />
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

  <input type="button" class="next-step"     value="Review Ticket">
  <input type="button" class="previous-step" value="Back">
</fieldset>
             
            <fieldset>
              <h2>Bileta</h2>
              <div class="ticket-body">
                <div class="ticket">
                  <div class="holes-top"></div>
                  <div class="title">
                    <p class="cinema">Metropol Theatre</p>
                    <p class="movie-title"><?= htmlspecialchars($tk['title']) ?></p>
                  </div>
                  <div class="poster">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/25240/only-god-forgives.jpg"
                      alt="Movie: Only God Forgives" />
                  </div>
                  <div class="info">
                    <table class="info-table ticket-table">
                      <tr>
                        <th>SCREEN</th>
                        <th>ROW</th>
                        <th>SEAT</th>
                      </tr>
                      <tr>
                        <td class="bigger">18</td>
                        <td class="bigger">H</td>
                        <td class="bigger">24</td>
                      </tr>
                    </table>
                    <table class="info-table ticket-table">
                      <tr>
                        <th>PRICE</th>
                        <th>DATE</th>
                        <th>TIME</th>
                      </tr>
                      <tr>
                        <td>ALL.12.00</td>
                        <td>4/13/21</td>
                        <td>19:30</td>
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
              <input type="button" name="previous-step" class="home-page-btn" value="Shkoni tek Kryefaqja"
                onclick="location.href='index.php';" />
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

</html>