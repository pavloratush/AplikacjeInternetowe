<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';


class ProfileController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function profile()
    {
        if ($_COOKIE["user"]) {
            $user = $this->userRepository->getUser($_COOKIE["user"]);
            $this->render('profile', ['user' => $user]);
        } else {
            $this->render('login', ['messages' => ['You have to be logged in!']]);
        }
    }
}