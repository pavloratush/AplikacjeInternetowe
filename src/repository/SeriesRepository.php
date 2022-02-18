<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Series.php';

class SeriesRepository extends Repository
{

    public function getSeries(string $title): ?Series
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM series WHERE title = :title
            ');
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();

        $series = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($series == false) {
            return null;
        }

        return new Series (
            $series['title'],
            $series['likes'],
            $series['dislikes'],
            $series['genre'],
            $series['creation_date'],
            $series['image']
        );
    }

    public function getSeriesArray(): ?array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM series
        ');

        $stmt->execute();
        $seriesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($seriesArray as $series) {
            $result[] = new Series (
                $series['title'],
                $series['likes'],
                $series['dislikes'],
                $series['genre'],
                $series['creation_date'],
                $series['image'],
                $series['id']
            );
        }

        return $result;
    }

    public function getSeriesByTitle(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM series WHERE LOWER(title) LIKE :search
        ');
        $stmt->bindParam(':search', $searchString, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function like(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE series SET "likes" = "likes" + 1 WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function dislike(int $id)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE series SET "dislikes" = "dislikes" + 1 WHERE id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addToWatched(int $idSeries)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt->bindParam(':tmp', $_COOKIE["user"], PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

        $stmt2 = $this->database->connect()->prepare('
            INSERT INTO users_series VALUES(:idUser,:idSeries);
        ');
        $stmt2->bindParam(':idSeries', $idSeries, PDO::PARAM_INT);
        $stmt2->bindParam(':idUser', $id, PDO::PARAM_INT);
        $stmt2->execute();
    }


    public function getWatchedSeries($email): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt->bindParam(':tmp', $email, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC)["id"];

        $stmt2 = $this->database->connect()->prepare('
            select * from series join users_series On users_series.id_series = series.id Where users_series.id_users = :id;
        ');
        $stmt2->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt2->execute();

        $seriesArray = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        foreach ($seriesArray as $series) {
            $result[] = new Series (
                $series['title'],
                $series['likes'],
                $series['dislikes'],
                $series['genre'],
                $series['creation_date'],
                $series['image'],
                $series['id']
            );
        }

        return $result;
    }

    public function addSeriesAsAdmin(Series $newSeries): void
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO series (title,likes,dislikes,genre,creation_date,image)
        VALUES (?,?,?,?,?,?)
        ');

        $stmt->execute([
            $newSeries->getTitle(),
            $newSeries->getLikes(),
            $newSeries->getDislikes(),
            $newSeries->getGenre(),
            $newSeries->getCreationDate(),
            $newSeries->getImage()
        ]);
    }

}