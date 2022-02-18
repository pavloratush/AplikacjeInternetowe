<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Meeting.php';

class MeetingRepository extends Repository
{

    public function getMeeting(int $id): ?Meeting
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM schedule WHERE id = :id
            ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $schedule = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($schedule == false) {
            return null;
        }

        return new Meeting(
            $schedule['title'],
            $schedule['description'],
            $schedule['image']
        );
    }

    public function addMeeting(Meeting $schedule): void
    {
        $date = new DateTime();
        $stmt = $this->database->connect()->prepare('
        INSERT INTO schedule  (title,description,created_at,id_assigned_by,image)
        VALUES (?,?,?,?,?)
        ');


        $stmt2 = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt2->bindParam(':tmp', $_COOKIE["user"], PDO::PARAM_STR);
        $stmt2->execute();

        $id_assigned_by = $stmt2->fetch(PDO::FETCH_ASSOC)["id"];


        $stmt->execute([
            $schedule->getTitle(),
            $schedule->getDescription(),
            $date->format('Y-m-d'),
            $id_assigned_by,
            $schedule->getImage()
        ]);
    }

    public function getMeetings(): ?array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM schedule WHERE id_assigned_by = :tmp
        ');


        $stmt2 = $this->database->connect()->prepare('
            SELECT id from users WHERE email = :tmp
        ');
        $stmt2->bindParam(':tmp', $_COOKIE["user"], PDO::PARAM_STR);
        $stmt2->execute();
        $id_assigned_by = $stmt2->fetch(PDO::FETCH_ASSOC)["id"];


        $stmt->bindParam(':tmp', $id_assigned_by, PDO::PARAM_INT);
        $stmt->execute();
        $meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($meetings as $schedule) {
            $result[] = new Meeting(
                $schedule['title'],
                $schedule['description'],
                $schedule['image']
            );
        }

        return $result;
    }
}