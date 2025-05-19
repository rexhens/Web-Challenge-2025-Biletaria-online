<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

$show_id = filter_input(INPUT_GET, 'show_id', FILTER_VALIDATE_INT);
$event_id = filter_input(INPUT_GET, 'event_id', FILTER_VALIDATE_INT);
$res_id = filter_input(INPUT_GET, 'res', FILTER_VALIDATE_INT);

if (($show_id === null && $event_id === null) || $res_id === null) {
    showError("Parametra të pavlefshëm ose të munguar!");
}

$sql = "SELECT email, show_id, event_id FROM reservations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $res_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    showError("Rezervimi nuk u gjet!");
}

$email = $result['email'];

$title = null;

if ($show_id !== null) {
    if($show_id != $result['show_id']) {
        showError("Një problem ndodhi!");
    }
    $id = $show_id;
    $sql = 'SELECT title FROM shows WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $show_id);
    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
    $result = $stmt->get_result()->fetch_assoc();
    if (!$result) {
        showError("Shfaqja nuk u gjet!");
    }
    $title = $result['title'];
} elseif ($event_id !== null) {
    if($event_id != $result['event_id']) {
        showError("Një problem ndodhi!");
    }
    $id = $event_id;
    $sql = 'SELECT title FROM events WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    if (!$stmt->execute()) {
        showError("Një problem ndodhi! Provoni më vonë!");
    }
    $result = $stmt->get_result()->fetch_assoc();
    if (!$result) {
        showError("Eventi nuk u gjet!");
    }
    $title = $result['title'];
}

$pageTitle = 'Vlerëso ' . isset($_GET['show_id']) ? 'Shfaqjen' : 'Eventin';
$pageStyles = [
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
    '/biletaria_online/assets/css/styles.css',
    '/biletaria_online/assets/css/navbar.css',
    '/biletaria_online/assets/css/footer.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        body {
            font-family: sans-serif;
            overflow-x: hidden !important;
            margin-top: 20px;
        }

        .footer-glass {
            width: calc(100% - 32px);
        }

        .footer-bottom {
            margin-left: -20px;
        }

        .review-form {
            width: 95%;
            max-width: 400px;
            margin: auto;
            padding: 20px 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: rgba(228, 228, 228, 0.04) !important;
        }

        .review-form.light {
            background: #f2f2f2 !important;
        }

        .review-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            border: none;
            margin-bottom: 15px;
        }

        .rating>input {
            display: none;
        }

        .rating>label {
            color: #ddd;
            font-size: 55px;
            padding: 0 3px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .rating>label:before {
            content: "\2605";
        }

        .rating>input:checked~label,
        .rating:not(:checked)>label:hover,
        .rating:not(:checked)>label:hover~label {
            color: var(--heading2-color);
        }

        .rating>input:checked+label:hover,
        .rating>input:checked~label:hover,
        .rating>label:hover~input:checked~label,
        .rating>input:checked~label:hover~label {
            color: var(--accent-color);
        }

        .comment-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .comment-section textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--accent-color);
            border-radius: 4px;
            box-sizing: border-box;
            min-height: 100px;
            resize: vertical;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            transition: background-color 0.2s;
        }

        @media (max-width: 535px) {
            .review-form {
                max-width: 80%;
                padding: 20px 30px;
            }
        }
    </style>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

    <div class="review-form">
        <h2>Vlerësoni <?= isset($_GET['show_id']) ? 'Shfaqjen' : 'Eventin' ?><br>
        <span>"<?php echo htmlspecialchars($title) ?>"</span></h2>
        <form action="" method="post">
            <input type="hidden" name="<?php echo isset($_GET['show_id']) ? 'show_id' : 'event_id'?>" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="reservation_id" value="<?php echo $_GET['res']; ?>">

            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 yje"></label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 yje"></label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 yje"></label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 yje"></label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 yll"></label>
            </div>

            <div class="comment-section">
                <label for="comment">Komenti juaj:</label>
                <textarea id="comment" name="comment" rows="5" placeholder="Shkruani komentin tuaj këtu..."><?php echo htmlspecialchars($_POST['comment'] ?? '') ?></textarea>
            </div>

            <button type="submit">Dërgo Vlerësimin</button>
        </form>
    </div>

    <div class="info-container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $reservation_id = $_POST['reservation_id'];
            $show_id = $_POST['show_id'] ?? null;
            $event_id = $_POST['event_id'] ?? null;
            $rating = $_POST['rating'] ?? null;
            $comment = trim($_POST['comment']) ?? null;
            $date = date('Y-m-d H:i:s');

            $errors = [];

            if ($reservation_id && ($show_id || $event_id) && $rating) {
                $stmt = $conn->prepare("INSERT INTO reviews (email, show_id, event_id, rating, comment, date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("siiiss", $email, $show_id, $event_id, $rating, $comment, $date);
                $stmt->execute();

                if (!$stmt->affected_rows > 0) {
                    $errors[] = "Dështoi ruajtja e vlerësimit.";
                }

                $stmt->close();
            } else {
                $errors[] = "Të dhënat mungojnë! Ju duhet të vendosni një vlerësim me yje!";
            }

            if(!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<div class='errors show'><p>$error</p></div>";
                }
            } else {
                echo "<div class='errors show' style='background-color: rgba(131, 173, 68) !important;'>
                         <p style='color: #E4E4E4;'>Vlerësimi juaj u dërgua me sukses!</p>
                      </div>";

                $subject = "U shtua review";
                $body = "Kontrolloni review-n e bërë nga <a href='mailto:" . $email . "'>" . $email . "</a> për shfaqjen/eventin \"" . $title . "\"<br>Ky email vjen automatikisht që ju të kontrolloni nëse review e bërë ka përmbajtje të padëshiruar.";

                $title = "Një review u shtua!";

                $sql = "SELECT email FROM users WHERE role = 'admin' OR role = 'ticketOffice'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result) {
                    while($row = $result->fetch_assoc()) {
                        sendEmail($row['email'], $subject, $title, $body, "");
                    }
                }
            }
        }
        ?>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

    <script>
        const elementsToHide = document.getElementsByClassName("show");
        setTimeout(() => {
            Array.from(elementsToHide).forEach((el) => el.classList.remove("show"))
        }, 4500);
    </script>
    <script src="/biletaria_online/assets/js/theme-change.js"></script>

</body>
</html>