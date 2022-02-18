<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Movie.php';
require_once __DIR__ . '/../repository/MovieRepository.php';
require_once __DIR__ . '/../repository/SeriesRepository.php';


class MoviesController extends AppController
{
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/movies/';

    private $messages = [];
    private $moviesRepository;
    private $seriesRepository;

    public function __construct()
    {
        parent::__construct();
        $this->moviesRepository = new MovieRepository();
        $this->seriesRepository = new SeriesRepository();
    }

    public function movies()
    {
        if ($_COOKIE["user"]) {
            $movies = $this->moviesRepository->getMovies();
            $this->render('movies', ['movies' => $movies]);
        } else
            $this->render('login', ['messages' => ['You have to be logged in!']]);
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->moviesRepository->getMovieByTitle($decoded['search']));
        }
    }

    public function like(int $id)
    {
        $this->moviesRepository->like($id);
        http_response_code(200);
    }

    public function dislike(int $id)
    {
        $this->moviesRepository->dislike($id);
        http_response_code(200);
    }

    public function addToWatched(int $idMovie)
    {
        $this->moviesRepository->addToWatched($idMovie);
        http_response_code(200);
    }

    public function watched()
    {
        if ($_COOKIE["user"]) {
            $movies = $this->moviesRepository->getMovies();
            $this->render('watched', ['movies' => $this->moviesRepository->getWatchedMovies($_COOKIE["user"]), 'series' => $this->seriesRepository->getWatchedSeries($_COOKIE["user"])]);
        } else
            $this->render('login', ['messages' => ['You have to be logged in!']]);
    }

    public function adminAdd()
    {
        if ($_COOKIE["admin"]) {
            if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->check($_FILES['file'])) {
                move_uploaded_file(
                    $_FILES['file']['tmp_name'],
                    dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
                );
                $newMovie = new Movie($_POST['title'], 0, 0, $_POST['genre'], 0, $_FILES['file']['name']);
                $this->moviesRepository->addMovieAsAdmin($newMovie);

                return $this->render('movies', [
                    'movies' => $this->moviesRepository->getMovies(),
                    'messages' => $this->message
                ]);
            }
            return $this->render('add-movie', ['messages' => $this->message]);
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