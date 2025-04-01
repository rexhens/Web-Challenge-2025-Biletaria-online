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
        .video-container {
            width: 100vw;
            height: 100vh;
            background: black;
            margin-bottom: 100vh;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        .controls {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            width: 100%;
            transform: translateY(-50%);
        }
        .control-button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 20px;
            font-size: 30px;
            cursor: pointer;
            opacity: 0.7;
        }
        .control-button:hover {
            opacity: 1;
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
        <iframe id="videoPlayer" src="https://www.youtube.com/embed/MpcE70VvyEI?autoplay=1" allow="autoplay" frameborder="0"></iframe>

        <div class="controls">
            <button class="control-button" id="prevBtn">&#10094;</button>
            <button class="control-button" id="nextBtn">&#10095;</button>
        </div>
    </div>

    <section id="info" class="info">
        <h2>INFORMACION</h2>
        <h3>DHE HISTORI</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>
    </section>

    <section id="current-shows" class="current-shows">
        <h2>SHFAQJET</h2>
        <h3>AKTUALE</h3>
        <div class="show">
            <img src="assets/img/shows/show-image.jpg" alt="Poster for Show 1">
            <div class="show-details">
                <h3>SHFAQJA 1</h3>
                <p>molestiae officiis in itaque quod explicabo velit libero quisquam...</p>
                <button class="reserve">REZERVO TANI</button>
                <button class="more-info">ME SHUME INFO</button>
            </div>
        </div>
    </section>

    <section id="troupe" class="troupe">
        <h2>TRUPA</h2>
        <h3>TEATRALE</h3>
        <div class="actors">
            <div class="actor">
                <img src="assets/img/actors/team-1.jpg" alt="Actor 1">
                <button>Me shume info</button>
            </div>
            <div class="actor">
                <img src="assets/img/actors/team-2.jpg" alt="Actor 2">
                <button>Me shume info</button>
            </div>
            <div class="actor">
                <img src="assets/img/actors/team-3.jpg" alt="Actor 3">
                <button>Me shume info</button>
            </div>
        </div>
    </section>
    <script src="assets/js/functions.js"></script>
    <script>
        window.addEventListener("scroll", function() {
            let navbar = document.getElementsByClassName("navbar")[0];
            if (window.scrollY > 50) {
                navbar.classList.add("blurred");
            } else {
                navbar.classList.remove("blurred");
            }
        });
    </script>
    <script>
        // Array of video IDs
        const videoIds = ["8zgOVbc1Yko", "a8gsni1c-To"];
        let currentIndex = 0;

        // Function to change the video based on the current index
        function changeVideo() {
            const iframe = document.getElementById('videoPlayer');
            iframe.src = `https://www.youtube.com/embed/${videoIds[currentIndex]}?autoplay=1`;
        }

        // Next button functionality
        document.getElementById('nextBtn').addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % videoIds.length; // Loop back to first video if last one
            changeVideo();
        });

        // Previous button functionality
        document.getElementById('prevBtn').addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + videoIds.length) % videoIds.length; // Loop to last video if first one
            changeVideo();
        });
    </script>
</body>
</html>