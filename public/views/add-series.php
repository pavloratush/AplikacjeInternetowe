<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/profile.css">
    <link rel="stylesheet" type="text/css" href="public/css/addMeeting.css">
    <title>STRACY</title>
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


        <section class="meeting-form">
            <h1>ADD SERIES</h1>
            <form action="adminAddSeries" method="POST" ENCTYPE="multipart/form-data">
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="title" type="text" placeholder="title">
                <input name="genre" type="text" placeholder="genre">
                <input name="creation_date" type="text" placeholder="creation_date">

                <input type="file" name="file"/><br/>
                <button type="submit">send</button>
            </form>
        </section>


    </main>

</div>

</body>