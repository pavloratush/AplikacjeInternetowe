<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Series.php';
require_once __DIR__ . '/../repository/SeriesRepository.php';


class SeriesController extends AppController
{
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/series/';

    private $messages = [];
    private $seriesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->seriesRepository = new SeriesRepository();
    }

    public function series()
    {
        if ($_COOKIE["user"]) {
            $movies = $this->seriesRepository->getSeriesArray();
            $this->render('series', ['series' => $movies]);
        } else
            $this->render('login', ['messages' => ['You have to be logged in!']]);
    }

    public function seriesArray()
    {
        if ($_COOKIE["user"]) {
            $series = $this->seriesRepository->getSeriesArray();
            $this->render('series', ['series' => $series]);
        } else
            $this->render('login', ['messages' => ['You have to be logged in!']]);
    }

    public function likeSeries(int $id)
    {
        $this->seriesRepository->like($id);
        http_response_code(200);
    }

    public function dislikeSeries(int $id)
    {
        $this->seriesRepository->dislike($id);
        http_response_code(200);
    }

    public function addToWatchedSeries(int $idSeries)
    {
        $this->seriesRepository->addToWatched($idSeries);
        http_response_code(200);
    }

    public function adminAddSeries()
    {
        if ($_COOKIE["admin"]) {
            if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->check($_FILES['file'])) {
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
                );
                $newSeries = new Series($_POST['title'], 0, 0, $_POST['genre'], 0, $_FILES['file']['name']);
                $this->seriesRepository->addSeriesAsAdmin($newSeries);

                return $this->render('series', [
                    'series' => $this->seriesRepository->getSeriesArray(),
                    'messages' => $this->message
                ]);
            }
            return $this->render('add-series', ['messages' => $this->message]);
        } else {
            return $this->render("settings", ['messages' => ["you have to be admin to reach this feature"]]);
        }
    }

    private function check(array $file): bool
    {
        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

}