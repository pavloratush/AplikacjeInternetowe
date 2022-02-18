<?php
require 'Routing.php';
$path = trim($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path,PHP_URL_PATH);


Routing::get('','DefaultController');
Routing::get('profile','ProfileController');
Routing::post('login','SecurityController');
Routing::post('friends','DefaultController');
Routing::post('watched','MoviesController');
Routing::post('movies','MoviesController');
Routing::post('schedule','MeetingController');
Routing::post('series','SeriesController');
Routing::post('register','RegisterController');
Routing::post('addMeeting','MeetingController');
Routing::post('settings','SettingsController');
Routing::post('logOut','SettingsController');
Routing::post('search','MoviesController');

Routing::post('adminAdd','MoviesController');
Routing::post('adminAddSeries','SeriesController');

Routing::get('like','MoviesController');
Routing::get('dislike','MoviesController');
Routing::get('addToWatched','MoviesController');
Routing::get('likeSeries','SeriesController');
Routing::get('dislikeSeries','SeriesController');
Routing::get('addToWatchedSeries','SeriesController');

Routing::run($path);
