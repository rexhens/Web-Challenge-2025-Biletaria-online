
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" content="Teatri Metropol - Your theater experience in Albania / Eksperienca juaj teatrore në Shqipëri.">
    <meta name="description" content="Teatri Metropol - Your theater experience in Albania / Eksperienca juaj teatrore në Shqipëri.">
    <meta property="og:title" content="Teatri Metropol">
    <meta property="og:image" content="/biletaria_online/assets/img/metropol_icon.png">
    <link rel="icon" type="image/x-icon" href="/biletaria_online/assets/img/metropol_icon.png">

    <title>Tetari Metropol <?php echo isset($pageTitle) ? '| ' . $pageTitle : ''; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <?php if (isset($pageStyles)): ?>
        <?php foreach ($pageStyles as $style): ?>
            <link rel="stylesheet" href="<?php echo $style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
