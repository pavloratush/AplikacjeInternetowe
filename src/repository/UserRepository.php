<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users u LEFT JOIN users_details ud 
            ON u.id_user_details = ud.id WHERE email = :email        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['name'],
            $user['surname'],
            $user['instagram'],
            $user['facebook'],
            $user['snapchat'],
            $user['google'],
            $user['languages'],
            $user['country'],
            $user['age'],
            $user['isAdmin']
        );
    }

    public function createUser(string $email, string $password, string $name, string $surname, string $languages, string $country, string $age)
    {
        $stmt = $this->database->connect()->prepare('
            SELECT email FROM users 
            ');
        $stmt->execute();
        $emails = $stmt->fetch(PDO::FETCH_ASSOC);

        foreach ($emails as $emailtmp) {
            if ($emailtmp === $email) {
                return $this->render('register', ['messages' => ['email already in use']]);
            }
        }

        $stmt = $this->database->connect()->prepare('
        INSERT INTO users_details  (name,surname,languages,country,age,instagram,facebook,snapchat,google)
        VALUES (?,?,?,?,?,?,?,?,?)
        ');

        $stmt->execute([
            $name,
            $surname,
            $languages,
            $country,
            $age,
            "https://www.instagram.com/",
            "https://www.facebook.com/",
            "https://www.snapchat.com/",
            "https://www.google.com/"
        ]);

        $stmt3 = $this->database->connect()->prepare('
        SELECT MAX(id) FROM users_details
        ');
        $stmt3->execute();
        $id_user_details = $stmt3->fetch(PDO::FETCH_ASSOC)["max"];

        $stmt2 = $this->database->connect()->prepare('
        INSERT INTO users  (email,password,id_user_details)
        VALUES (?,?,?)
        ');

        $stmt2->execute([
            $email,
            $password,
            $id_user_details
        ]);


    }
}