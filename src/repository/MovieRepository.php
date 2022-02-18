<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Movie.php';

class MovieRepository extends Repository
{

    public function getMovie(string $title): ?Movie
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM movies WHERE title = :title
            ');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($movie == false) {
            return null;
        }

        return new Movie(
            $movie['title'],
            $movie['likes'],
            $movie['dislikes'],
            $movie['genre'],
            $movie['creation_date'],
            $movie['image']
        );
    }

    public function getMovies(): ?array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM movies
        ');

        $stmt->execute();
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($movies as $movie) {
            $result[] = new Movie(
                $movie['title'],
                $movie['likes'],
                $movie['dislikes'],
                $movie['genre'],
                $movie['creation_date'],
                $movie['image'],
                $movie['id']
            );
        }

        return $result;
    }

    public function getMovieByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM movies WHERE LOWER(title) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function like(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE movies SET "likes" = "likes" + 1 WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function dislike(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE movies SET "dislikes" = "dislikes" + 1 WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addToWatched(int $idMovie)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt->bindParam(':tmp', $_COOKIE["user"], PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

        $stmt2 = $this->database->connect()->prepare('
            INSERT INTO users_movies VALUES(:idUser,:idMovie);
        ');
        $stmt2->bindParam(':idMovie', $idMovie, PDO::PARAM_INT);
        $stmt2->bindParam(':idUser', $id, PDO::PARAM_INT);
        $stmt2->execute();
    }


    public function getWatchedMovies($email): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt->bindParam(':tmp', $email, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

        $stmt2 = $this->database->connect()->prepare('
            select * from movies join users_movies On users_movies.id_movies = movies.id Where users_movies.id_user = :id;
        ');
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt2->execute();

        $movies = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($movies as $movie) {
            $result[] = new Movie(
                $movie['title'],
                $movie['likes'],
                $movie['dislikes'],
                $movie['genre'],
                $movie['creation_date'],
                $movie['image'],
                $movie['id']
            );
        }

        return $result;
    }

    public function addMovieAsAdmin(Movie $newMovie): void
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO movies (title,likes,dislikes,genre,creation_date,image)
        VALUES (?,?,?,?,?,?)
        ');

        $stmt->execute([
            $newMovie->getTitle(),
            $newMovie->getLikes(),
            $newMovie->getDislikes(),
            $newMovie->getGenre(),
            $newMovie->getCreationDate(),
            $newMovie->getImage()
        ]);
    }

}