<?php
session_start();

require_once '../config/db_connect.php';  // Adjust the path as needed

// 1. Check if user is logged in
/*
if(!isset($_SESSION['id'])) {
    header("Location: ../../../auth/login.php");
    exit();
}
*/

// 2. Get show ID
$showId = isset($_GET['show_id']) ? intval($_GET['show_id']) : 0;
if($showId <= 0) {
    die("Shfaqje e pavlefshme!");
}

// 3. Fetch show details
$stmt = $conn->prepare("SELECT * FROM shows WHERE id = ?");
$stmt->bind_param("i", $showId);
$stmt->execute();
$showResult = $stmt->get_result();
if(!$showResult->num_rows) {
    die("Shfaqja nuk u gjet!");
}
$show = $showResult->fetch_assoc();
$stmt->close();

$errors = [];
$success = "";

// 4. Handle reservation submission
if(isset($_POST['reserve'])) {
    $userId    = $_SESSION['id'];
    $dateTime  = $_POST['datetime'] ?? '';
    $seat      = $_POST['seatSelected'] ?? '';
    $hall      = $show['hall'];

    if(empty($dateTime)) {
        $errors[] = "Ju lutemi zgjidhni datën/orën!";
    }
    if(empty($seat)) {
        $errors[] = "Ju lutemi zgjidhni një vend!";
    }

    // Check seat availability
    if(empty($errors)) {
        $checkSql = "SELECT * FROM reservations WHERE show_id = ? AND date = ? AND seat = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("iss", $showId, $dateTime, $seat);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if($checkResult->num_rows > 0) {
            $errors[] = "Vendi $seat është i zënë për këtë orar!";
        }
        $checkStmt->close();

        // Insert reservation
        if(empty($errors)) {
            $insertSql = "INSERT INTO reservations (user_id, show_id, date, hall, seat)
                          VALUES (?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("issis", $userId, $showId, $dateTime, $hall, $seat);

            if($insertStmt->execute()) {
                $success = "Rezervimi juaj për vendin $seat u ruajt me sukses!";
            } else {
                $errors[] = "Ndodhi një gabim gjatë rezervimit. Ju lutemi provoni përsëri.";
            }
            $insertStmt->close();
        }
    }
}

// 5. Determine taken seats if datetime is chosen
$takenSeats = [];
$chosenDatetime = "";
if(isset($_POST['datetime']) || isset($_POST['reserve'])) {
    $chosenDatetime = $_POST['datetime'] ?? '';
    if($chosenDatetime) {
        $stmt = $conn->prepare("SELECT seat FROM reservations WHERE show_id = ? AND date = ?");
        $stmt->bind_param("is", $showId, $chosenDatetime);
        $stmt->execute();
        $res = $stmt->get_result();
        while($row = $res->fetch_assoc()) {
            $takenSeats[] = $row['seat'];
        }
        $stmt->close();
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teatri Metropol - Rezervo</title>
    <meta name="description" content="Teatri Metropol - Your theater experience in Albania.">
    <meta property="og:title" content="Teatri Metropol">
    <meta property="og:description" content="Your theater experience in Albania.">
    <meta property="og:image" content="=../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">

    <!-- Your main homepage CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">

    <!-- Additional styling for the reservation section -->
    <style>
        /* BODY / PAGE LAYOUT */
        body {
            margin: 0;
            padding: 0;
            /* If you want a custom background: 
            background: url('../../../assets/img/background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            */
        }

        /* Dark / Transparent Reservation Container */
        .reservation-section {
            max-width: 800px;
            margin: 40px auto;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 20px;
            border-radius: 10px;
            color: #fff; /* Light text */
        }

        .reservation-section h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #ffcc00; /* A pop of color (yellowish) */
        }

        .reservation-section p.show-description {
            text-align: center;
            margin-bottom: 25px;
        }

        /* FLASH MESSAGES */
        .flash-message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .flash-error {
            background-color: #ff6666;
            color: #fff;
        }
        .flash-success {
            background-color: #66cc66;
            color: #fff;
        }

        /* FORM ELEMENTS */
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .form-group input[type="datetime-local"] {
            padding: 8px;
            width: 100%;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }

        /* SEAT LAYOUT (130 seats) */
        .seat-container {
            margin-top: 20px;
        }
        .seat-container p {
            font-style: italic;
            margin-bottom: 12px;
        }
        .seat-rows {
            display: grid;
            /* 13 rows (A - M) => we'll set them as 13 show "groups" */
            grid-template-rows: repeat(13, auto);
            gap: 16px;
            justify-items: center;
        }
        .seat-row {
            /* Each show has 10 seats => 10 columns */
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 8px;
        }

        /* SMALLER SEAT BUTTONS */
        .seat-btn {
            width: 36px;
            height: 36px;
            line-height: 36px;
            background: #222;
            color: #fff;
            border: 1px solid #555;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            transition: background 0.2s;
            font-weight: bold;
            font-size: 12px;
        }
        .seat-btn:hover {
            background: #333;
        }
        .seat-taken {
            background: #b30000 !important;
            color: #fff;
            cursor: not-allowed;
        }
        .seat-selected {
            background: #00a300 !important;
            color: #fff;
        }

        /* RESERVE BUTTON */
        .reserve-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            cursor: pointer;
            background: #ff9900;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            transition: background 0.3s;
        }
        .reserve-button:hover {
            background: #e68a00;
        }

        /* BACK LINK */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            font-weight: bold;
            color: #ffcc00;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }

        /* RESPONSIVE MEDIA QUERIES */
        @media (max-width: 600px) {
            .seat-btn {
                width: 30px;
                height: 30px;
                line-height: 30px;
                font-size: 11px;
            }
        }
        @media (max-width: 400px) {
            .seat-btn {
                width: 26px;
                height: 26px;
                line-height: 26px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER (from your main design) -->
    <header>
        <h1 class="logo">METROPOL</h1>
        <nav aria-label="Main navigation">
            <ul>
                <li><a href="#">SHFAQJET</a></li>
                <li><a href="#">AKTORET</a></li>
                <li><a href="#">EVENTET</a></li>
                <li><a href="#">KONTAKTI</a></li>
            </ul>
        </nav>
        <div class="buttons">
            <!-- Adjust these if you have different paths -->
            <button class="reserve" aria-label="Reserve tickets"
                onclick="window.location.href='../index.php'">
                REZERVO
            </button>
            <button class="login" aria-label="Log in to your account"
                onclick="window.location.href='../../../login.php'">
                LOG IN
            </button>
        </div>
    </header>

    <!-- MAIN Reservation Section -->
    <section class="reservation-section">
        <h2>Rezervo Biletën</h2>
        <p class="show-description">
            <strong><?php echo htmlspecialchars($show['title']); ?></strong><br>
            <?php echo nl2br(htmlspecialchars($show['description'])); ?>
        </p>

        <!-- Flash messages -->
        <?php if(!empty($errors)): ?>
            <div class="flash-message flash-error">
                <?php foreach($errors as $error) {
                    echo "<p>$error</p>";
                } ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)): ?>
            <div class="flash-message flash-success">
                <p><?php echo $success; ?></p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="datetime">Zgjidh datën/orën e shfaqjes:</label>
                <input
                    type="datetime-local"
                    id="datetime"
                    name="datetime"
                    value="<?php echo htmlspecialchars($chosenDatetime); ?>"
                    required
                    onchange="document.getElementById('refreshForm').click();"
                />
                <!-- Hidden button to refresh seats upon date/time change -->
                <button type="submit" id="refreshForm" style="display:none;">Rifresko</button>
            </div>

            <div class="seat-container">
                <p>(Klikoni një vend të lirë për ta zgjedhur)</p>
                <div class="seat-rows">
                    <?php
                    // 13 rows: A through M
                    $rows = range('A', 'M');  // A, B, C, ..., M
                    // 10 columns/seats: 1..10
                    $cols = range(1, 10);

                    foreach($rows as $row) {
                        echo '<div class="seat-row">';
                        foreach($cols as $col) {
                            $seatCode = $row.$col; // e.g. A1, A2 ... M10
                            $taken = in_array($seatCode, $takenSeats);
                            echo '<div 
                                    class="seat-btn '.($taken ? 'seat-taken' : '').'" 
                                    data-seat="'.$seatCode.'" 
                                    onclick="selectSeat(this)"
                                    '.($taken ? 'disabled' : '').'
                                  >'
                                  .$seatCode.
                                  '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Hidden field to store selected seat -->
            <input type="hidden" name="seatSelected" id="seatSelected" value="">

            <div style="text-align:center;">
                <button type="submit" name="reserve" class="reserve-button">REZERVO</button>
            </div>
        </form>

        <a href="../index.php" class="back-link">Kthehu në faqen kryesore</a>
    </section>

    <script>
    function selectSeat(element) {
        if (element.classList.contains('seat-taken')) {
            return;
        }
        // Remove previous selection
        const allSeats = document.querySelectorAll('.seat-btn');
        allSeats.forEach(seat => seat.classList.remove('seat-selected'));

        // Mark current seat as selected
        element.classList.add('seat-selected');

        // Store seat code in hidden input
        document.getElementById('seatSelected').value = element.getAttribute('data-seat');
    }
    </script>
</body>
</html>
