<!doctype html>
<html lang="sq">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" content="Teatri Metropol - Your theater experience in Albania.">
    <meta name="description" content="Teatri Metropol - Your theater experience in Albania.">
    <meta property="og:title" content="Teatri Metropol">
    <meta property="og:description" content="Your theater experience in Albania.">
    <meta property="og:image" content="assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">

    <title>Tetari Metropol <?php echo isset($pageTitle) ? '| ' . $pageTitle : ''; ?></title>

    <!-- Main CSS (always loaded) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Page-specific CSS -->
    <?php if (isset($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?php echo $style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>

    <!-- header -->
    <header id="site-header" class="w3l-header fixed-top">
        <!--/nav-->
        <nav class="navbar navbar-expand-lg navbar-light fill px-lg-0 py-0 px-3">
            <div class="container">

                <a class="navbar-brand" href="../views/index.php">
                    <img src="../assets/images/metropol_icon.png" alt="metropol" title="metropol" style="height:35px;" />
                </a>
                
                <a class="navbar-brand" href="../views/index.php">
                    Teatri <b style="color: #836e4f;">Metropol</b>
                </a>    
                
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="fa icon-expand fa-bars"></span>
                    <span class="fa icon-close fa-times"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="../views/index.php">Home</a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="../views/shows.php">Shfaqje</a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="about.php">Rreth Nesh</a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'metrofest.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="metrofest.php">Metrofest</a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="contact.php">Kontakt</a>
                        </li>
                        <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'applications.php' ? 'active' : ''; ?>">
                            <a class="nav-link" href="applications.php">Aplikime</a>
                        </li>
                    </ul>

                    <!--/search-right-->
                    <div class="search-right">
                        <a href="#search" class="btn search-hny mr-lg-3 mt-lg-0 mt-4" title="search">Search <span
                                class="fa fa-search ml-3" aria-hidden="true"></span></a>
                        <!-- search popup -->
                        <div id="search" class="pop-overlay">
                            <div class="popup">
                                <form action="#" method="post" class="search-box">
                                    <input type="search" placeholder="Search your Keyword" name="search"
                                        required="required" autofocus="">
                                    <button type="submit" class="btn"><span class="fa fa-search"
                                            aria-hidden="true"></span></button>
                                </form>
                                <div class="browse-items">
                                    <h3 class="hny-title two mt-md-5 mt-4">Browse all:</h3>
                                    <ul class="search-items">
                                        <li><a href="events.php">Action</a></li>
                                        <li><a href="events.php">Drama</a></li>
                                        <li><a href="events.php">Family</a></li>
                                        <li><a href="events.php">Thriller</a></li>
                                        <li><a href="events.php">Commedy</a></li>
                                        <li><a href="events.php">Romantic</a></li>
                                        <li><a href="events.php">Tv-Series</a></li>
                                        <li><a href="events.php">Horror</a></li>
                                    </ul>
                                </div>
                            </div>
                            <a class="close" href="#close">×</a>
                        </div>
                        <!-- /search popup -->
                    </div>
                    <div class="Login_SignUp" id="login"
                        style="font-size: 2rem ; display: inline-block; position: relative;">
                        <a class="nav-link" href="../auth/login.php"><i class="fa fa-user-circle-o"></i></a>
                    </div>
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