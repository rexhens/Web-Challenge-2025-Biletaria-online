<!DOCTYPE html>
<html lang="sq">
<?php
$pageTitle = 'Pagesa';
$pageStyles = [
    '/biletaria_online/assets/css/styles.css'
];
?>
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
    <style>
        .animation {
            width: 650px;
        }
        @media (max-width: 945px) {
            .animation {
                width: 400px;
            }
        }
    </style>
</head>
<body class="light">
<div class="form-container light">
    <h1 style="color: forestgreen; font-weight: bold !important; margin-bottom: -20px !important;">Pagesa u krye me sukses!</h1>
    <div class="checkmark-animation">
        <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_jbrw3hcz.json" class="animation" background="transparent" speed="0.4" autoplay></lottie-player>
    </div>
</div>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>
</html>
