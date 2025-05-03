<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

if(!isset($_GET['show_id'])) {
    showError("Nuk ka të dhëna të mjaftueshme!");
}

$show_id = $_GET['show_id'];

$sql = 'SELECT title FROM shows WHERE id = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $show_id);
if(!$stmt->execute()) {
    showError("Një problem ndodhi! Provoni më vonë!");
}
$title = $stmt->get_result()->fetch_assoc()['title'];

$pageTitle = 'Vlerëso Shfaqjen';
$pageStyles = [
    '/biletaria_online/assets/css/styles.css',
    '/biletaria_online/assets/css/navbar.css',
    '/biletaria_online/assets/css/footer.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
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

        .footer-bottom {
            margin-left: -20px;
        }

        .review-form {
            width: 95%;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: rgba(228, 228, 228, 0.04) !important;
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
            border: 1px solid #ccc;
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
    </style>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

    <div class="review-form">
        <h2>Vlerësoni Shfaqjen<br>
        <span>"<?php echo htmlspecialchars($title) ?>"</span></h2>
        <form action="process_review.php" method="post">
            <input type="hidden" name="show_id" value="<?php echo htmlspecialchars($show_id); ?>">

            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 yje"></label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 yje"></label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 yje"></label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 yje"></label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 yll"></label>
            </div>

            <div class="comment-section">
                <label for="comment">Komenti juaj:</label>
                <textarea id="comment" name="comment" rows="5" placeholder="Shkruani komentin tuaj këtu..." required></textarea>
            </div>

            <button type="submit">Dërgo Vlerësimin</button>
        </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

</body>
</html>