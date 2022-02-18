<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';


class RegisterController extends AppController
{
    private $userRepository;
    private $email;
    private $password;
    private $name;
    private $surname;
    private $country;
    private $age;
    private $languages;
    private $instagram;
    private $facebook;
    private $snapchat;
    private $google;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function register()
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (!$this->isPost()) {
            return $this->render('register');
        }

        if ($_POST['email'] === "" || $_POST['password'] === "" || $_POST['name'] === "" || $_POST['surname'] === "" || $_POST['languages'] === "" || $_POST['country'] === "" || $_POST['age'] === "") {
            return $this->render('register', ['messages' => ['you need to fill in all fields']]);
        }

        if ($_POST['confirmedPassword'] === $_POST['password']) {
            $this->userRepository->createUser($_POST['email'], $password, $_POST['name'], $_POST['surname'], $_POST['languages'], $_POST['country'], $_POST['age']);
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
        }
        return $this->render('register');
    }


}