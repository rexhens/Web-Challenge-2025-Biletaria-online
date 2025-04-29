
<nav class="navbar">
    <div class="navbar-logo" onclick="window.location.href='/biletaria_online/index.php'">
        <img src="/biletaria_online/assets/img/metropol_icon.png" alt="Teatri Metropol Logo" class="logo-img">
    </div>

    <div class="navbar-title" onclick="window.location.href='/biletaria_online/index.php'">
        <h1>Teatri <span class="metropol">Metropol</span></h1>
    </div>

    <ul class="navbar-links">
        <li>
            <a href="/biletaria_online/index.php"
               class="<?php echo $_SERVER['SCRIPT_NAME'] == '/biletaria_online/index.php' ? 'active' : ''; ?>">
                Kreu
            </a>
        </li>
        <li>
            <a href="/biletaria_online/views/client/shows/index.php"
               class="<?php echo $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/shows/index.php' ? 'active' : ''; ?>">
                Shfaqje
            </a>
        </li>
        <li>
            <a href="/biletaria_online/views/client/events/index.php"
               class="<?php echo $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/events/index.php' ? 'active' : ''; ?>">
                Evente
            </a>
        </li>
        <li>
            <a href="/biletaria_online/views/client/about.php"
               class="<?php echo $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/about.php' ? 'active' : ''; ?>">
                Rreth nesh
            </a>
        </li>
        <li>
            <a href="/biletaria_online/views/client/applications.php"
               class="<?php echo $_SERVER['SCRIPT_NAME'] == '/biletaria_online/views/client/applications.php' ? 'active' : ''; ?>">
                Aplikime
            </a>
        </li>
        <?php if(!isset($_SESSION['user_id'])) {
        ?>
        <li>
            <div class="navbar-icons">
                <a href="/biletaria_online/auth/login.php" class="profile-icon"><i class="fas fa-user-circle"></i></a>
            </div>
        </li>
        <?php } else { ?>
        <li>
            <div class="navbar-icons">
                <a href="/biletaria_online/auth/logout.php" class="profile-icon"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </li>
        <?php } ?>
    </ul>

    <div class="navbar-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>
</nav>
<script>
    const mobileMenu = document.getElementById('mobile-menu');
    const navbarLinks = document.querySelector('.navbar-links');
    const menuIcon = mobileMenu.querySelector('i');

    mobileMenu.addEventListener('click', () => {
        navbarLinks.classList.toggle('active');

        if (navbarLinks.classList.contains('active')) {
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        } else {
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }
    });
/*
    // Toggle dark/light icon
    const themeToggle = document.querySelector('.theme-toggle');
    const themeIcon = themeToggle.querySelector('i');

    themeToggle.addEventListener('click', () => {
        if (themeIcon.classList.contains('fa-sun')) {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }
    });*/
</script>
