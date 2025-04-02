<!DOCTYPE html>
<html lang="sq">
<head>
    <?php require 'includes/links.php' ?>
    <meta property="og:image" content="assets/img/metropol_icon.png">
    <title>Metropol Ticketing</title>
    <link rel="icon" type="image/x-icon" href="assets/img/metropol_icon.png">
    <link rel="stylesheet" href="assets/css/homepagestyles.css">
    <!-- <link rel="stylesheet" href="assets/css/styles.css"> -->
    <style>
        h1 {
            font-weight: lighter;
        }
        button {
            font-size: 17px;
            width: 140px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="assets/img/metropol_icon.png" alt="logo"></img>
            <h1><span>Metropol</span>Ticketing</h1>
        </div>
        <div class="menu-bar">
            <div class="menu">
                <a href="#" class="nav">SHFAQJET</a>
                <a href="#" class="nav">AKTORËT</a>
                <a href="#" class="nav">RRETH NESH</a>
                <a href="#" class="nav">KONTAKT</a>
            </div>
            <div class="buttons">
                <button aria-label="Identifikohu" onclick="redirectTo('auth/login.php')">Identifikohu</button>
                <button class="black-btn" aria-label="Regjistrohu" onclick="redirectTo('auth/signup.php')">Regjistrohu</button>
            </div>
        </div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
    </div>

    <div class="video-container">
        <div id="player"></div>

        <div class="controls">
            <div class="control-button" id="prevBtn">&#10094;</div>
            <div class="control-button" id="nextBtn">&#10095;</div>
        </div>
    </div>

    <script src="assets/js/functions.js"></script>
    <script src="assets/js/load-trailers.js"></script>
</body>
</html>