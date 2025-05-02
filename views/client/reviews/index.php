<?php

session_start();
$show_id = $_GET['show_id'] ?? null;

$pageTitle = 'Shfaqjet';
$pageStyles = [
    '/biletaria_online/assets/css/styles.css',
    '/biletaria_online/assets/css/navbar.css',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'
];
?>


<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vlerëso Shfaqjen</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        .review-form {
            width: 100%;
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
            color: #f7d106;
        }

        .rating>input:checked+label:hover,
        .rating>input:checked~label:hover,
        .rating>label:hover~input:checked~label,
        .rating>input:checked~label:hover~label {
            color: #f7b406;
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

        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>


    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>

    <style>
        body {
            padding: 0 30px;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

    <div class="review-form">
        <h2>Vlerësoni <span>Shfaqjen</span></h2>
       <form action="process_review.php" method="post">
    <input type="hidden" name="show_id" value="<?php echo htmlspecialchars($show_id); ?>">
    
        <div class="rating">
            <!-- yjet me radiobuton -->
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
</body>

</html>