<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/movies.css">    <title>STRACY</title>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/statisticsSeries.js" defer></script>
    <script src="https://kit.fontawesome.com/52b5666f67.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="public/img/logo.svg">
        <ul>
            <li>
                <a href="profile" class="button-icon"><i class="fas fa-user"></i></a>
                <a href="profile" class="button">profile</a>
            </li>
            <li>
                <a href="friends" class="button-icon"><i class="fas fa-users"></i></a>
                <a href="friends" class="button">friends</a>
            </li>
            <li>
                <a href="series" class="button-icon"><i class="fas fa-dice-d20"></i></a>
                <a href="series" class="button">series</a>
            </li>
            <li>
                <a href="movies" class="button-icon"><i class="fas fa-film"></i></a>
                <a href="movies" class="button">movies</a>
            </li>
            <li>
                <a href="schedule" class="button-icon"><i class="fas fa-calendar-alt"></i></a>
                <a href="schedule" class="button">schedule</a>
            </li>
            <li>
                <a href="watched" class="button-icon"><i class="fas fa-video"></i></a>
                <a href="watched" class="button">watched</a>
            </li>
            <li>
                <a href="settings" class="button-icon"><i class="fas fa-cog"></i></a>
                <a href="settings" class="button">settings</a>
            </li>
        </ul>
    </nav>


    <main>
        <header>
            <div class="logo-header">
                <img src="public/img/logo.svg">
            </div>
            <div class="search-bar">
                    <input placeholder="search movie">
            </div>
            <a href="addMeeting" class="add-meeting">
                <i class="fas fa-plus"></i>
                <div class="add-meeting-to-hide">add meeting</div>
            </a>
        </header>


        <section class="movies">
            <?php foreach ($series as $serie): ?>
                <div class="movie-1">
                    <div id="<?= $serie->getId(); ?>">
                        <img src="public/img/series/<?= $serie->getImage(); ?>">
                        <div class="text-of-movies">
                            <h2><?= $serie->getTitle(); ?></h2>
                            <div class="social-section">
                                <i class="fas fa-heart"> <?= $serie->getLikes(); ?> </i>
                                <i class="fas fa-minus-square"> <?= $serie->getDislikes(); ?> </i>
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

    </main>

</div>
</body>


<template id="movie-template">
    <div id="">
        <div class="movie-1">
            <img src="">
            <div class="text-of-movies">
                <h2>title</h2>
                <div class="social-section">
                    <i class="fas fa-heart"> 0 </i>
                    <i class="fas fa-minus-square"> 0 </i>
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
    </div>
</template>